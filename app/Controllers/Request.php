<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\CategoryModel;
use App\Models\CollectionModel;
use App\Models\ImageModel;
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

        //get the categories
        foreach ($catIds as $catId){
            $category = $this->categoryModel->getCategory($catId);
            if ($category["active"]){
                $icon = $category["iconPath"];
                if (!is_null($icon)){
                    if (preg_match("/^http/", $icon) == "0"){
                        $icon = "/requests/v1/category/" . explode("/", $category["iconPath"])[3];
                    }
                }else{
                    $icon = "";
                }

                $data[$category["name"]] = [
                    "image" => $icon,
                    "link" => $category["link"],
                    "collections" => []
                ];
                
                //get the collections
                $collectionIds = $this->collectionModel->getCollumn("id", $category["id"], getBy: "category_id");
                foreach($collectionIds as $colId){
                    $colId = $colId["id"];
                    $collection = $this->collectionModel->getCollection($colId);
                    if ($collection["active"]){
                        $icon = $collection["iconPath"];
                        if (!is_null($icon)) {
                            if (preg_match("/^http/", $icon) == "0") {
                                $icon = "/requests/v1/collection/" . explode("/", $collection["iconPath"])[3];
                            }
                        } else {
                            $icon = "";
                        }

                        $data[$category["name"]]["collections"][$collection["name"]] = [
                            "image" => $icon,
                            "link" => $collection["link"],
                            "images" => []
                        ];

                        $imageids = $this->imageModel->getCollumn("id", $collection["id"], getBy: "collection_id");
                        foreach($imageids as $imageid){
                            $imageid = $imageid["id"];
                            $image = $this->imageModel->getImage($imageid)[0];

                            $thumbnail = $image["thumbnail"];
                            $icon = $image["imagePath"];

                            if (!is_null($thumbnail)) {
                                if (preg_match("/^http/", $thumbnail) == "0") {
                                    $thumbnail = "/requests/v1/image/thumbnail/" . explode("/", $image["thumbnail"])[3];
                                }
                            } else {
                                $thumbnail = "";
                            }

                            if (!is_null($icon)) {
                                if (preg_match("/^http/", $icon) == "0") {
                                    $icon = "/requests/v1/image/" . explode("/", $image["imagePath"])[3];
                                }
                            } else {
                                $icon = "";
                            }


                            $data[$category["name"]]["collections"][$collection["name"]]["images"][$image["name"]]= [
                                "thumbnail" => $thumbnail,
                                "imagePath" => $icon,
                                "link" => $image["link"]
                            ];
                        }
                    }
                }
            }
        }

        echo json_encode($data);
    }

    //branding
    public function brandingImages($type){

    }

    public function branding(){

    }

    //images
    public function images($image, $thumbnail){

    }

    public function collections($image, $thumbnail){

    }

    public function categories($image, $thumbnail){

    }
}
