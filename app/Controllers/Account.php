<?php

namespace App\Controllers;

class Account extends BaseController
{
    public function index()
    {   
        $session = session();
        if ($session->get("logIn")){
            return view('Account');
        }else{
            return view("errors/html/authError");
        }
        
    }
}

?>
