<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;
use RuntimeException;

class Category extends BaseController
{
    public function index()
    {
        $session = session();
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;
        $brandModel = new BrandModel;
        $brandname = $session->get("brand_name");

        $ids = $catModel->getCollumn("id", $brandname);
        $colIds = $colModel->getCollumn("id", $brandname);

        $categories = [];

        foreach ($ids as $id){
            $category = $catModel->getCategory($id, assoc: true);

            foreach($colIds as $colId){
                $colCatId = $colModel->getCollection($colId, filter: ["category_id", "name"], assoc: true);

                if ($colCatId["category_id"] == $id){
                    $category["collectionName"] = $colCatId["name"];
                }else{
                    $category["collectionName"] = "None";
                }
            }

            array_push($categories, $category);
        }


        $data = [
            "categories" => $categories,
        ];

        return Navigation::renderNavBar("Categories","categories", [true, "Images"]) . view('Category/Category_Detail', $data) . Navigation::renderFooter();
    }

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $catModel = new CategoryModel;
            $brandname = $session->get("brand_name");

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $req = $request->getVar("UpperReq", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($req == "true"){
                return json_encode($catModel->getCollumn("name", $brandname));
            }

            $category = $catModel->getCategory($id, fetchBy: "name", assoc: true);

            return json_encode($category);
        }else{
            return json_encode(["success" => false]);
        }
    }

    public function update(){
        $categoryModel = new CategoryModel();
        $assets = new Assets();

        //delete caches
        if (file_exists("../writable/cache/CategoryCategory_Detail")) {
            unlink("../writable/cache/CategoryCategory_Detail");
            unlink("../writable/cache/CategoryCategory_List");
        }

        try {
            $brandModel = new BrandModel();
            $session = session();
            $post = $this->request->getPost(["id", "name", "description", "link"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($post["id"] == "undefined"){
                $data = [
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "link" => $post["link"],
                    "brand_id" => $brandModel->getBrand($session->get("brand_name"), "name", ["id"])
                ];

                if (count($this->request->getFiles()) > 0){
                    $file = $this->request->getFile("file");

                    if (!$file->isValid()){
                        throw new RuntimeException("Invalid File");
                    }

                    $name = $assets->saveCategory($file->getTempName(), $file->guessExtension());
                    $data["iconPath"] = "/assets/category/" . $name;
                }

                $categoryModel->save($data);
                return json_encode(["success" => true]);
                die;
            }


            if (count($_FILES) > 0){
                //get rid of the assets/category/
                $oldName = (string)$categoryModel->getCategory($post["id"], filter: ["iconPath"]);
                $tmpPath = htmlspecialchars($_FILES["file"]["tmp_name"]);

                $type = $this->request->getPost("type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $type = explode("image/", (string)$type)[1];

                if ($type == "svg+xml"){
                    $type = "svg";
                }

                if ($oldName == ""){
                    $newName = $assets->saveCategory($tmpPath, $type);
                }else{
                    $oldName = explode("category/", $oldName)[1];
                    $newName = $assets->updateCategory($tmpPath, $type, $oldName);
                }

                if(!$newName){
                    return json_encode(["success" => false, "message" => "File Error"]);
                    exit();
                }

                $data = [
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "iconPath" => "/assets/category/" . $newName,
                    "link" => $post["link"]
                ];

                $categoryModel->updateCategory($post["id"], $data);
            }else{
                $data = [
                    "name" => $post["name"],
                    "description" => $post["description"],
                    "link" => $post["link"]
                ];

                $categoryModel->updateCategory($post["id"], $data);
            }

            return json_encode(["success" => true]);
        }catch (\Exception $e){
            http_response_code(400);
            return json_encode($e->getMessage());
            die;
        }
    }

    //delete collections
    public function delete()
    {
        try {
            $catModel = new CategoryModel();
            $colModel = new CollectionModel();
            $session = session();
            $assets = new Assets();

            //bulk image or single
            if ($this->request->getPost("ids") != null) {
                $ids = filter_var_array(json_decode((string)$this->request->getPost("ids")), FILTER_SANITIZE_SPECIAL_CHARS);
                $dbids = $catModel->getCollumn("name", $session->get("brand_name"));

                $vallidIds = array_intersect($dbids, $ids);

                if (count($vallidIds) > 1) {
                    array_shift($vallidIds);
                }

                $colIds = $colModel->getAllIds($session->get("brand_name"));
                
                foreach($vallidIds as $id){
                    $category = $catModel->getCategory($id, "name", ["iconPath", "id"], true);

                    //foreign key check
                    foreach($colIds as $colId){
                        $collCatId = $colModel->getCollection($colId, ["category_id"]);
                        if ($collCatId == $category["id"]){
                            throw new RuntimeException("You can not delete a category that contains collections");
                        }
                    }

                    //delete assets
                    if ($category["iconPath"] != "" && preg_match("/http/", $category["iconPath"]) != 1) {
                        $name = explode("/", $category["iconPath"])[3];
                        $assets->removeCategory($name);
                    }

                    $catModel->delete($category["id"]);
                }

            } else {
                $id = $this->request->getPost("id", FILTER_SANITIZE_SPECIAL_CHARS);

                if ($id != null){
                    $category = $catModel->getCategory($id, assoc: true);
                    $dbids = $catModel->getCollumn("id", $session->get("brand_name"));

                    $validId = array_intersect($dbids, [$id]);

                    //foreign key check
                    $colIds = $colModel->getAllIds($session->get("brand_name"));
                    foreach($colIds as $colId){
                        $collection = $colModel->getCollection($colId, assoc: true);
                        if ($category["id"] == $collection["category_id"]){
                            throw new RuntimeException("You can not delete a category that contains collections");
                        }
                    }

                    //delete assets
                    if ($category["iconPath"] != "" && preg_match("/http/", $category["iconPath"]) != 1) {
                        $name = explode("/", $category["iconPath"])[3];
                        $assets->removeCategory($name);
                    }

                    $catModel->delete($validId);
                }
            }
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["message" => $e->getMessage()]);
            exit;
        }
    }
}
