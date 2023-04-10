<?php

namespace App\Controllers;
use App\Models\MenuModel;
use App\Models\BrandModel;

class Menu extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $menuModel = new MenuModel;
            $brandModel = new BrandModel;

            $ids = $menuModel->getCollumn("id", $session->get("brand_name"));

            $menuItems = [];

            foreach($ids as $id){
                array_push($menuItems, $menuModel->getMenuItem($id, assoc: true));
            }

            $data = [
                "menuItems" => $menuItems,
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Menu Items for"
            ];

            return view('Menu', $data);
        }else{
            return view("errors/html/authError");
        }
    }
}

?>