<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;


class Collection extends BaseController
{
    public function index()
    {
        $collModel = new CollectionModel;
        $catModel = new CategoryModel;

        $ids = $collModel->getAllIds("Beautiful AI");
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
            "collections" => $collections
        ];

        return view('Collection/Collection_Detail', $data);
    }

    public function post(){
        $request = \Config\Services::request();
        $colModel = new CollectionModel;
        $catModel = new CategoryModel;

        $id = $request->getVar("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($req == "true"){
            return json_encode($catModel->getCollumn("name", "Beautiful AI"));
        }

        $id = $colModel->getIdByName($id);
        //$exp = "/\/.*\/(.*)/";

        $collection = $colModel->getCollection($id, filter: ["name", "dateUpdated", "description", "link", "iconPath"], assoc: true);

        // $matches = [];
        // preg_match($exp, $collection["iconPath"], $matches);

        // $collection["iconPath"] = $matches[1];

        $categories = $catModel->getCollumn("name", "Beautiful AI");
        $collection = array_merge($collection, ["categoryNames" => $categories]);

        return json_encode($collection);
    }
}
