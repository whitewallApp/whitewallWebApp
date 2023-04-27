<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\BrandModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            return Navigation::renderNavBar("Dashboard for") . view('Dashboard') . Navigation::renderFooter();
        }else{
            $session->setFlashdata('prev_url', 'dashboard');
            return redirect()->to("");
        }
    }
}
