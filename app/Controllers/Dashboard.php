<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\SubscriptionModel;
use App\Models\BrandModel;
use App\Models\ImageModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $subModel = new SubscriptionModel();
        $session = session();

        $imageLimit = $subModel->getLimit($session->get("user_id"), "imageLimit");
        $userLimit = $subModel->getLimit($session->get("user_id"), "userLimit");
        $brandLimit = $subModel->getLimit($session->get("user_id"), "brandLimit");

        $currentImage = $subModel->getCurrentImageCount($session->get("user_id"));
        $currentUser = $subModel->getCurrentUserCount($session->get("user_id"));
        $currentBrand = $subModel->getCurrrentBrandCount($session->get("user_id"));

        $data = [
            "limits" => [
                "images" => ["limit" => $imageLimit, "count" => $currentImage],
                "users" => ["limit" => $userLimit, "count" => $currentUser],
                "brands" => ["limit" => $brandLimit, "count" => $currentBrand]
            ]
        ];

        return Navigation::renderNavBar("Dashboard") . view('Dashboard', $data) . Navigation::renderFooter();
    }
}
