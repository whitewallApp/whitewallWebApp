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

        $brandID = $brandModel->getBrand("Beautiful AI", filter: ["id"], fetchBy: "name");
        $appID = $appModel->getIdByBrandId($brandID);

        $notifications = $notModel->getNotification($appID, fetchBy: "mobleApp_id", assoc: true);

        $data = [
            "notifications" => $notifications
        ];

        return view('Notifications', $data);
    }
}

?>
