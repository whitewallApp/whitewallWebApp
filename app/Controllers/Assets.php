<?php

namespace App\Controllers;

use App\Models\UserModel;

class Assets extends BaseController {
    
    /**
     * Constructor
     *
     * @access    public
     */

     private $imgPath;
     private $collPath;
     private $catPath;
     private $userPath;
     private $session;
    
    public function __construct(){
        $this->session = session();

        $userModel = new UserModel();
        $accountId = $userModel->getUser($this->session->get("user_id"), filter: ["account_id"]);

        $this->imgPath = getenv("BASE_PATH") . $accountId . "/" . $this->session->get("brand_name") . "/images/";
        $this->catPath = getenv("BASE_PATH") . $accountId . "/" . $this->session->get("brand_name") . "/images/categories/";
        $this->userPath = getenv("BASE_PATH") . $accountId . "/users/";
        $this->collPath = getenv("BASE_PATH") . $accountId . "/" . $this->session->get("brand_name") . "/images/collections/";  
    }
    /**
     * Returns image files
     *
     * @access    public
     * @param    string    file path
     */
    function images($file)
    {
        if (file_exists($this->imgPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            header("Content-type: " . "image/" . $matches[1]);
            require($this->imgPath . $file);
            exit;
        }
    }

    function catImages($file)
    {
        if (file_exists($this->catPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            header("Content-type: " . "image/" . $matches[1]);
            require($this->catPath . $file);
            exit;
        }
    }

    function colImages($file)
    {
        if (file_exists($this->collPath . $file)){

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            header("Content-type: " . "image/" . $matches[1]);
            require($this->collPath . $file);
            exit;
        }else{
            
        }
    }

    public function saveProfilePhoto($userId, $imgName, $tmpPath): string
    {
        $matches = [];
        preg_match("/\.(.*)/", $imgName, $matches);

        $path = $this->userPath . $userId . $matches[0];
        $dir = $this->userPath;

        if (is_dir($dir)) {
            if (!file_exists($path)) {
                move_uploaded_file($tmpPath, $path);
            }
        } else {
            mkdir($dir, recursive: true);
            if (!file_exists($path)) {
                move_uploaded_file($tmpPath, $path);
            }
        }

        return "assets/user/" . $userId . $matches[0];
    }
}

?>