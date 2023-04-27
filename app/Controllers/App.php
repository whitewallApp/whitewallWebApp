<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class App extends BaseController

{
    public function index()
    {

        return Navigation::renderNavBar("Versions") . view('App') . Navigation::renderFooter();
    }
}