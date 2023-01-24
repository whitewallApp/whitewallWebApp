<?php

namespace App\Controllers;

class Collection extends BaseController
{
    public function index()
    {
        return view('Collection/Collection_List');
    }
}
