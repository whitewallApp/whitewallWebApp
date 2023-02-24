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
            $colID = $imageModel->getImage($id, filter: ["collection_id"]);
            $catID = $collModel->getCollection($colID, filter: ["category_id"]);



            $image = [
                "id" => $id,
                "path" => $imageModel->getImage($id, filter: ["imagePath"]), 
                "name" => $imageModel->getImage($id, filter: ["name"]), 
                "collection" => $collModel->getCollection($colID, filter: ["name"]),
                "category" => $catModel->getCategory($catID, filter: ["name"])
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

        $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $collectionReq = $request->getPost("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if ($collectionReq == "true"){
            $collections = $colModel->getCollumn("name", "Beautiful AI");
            return json_encode($collections);
        }

        $image = $imageModel->getImgByName($id);
        $collections = $colModel->getCollumn("name", "Beautiful AI");

        $image["collection_id"] = $colModel->getCollection($image["collection_id"], filter: ["name"]);

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
