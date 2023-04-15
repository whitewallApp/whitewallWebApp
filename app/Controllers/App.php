<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class App extends BaseController

{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
               
            ];

            return Navigation::renderNavBar("App Builds") . view('App', $data) . Navigation::renderFooter();
        }else{
            return view("errors/html/authError");
        }
    }
}