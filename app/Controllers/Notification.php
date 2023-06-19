<?php

namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\ImageModel;
use App\Models\AppModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\MenuModel;
use App\Controllers\Navigation;
use App\Models\UserModel;

class Notification extends BaseController
{
    public function index()
    {
        $session = session();
        $brandModel = new BrandModel;
        $notModel = new NotificationModel;
        $menuModel = new MenuModel();
        $imageModel = new ImageModel;
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;
        $brandID = $session->get("brand_id");

        //add time to notifications
        $notifications = $notModel->getNotification($brandID, fetchBy: "brand_id");
        foreach ($notifications as &$notification) {
            $date = date_create($notification["sendTime"]); //TODO: this will need conversion
            $notification["sendTime"] = date_format($date, "m/d/Y h:m:s A");
        }

        //set up the images
        $ids = $imageModel->getAllIds($brandID);
        $images = [];

        foreach($ids as $id){
            array_push($images, $imageModel->getImage($id, filter: ["id", "name"], assoc: true));
        }

        //get collection category images array
        $catNames = $catModel->getCollumn("name", $brandID);
        $categories = [];

        foreach ($catNames as $category) {
            $catID = $catModel->getCategory($category, "name", ["id"]);
            $colIDs = $colModel->getCollumn("id", $brandID, ["category_id" => $catID]); //gets an ID but will later be removed to be an array of images

            $collections = [];

            foreach($colIDs as $colID){
                $collections[$colModel->getCollection($colID, ["name"])] = $imageModel->getCollumn("name", $brandID, ["collection_id" => $colID]);
            }


            $categories[$category] = $collections;
        }

        $data = [
            "notifications" => $notifications,
            "images" => $images,
            "categories" => $categories,
            "menuItems" => $menuModel->getCollumn("title", $brandID),
        ];

        return Navigation::renderNavBar("Notifications", "notifications", [true, "Notifications"]) . view('Notifications', $data) . Navigation::renderFooter();
    }

    //get the data
    public function post(){
        $session = session();
        $request = \Config\Services::request();
        $notModel = new NotificationModel;
        $imgModel = new ImageModel();
        $colModel = new CollectionModel;
        $catModel = new CategoryModel;

        $postid = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $ids = $notModel->getCollumn("id", $session->get("brand_id"));
        $notification = [];
        foreach ($ids as $id) {
            if ($postid == $id) {
                $notification = $notModel->getNotification($id, assoc: true)[0];

                $data = (array)json_decode($notification["data"]);
                $data["clickAction"] = (array)$data["clickAction"];
                $data["forceAction"] = (array)$data["forceAction"];

                if ($data["clickAction"]["type"] == "App") {
                    if ($data["clickAction"]["idType"] == "category") {
                        $data["clickAction"]["data"] = $catModel->getCategory($data["clickAction"]["data"], filter: ["name"]);
                    }
                    if ($data["clickAction"]["idType"] == "collection") {
                        $data["clickAction"]["data"] = $colModel->getCollection($data["clickAction"]["data"], ["name"]);
                    }
                    if ($data["clickAction"]["idType"] == "image") {
                        $data["clickAction"]["data"] = $imgModel->getImage($data["clickAction"]["data"], filter: ["name"]);
                    }
                }

                $notification["data"] = $data;
            }
        }

        return json_encode($notification);
    }

    public function update(){
        $notModel = new NotificationModel();
        $imgModel = new ImageModel();
        $menuModel = new MenuModel();
        $catModel = new CategoryModel();
        $colModel = new CollectionModel();
        $userModel = new UserModel();
        $session = session();
        $post = $this->request->getPost(["id", "title", "description", "sendtime"], FILTER_SANITIZE_SPECIAL_CHARS);
        $permission = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"), ["images"], ["p_add"]);
        $session = session();

        //sanitize JSON
        $data = (string)$this->request->getPost("data");
        $data = (array)json_decode($data);
        $data["clickAction"] = filter_var_array((array)$data["clickAction"], FILTER_SANITIZE_SPECIAL_CHARS);

        $data["forceAction"] = filter_var_array((array)$data["forceAction"], 
            ["activated" => ["filter" => FILTER_VALIDATE_BOOL],
            "imageId" => ["filter" => FILTER_VALIDATE_INT]
            ]
        );
        
        if ($data["clickAction"]["type"] == "App"){
            if ($data["clickAction"]["idType"] == "category"){
                $data["clickAction"]["data"] = $catModel->getCategory($data["clickAction"]["data"], "name", ["id"]);
            }
            if ($data["clickAction"]["idType"] == "collection") {
                $data["clickAction"]["data"] = $colModel->getCollection($data["clickAction"]["data"], ["id"], "name");
            }
            if ($data["clickAction"]["idType"] == "image") {
                $data["clickAction"]["data"] = $imgModel->getImage($data["clickAction"]["data"], "name", ["id"]);
            }
        }

        $row = [
            "title" => $post["title"],
            "description" => $post["description"],
            "sendTime" => $post["sendtime"],
            "data" => json_encode($data)
        ];


        if ($post["id"] == "undefined" && $permission){
            $row["brand_id"] = $session->get("brand_id");
            $notModel->insert($row);
        }else{
            $ids = $notModel->getCollumn("id", $session->get("brand_id"));
            foreach($ids as $id){
                if ($post["id"] == $id){
                    $notModel->update($id, $row);
                }
            }
        }

        return json_encode(["success" => true]);
    }

    public function delete(){
        try {
            $notModel = new NotificationModel();
            $session = session();

            if ($this->request->getPost("ids") != null) {
                $ids = filter_var_array(json_decode((string)$this->request->getPost("ids")), FILTER_SANITIZE_NUMBER_INT);
                $dbids = $notModel->getCollumn("id", $session->get("brand_id"));

                $vallidIds = array_intersect($dbids, $ids);

                $notModel->delete($vallidIds);
            } else {
                $id = $this->request->getPost("id", FILTER_SANITIZE_NUMBER_INT);
                $dbids = $notModel->getCollumn("id", $session->get("brand_id"));

                foreach ($dbids as $dbid) {
                    if ($dbid == $id) {
                        $notModel->delete($id);
                    }
                }
            }
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode($e->getMessage());
            exit;
        }
    }
}
