<?php

namespace App\Controllers;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\UserModel;

class Brand extends BaseController
{
    public function index() //Change brand page
    {
        $session = session();
        $brandModel = new BrandModel;
        $ids = $brandModel->getCollumn("id", $session->get("user_id"));

        $brands = [];

        foreach($ids as $id){
            array_push($brands, $brandModel->getBrand($id, assoc: true));
        }

        $data = [
            "brandInfo" => $brands,
            "admin" => $session->get("is_admin")
        ];

        return Navigation::renderNavBar("Brands") . view('brand/Brand', $data) . Navigation::renderFooter();
    }

    public function branding($brandId){
            return Navigation::renderNavBar("Branding", [true, "Brands"]) . view("brand/Branding") . Navigation::renderFooter();
    }

    public function users($brandId){
        $session = session();
        if($session->get("is_admin")){
            $userModel = new UserModel();
            $userIds = $userModel->getCollumn("id", $session->get("brand_name"));

            $users = [];

            foreach($userIds as $id){
                $user = $userModel->getUser($id, filter: ["name", "email", "id", "brand_id", "status"]);
                array_push($users, $user);
            }

            $data = [
                "users" => $users
            ];

            return Navigation::renderNavBar("Brand Users", [true, "Users"]) . view("brand/Users", $data) . Navigation::renderFooter();
        }
    }

    public function userData(){ //Post
        $session = session();

        if ($session->get("logIn") && $session->get("is_admin")){
            $request = \Config\Services::request();
            $userModel = new UserModel();

            $id = esc($request->getGet("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS));

            $user = $userModel->getUser($id, filter: ["name", "email", "status"]);
            $permissions = $userModel->getPermissions($id, $session->get("brand_name"));

            $data = [
                "user" => $user,
                "permissions" => $permissions
            ];

            return json_encode($data);
        }else{
            $this->response->setStatusCode(401);
            return $this->response->send(); 
        }
    }

    public function setBrand() //Post
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $brandModel = new BrandModel();
            $userModel = new UserModel();
            $name = esc($request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            $session = session();

            $brands = $brandModel->getCollumn("name", $session->get("user_id"));
            $success = false;

            foreach($brands as $brand){
                if ($brand["name"] == $name){
                    $success = true;
                }
            }

            if ($success){
                $session->set("brand_name", $name);
                $session->set('is_admin', $userModel->getAdmin($session->get("user_id"), $session->get("brand_name")));
                return json_encode(["success" => true]);
            }

        } else {
            $this->response->setStatusCode(401);
            return $this->response->send(); 
        }
    }
}

?>
