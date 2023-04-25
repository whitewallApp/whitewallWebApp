<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class Account extends BaseController
{
    public function index()
    {   
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel();
            $brandnames = $brandModel->getCollumn("name", $session->get("user_id"));

            $data = [
                "brands" => $brandnames
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
        $fileControler = new FileControler();
        if ($session->get("logIn")) {
            $tempPath = $_FILES["profilePhoto"]["tmp_name"];
            $imgName = $_FILES["profilePhoto"]["name"];

            $matches = [];
            preg_match("/\.(.*)$/", $imgName, $matches);
            $fileName = $session->get("user_id")[0] . $matches[0];

            $fileControler->saveProfilePhoto($session->get("user_id"), $session->get("brand_name"), $fileName, $tempPath);

            return $this->index();

        }else{
            $this->response->setStatusCode(401);
            return $this->response->send();
        }
    }
}

?>
