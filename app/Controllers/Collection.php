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
}
