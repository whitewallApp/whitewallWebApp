<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\UserModel;

class FileControler {

    public $basePath;

    public function __construct()
    {
        // Legal initialization.
        $this->basePath = getenv("BASE_PATH");
    }

    public function saveImage(){

    }

    public function saveCollection(){

    }

    public function saveCategory(){

    }

    public function saveBrandInfo(){

    }

    public function saveProfilePhoto($userId, $brandName, $photoName, $tmpPath){
        $userModel = new UserModel();
        $accountId = $userModel->getUser($userId, filter: ["account_id"]);

        $brandModel = new BrandModel();
        $brandId = $brandModel->getBrand($brandName, "name", ["id"]);

        $path = $this->basePath . $accountId . "/" . $brandId . "/users/" . $photoName;
        $dir = $this->basePath . $accountId . "/" . $brandId . "/users/";

        if (is_dir($dir)){
            if (!file_exists($path)){
                move_uploaded_file($tmpPath, $path);
            }
        }else{
            mkdir($dir, recursive: true);
            if (!file_exists($path)) {
                move_uploaded_file($tmpPath, $path);
            }
        }
    }

    public function getImage(){

    }

    public function getCollection(){

    }

    public function getCategory(){

    }

    public function getProfilePhoto(){

    }
}

?>