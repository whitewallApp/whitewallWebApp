<?php

namespace App\Controllers;
use App\Controllers\Navigation;
use App\Models\SubscriptionModel;
use App\Models\BrandModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;

use function PHPSTORM_META\type;

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

    public function regenerateThumbnails(){
        $session = session();
        $imageModel = new ImageModel();
        $brandModel = new BrandModel();
        $collModel = new CollectionModel();
        $assets = new Assets();

        set_time_limit(0);

        //regenerate image thumbnails
        $brand_id = $session->get("brand_id");
        $accountId = $brandModel->getBrand($brand_id, filter: ["account_id"]);
        $imgPath = getenv("BASE_PATH") . $accountId . "/" . $brand_id . "/images/";
        $collPath = getenv("BASE_PATH") . $accountId . "/" . $brand_id . "/images/collections/";

        $imgTmbPath = getenv("BASE_PATH") . $accountId . "/" . $brand_id . "/images/thumbnails/";
        $collTmbPath = getenv("BASE_PATH") . $accountId . "/" . $brand_id . "/images/collections/thumbnails/";

        $imageids = $imageModel->getAllIds($brand_id);

        foreach($imageids as $imageid){
            $image = $imageModel->getImage($imageid, assoc: true)[0];
            if ($image["imagePath"] != "" && preg_match("/^http/", $image["imagePath"]) != 1){
                $name = explode("/", $image["thumbnail"])[4];
                $type = explode(".", $name)[1];
                $file = $imgPath . $name;

                // unlink($file);

                $dst = $assets->generateThumbnail($file, $type);
                imagejpeg($dst, $imgTmbPath . $name);
            }
        }

        $colids = $collModel->getAllIds($brand_id);

        foreach ($colids as $colid) {
            $collection = $collModel->getCollection($colid, assoc: true);
            if ($collection["iconPath"] != null || $collection["iconPath"] != ""){
                $name = explode("/", $collection["iconPath"])[3];
                $type = explode(".", $name)[1];
                $file = $collPath . $name;

                // unlink($file);

                $dst = $assets->generateThumbnail($file, $type);
                imagejpeg($dst, $collTmbPath . $name);
                $collModel->update($colid, ["thumbnail" => "/assets/collection/thumbnail/" . $name]);
            }
        }
    }
}
