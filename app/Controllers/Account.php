<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\AccountModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\SubscriptionModel;
use App\Models\UserModel;
use Config\Logger;
use Google;
use Google\Service\AndroidPublisher\Subscription;

class Account extends BaseController
{
    public function index()
    {   
        $session = session();
        $brandModel = new BrandModel();
        $userModel = new UserModel();
        $brandnames = $brandModel->getCollumn("name", $session->get("user_id"));

        $dBrandId = $userModel->getUser($session->get("user_id"), filter: ["default_brand"]);
        $brandName = $brandModel->getBrand($dBrandId, filter: ["name"]);

        $data = [
            "brands" => $brandnames,
            "email" => $userModel->getUser($session->get("user_id"), filter: ["email"]),
            "default_brand" => $brandName,
            "success" => false
        ];

        if ($this->request->getGet("logout") !== null){
            session_destroy();
            return redirect()->to("");
        }

        return Navigation::renderNavBar("Account Settings") . view('account/Account', $data) . Navigation::renderFooter();
        
    }

    public function billing(){
        $subModel = new SubscriptionModel();
        $userModel = new UserModel();
        $session = session();

        $accountID = $userModel->getUser($session->get("user_id"), filter: ["account_id"]);

        $type = $subModel->getSubscription($accountID, "account_id", ["subscriptionID"]);


        if ($type == null){
            return Navigation::renderNavBar("Billing") . view("account/Billing", ["accountID" => $accountID]) . Navigation::renderFooter();
        }else{
            header('Location: ' . getenv("STRIPE_CLIENT_PORTAL"));
            exit;
        }
    }

    public function updateBilling(){
        // See your keys here: https://dashboard.stripe.com/apikeys
        \Stripe\Stripe::setApiKey(getenv("STRIPE_API_KEY"));

        // If you are testing your webhook locally with the Stripe CLI you
        // can find the endpoint's secret by running `stripe listen`
        // Otherwise, find your endpoint's secret in your webhook settings in the Developer Dashboard
        $endpoint_secret = getenv("STRIPE_WEBHOOK_SECRET");

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            log_message("warning", "Invalid Stripe Payload, Event ID:" . $event->id);
            http_response_code(400);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            log_message("warning", "Invalid Stripe Signature, Event ID:" . $event->id);
            http_response_code(400);
            exit();
        }

        // $myfile = fopen("newfile.json", "w") or die("Unable to open file!");
        // fwrite($myfile, json_encode($subid["id"]));
        // fclose($myfile);

