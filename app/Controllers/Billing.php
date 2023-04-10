<?php

namespace App\Controllers;

use App\Models\BrandModel;

class Billing extends BaseController

{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")) {
            $brandModel = new BrandModel;

            $data = [
                "brandId" => $brandModel->getBrand($session->get("brand_name"), "name", ["id"]),
                "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
                "pageTitle" => "Billing"
            ];

            return view('Billing', $data);
        } else {
            return view("errors/html/authError");
        }
    }
}
