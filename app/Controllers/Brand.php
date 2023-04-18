<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\UserModel;

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
                "brandInfo" => $brands,
            ];

            return Navigation::renderNavBar("Brands") . view('brand/Brand', $data) . Navigation::renderFooter();
        }else{
            return view("errors/html/authError");
        }
    }

    public function branding($brandId){
        $session = session();
        if ($session->get("logIn")){
            $brandModel = new BrandModel;

            $data = [
                "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
            ];

            return Navigation::renderNavBar("Branding", [true, "Brands"]) . view("brand/Branding", $data) . Navigation::renderFooter();
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function users($brandId){
        $session = session();
        if ($session->get("logIn")){
            $userModel = new UserModel();
            $brandModel = new BrandModel();
            $userIds = $userModel->getCollumn("id", 1); //TODO: session account id

            $users = [];

            foreach($userIds as $id){
                $user = $userModel->getUser($id, filter: ["name", "email", "id"]);
                array_push($users, $user);
            }

            $data = [
                "users" => $users,
                "brandNames" => $brandModel->getCollumn("name", 1)
            ];

            return Navigation::renderNavBar("Brand Users", [true, "Users"]) . view("brand/Users", $data) . Navigation::renderFooter();
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
