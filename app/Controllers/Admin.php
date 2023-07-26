<?php

namespace App\Controllers;

use App\Models\BrandModel;

class Admin extends BaseController

{
    public function index()
    {
        $session = session();
        if ($session->get("super_admin") !== null){
            return Navigation::renderNavBar("Super Admin") . view("Admin") . Navigation::renderFooter();
        }else{
            http_response_code(404);
            exit;
        }
    }
}