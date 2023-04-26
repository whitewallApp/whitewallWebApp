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
        if ($session->get("logIn")){
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

            return Navigation::renderNavBar("Account Settings") . view('Account', $data) . Navigation::renderFooter();
        }else{
            return view("errors/html/authError");
        }
        
    }

    public function billing(){
        return Navigation::renderNavBar("Billing") . view("Billing") . Navigation::renderFooter();
    }

    public function post(){
        $session = session();

        if ($session->get("logIn")) {
            $assetControler = new Assets();
            $userModel = new UserModel();
            $brandName = esc($this->request->getPost("brand"));
            $email = esc($this->request->getPost("email", FILTER_VALIDATE_EMAIL));

            if (isset($_FILES["profilePhoto"])){
                //set new user info
                $tempPath = $_FILES["profilePhoto"]["tmp_name"];
                $imgName = $_FILES["profilePhoto"]["name"];

                $link = $assetControler->saveProfilePhoto($session->get("user_id"), $imgName, $tempPath);
                $userModel->update($session->get("user_id"), ["icon" => $link]);
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

            $data = [
                "brands" => $brandnames,
                "email" => $userModel->getUser($session->get("user_id"), filter: ["email"]),
                "default_brand" => $brandName,
                "success" => true
            ];

            return Navigation::renderNavBar("Account Settings") . view('Account', $data) . Navigation::renderFooter();

        }else{
            $this->response->setStatusCode(401);
            return $this->response->send();
        }
    }
}

?>
