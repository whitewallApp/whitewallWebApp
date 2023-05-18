<?php

namespace App\Controllers;
use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;

class Image extends BaseController
{
    public function index()
    {
        $session = session();
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
            "images" => $images,
        ];

        return Navigation::renderNavBar("Images", [true, "Images"]) . view('Image/Image_Detail', $data, ["cache" => 86400]) . Navigation::renderFooter();
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

            $image = $imageModel->getImage($id)[0];
            $collections = $colModel->getCollumn("name", $brandname);

            $image["collection_id"] = $colModel->getCollection($image["collection_id"], filter: ["name"]);

            if (!$image["externalPath"]){ //removes the assets/images
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

    public function update(){
        $assets = new Assets();
        $imageModel = new ImageModel();
        $collectionModel = new CollectionModel();

        //delete caches
        if (file_exists("../writable/cache/ImageImage_Detail")){
            unlink("../writable/cache/ImageImage_Detail");
            unlink("../writable/cache/ImageImage_List");
        }

        if (isset($_POST["type"])){
            //file -> file
            $tmpPath = htmlspecialchars($_FILES["file"]["tmp_name"]);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));
            $type = explode("/", (string)$this->request->getPost("type"))[1];

            $name = $imageModel->getImage($imageID, filter: ["imagePath", "externalPath"], assoc: true);
            if ($name["externalPath"] == "0"){
                //get rid of the assets/images
                $name = explode("assets/images/", $name)[1];

                $newPath = $assets->updateImage($tmpPath, $type, $name);

                if ($newPath){ //if no error
                    $post = $this->request->getPost(["name", "description", "collection", "externalPath"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $data = [
                        "imagePath" => "assets/images/" . $newPath,
                        "thumbnail" => "assets/thumbnail/" . $newPath,
                        "name" => $post["name"],
                        "description" => $post["description"],
                        "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                        "externalPath" => $post["externalPath"]
                    ];
                    $imageModel->updateImage($imageID, $data);
                }
            }else{
                //link -> file
                $name = $assets->saveImage($tmpPath, $type);

                $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $data = [
                    "imagePath" => "assets/images/" . $name,
                    "thumbnail" => "assets/thumbnail/" . $name,
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                    "externalPath" => $post["externalPath"]
                ];
                $imageModel->updateImage($imageID, $data);
            }

        }else if (isset($_POST["link"])){
            //link -> link or file -> link
            $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));

            $data = [
                "imagePath" => $post["link"],
                "thumbnail" => "none",
                "name" => $post["name"],
                "description" => $post["description"],
                "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                "externalPath" => $post["externalPath"]
            ];
            $imageModel->updateImage($imageID, $data);
        }else{
            $post = $this->request->getPost(["name", "description", "collection"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));

            $data = [
                "name" => $post["name"],
                "description" => $post["description"],
                "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
            ];
            $imageModel->updateImage($imageID, $data);
        }

        return json_encode(["success" => true]);
    }
}
