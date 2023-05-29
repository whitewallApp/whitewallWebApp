<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\MobleModel;
use Google\Service\CloudAsset\Asset;
use RuntimeException;

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

        return Navigation::renderNavBar("Images", "images", [true, "Images"]) . view('Image/Image_Detail', $data, ["cache" => 86400]) . Navigation::renderFooter();
    }

    public function post()
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $imageModel = new ImageModel;
            $colModel = new CollectionModel;
            $brandname = $session->get("brand_name");

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true") {
                return json_encode($colModel->getCollumn("name", $brandname));
            }

            $image = $imageModel->getImage($id)[0];
            $collections = $colModel->getCollumn("name", $brandname);

            $image["collection_id"] = $colModel->getCollection($image["collection_id"], filter: ["name"]);

            if (!$image["externalPath"]) { //removes the assets/images
                $exp = "/\/.*\/(.*)/";
                $matches = [];
                preg_match($exp, $image["imagePath"], $matches);

                $image["imagePath"] = $matches[1];
            }

            $image = array_merge($image, ["collectionNames" => $collections]);

            return json_encode($image);
        } else {
            return json_encode(["success" => false]);
        }
    }

    public function update()
    {
        $assets = new Assets();
        $imageModel = new ImageModel();
        $collectionModel = new CollectionModel();
        $catModel = new CategoryModel();

        //delete caches
        if (file_exists("../writable/cache/ImageImage_Detail")) {
            unlink("../writable/cache/ImageImage_Detail");
            unlink("../writable/cache/ImageImage_List");
        }

        if (isset($_POST["type"])) {
            //file -> file
            $tmpPath = htmlspecialchars($_FILES["file"]["tmp_name"]);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));
            $type = explode("/", (string)$this->request->getPost("type"))[1];

            $name = $imageModel->getImage($imageID, filter: ["imagePath", "externalPath"], assoc: true);
            if ($name["externalPath"] == "0") {
                //get rid of the assets/images
                $name = explode("assets/images/", $name["imagePath"])[1];

                $newPath = $assets->updateImage($tmpPath, $type, $name);

                if ($newPath) { //if no error
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
            } else {
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
        } else if (isset($_POST["link"])) {
            //link -> link or file -> link
            $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));

            //remove old file if there is one
            if ($imageModel->getImage($imageID, filter: ["externalPath"]) == "0") {
                $name = explode("assets/images/", $imageModel->getImage($imageID, filter: ["imagePath"]))[1];
                $assets->removeImage($name);
            }

            $data = [
                "imagePath" => $post["link"],
                "thumbnail" => "none",
                "name" => $post["name"],
                "description" => $post["description"],
                "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                "externalPath" => $post["externalPath"]
            ];
            $imageModel->updateImage($imageID, $data);
        } else {
            //update just the data
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

    public function uploadView()
    {
        return Navigation::renderNavBar("Images", [false, "Images"]) . view('Image/Image_Upload') . Navigation::renderFooter();
    }

    public function upload($dryrun)
    {
        $file = $this->request->getFile("file");
        $imageModel = new ImageModel();
        $brandModel = new BrandModel();
        $colModel = new CollectionModel();
        $catModel = new CategoryModel();
        $assets = new Assets();
        $session = session();

        try {
            if (!$file->isValid()) {
                throw new RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
            }

            if (preg_match("/image/", $file->getMimeType()) == 0 && preg_match("/csv/", $file->getMimeType()) == 0) {
                throw new RuntimeException("File needs to be a image");
            }

            // if its an image save the image to the server and database
            if (preg_match("/image/", $file->getMimeType()) == 1) {
                //save the image
                $imagePath = $assets->saveImage($file->getTempName(), $file->guessExtension());

                //add image to database with their uploaded name add .validate to so we can grab it later if need be
                $tempName = htmlspecialchars($file->getName()) . ".validate";
                $colIds = $colModel->getAllIds($session->get("brand_name"));

                $data = [
                    "description" => $tempName,
                    "brand_id" => $brandModel->getBrand($session->get("brand_name"), "name", ["id"]),
                    "collection_id" => $colIds[0],
                    "externalPath" => 0,
                    "imagePath" => "/assets/images/" . $imagePath
                ];

                $imageModel->insert($data);

                return json_encode(["status" => "success"]);
            }

            // if its a csv read in the images
            if (preg_match("/csv/", $file->getMimeType()) == 1) {
                $overwrite = filter_var($this->request->getPost("overwrite", FILTER_SANITIZE_FULL_SPECIAL_CHARS), FILTER_VALIDATE_BOOL);
                $row = 1;
                $errors = [];
                if (($handle = fopen($this->request->getFile("file")->getTempName(), "r")) !== FALSE) {
                    $columns = [];
                    $ids = $imageModel->getAllIds($session->get("brand_name"));
                    $structure = [];
                    //read from csv while there is lines
                    while (($data = fgetcsv($handle, 1000)) !== FALSE) {

                        //sanitize csv row
                        foreach ($data as &$item) {
                            $item = htmlspecialchars($item);
                        }

                        if ($row == 1) {
                            //flip the first row so you know idecies to use
                            $columns = array_flip($data);
                            $row++;
                        } else {
                            //check if they have access to those image ids
                            $imgfound = false;
                            foreach ($ids as $imgId) {
                                if ($data[$columns["id"]] == $imgId) {
                                    $imgfound = true;
                                }
                            }

                            if ($imgfound) {
                                
                                //check if a collection is in multipule categories
                                if (array_key_exists($data[$columns["collection_name"]], $structure)){
                                    if ($structure[$data[$columns["collection_name"]]] != $data[$columns["category_name"]]){
                                        array_push($errors, ["image" => $data[$columns["name"]], "message" => "A collection can't be in mulitpule categories"]);
                                        continue;
                                    }
                                }else{
                                    $structure[$data[$columns["collection_name"]]] = $data[$columns["category_name"]];
                                }

                                //check if collection and category is blank
                                if ($data[$columns["collection_name"]] == ""){
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Image must have a collection"]);
                                    continue;
                                }
                                if ($data[$columns["category_name"]] == "") {
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Image must have a category"]);
                                    continue;
                                }

                                //check if category exists
                                $catfound = false;
                                $categoryNames = $catModel->getCollumn("name", $session->get("brand_name"));
                                foreach ($categoryNames as $categoryName) {
                                    if ($categoryName == $data[$columns["category_name"]]) {
                                        $catfound = true;
                                    }
                                }

                                //check if collection exists
                                $colfound = false;
                                $columnNames = $colModel->getCollumn("name", $session->get("brand_name"));
                                foreach ($columnNames as $columnName) {
                                    if ($columnName == $data[$columns["collection_name"]]) {
                                        $colfound = true;
                                    }
                                }


                                $brandid = $brandModel->getBrand($session->get("brand_name"), "name", ["id"]);

                                // echo var_dump(["row" => $row, "collectionFound" => $colfound, "categoryFound" => $catfound]);

                                //don't do database stuff if dry run
                                if (!$dryrun){
                                    //if cateogory doesn't exist make it (needs to be done before collection)
                                    if (!$catfound) {
                                        $category = [
                                            "name" => $data[$columns["category_name"]],
                                            "brand_id" => $brandid
                                        ];
                                        
                                        $catModel->insert($category);
                                    }

                                    //if collection doesn't exist make it
                                    if (!$colfound) {
                                        $collection = [
                                            "name" => $data[$columns["collection_name"]],
                                            "category_id" => $catModel->getCategory($data[$columns["category_name"]], "name", ["id"]),
                                            "brand_id" => $brandid
                                        ];

                                        $colModel->insert($collection);
                                    }

                                    //finally update the image

                                    if ($overwrite){

                                        $image = [
                                            "name" => $data[$columns["name"]],
                                            "description" => $data[$columns["description"]],
                                            "link" => $data[$columns["link"]],
                                            "collection_id" => $colModel->getCollection($data[$columns["collection_name"]], ["id"], "name")
                                        ];

                                        $imageModel->update($data[$columns["id"]], $image);
                                    }else{
                                        $imageDatabase = $imageModel->getImage($data[$columns["id"]], assoc: true)[0];
                                        $image = [];

                                        if ($imageDatabase["name"] == ""){
                                            $image["name"] = $data[$columns["name"]];
                                        }

                                        if ($imageDatabase["description"] == "" || preg_match("/\.validate$/", $imageDatabase["description"]) == 1){
                                            $image["description"] = $data[$columns["description"]];
                                        }

                                        if ($imageDatabase["link"] == ""){
                                            $image["link"] = $data[$columns["link"]];
                                        }

                                        $imageModel->update($data[$columns["id"]], $image);
                                    }

                                }

                            }else{
                                //add error to error array
                                array_push($errors, ["image" => $data[$columns["name"]], "message" => "you don't have permission to edit this ID"]);
                            }
                            $row++;
                        }
                    }
                }else{
                    //add error to error array
                    array_push($errors, ["row" => 0, "message" => "File Could not be read"]);
                }
                fclose($handle);
            }

            //delete caches images
            if (file_exists("../writable/cache/ImageImage_Detail")) {
                unlink("../writable/cache/ImageImage_Detail");
                unlink("../writable/cache/ImageImage_List");
            }

            //delete caches categories
            if (file_exists("../writable/cache/CategoryCategory_Detail")) {
                unlink("../writable/cache/CategoryCategory_Detail");
                unlink("../writable/cache/CategoryCategory_List");
            }

            //delete caches collections
            if (file_exists("../writable/cache/CollectionCollection_Detail")) {
                unlink("../writable/cache/CollectionCollection_Detail");
                unlink("../writable/cache/CollectionCollection_List");
            }
            
            // echo var_dump($structure);

            //if there were errors say so
            if (count($errors) > 0) {
                throw new RuntimeException(json_encode($errors));
            } else {
                if ($dryrun){
                    $this->upload(false);
                }
            }

        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode($e->getMessage());
            exit;
        }
    }

    public function makeCSV($group)
    {
        $imageModel = new ImageModel();
        $colModel = new CollectionModel();
        $catModel = new CategoryModel();
        $session = session();
        $assets = new Assets();

        $ids = $imageModel->getAllIds($session->get("brand_name"));


        if ($group == "detail") {
            $assets->makeCSV(["id", "uploaded_name", "name", "description", "link", "collection_name", "category_name"]);
            foreach ($ids as $id) {
                $image = $imageModel->getImage($id, assoc: true)[0];
                if (preg_match("/\.validate$/", $image["description"]) == 1) {
                    //append to csv
                    $description = explode(".validate", $image["description"])[0];
                    $csvData = [
                        $id,
                        $description,
                        "",
                        "",
                        "",
                        "",
                        ""
                    ];
                    $assets->writeLineCSV($csvData);
                }
            }
        } else {
            $assets->makeCSV(["id", "name", "description", "link", "collection_name", "category_name"]);
            foreach ($ids as $id) {
                //append to csv
                $image = $imageModel->getImage($id, assoc: true)[0];
                $collection = $colModel->getCollection($image["collection_id"], ["name", "category_id"], assoc: true);
                $catname = $catModel->getCategory($collection["category_id"], filter: ["name"]);

                if (preg_match("/\.validate$/", $image["description"]) == 1) {
                    $image["name"] = explode(".validate", $image["description"])[0];
                    $image["description"] = "";
                }

                $csvData = [
                    $id,
                    $image["name"],
                    $image["description"],
                    $image["link"],
                    $collection["name"],
                    $catname
                ];
                $assets->writeLineCSV($csvData);
            }
        }

        header("Content-Type: " . "text/csv");
        readfile($assets->getCSV());
        $assets->deleteCSV();
        exit;
    }
}
