<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;

class Image extends BaseController
{
    public function index()
    {
        // Grab all images from the database
        $imageModel = new ImageModel;
        $collModel = new CollectionModel;
        $catModel = new CategoryModel;

        $ids = $imageModel->getAllIds("Beautiful AI");
        $images = [];

        foreach ($ids as $id) {
            $colID = $imageModel->getImageById($id, ["collection_id"]);
            $catID = $collModel->getCollectionbyId($colID, ["category_id"]);

            $image = [
                "id" => $id,
                "path" => $imageModel->getImageById($id, ["imagePath"]), 
                "name" => $imageModel->getImageById($id, ["name"]), 
                "collection" => $collModel->getCollectionbyId($colID, ["name"]),
                "category" => $catModel->getCategoryById($catID, ["name"])
            ];
            array_push($images, $image);
        }

        

        // compile data to be sent to view
        $data = [
            "images" => $images
        ];
        return view('Image/Image_Detail', $data);
    }

    public function post(){
        $request = \Config\Services::request();
        $imageModel = new ImageModel;
        $colModel = new CollectionModel;

        $id = $request->getVar("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $image = $imageModel->getImgByName($id);
        $collections = $colModel->getCollumn("name", "Beautiful AI");

        if (!$image["externalPath"]){
            $exp = "/\/.*\/(.*)/";
            $matches = [];
            preg_match($exp, $image["imagePath"], $matches);

            $image["imagePath"] = $matches[1];
        }

        $image = array_merge($image, ["collectionNames" => $collections]);

        return json_encode($image);
    }
}
