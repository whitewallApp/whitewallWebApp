<?php

namespace App\Controllers;

class Menu extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            return view('Menu');
        }else{
            return view("errors/html/authError");
        }
    }
}

?>