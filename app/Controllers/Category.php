<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class Category extends BaseController
{
    public function index()
    {
        $session = session();
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;
        $brandModel = new BrandModel;
        $brandname = $session->get("brand_name");

        $ids = $catModel->getCollumn("id", $brandname);
        $colIds = $colModel->getCollumn("id", $brandname);

        $categories = [];

        foreach ($ids as $id){
            $category = $catModel->getCategory($id, assoc: true);

            foreach($colIds as $colId){
                $colCatId = $colModel->getCollection($colId, filter: ["category_id", "name"], assoc: true);

                if ($colCatId["category_id"] == $id){
                    $category["collectionName"] = $colCatId["name"];
                }
            }

            array_push($categories, $category);
        }


        $data = [
            "categories" => $categories,
        ];

        return Navigation::renderNavBar("Categories", [true, "Images"]) . view('Category/Category_Detail', $data) . Navigation::renderFooter();
    }

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $catModel = new CategoryModel;
            $brandname = $session->get("brand_name");

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true"){
                return json_encode($catModel->getCollumn("name", $brandname));
            }

            $category = $catModel->getCategory($id, fetchBy: "name", assoc: true);

            return json_encode($category);
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function update(){
        return json_encode(["hello" => true]);
    }
}
