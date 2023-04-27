<?php

namespace App\Controllers;
use App\Controllers\Navigation;

class Dashboard extends BaseController
{
    public function index()
    {
        return Navigation::renderNavBar("Dashboard for") . view('Dashboard') . Navigation::renderFooter();
    }
}
