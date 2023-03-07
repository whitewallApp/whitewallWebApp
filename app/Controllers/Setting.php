<?php

namespace App\Controllers;

class Setting extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            return view('Settings');
        }else{
            return view("errors/html/authError");
        }
    }
}

?>
