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
            $catID = $collModel->getCollectionbyId($id, ["category_id"]);
            $collecion = [
                "name" => $collModel->getCollectionbyId($id, ["name"]),
                "iconPath" => $collModel->getCollectionbyId($id, ["iconPath"]),
                "category" => $catModel->getCategoryById($catID, ["name"])
            ];

            array_push($collections, $collecion);
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
        $id = $colModel->getIdByName($id);

        $collection = $colModel->getCollectionbyId($id, ["name", "dateUpdated", "description", "link"], true);
        $categories = $catModel->getCollumn("name", "Beautiful AI");
        $collection = array_merge($collection, ["categoryNames" => $categories]);

        return json_encode($collection);
    }
}
