<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('Login'); //TODO: Needs to save in session: Brand Name, Account ID, if logged in
    }

    public function post(){
        $session = session();
        $session->set("logIn", true);
        $session->set("brand_name", "Beautiful AI");

        return json_encode(["success" => true]);
    }
}

?>
