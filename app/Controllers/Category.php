<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CollectionModel;

class Category extends BaseController
{
    public function index()
    {
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;

        $ids = $catModel->getCollumn("id", "Beautiful AI");
        $colIds = $colModel->getCollumn("id", "Beautiful AI");

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

       //echo var_dump($categories);

        $data = [
            "categories" => $categories
        ];

        return view('Category/Category_Detail', $data);
    }
}
