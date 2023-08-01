<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;
use App\Models\SubscriptionModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Request extends BaseController
{
    private $brandModel;
    private $imageModel;
    private $collectionModel;
    private $categoryModel;
    private $apikey;
    private $accountId;
    private $brandId;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->brandModel = new BrandModel();
        $this->imageModel = new ImageModel();
        $this->collectionModel = new CollectionModel();
        $this->categoryModel = new CategoryModel();

        $this->apikey = $this->request->getGetPost("apikey");

        if (is_null($this->apikey) && array_key_exists("x-api-key", getallheaders())){
            $this->apikey = getallheaders()["x-api-key"];
        }
        
        if (is_null($this->apikey)){
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "No valid API key found"]);
            exit;
        }

        $brand = $this->brandModel->getBrand($this->apikey, "apikey", ["id", "account_id"], true);
        $this->accountId = $brand["account_id"];
        $this->brandId = $brand["id"];
    }

    //data object
    public function data(){
        //get collection category images array
        $data = [];
        $catIds = $this->categoryModel->getCollumn("id", $this->brandId);

        $accountId = $this->accountId;
        $brandId = $this->brandId;

        //get the categories
        foreach ($catIds as $catId){
            $category = $this->categoryModel->getCategory($catId);
            if ($category["active"]){

                $data[$category["name"]] = [
                    "image" => $category["iconPath"],
                    "link" => $category["link"],
                    "collections" => []
                ];
                
                //get the collections
                $collectionIds = $this->collectionModel->getCollumn("id", $category["id"], getBy: "category_id");
                foreach($collectionIds as $colId){
                    $colId = $colId;
                    $collection = $this->collectionModel->getCollection($colId);
                    if ($collection["active"]){
                        $data[$category["name"]]["collections"][$collection["name"]] = [
                            "image" => $collection["thumbnail"],
                            "link" => $collection["link"],
                            "images" => []
                        ];

                        $imageids = $this->imageModel->getCollumn("id", $collection["id"], getBy: "collection_id");
                        foreach($imageids as $imageid){
                            $imageid = $imageid["id"];
                            $image = $this->imageModel->getImage($imageid)[0];

                            if ($image["externalPath"]){
                                $data[$category["name"]]["collections"][$collection["name"]]["images"][$image["name"]]= [
                                    "thumbnail" => $image["thumbnail"],
                                    "imagePath" => $image["imagePath"],
                                    "description" => $image["description"],
                                    "action" => $image["callToAction"],
                                    "width" => getimagesize($image["imagePath"])[0],
                                    "height" => getimagesize($image["imagePath"])[1]
                                ];
                            }else{
                                $data[$category["name"]]["collections"][$collection["name"]]["images"][$image["name"]] = [
                                    "thumbnail" => $image["thumbnail"],
                                    "imagePath" => $image["imagePath"],
                                    "description" => $image["description"],
                                    "action" => $image["callToAction"],
                                    "width" => getimagesize(getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/" . explode("/", $image["imagePath"])[3])[0],
                                    "height" => getimagesize(getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/" . explode("/", $image["imagePath"])[3])[1],
                                ];
                            }
                        }
                    }
                }
            }
        }
        // header("Content-Type: " . "application/json");
        return json_encode($data);
    }

    public function branding(){
        $subModel = new SubscriptionModel();
        $branding = $this->brandModel->getBrand($this->brandId, filter: ["appIcon", "appLoading", "appHeading", "appBanner", "branding"], assoc: true);
        $branding["status"] = $subModel->getSubscription($this->accountId, "account_id", ["status"]);

        echo json_encode($branding);
    }

    public function menu(){

    }

    public function tracking(){
        $post = $this->request->getPost(["type", "name"], FILTER_SANITIZE_SPECIAL_CHARS);

        if ($post["type"] == "link"){
            $image = $this->imageModel->getImage($post["name"], fetchBy: "name", filter: ["id", "linkClick"], assoc: true);
            $this->imageModel->update($image["id"], ["linkClick" => intval($image["linkClick"]) + 1]);
        }

        if ($post["type"] == "wallpaper"){
            $image = $this->imageModel->getImage($post["name"], fetchBy: "name", filter: ["id", "wallpaperClick"], assoc: true);
            $this->imageModel->update($image["id"], ["wallpaperClick" => intval($image["wallpaperClick"]) + 1]);
        }
    }
}
