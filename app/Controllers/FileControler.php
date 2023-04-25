<?php

namespace App\Controllers;

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

    public function saveProfilePhoto($userId, $brandId, $photoName, $photo){
        $userModel = new UserModel();
        $accountId = $userModel->getUser($userId, filter: ["account_id"]);
        $path = $this->basePath . $accountId . "/" . $brandId . "/users/" . $photoName;

        if (!file_exists($path)){
            // move_uploaded_file()
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