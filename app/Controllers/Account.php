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

            return Navigation::renderNavBar("Account Settings") . view('Account') . Navigation::renderFooter();
        }else{
            return view("errors/html/authError");
        }
        
    }
}

?>
