<?php

namespace App\Controllers;

use App\Models\ImageModel;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\SubscriptionModel;
use App\Models\UserModel;
use Google\Service\AndroidPublisher\Subscription;
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
        $brandId = $session->get("brand_id");
        $paginate = 10;

        if ($this->request->getGet("items") != null) {
            $paginate = $this->request->getGet("items", FILTER_SANITIZE_NUMBER_INT);
        }

        $dbImages = $imageModel->where("brand_id", $brandId)->paginate($paginate);

        $images = [];

        if ($this->request->getGet("collection") != null) {
            $collectionID = $this->request->getGet("collection", FILTER_SANITIZE_NUMBER_INT);

            if ($this->request->getGet("orderby") != null) {
                $column = $this->request->getGet("orderby", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $dbImages = $imageModel->where("brand_id", $brandId)->where("collection_id", $collectionID)->orderBy($column, "ASC")->paginate($paginate);
            } else {
                $dbImages = $imageModel->where("brand_id", $brandId)->where("collection_id", $collectionID)->paginate($paginate);
            }
        }

        if ($this->request->getGet("id") != null) {
            $imageID = $this->request->getGet("id", FILTER_SANITIZE_NUMBER_INT);
            $ids = $imageModel->getAllIds($brandId);
            foreach ($ids as $id) {
                if ($id == $imageID) {
                    $dbImages = $imageModel->getImage($id, assoc: true);
                }
            }
        }

        $collections = [];

        $dbcollections = $collModel->getAllIds($brandId);

        foreach ($dbcollections as $dbcollectionid) {
            $dbcollection = $collModel->getCollection($dbcollectionid);

            $collection = [
                "id" => $dbcollection["id"],
                "name" => $dbcollection["name"]
            ];
            array_push($collections, $collection);
        }

        $subModel = new SubscriptionModel();
        $amount = 0;
        $limit = $subModel->getLimit($session->get("user_id"), "imageLimit");
        foreach ($dbImages as $image) {
            $colID = $imageModel->getImage($image["id"], filter: ["collection_id"]);
            $catID = $collModel->getCollection($colID, filter: ["category_id"]);

            $run = true;
            if ($amount > $limit && $limit != 0) {
                $run = false;
            }

            if ($run) {
                $image = [
                    "id" => $image["id"],
                    "path" => $image["thumbnail"],
                    "name" => $image["name"],
                    "collection" => $collModel->getCollection($colID, filter: ["name"]),
                    "category" => $catModel->getCategory($catID, filter: ["name"])
                ];
                array_push($images, $image);
            }
            $amount++;
        }



        // compile data to be sent to view
        $data = [
            "images" => $images,
            'pager' => $imageModel->pager,
            "collections" => $collections,
            "pageamount" => $paginate
        ];

        return Navigation::renderNavBar("Images", "images", [true, "Images"]) . view('Image/Image_Detail', $data) . Navigation::renderFooter();
    }

    //get image data
    public function post()
    {
        $session = session();
        if ($session->get("logIn")) {
            $request = \Config\Services::request();
            $imageModel = new ImageModel;
            $colModel = new CollectionModel;
            $brandname = $session->get("brand_id");

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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

    //update the image
    public function update()
    {
        // try {
        $assets = new Assets();
        $imageModel = new ImageModel();
        $collectionModel = new CollectionModel();
        $brandModel = new BrandModel();
        $catModel = new CategoryModel();
        $session = session();

        //delete caches
        if (file_exists("../writable/cache/ImageImage_Detail")) {
            unlink("../writable/cache/ImageImage_Detail");
            unlink("../writable/cache/ImageImage_List");
        }

        if (isset($_POST["type"])) {
            //file -> file

            //check if they have reached the limit
            $subModel = new SubscriptionModel();
            $imageLimit = $subModel->getLimit($session->get("user_id"), "imageLimit");
            if ($subModel->checkImageLimit($session->get("user_id"), $imageLimit)) {
                throw new RuntimeException("Image Limit Reached");
            }

            $tmpPath = htmlspecialchars($_FILES["file"]["tmp_name"]);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));
            $type = explode("/", (string)$this->request->getPost("type"))[1];


            //create image
            if ($imageID == "undefined") {
                $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link", "actionText", "actionLink"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $collectionId = $collectionModel->getCollection($post["collection"], ["id"], "name");
                $brandId = $session->get("brand_id");

                $action = [
                    "name" => $post["actionText"],
                    "link" => $post["actionLink"]
                ];

                $data = [
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "externalPath" => $post["externalPath"],
                    "collection_id" => $collectionId,
                    "brand_id" => $brandId,
                    "callToAction" => json_encode($action)
                ];

                if ($post["externalPath"] == "0") {
                    $file = $this->request->getFile("file");
                    if (!$file->isValid()) {
                        throw new RuntimeException("Invalid File");
                    }

                    $name = $assets->saveImage($file->getTempName(), $file->guessExtension());
                    $data["imagePath"] = "/assets/images/" . $name;
                    $data["thumbnail"] = "/assets/images/thumbnail/" . $name;
                } else {
                    $data["imagePath"] = $post["link"];
                    $data["thumbnail"] = $post["link"];
                }

                $imageModel->updateImage($data, "");
                return json_encode(["success" => true]);
                die;
            }

            $name = $imageModel->getImage($imageID, filter: ["imagePath", "externalPath"], assoc: true);
            if ($name["externalPath"] == "0") {
                //get rid of the assets/images
                $name = explode("assets/images/", $name["imagePath"])[1];

                $newPath = $assets->updateImage($tmpPath, $type, $name);

                if ($newPath) { //if no error
                    $post = $this->request->getPost(["name", "description", "collection", "externalPath", "actionText", "actionLink"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $action = [
                        "name" => $post["actionText"],
                        "link" => $post["actionLink"]
                    ];

                    $data = [
                        "imagePath" => "/assets/images/" . $newPath,
                        "thumbnail" => "/assets/images/thumbnail/" . $newPath,
                        "name" => $post["name"],
                        "description" => $post["description"],
                        "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                        "externalPath" => $post["externalPath"],
                        "callToAction" => json_encode($action)
                    ];
                    $imageModel->updateImage($data, $imageID);
                }
            } else {
                //link -> file

                //check if they have reached the limit
                $subModel = new SubscriptionModel();
                $imageLimit = $subModel->getLimit($session->get("user_id"), "imageLimit");
                if ($subModel->checkImageLimit($session->get("user_id"), $imageLimit)) {
                    throw new RuntimeException("Image Limit Reached");
                }

                $name = $assets->saveImage($tmpPath, $type);

                $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link", "actionText", "actionLink"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                $action = [
                    "name" => $post["actionText"],
                    "link" => $post["actionLink"]
                ];

                $data = [
                    "imagePath" => "/assets/images/" . $name,
                    "thumbnail" => "/assets/images/thumbnail/" . $name,
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                    "externalPath" => $post["externalPath"],
                    "callToAction" => json_encode($action)
                ];
                $imageModel->updateImage($data, $imageID);
            }
        } else if (isset($_POST["link"])) {
            //link -> link or file -> link
            $post = $this->request->getPost(["name", "description", "collection", "externalPath", "link", "actionText", "actionLink"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));

            $action = [
                "name" => $post["actionText"],
                "link" => $post["actionLink"]
            ];

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
                "externalPath" => $post["externalPath"],
                "callToAction" => json_encode($action)
            ];
            $imageModel->updateImage($data, $imageID);
        } else {
            //update just the data
            $post = $this->request->getPost(["name", "description","collection", "actionText", "actionLink"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $imageID = htmlspecialchars((string)$this->request->getPost("id"));

            $action = [
                "name" => $post["actionText"],
                "link" => $post["actionLink"]
            ];

            $data = [
                "name" => $post["name"],
                "description" => $post["description"],
                "collection_id" => $collectionModel->getCollection($post["collection"], ["id"], "name"),
                "callToAction" => json_encode($action)
            ];
            $imageModel->updateImage($data, $imageID);
        }

        return json_encode(["success" => true]);
        // }catch (\Exception $e){
        //     http_response_code(403);
        //     return json_encode($e->getMessage());
        //     exit;
        // }
    }

    //delete images
    public function delete()
    {
        $imageModel = new ImageModel();
        $session = session();
        $assets = new Assets();

        //bulk image or single
        if ($this->request->getPost("ids") != null) {
            $ids = filter_var_array(json_decode((string)$this->request->getPost("ids")), FILTER_SANITIZE_NUMBER_INT);
            $dbids = $imageModel->getAllIds($session->get("brand_id"));

            $vallidIds = array_intersect($dbids, $ids);

            foreach ($vallidIds as $id) {
                $path = $imageModel->getImage($id, filter: ["imagePath"]);
                if (preg_match("/assets/", $path) == 1) {
                    $name = explode("/", $path)[3];
                    $assets->removeImage($name);
                }
                $imageModel->delete($id);
            }
        } else {
            $id = $this->request->getPost("id", FILTER_SANITIZE_NUMBER_INT);
            $dbids = $imageModel->getAllIds($session->get("brand_id"));

            foreach ($dbids as $dbid) {
                if ($dbid == $id) {
                    $path = $imageModel->getImage($id, filter: ["imagePath"]);
                    if (preg_match("/assets/", $path) == 1) {
                        $name = explode("/", $path)[3];
                        $assets->removeImage($name);
                    }
                    $imageModel->delete($id);
                }
            }
        }
    }

    //upload functions
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

        // try {
            if ($file != null) {
                if (!$file->isValid()) {
                    throw new RuntimeException($file->getErrorString() . '(' . $file->getError() . ')');
                }
            } else {
                throw new RuntimeException("Error uploading, clear cache, reload and try again");
            }

            $type = "";
            switch ($file->getMimeType()) {
                case 'text/csv':
                    $type = "csv";
                    break;
                case 'text/plain':
                    $type = "csv";
                    break;
                case 'image/webp':
                    $type = "image";
                    break;
                case 'image/jpg':
                    $type = "image";
                    break;
                case 'image/jpeg':
                    $type = "image";
                    break;
                case 'image/svg+xml':
                    $type = "image";
                    break;
                case 'image/png':
                    $type = "image";
                    break;
                case 'image/giff':
                    $type = "image";
                    break;
                default:
                    throw new RuntimeException($file->getMimeType() . " file is not an image");
                    break;
            }

            // if its an image save the image to the server and database
            if ($type == "image") {
                //check if they have reached the limit
                $subModel = new SubscriptionModel();
                $imageLimit = $subModel->getLimit($session->get("user_id"), "imageLimit");
                if ($subModel->checkImageLimit($session->get("user_id"), $imageLimit)) {
                    throw new RuntimeException("Image Limit Reached");
                }

                //check for duplicates
                $imageDescription = $imageModel->getCollumn("description", $session->get("brand_id"));

                foreach ($imageDescription as $description) {
                    $description = $description["description"];
                    if (preg_match("/" . $file->getName() . "/", $description) == 1) {
                        throw new RuntimeException("Dupicate Image Found");
                    }
                }

                //save the image
                $imagePath = $assets->saveImage($file->getTempName(), $file->guessExtension());

                //add image to database with their uploaded name add .validate to so we can grab it later if need be
                $tempName = htmlspecialchars($file->getName()) . ".validate";
                $colIds = $colModel->getAllIds($session->get("brand_id"));

                $data = [
                    "description" => $tempName,
                    "brand_id" => $session->get("brand_id"),
                    "collection_id" => $colIds[0],
                    "externalPath" => 0,
                    "imagePath" => "/assets/images/" . $imagePath,
                    "thumbnail" => "/assets/images/thumbnail/" . $imagePath
                ];

                $imageModel->insert($data);

                return json_encode(["status" => "success"]);
            }


            $errors = [];

            // if its a csv read in the images
            if ($type == "csv") {
                $overwrite = filter_var($this->request->getPost("overwrite", FILTER_SANITIZE_FULL_SPECIAL_CHARS), FILTER_VALIDATE_BOOL);
                $row = 1;
                if (($handle = fopen($this->request->getFile("file")->getTempName(), "r")) !== FALSE) {
                    $columns = [];
                    $ids = $imageModel->getAllIds($session->get("brand_id"));
                    $structure = [];
                    //read from csv while there is lines
                    while (($data = fgetcsv($handle, 1000)) !== FALSE) {

                        //sanitize csv row
                        foreach ($data as &$item) {
                            $item = strtolower(htmlspecialchars($item));
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

                            if ($imgfound || $data[$columns["id"]] == "") {

                                //check if a collection is in multipule categories
                                if (array_key_exists($data[$columns["collection_name"]], $structure)) {
                                    if ($structure[$data[$columns["collection_name"]]] != $data[$columns["category_name"]]) {
                                        array_push($errors, ["image" => $data[$columns["name"]], "message" => "A collection can't be in mulitpule categories"]);
                                        continue;
                                    }
                                } else {
                                    $structure[$data[$columns["collection_name"]]] = $data[$columns["category_name"]];
                                }

                                if (strlen($data[$columns["description"]]) > (255 - 10)) {
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Description must be under 245 characters"]);
                                }
                                if (strlen($data[$columns["name"]]) > (255)) {
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Name must be under 255 characters"]);
                                }

                                //check if collection and category is blank
                                if ($data[$columns["collection_name"]] == "") {
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Image must have a collection"]);
                                    continue;
                                }
                                if ($data[$columns["category_name"]] == "") {
                                    array_push($errors, ["image" => $data[$columns["name"]], "message" => "Image must have a category"]);
                                    continue;
                                }

                                //check if category exists
                                $catfound = false;
                                $categoryNames = $catModel->getCollumn("name", $session->get("brand_id"));
                                foreach ($categoryNames as $categoryName) {
                                    if ($categoryName == $data[$columns["category_name"]]) {
                                        $catfound = true;
                                    }
                                }

                                //check if collection exists
                                $colfound = false;
                                $columnNames = $colModel->getCollumn("name", $session->get("brand_id"));
                                foreach ($columnNames as $columnName) {
                                    if ($columnName == $data[$columns["collection_name"]]) {
                                        $colfound = true;
                                    }
                                }


                                $brandid = $session->get("brand_id");

                                // echo var_dump(["row" => $row, "collectionFound" => $colfound, "categoryFound" => $catfound]);

                                //don't do database stuff if dry run
                                if (!$dryrun) {
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
                                    if ($overwrite) {
                                        $action = [
                                            "name" => $data[$columns["action_text"]],
                                            "link" => $data[$columns["action_link"]]
                                        ];

                                        $image = [
                                            "name" => $data[$columns["name"]],
                                            "description" => $data[$columns["description"]],
                                            "imagePath" => $data[$columns["path"]],
                                            "collection_id" => $colModel->getCollection($data[$columns["collection_name"]], ["id"], "name"),
                                            "externalPath" => preg_match("/^http/", $data[$columns["path"]]),
                                            "brand_id" => $brandid,
                                            "callToAction" => json_encode($action)
                                        ];

                                        //delete the file if going file -> link
                                        if ($data[$columns["id"]] != "") {
                                            $imageDatabase = $imageModel->getImage($data[$columns["id"]], assoc: true)[0];
                                            if (preg_match("/^http/", $imageDatabase["imagePath"]) == 0 && preg_match("/^http/", $data[$columns["path"]]) == 1) {
                                                $assets->removeImage(explode("/images/", $imageDatabase["imagePath"])[1]);
                                                $image["thumbnail"] = $data[$columns["path"]];
                                            }
                                        }

                                        $imageModel->updateImage($image, $data[$columns["id"]]);
                                    } else {
                                        //grab the image if it exists in the db, if they want to update the image
                                        $imageDatabase = $imageModel->getImage($data[$columns["id"]], assoc: true);

                                        $action = [
                                            "name" => "Click here for Details",
                                            "link" => ""
                                        ];
                                        $image = [];
                                        if (count($imageDatabase) > 0) {
                                            $imageDatabase = $imageDatabase[0];
                                            $colDefaultId = $colModel->getCollection("Default Collection", ["id"], "name");

                                            if ($imageDatabase["name"] == "") {
                                                $image["name"] = $data[$columns["name"]];
                                            }

                                            if ($imageDatabase["description"] == "" || preg_match("/\.validate$/", $imageDatabase["description"]) == 1) {
                                                $image["description"] = $data[$columns["description"]];
                                            }

                                            if (((array)json_decode($imageDatabase["callToAction"]))["name"] == "Click here for Details" && $data[$columns["action_text"]] != "Click here for Details"){
                                                $action["name"] = $data[$columns["action_text"]];
                                            }

                                            if (((array)json_decode($imageDatabase["callToAction"]))["link"] == "" && $data[$columns["action_link"]] != "") {
                                                $action["link"] = $data[$columns["action_link"]];
                                            }

                                            if ($imageDatabase["collection_id"] == $colDefaultId){
                                                $image["collection_id"] == $colModel->getCollection($data[$columns["collection_name"]], ["id"], "name");
                                            }

                                            $image["callToAction"] = json_encode($action);
                                        } else {
                                            //if we need to create the image
                                            $image = [
                                                "name" => $data[$columns["name"]],
                                                "description" => $data[$columns["description"]],
                                                "thumbnail" => $data[$columns["path"]],
                                                "imagePath" => $data[$columns["path"]],
                                                "collection_id" => $colModel->getCollection($data[$columns["collection_name"]], ["id"], "name"),
                                                "brand_id" => $brandid
                                            ];
                                        }

                                        $image["externalPath"] = preg_match("/^https/", $data[$columns["path"]]);

                                        $imageModel->updateImage($image, $data[$columns["id"]]);
                                    }
                                }
                            } else {
                                //add error to error array
                                array_push($errors, ["image" => $data[$columns["name"]], "message" => "you don't have permission to edit this ID"]);
                            }
                            $row++;
                        }
                    }
                } else {
                    //add error to error array
                    array_push($errors, ["row" => 0, "message" => "File Could not be read"]);
                }
                fclose($handle);
            }

            //delete caches images
            if (file_exists("../../writable/cache/ImageImage_Detail")) {
                unlink("../../writable/cache/ImageImage_Detail");
                unlink("../../writable/cache/ImageImage_List");
            }

            //delete caches categories
            if (file_exists("../../writable/cache/CategoryCategory_Detail")) {
                unlink("../../writable/cache/CategoryCategory_Detail");
                unlink("../../writable/cache/CategoryCategory_List");
            }

            //delete caches collections
            if (file_exists("../../writable/cache/CollectionCollection_Detail")) {
                unlink("../../writable/cache/CollectionCollection_Detail");
                unlink("../../writable/cache/CollectionCollection_List");
            }


            //if there were errors say so
            if (count($errors) > 0) {
                throw new RuntimeException(json_encode($errors));
            } else {
                if ($dryrun) {
                    $this->upload(false);
                }
            }
        // } catch (\Exception $e) {
        //     http_response_code(400);
        //     echo json_encode($e->getMessage());
        //     exit;
        // }
    }

    public function makeCSV($group)
    {
        $imageModel = new ImageModel();
        $colModel = new CollectionModel();
        $catModel = new CategoryModel();
        $session = session();
        $assets = new Assets();

        $ids = $imageModel->getAllIds($session->get("brand_id"));


        if ($group == "detail") {
            $assets->makeCSV(["id", "path", "name", "description", "collection_name", "category_name", "action_text", "action_link"]);
            foreach ($ids as $id) {
                $image = $imageModel->getImage($id, assoc: true)[0];
                if (preg_match("/\.validate$/", $image["description"]) == 1) {
                    //append to csv
                    $description = explode(".validate", $image["description"])[0];
                    $csvData = [
                        $id,
                        $image["imagePath"],
                        "",
                        $description,
                        "",
                        "",
                        ((array)json_decode($image["callToAction"]))["name"],
                        ""
                    ];
                    $assets->writeLineCSV($csvData);
                }
            }
        } else {
            $assets->makeCSV(["id", "path", "name", "description", "collection_name", "category_name", "action_text", "action_link"]);
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
                    $image["imagePath"],
                    $image["name"],
                    $image["description"],
                    $collection["name"],
                    $catname,
                    ((array)json_decode($image["callToAction"]))["name"],
                    ((array)json_decode($image["callToAction"]))["link"]
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
