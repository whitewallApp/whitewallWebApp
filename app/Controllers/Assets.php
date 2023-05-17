<?php

namespace App\Controllers;

use App\Models\BrandModel;
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

            $type = $this->mapType($matches[1]);

            // echo $type;

            header("Content-Type: " . "image/" . $type);
            readfile($this->imgPath . $file);
            exit;
        }else{
            return view("errors/html/error_404", ["message" => "sorry we can't find that file"]);
        }
    }

    function catImages($file)
    {
        if (file_exists($this->catPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            header("Content-Type: " . "image/" . $type);
            readfile($this->catPath . $file);
            exit;
        } else {
            return view("errors/html/error_404", ["message" => "sorry we can't find that file"]);
        }
    }

    function colImages($file)
    {
        if (file_exists($this->collPath . $file)){

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            header("Content-Type: " . "image/" . $type);
            readfile($this->collPath . $file);
            exit;
        } else {
            return view("errors/html/error_404", ["message" => "sorry we can't find that file"]);
        }
    }

    function user($file){
        if (file_exists($this->userPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            header("Content-Type: " . "image/" . $type);
            readfile($this->userPath . $file);
            exit;
        } else {
            return view("errors/html/error_404", ["message" => "sorry we can't find that file"]);
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

    /**
     * Saves the image file to the correct directory
     *
     * @param string $tmpPath | The temp path from the file upload
     * @param string $type | the type of image (png, jpg, bmp, webp)
     * @return string | the unique file name to save in database
     */
    public function saveImage($tmpPath, $type){

        $filename = tempnam($this->imgPath, '');
        unlink($filename); // Need to delete the created tmp file, just want the name

        $file = explode(".tmp", $filename)[0];
        $file = $file . "." . $type;

        if(move_uploaded_file($tmpPath, $file)){
            return explode("images\\", $file)[1];
        }else{
            return false;
        }
        
    }

    /**
     * updated the image by deleting the old one then saving the new one
     *
     * @param string $tmpPath | the temporary path of the new image
     * @param string $type | the type of the image (png, jpg, bmp, webp)
     * @param string $oldPath | the old name/path of the image
     * @return string name of the new file
     */
    public function updateImage($tmpPath, $type, $oldPath){
        unlink($this->imgPath . $oldPath);
        return $this->saveImage($tmpPath, $type);
    }

    private function mapType($inputType): string {
        return match ($inputType) {
            "png" => "png",
            "svg" => "svg+xml",
            "jpg", "jpeg", "jfif" => "jpg",
            "webp" => "webp",
            "ico", "cur" => "x-icon",
            "bmp" => "bmp",
            "tiff", "tif" => "tiff"
        };
    }
}

?>