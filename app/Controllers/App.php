<?php

namespace App\Controllers;
use App\Models\BrandModel;

class App extends BaseController

{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
                "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "App"
            ];

            return view('App', $data);
        }else{
            return view("errors/html/authError");
        }
    }
}