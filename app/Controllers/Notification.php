<?php

namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\ImageModel;
use App\Models\AppModel;
use App\Models\BrandModel;

class Notification extends BaseController
{
    public function index()
    {
        $brandModel = new BrandModel;
        $appModel = new AppModel;
        $notModel = new NotificationModel;
        $imageModel = new ImageModel;

        $brandID = $brandModel->getBrand("Beautiful AI", filter: ["id"], fetchBy: "name");
        $appID = $appModel->getIdByBrandId($brandID);

        $notifications = $notModel->getNotification($appID, fetchBy: "mobleApp_id", assoc: true);

        foreach ($notifications as &$notification) {
            $date = date_create($notification["sendTime"]); //TODO: this will need conversion
            $notification["sendTime"] = date_format($date, "m/d/Y h:m:s A");
        }

        $ids = $imageModel->getAllIds("Beautiful AI");
        $images = [];

        foreach($ids as $id){
            array_push($images, $imageModel->getImage($id, filter: ["image.id", "name"], assoc: true));
        }

        $data = [
            "notifications" => $notifications,
            "images" => $images
        ];

        return view('Notifications', $data);
    }

    public function post(){
        $request = \Config\Services::request();
        $notModel = new NotificationModel;

        $id = $request->getPost("id", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        return json_encode($notModel->getNotification($id, assoc: true));

    }
}

?>
