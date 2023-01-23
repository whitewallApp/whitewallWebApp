<?php

namespace App\Controllers;

class Category extends BaseController
{
    public function index()
    {
        return view('Category_List');
    }
}
