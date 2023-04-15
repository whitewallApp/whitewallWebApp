<?php

namespace App\Controllers;
use App\Models\MenuModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;

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
            ];

            return Navigation::renderNavBar("Menu Items For") . view('Menu', $data) . Navigation::renderFooter();
        }else{
            return view("errors/html/authError");
        }
    }
}

?>