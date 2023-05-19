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
        $appModel = new AppModel;
        $notModel = new NotificationModel;
        $imageModel = new ImageModel;
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;
        $menuModel = new MenuModel;
        $brandname = $session->get("brand_name");

        $brandID = $brandModel->getBrand($brandname, filter: ["id"], fetchBy: "name");
        $appID = $appModel->getIdByBrandId($brandID);

        //add time to notifications
        $notifications = $notModel->getNotification($appID, fetchBy: "mobleApp_id");
        foreach ($notifications as &$notification) {
            $date = date_create($notification["sendTime"]); //TODO: this will need conversion
            $notification["sendTime"] = date_format($date, "m/d/Y h:m:s A");
        }

        //set up the images
        $ids = $imageModel->getAllIds($brandname);
        $images = [];

        foreach($ids as $id){
            array_push($images, $imageModel->getImage($id, filter: ["id", "name"], assoc: true));
        }

        //get collection category images array
        $catNames = $catModel->getCollumn("name", $brandname);
        $categories = [];

        foreach ($catNames as $category) {
            $catID = $catModel->getCategory($category, "name", ["id"]);
            $colIDs = $colModel->getCollumn("id", $brandname, ["category_id" => $catID]); //gets an ID but will later be removed to be an array of images

            $collections = [];

            foreach($colIDs as $colID){
                $collections[$colModel->getCollection($colID, ["name"])] = $imageModel->getCollumn("name", $brandname, ["collection_id" => $colID]);
            }


            $categories[$category] = $collections;
        }

        $data = [
            "notifications" => $notifications,
            "images" => $images,
            "categories" => $categories,
            "menuItems" => $menuModel->getCollumn("title", $brandname),
        ];

        return Navigation::renderNavBar("Notifications", [true, "Notifications"]) . view('Notifications', $data) . Navigation::renderFooter();
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

            $notification = $notModel->getNotification($id, assoc: true);

            if ($notification[0]["clickAction"] == "Wallpaper"){
                $notification[0]["data"] = $imgModel->getImage($notification[0]["data"], filter: ["name"]);
            }

            return json_encode($notification);
        }else{
            return json_encode(["success" => false]);
        }

    }
}
