<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\UserModel;

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
        return Navigation::renderNavBar("Billing") . view("Billing") . Navigation::renderFooter();
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
        return view('account/Create');
    }
}

?>
