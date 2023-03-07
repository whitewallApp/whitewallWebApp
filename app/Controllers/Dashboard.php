<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            return view('Dashboard');
        }else{
            return view("errors/html/authError");
        }
    }
}
