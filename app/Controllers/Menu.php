<?php

namespace App\Controllers;
use App\Models\MenuModel;

class Menu extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $menuModel = new MenuModel;

            $ids = $menuModel->getCollumn("id", $session->get("brand_name"));

            $menuItems = [];

            foreach($ids as $id){
                array_push($menuItems, $menuModel->getMenuItem($id, assoc: true));
            }

            $data = [
                "menuItems" => $menuItems
            ];

            return view('Menu', $data);
        }else{
            return view("errors/html/authError");
        }
    }
}

?>