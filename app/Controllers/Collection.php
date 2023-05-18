<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class Collection extends BaseController
{
    public function index()
    {
        $session = session();
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
            "collections" => $collections,
        ];

        return Navigation::renderNavBar("Collections", [true, "Images"]) . view('Collection/Collection_Detail', $data, ["cache" => 86400]) . Navigation::renderFooter();
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

            $collection = $colModel->getCollection($id, filter: ["id", "name", "dateUpdated", "description", "link", "iconPath", "category_id"], assoc: true);
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

    public function update(){
        $session = session();
        if ($session->get("logIn")) {
            //delete caches
            unlink("../writable/cache/ImageImage_Detail");
            unlink("../writable/cache/ImageImage_List");
        }
    }
}
