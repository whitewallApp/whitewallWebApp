<?php

namespace App\Controllers;
use App\Models\CollectionModel;
use App\Models\CategoryModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use App\Models\ImageModel;
use RuntimeException;

class Collection extends BaseController
{
    public function index()
    {
        $session = session();
        $collModel = new CollectionModel;
        $catModel = new CategoryModel;
        $brandModel = new BrandModel;
        $brandname = $session->get("brand_id");

        $ids = $collModel->getAllIds($brandname);
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
            "collections" => $collections,
            "categories" => $catModel->getCollumn("name", $session->get("brand_id"))
        ];

        return Navigation::renderNavBar("Collections", "collections") . view('Collection/Collection_Detail', $data) . Navigation::renderFooter();
    }

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $colModel = new CollectionModel;
            $catModel = new CategoryModel;
            $brandname = $session->get("brand_id");

            $id = $request->getVar("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true"){
                return json_encode($catModel->getCollumn("name", $brandname));
            }

            $id = $colModel->getIdByName($id);
            $exp = "/\/.*\/(.*)/";

            $collection = $colModel->getCollection($id, filter: ["id", "name", "dateUpdated", "description", "link", "iconPath", "category_id"], assoc: true);
            $collection["category_id"] = $catModel->getCategory($collection["category_id"], filter: ["name"]);

            //gets rid of the assets/collection
            $matches = []; 
            preg_match($exp, $collection["iconPath"], $matches);

            if (count($matches) > 0){
                $collection["iconPath"] = $matches[1];
            }

            $categories = $catModel->getCollumn("name", $brandname);
            $collection = array_merge($collection, ["categoryNames" => $categories]);

            return json_encode($collection);
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function update(){
        $session = session();
        try {
            $catModel = new CategoryModel();
            $colModel = new CollectionModel();
            $assets = new Assets();

            //delete caches
            if (file_exists("../writable/cache/CollectionCollection_Detail")){
                unlink("../writable/cache/CollectionCollection_Detail");
                unlink("../writable/cache/CollectionCollection_List");
            }

            $post = $this->request->getPost(["id", "name", "description", "link", "category"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $categoryId = $catModel->getCategory($post["category"], "name", ["id"]);

            //create the collection
            if ($post["id"] == "undefined"){
                $brandModel = new BrandModel();

                $data = [
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "link" => $post["link"],
                    "category_id" => $categoryId,
                    "brand_id" => $session->get("brand_id")
                ];

                if (count($this->request->getFiles()) > 0){
                    $file = $this->request->getFile("file");

                    if (!$file->isValid()){
                        throw new RuntimeException("Invalid File");
                    }

                    $name = $assets->saveCollection($file->getTempName(), $file->guessExtension());
                    $data["iconPath"] = "/assets/collection/" . $name;
                }

                $colModel->save($data);
                return json_encode(["success" => true]);
                die;
            }

            $data = [
                "name" => $post["name"],
                "description" => $post["description"],
                "link" => $post["link"],
                "category_id" => $categoryId
            ];

            if (count($_FILES) > 0){
                $type = $this->request->getPost("type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $type = explode("image/", (string)$type)[1];

                $oldPath = $colModel->getCollection($post["id"], ["iconPath"]);

                if ($oldPath == ""){
                    $data["iconPath"] = "/assets/collection/" . $assets->saveCollection($this->request->getFile("file")->getTempName(), $type);
                }else{
                    $oldName = explode("assets/collection/", $oldPath)[1];
                    $data["iconPath"] = "/assets/collection/" . $assets->updateCollection($this->request->getFile("file")->getTempName(), $type, $oldName);
                }
            }

            $colModel->updateCollection($post["id"], $data);

            return json_encode(["success" => true]);
        }catch (\Exception $e){
            http_response_code(400);
            return json_encode($e->getMessage());
            exit;
        }
    }

    //delete
    public function delete()
    {
        try {
            $collModel = new CollectionModel();
            $imageModel = new ImageModel();
            $session = session();
            $assets = new Assets();

            //bulk image or single
            if ($this->request->getPost("ids") != null) {
                $ids = filter_var_array(json_decode((string)$this->request->getPost("ids")), FILTER_SANITIZE_SPECIAL_CHARS);
                $dbids = $collModel->getCollumn("name", $session->get("brand_id"));

                $vallidIds = array_intersect($dbids, $ids);

                if (count($vallidIds) > 1){
                    array_shift($vallidIds);
                }

                $imageIds = $imageModel->getAllIds($session->get("brand_id"));

                foreach ($vallidIds as $id) {
                    $path = $collModel->getCollection($id, ["iconPath", "id"], "name", true);

                    foreach($imageIds as $imageId){
                        $imagecol = $imageModel->getImage($imageId, filter: ["collection_id"]);
                        if ($imagecol == $path["id"]){
                            throw new RuntimeException("You can not delete a collection that contains images");
                        }
                    }

                    if ($path["iconPath"] != "" && preg_match("/http/", $path["iconPath"]) != 1){
                        $name = explode("/", $path["iconPath"])[3];
                        $assets->removeCollection($name);
                    }

                    $collModel->delete($path["id"]);
                }
            } else {
                $id = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);

                if ($id != null) {
                    $collection = $collModel->getCollection($id, assoc: true);
                    $dbids = $collModel->getCollumn("id", $session->get("brand_id"));

                    $validId = array_intersect($dbids, [$id]);

                    //foreign key check
                    $imgIds = $imageModel->getAllIds($session->get("brand_id"));
                    foreach ($imgIds as $imgid) {
                        $image = $imageModel->getImage($imgid, assoc: true)[0];
                        if ($collection["id"] == $image["collection_id"]) {
                            throw new RuntimeException("You can not delete a collection that contains images");
                        }
                    }

                    //delete assets
                    if ($collection["iconPath"] != "" && preg_match("/http/", $collection["iconPath"]) != 1) {
                        $name = explode("/", $collection["iconPath"])[3];
                        $assets->removeCollection($name);
                    }

                    $collModel->delete($validId);
                }
            }
        }catch (\Exception $e){
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            exit;
        }
    }
}
