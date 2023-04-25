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
            echo var_dump($_FILES["profilePhoto"]["name"]);
        }else{
            $this->response->setStatusCode(401);
            return $this->response->send();
        }
    }
}

?>
