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
            $brandnames = $brandModel->getCollumn("name", $session->get("user_id"));

            $data = [
                "brands" => $brandnames,
                "success" => false
            ];

            return Navigation::renderNavBar("Account Settings") . view('Account', $data) . Navigation::renderFooter();
            // header("Content-type: " . "image/png");
            // require("C:/images/1.png");
            // exit;
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
            $tempPath = $_FILES["profilePhoto"]["tmp_name"];
            $imgName = $_FILES["profilePhoto"]["name"];

            $link = $assetControler->saveProfilePhoto($session->get("user_id"), $imgName, $tempPath);
            $userModel->update($session->get("user_id"), ["icon" => $link]);


            //re render the page for success
            $brandModel = new BrandModel();
            $brandnames = $brandModel->getCollumn("name", $session->get("user_id"));

            $data = [
                "brands" => $brandnames,
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
