<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\BrandModel;

class Category extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
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
                "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
                "categories" => $categories,
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Categories for"
            ];

            return view('Category/Category_Detail', $data);
        }else{
            return view("errors/html/authError");
        }
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
}
