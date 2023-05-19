<?php

namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\BrandModel;
use App\Controllers\Navigation;

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
                }
            }

            array_push($categories, $category);
        }


        $data = [
            "categories" => $categories,
        ];

        return Navigation::renderNavBar("Categories", [true, "Images"]) . view('Category/Category_Detail', $data, ["cache" => 86400]) . Navigation::renderFooter();
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

        $post = $this->request->getPost(["id", "name", "description", "link"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        if (count($_FILES) > 0){
            //get rid of the assets/category/
            $oldName = explode("category/", (string)$categoryModel->getCategory($post["id"], filter: ["iconPath"]))[1];
            $tmpPath = htmlspecialchars($_FILES["file"]["tmp_name"]);
            $type = $this->request->getPost("type", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $newName = $assets->updateCategory($tmpPath, $type, $oldName);

            if(!$newName){
                return json_encode(["success" => false, "message" => "File Error"]);
                exit();
            }

            $data = [
                "name" => $post["name"],
                "description" => $post["description"],
                "iconPath" => "assets/category/" . $newName,
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
    }
}
