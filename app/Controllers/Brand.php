<?php

namespace App\Controllers;
use App\Models\BrandModel;

class Brand extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;
            $ids = $brandModel->getCollumn("id", 1); //TODO: make accountID a session variable

            $brands = [];

            foreach($ids as $id){
                array_push($brands, $brandModel->getBrand($id, assoc: true));
            }

            $data = [
                "brands" => $brands,
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Brand"
            ];

            return view('brand/Brand', $data);
        }else{
            return view("errors/html/authError");
        }
    }

    public function info($brandId){
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
                "brands" => $brandModel->getCollumn("name", 1), //TODO: session accountID
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Branding"
            ];

            return view("brand/Branding", $data);
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function users($brandId){
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
                "brands" => $brandModel->getCollumn("name", 1), //TODO: session accountID
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Users"
            ];

            return view("brand/Users", $data);
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function post()
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $name = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $session = session();
            $session->set("brand_name", $name);

            return json_encode(["success" => true]);
        } else {
            return json_encode(["success" => false]);
        }
    }
}

?>
