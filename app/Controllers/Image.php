<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;

class Image extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get("logIn")){
            // Grab all images from the database
            $imageModel = new ImageModel;
            $collModel = new CollectionModel;
            $catModel = new CategoryModel;
            $brandModel = new BrandModel;
            $brandname = $session->get("brand_name");

            $ids = $imageModel->getAllIds($brandname);
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
                "brands" => $brandModel->getCollumn(["name", "logo"], 1), //TODO: session accountID
                "images" => $images,
                "brandId" => $brandModel->getBrand($session->get("brand_name"), fetchBy: "name", filter: ["id"]),
                "pageTitle" => "Images for"
            ];
            return view('Image/Image_Detail', $data);
        }else{
            return view("errors/html/authError");
        }
    }

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $imageModel = new ImageModel;
            $colModel = new CollectionModel;
            $brandname = $session->get("brand_name");

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true"){
                return json_encode($colModel->getCollumn("name", $brandname));
            }

            $image = $imageModel->getImgByName($id);
            $collections = $colModel->getCollumn("name", $brandname);

            $image["collection_id"] = $colModel->getCollection($image["collection_id"], filter: ["name"]);

            if (!$image["externalPath"]){
                $exp = "/\/.*\/(.*)/";
                $matches = [];
                preg_match($exp, $image["imagePath"], $matches);

                $image["imagePath"] = $matches[1];
            }

            $image = array_merge($image, ["collectionNames" => $collections]);

            return json_encode($image);
        }else{
            return json_encode(["success" => false]);
        }
        
    }
}
