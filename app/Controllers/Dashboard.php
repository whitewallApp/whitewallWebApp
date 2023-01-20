<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
}
