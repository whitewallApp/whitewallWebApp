<?php

namespace App\Controllers;
use App\Models\BrandModel;

class Setting extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
                "brands" => $brandModel->getCollumn("name", 1), //TODO: session accountID
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Account Settings"
            ];

            return view('Settings', $data);
        }else{
            return view("errors/html/authError");
        }
    }
}

?>
