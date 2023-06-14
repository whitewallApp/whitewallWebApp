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

    public function post(){
        $session = session();
        if ($session->get("logIn")){
            $request = \Config\Services::request();
            $notModel = new NotificationModel;
            $imgModel = new ImageModel();
            $colModel = new CollectionModel;
            $catModel = new CategoryModel;

            $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $notification = $notModel->getNotification($id, assoc: true)[0];

            if ($notification["clickAction"] == "Wallpaper"){
                $notification["data"] = $imgModel->getImage($notification["data"], filter: ["name"]);
            }

            if ($notification["forceWall"]){
                $notification["forceId"] = $imgModel->getImage($notification["forceId"], filter: ["name"]);
            }

            return json_encode($notification);
        }else{
            return json_encode(["success" => false]);
        }

    }

    public function update(){
        $notModel = new NotificationModel();
        $imgModel = new ImageModel();
        $menuModel = new MenuModel();
        $post = $this->request->getPost(["id", "title", "description", "sendtime", "selection", "forceSwitch", "data"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            "title" => $post["title"],
            "description" => $post["description"],
            "clickAction" => $post["selection"],
            "sendTime" => $post["sendtime"],
        ];

        if ($post["selection"] == "Wallpaper"){
            $data["data"] = $imgModel->getImage($post["data"], "name", ["id"]);
        }

        if ($post["selection"] == "App"){
            $appSelection = $this->request->getPost("appSelection", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if ($appSelection == "app"){
                $data["data"] = $imgModel->getImage($post["data"], "name", ["id"]);
            }
            if ($appSelection == "menu"){
                $data["data"] = $menuModel->getMenuItem($post["data"], ["id"], "title");
            }
        }

        if ($post["selection"] == "Link") {
            $data["data"] = $post["data"];
        }

        if ($post["forceSwitch"] == "true"){
            $wallpaperName = $this->request->getPost("forceWallpaper", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $data["forceId"] = $imgModel->getImage($wallpaperName, "name", ["id"]);
            $data["forceWall"] = true;
        }else{
            $data["forceWall"] = false;
        }

        if ($post["id"] == "undefined"){
            $brandModel = new BrandModel();
            $session = session();

            $data["brand_id"] = $session->get("brand_id");
            $notModel->save($data);
        }else{
            $notModel->update($post["id"], $data);
        }

        return json_encode(["success" => true]);
        // return json_encode($data);
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
