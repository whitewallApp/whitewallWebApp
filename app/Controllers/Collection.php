<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;


class Collection extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            $collModel = new CollectionModel;
            $catModel = new CategoryModel;
            $brandModel = new BrandModel;
            $brandname = $session->get("brand_name");

            $ids = $collModel->getAllIds($brandname);
            $collections = [];


            foreach($ids as $id){
                $catID = $collModel->getCollection($id, filter: ["category_id"]);
                $collection = [
                    "name" => $collModel->getCollection($id, filter: ["name"]),
                    "iconPath" => $collModel->getCollection($id, filter: ["iconPath"]),
                    "category" => $catModel->getCategory($catID, filter: ["name"])
                ];

                array_push($collections, $collection);
            };

            $data = [
                "brands" => $brandModel->getCollumn("name", 1), //TODO: session accountID
                "collections" => $collections,
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Collections for"
            ];

            return view('Collection/Collection_Detail', $data);
        }else{
            return view("errors/html/authError");
        }
    }

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $colModel = new CollectionModel;
            $catModel = new CategoryModel;
            $brandname = $session->get("brand_name");

            $id = $request->getVar("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true"){
                return json_encode($catModel->getCollumn("name", $brandname));
            }

            $id = $colModel->getIdByName($id);
            //$exp = "/\/.*\/(.*)/";

            $collection = $colModel->getCollection($id, filter: ["name", "dateUpdated", "description", "link", "iconPath", "category_id"], assoc: true);
            $collection["category_id"] = $catModel->getCategory($collection["category_id"], filter: ["name"]);

            // $matches = [];
            // preg_match($exp, $collection["iconPath"], $matches);

            // $collection["iconPath"] = $matches[1];

            $categories = $catModel->getCollumn("name", $brandname);
            $collection = array_merge($collection, ["categoryNames" => $categories]);

            return json_encode($collection);
        }else{
            return json_encode(["success" => false]);
        }
    }
}
