<?php

namespace App\Controllers;

class Category extends BaseController
{
    public function index()
    {
        return view('ViewsCategory/Category_List');
    }
}
