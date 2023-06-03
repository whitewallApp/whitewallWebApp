<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\UserModel;
use RuntimeException;

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
     private $menuPath;
     private $session;
     private $imgTmbPath;
    private $brandPath;
    
    public function __construct(){
        $this->session = session();

        $userModel = new UserModel();
        $brandModel = new BrandModel();
        $accountId = $userModel->getUser($this->session->get("user_id"), filter: ["account_id"]);
        $brandId = $brandModel->getBrand($this->session->get("brand_name"), "name", ["id"]);

        $this->imgPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/";
        $this->imgTmbPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/thumbnails/";
        $this->catPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/categories/";
        $this->userPath = getenv("BASE_PATH") . $accountId . "/users/";
        $this->collPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/images/collections/";
        $this->menuPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/menu/";
        $this->brandPath = getenv("BASE_PATH") . $accountId . "/" . $brandId . "/branding/";  

        //TODO if not a directory make a directory
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
            return view("errors/html/error_404", ["message" => "sorry we can't find that image"]);
        }
    }

    /**
     * Returns image files
     *
     * @access    public
     * @param    string    file path
     */
    function branding($file)
    {
        if (file_exists($this->brandPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            // echo $type;

            header("Content-Type: " . "image/" . $type);
            readfile($this->brandPath . $file);
            exit;
        } else {
            return view("errors/html/error_404", ["message" => "sorry we can't find that image"]);
        }
    }

    function imageThumbnail($file){
        if (file_exists($this->imgTmbPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            // echo $type;

            header("Content-Type: " . "image/" . $type);
            readfile($this->imgTmbPath . $file);
            exit;
        } else {
            return view("errors/html/error_404", ["message" => "sorry we can't find that thumbnail"]);
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

    function menu($file)
    {
        if (file_exists($this->menuPath . $file)) {

            $matches = [];
            preg_match("/\.(.*)/", $file, $matches);

            $type = $this->mapType($matches[1]);

            header("Content-Type: " . "image/" . $type);
            readfile($this->menuPath . $file);
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
     * Saves the image file to the correct directory and creates a thumbnail
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

            $tmbsizey = 200;
            $tmbsizex = (int)$tmbsizey / 1.778;

            $src = $this->correctImageOrientation($file, $type);

            $srcheight = imagesy($src);
            $srcwidth = (int)$srcheight / 1.778;

            $src = imagecrop($src, ["x" => ((imagesx($src) / 2) - ($srcwidth / 2)), "y" => 0, "width" => $srcwidth, "height" => $srcheight]);

            $dst = imagecreatetruecolor($tmbsizex, $tmbsizey);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $tmbsizex, $tmbsizey, $srcwidth, $srcheight);

            if (PHP_OS == "Linux"){
                $name = explode("images/", $file)[1];
                imagejpeg($dst, $this->imgTmbPath . $name);
                return $name;
            }else{
                $name = explode("images\\", $file)[1];
                imagejpeg($dst, $this->imgTmbPath . $name);
                return $name;
            }
        }else{
            return false;
        }
        
    }

    private function correctImageOrientation($filename, $type){
        try {
            if ($type == "JPG" || $type == "jpg" || $type == "jpeg" || $type == "tiff" || $type == "tiff"){
                $exif = exif_read_data($filename);
                if ($exif && isset($exif['Orientation'])) {
                    $orientation = $exif['Orientation'];
                    $img = $this->imagecreatefromfile($filename);
                    if ($orientation != 1) {
                        $deg = 0;
                        switch ($orientation) {
                            case 3:
                                $deg = 180;
                                break;
                            case 6:
                                $deg = 270;
                                break;
                            case 8:
                                $deg = 90;
                                break;
                        }
                        if ($deg) {
                            $img = imagerotate($img, $deg, 0);
                            return $img;
                        }
                    }else{
                        return $img;
                    }
                }else{
                    throw new RuntimeException("Image Malformated (exif data missing)");
                }
            }else{
                return $this->imagecreatefromfile($filename);
            }
        }catch (\Exception $e){
            return $this->imagecreatefromfile($filename);
        }
    }

    private function imagecreatefromfile($filename) {
        if (!file_exists($filename)) {
            throw new \InvalidArgumentException('File "' . $filename . '" not found.');
        }

        try {
            switch (strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
                case "JPG":
                case 'jpeg':
                case 'jpg':
                    return imagecreatefromjpeg($filename);
                    break;

                case 'png':
                    return imagecreatefrompng($filename);
                    break;

                case 'gif':
                    return imagecreatefromgif($filename);
                    break;

                case 'webp':
                    return imagecreatefromwebp($filename);
                    break;

                default:
                    throw new \InvalidArgumentException('File "' . $filename . '" is not valid jpg, png, webp or gif image.');
                    break;
            }
        }catch (\Exception $e){
            throw new \InvalidArgumentException('Error creating file: ' . $filename );
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
    public function updateImage($tmpPath, $type, $oldPath)
    {
        unlink($this->imgPath . $oldPath);
        return $this->saveImage($tmpPath, $type);
    }

    public function removeImage($fileName){
        unlink($this->imgPath . $fileName);
        unlink($this->imgTmbPath . $fileName);
    }

    /**
     * updated the image by deleting the old one then saving the new one
     *
     * @param string $tmpPath | the temporary path of the new image
     * @param string $type | the type of the image (png, jpg, bmp, webp)
     * @param string $oldPath | the old name/path of the image
     * @return string name of the new file
     */
    public function updateCollection($tmpPath, $type, $oldPath){
        unlink($this->collPath . $oldPath);
        return $this->saveCollection($tmpPath, $type);
    }

    /**
     * Saves the image file to the correct directory
     *
     * @param string $tmpPath | The temp path from the file upload
     * @param string $type | the type of image (png, jpg, bmp, webp)
     * @return string | the unique file name to save in database
     */
    public function saveCollection($tmpPath, $type)
    {

        $filename = tempnam($this->collPath, '');
        unlink($filename); // Need to delete the created tmp file, just want the name

        $file = explode(".tmp", $filename)[0];
        $file = $file . "." . $type;

        if (move_uploaded_file($tmpPath, $file)) {
            if (PHP_OS == "Linux") {
                return explode("collections/", $file)[1];
            } else {
                return explode("collections\\", $file)[1];
            }
        } else {
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
    public function updateCategory($tmpPath, $type, $oldPath)
    {
        unlink($this->catPath . $oldPath);
        return $this->saveCategory($tmpPath, $type);
    }

    /**
     * Saves the image file to the correct directory
     *
     * @param string $tmpPath | The temp path from the file upload
     * @param string $type | the type of image (png, jpg, bmp, webp)
     * @return string | the unique file name to save in database
     */
    public function saveCategory($tmpPath, $type)
    {

        $filename = tempnam($this->catPath, '');
        unlink($filename); // Need to delete the created tmp file, just want the name

        $file = explode(".tmp", $filename)[0];
        $file = $file . "." . $type;

        if (move_uploaded_file($tmpPath, $file)) {
            if (PHP_OS == "Linux") {
                return explode("categories/", $file)[1];
            } else {
                return explode("categories\\", $file)[1];
            }
        } else {
            return false;
        }
    }

    /**
     * Saves the image file to the correct directory
     *
     * @param string $tmpPath | The temp path from the file upload
     * @param string $type | the type of image (png, jpg, bmp, webp)
     * @return string | the unique file name to save in database
     */
    public function saveMenu($tmpPath, $type)
    {

        $filename = tempnam($this->menuPath, '');
        unlink($filename); // Need to delete the created tmp file, just want the name

        $file = explode(".tmp", $filename)[0];
        $file = $file . "." . $type;

        if (move_uploaded_file($tmpPath, $file)) {
            if (PHP_OS == "Linux") {
                return explode("menu/", $file)[1];
            } else {
                return explode("menu\\", $file)[1];
            }
        } else {
            return false;
        }
    }

    /**
     * Saves the image file to the correct directory
     *
     * @param string $tmpPath | The temp path from the file upload
     * @param string $type | the type of image (png, jpg, bmp, webp)
     * @return string | the unique file name to save in database
     */
    public function saveBrandImg($tmpPath, $type, $name)
    {
        $file = $this->brandPath . $name . "." . $type;

        if (move_uploaded_file($tmpPath, $file)) {
            return $name . "." . $type;
        } else {
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
    public function updateBrandImg($tmpPath, $type, $name)
    {
        unlink($this->brandPath . $name);
        $name = explode(".", $name)[0];
        return $this->saveBrandImg($tmpPath, $type, $name);
    }

    //image upload csv
    public function makeCSV($columns) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample.csv"');
        $fp = fopen($this->imgPath . "../images.csv", 'wb');
        fputcsv($fp, $columns);
        fclose($fp);
        return false;
    }

    public function writeLineCSV($data){
        $fp = fopen($this->imgPath . "../images.csv", 'a');
        fputcsv($fp, $data);
        fclose($fp);
    }

    public function getCSV(){
        return $this->imgPath . "../images.csv";
    }

    public function deleteCSV(){
        unlink($this->imgPath . "../images.csv");
    }

    private function mapType($inputType): string {
        return match ($inputType) {
            "png" => "png",
            "svg", => "svg+xml",
            "jpg", "jpeg", "jfif" => "jpg",
            "webp" => "webp",
            "ico", "cur" => "x-icon",
            "bmp" => "bmp",
            "tiff", "tif" => "tiff"
        };
    }
}

?>