        //STRIPE DOCS: https://stripe.com/docs/api
        $subModel = new SubscriptionModel();
        switch($event->type){
            case 'customer.subscription.updated':
                $stripeSubId = $event->data->object->id;
                $status = $event->data->object->status;
                $productId = (string)$event->data->object->items->data[0]->plan->product;
                $subid = $subModel->where("subscriptionID", $stripeSubId)->first();
                $subModel->update($subid["id"], ["productID" => $productId, "status" => $status]);
                break;
            case 'customer.subscription.deleted':
                $stripeSubId = $event->data->object->id;
                $productId = (string)$event->data->object->items->data[0]->plan->product;
                $subid = $subModel->where("subscriptionID", $stripeSubId)->first();
                $subModel->update($subid["id"], ["productID" => $productId, "status" => "ended"]);
                break;
            case 'checkout.session.completed':
                $subid = $subModel->where("account_id", $event->data->object->client_reference_id)->first();
                $subModel->update($subid["id"], ["subscriptionID" => $event->data->object->subscription, "customerID" => $event->data->object->customer]);
                break;
            default:
            // error_log('Received unknown event type of: ' . $event->type);
        }
    }

    public function post(){
        $session = session();

        try {
            $assetControler = new Assets();
            $userModel = new UserModel();
            $brandName = esc($this->request->getPost("brand"));
            $email = esc($this->request->getPost("email", FILTER_VALIDATE_EMAIL));

            if (isset($_FILES["profilePhoto"])){
                    //set new user info
                $file = $this->request->getFile("profilePhoto");
                if ($file->isValid()){
                    $tempPath = $file->getTempName();

                    $link = $assetControler->saveProfilePhoto($session->get("user_id"), $tempPath, $file->guessExtension());
                    $userModel->update($session->get("user_id"), ["icon" => $link]);
                }
            }

            $userModel->update($session->get("user_id"), ["email" => $email]);

            //re render the page for success
            $brandModel = new BrandModel();
            $brandnames = $brandModel->getCollumn("name", $session->get("user_id"));

            // //validate that the user has access to that brand
            foreach($brandnames as $name){
                if ($name["name"] == $brandName){
                    $brandId = $brandModel->getBrand($brandName, "name", ["id"]);
                    $userModel->update($session->get("user_id"), ["default_brand" => $brandId]);
                }
            }
        }catch (\Exception $e){
            http_response_code(400);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    public function create(){
        helper("form");
        $data = [
            "name" => "",
            "email" => ""
        ];
        return view('account/create/Create', $data);
    }

    public function addFirst(){

        helper("form");
        $session = session();
        //if they sign in with google
        if ($this->request->getPost("credential") != null){

            if ($this->request->getPost("credential") != "google"){
                $client = new Google\Client(["client_id" => getenv("GOOGLE_CLIENT_ID")]);
                $payload = $client->verifyIdToken($this->request->getPost("credential"));

                $name = $payload["name"];
                $email = $payload["email"];
                $profilePic = $payload["picture"];
                $googleID = $payload["sub"];

                $session->set("name", $name);
                $session->set("email", $email);
                $session->set("googleID", $googleID);
                $session->set("profile", $profilePic);

                $data = [
                    "credential" => "google"
                ];

                return view("account/create/Subscription", $data);
            }

            if ($this->request->getPost("page") == "subscription"){
                $id = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);
                $session->set("productID", $id);

                $data = [
                    "credential" => "google"
                ];

                return view("account/create/Brand", $data);
            }

            if ($this->request->getPost("page") == "brand"){
                //make stuff now that we have brandName
                $brandName = $this->request->getPost("brandName", FILTER_SANITIZE_SPECIAL_CHARS);
                $productID = $session->get("productID");
                $name = $session->get("name");
                $email = $session->get("email");
                $profilePic = $session->get("profile");
                $googleID = $session->get("googleID");

                $accountModel = new AccountModel();
                $subModel = new SubscriptionModel();
                $brandModel = new BrandModel();
                $userModel = new UserModel();
                $colModel = new CollectionModel();
                $catModel = new CategoryModel();

                //make the account
                $accountID = $accountModel->insert(["id" => null]);

                //make a subscription
                $subModel->insert(["account_id" => $accountID, "productID" => $productID]);

                //make the brand
                $brandID = $brandModel->insert(["name" => $brandName, "account_id" => $accountID]);

                //create default category and collections
                $catID = $catModel->insert(["name" => "Default Category", "brand_id" => $brandID]);
                $colModel->insert(["name" => "Default Collection", "category_id" => $catID, "brand_id" => $brandID]);

                $userData = [
                    "name" => $name,
                    "email" => $email,
                    "google_id" => $googleID,
                    "icon" => $profilePic,
                    "status" => true
                ];
                $userModel->addUser($userData, $brandID, admin: true);

                $userId = $userModel->getUser($email, "email", ["id"]);

                LogIn::login($userId);
                return redirect()->to("/dashboard");
            }

        }else{
            //user information form
            if ($this->request->getPost("name") != null){
                //validate form
                $rules = [
                    'name' => 'required',
                    'password' => 'required|min_length[12]',
                    'passconf' => 'required|matches[password]',
                    'email'    => 'required|valid_email',
                ];

                $errors = [
                    'name' => [
                        'required' => "The Name feild is required"
                    ],
                    'password' => [
                        'required' => "The Password feild is required",
                        'min_length' => "Your password must be over 12 characters in length"
                    ],
                    'passconf' => [
                        'required' => "You need to confirm your password",
                        'matches' => "Your Password fields don't match"
                    ],
                    'email' => [
                        'required' => "You need to put in a valid email",
                        'valid_email' => "Your email is not valid"
                    ]
                    ];

                if (! $this->validate($rules, $errors)){
                    $data = [
                        "name" => $this->request->getPost("name"),
                        "email" => $this->request->getPost("email"),
                    ];
                    return view('account/create/Create', $data);
                }

                //save to session
                $session->set("name", $this->request->getPost("name", FILTER_SANITIZE_SPECIAL_CHARS));
                $session->set("email", $this->request->getPost("email", FILTER_SANITIZE_EMAIL));
                $session->set("password", $this->request->getPost("password"));

                return view("account/create/Subscription");
            }

            if ($this->request->getPost("page") == "subscription"){
                $id = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);
                $session->set("productID", $id);

                return view("account/create/Brand");
            }

            if ($this->request->getPost("page") == "brand"){
                $brandName = $this->request->getPost("brandName", FILTER_SANITIZE_SPECIAL_CHARS);
                $name = $session->get("name");
                $email = $session->get("email");
                $password = (string)$session->get("password");
                $productID = $session->get("productID");

                $accountModel = new AccountModel();
                $subModel = new SubscriptionModel();
                $brandModel = new BrandModel();
                $userModel = new UserModel();
                $colModel = new CollectionModel();
                $catModel = new CategoryModel();

                //make the account
                $accountID = $accountModel->insert(["id" => null]);

                //make a subscription
                $subModel->insert(["account_id" => $accountID, "productID" => $productID]);

                //make the brand
                $brandID = $brandModel->insert(["name" => $brandName, "account_id" => $accountID]);

                //create default category and collections
                $catID = $catModel->insert(["name" => "Default Category", "brand_id" => $brandID]);
                $colModel->insert(["name" => "Default Collection", "category_id" => $catID, "brand_id" => $brandID]);

                //Create user and permissions
                $hashpass = password_hash($password, PASSWORD_DEFAULT);
                $userData = [
                    "name" => $name, 
                    "email" => $email, 
                    "password" => $hashpass, 
                    "status" => true
                ];
                $userModel->addUser($userData, $brandID, admin: true);

                $userId = $userModel->getUser($email, "email", ["id"]);

                LogIn::login($userId);
                return redirect()->to("/dashboard");
            }
        }
    }
}

?>
