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
    }

    //image data
    public function data(){
        
    }

    //branding
    public function brandingImages(){

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
