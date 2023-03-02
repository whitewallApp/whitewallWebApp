<?php

namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\ImageModel;
use App\Models\AppModel;
use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;

class Notification extends BaseController
{
    public function index()
    {
        $brandModel = new BrandModel;
        $appModel = new AppModel;
        $notModel = new NotificationModel;
        $imageModel = new ImageModel;
        $catModel = new CategoryModel;
        $colModel = new CollectionModel;

        $brandID = $brandModel->getBrand("Beautiful AI", filter: ["id"], fetchBy: "name", assoc: true);
        $appID = $appModel->getIdByBrandId($brandID);

        //add time to notifications
        $notifications = $notModel->getNotification($appID, fetchBy: "mobleApp_id");
        foreach ($notifications as &$notification) {
            $date = date_create($notification["sendTime"]); //TODO: this will need conversion
            $notification["sendTime"] = date_format($date, "m/d/Y h:m:s A");
        }

        //set up the images
        $ids = $imageModel->getAllIds("Beautiful AI");
        $images = [];

        foreach($ids as $id){
            array_push($images, $imageModel->getImage($id, filter: ["image.id", "name"], assoc: true));
        }

        //get collection category images array
        $catNames = $catModel->getCollumn("name", "Beautiful AI");
        $categories = [];

        foreach ($catNames as $category) {
            $catID = $catModel->getCategory($category, "name", ["id"]);
            $colIDs = $colModel->getCollumn("id", "Beautiful AI", ["category_id" => $catID]); //gets an ID but will later be removed to be an array of images

            $collections = [];

            foreach($colIDs as $colID){
                $collections[$colModel->getCollection($colID, ["name"])] = $imageModel->getCollumn("name", "Beautiful AI", ["collection_id" => $colID]);
            }


            $categories[$category] = $collections;
        }

        $data = [
            "notifications" => $notifications,
            "images" => $images,
            "categories" => $categories
        ];

        return view('Notifications', $data);
    }

    public function post(){
        $request = \Config\Services::request();
        $notModel = new NotificationModel;
        $colModel = new CollectionModel;
        $catModel = new CategoryModel;

        $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        return json_encode($notModel->getNotification($id, assoc: true));

    }
}

?>
