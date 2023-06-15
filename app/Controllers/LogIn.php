<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\BrandModel;
use App\Models\UserModel;
use Google;

class LogIn extends BaseController
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
        } catch (\Throwable $e) {
            echo var_dump($e->getMessage());
        }

        return view('Login') . Navigation::renderFooter();
    }

    public function post(){
        $session = session();
        $request = \Config\Services::request();
        $return = ["success" => false];
        $userModel = new UserModel();
        $brandModel = new BrandModel();

        $emailInput = esc($request->getPost("email"));
        $password = esc($request->getPost("password"));
        $google = esc($request->getPost("google"));

        if (isset($google)){
            $client = new Google\Client(["client_id" => $google["clientId"]]);
            $payload = $client->verifyIdToken($google["credential"]);
            if ($payload){
                $emails = $userModel->findColumn("email");

                foreach($emails as $email){
                    if ($payload["email"] == $email){
                        $ids = $userModel->getUser($payload["email"], "user.email", ["google_id", "id"]);
                        if ($ids["google_id"] == ""){
                            $userModel->update($ids["id"], ["google_id" => $payload["sub"]]);

                            if($userModel->getUser($ids["id"], filter: ["icon"]) == ""){
                                $userModel->update($ids["id"], ["icon" => $payload["picture"]]);
                            }

                            $return["success"] = true;
                        }else{
                            if ($ids["google_id"] == $payload["sub"]){

                                if ($userModel->getUser($ids["id"], filter: ["icon"]) == "") {
                                    $userModel->update($ids["id"], ["icon" => $payload["picture"]]);
                                }

                                $return["success"] = true;
                            }
                        }
                    }
                }

                if ($return["success"]){
                    $userId = $userModel->getUser($payload["email"], "user.email", ["id"]);
                    $this->login($userId);
                }
            }
        }else{
            $emails = $userModel->findColumn("email");
            foreach($emails as $email){
                if ($email == $emailInput){
                    if (password_verify($password, $userModel->getUser($email, "email", ["password"]))){
                        $return["success"] = true;

                        $userId = $userModel->getUser($email, "email", ["id"]);

                        $this->login($userId);
                    }
                }
            }
        }

        if (isset($_SESSION["prev_url"]) && $return["success"]){
            $return["prevURL"] = $session->get("prev_url");
        }
        
        return json_encode($return);
    }

    public static function login($userId){
        $session = session();
        $userModel = new UserModel();
        $session->set("logIn", true);
        $session->set("brand_id", $userModel->getUser($userId, filter: ["default_brand"]));
        $session->set("user_id", $userId);
        $session->set("is_admin", $userModel->getAdmin($userId, $session->get("brand_id")));
	
    }
}

?>
