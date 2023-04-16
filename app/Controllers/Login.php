<?php

namespace App\Controllers;
use App\Controllers\Navigation;

class Login extends BaseController
{
    public function index()
    {
        return view('Login') . Navigation::renderFooter(); //TODO: Needs to save in session: Brand Name, Account ID, if logged in
    }

    public function post(){
        $session = session();
        $session->set("logIn", true);
        $session->set("brand_name", "Beautiful AI");

        return json_encode(["success" => true]);
    }
}

?>
