<?php

namespace App\Controllers;

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
    
    public function __construct(){
        $imgPath = getenv("BASE_PATH") . 
    }
    /**
     * Returns image files
     *
     * @access    public
     * @param    string    file path
     */
    function images($file)
    {
        if (file_exists(PATH.$file)){
            // Figure out mime-type
            $mimes = array(
                'gif'    =>    'image/gif',
                'jpeg'    =>    'image/jpeg',
                'jpg'    =>    'image/jpeg',
                'jpe'    =>    'image/jpeg',
                'png'    =>    'image/png',
                'tiff'    =>    'image/tiff',
                'tif'    =>    'image/tiff',
                'webp'    =>    'image/webp',
                'svg' => 'image/svg+xml'
            );
            
            $tmp = explode('.', $file);
            $ext = end($tmp);


            if (in_array($ext, $mimes));
            {
                header("Content-type: ". $mimes[$ext]);
                require(PATH.$file);
                exit;
            }
        }
        die('Invalid Image File: '. PATH.$file );
    }

    function catImages($file)
    {
        if (file_exists(CATPATH.$file)){
            // Figure out mime-type
            $mimes = array(
                'gif'    =>    'image/gif',
                'jpeg'    =>    'image/jpeg',
                'jpg'    =>    'image/jpeg',
                'jpe'    =>    'image/jpeg',
                'png'    =>    'image/png',
                'tiff'    =>    'image/tiff',
                'tif'    =>    'image/tiff',
                'webp'    =>    'image/webp',
                'svg' => 'image/svg+xml'
            );
            
            $tmp = explode('.', $file);
            $ext = end($tmp);


            if (in_array($ext, $mimes));
            {
                header("Content-type: ". $mimes[$ext]);
                require(CATPATH.$file);
                exit;
            }
        }
        die('Invalid Image File: '.current(explode('.', $file)) );
    }

    function colImages($file)
    {
        if (file_exists(COLPATH.$file)){
            // Figure out mime-type
            $mimes = array(
                'gif'    =>    'image/gif',
                'jpeg'    =>    'image/jpeg',
                'jpg'    =>    'image/jpeg',
                'jpe'    =>    'image/jpeg',
                'png'    =>    'image/png',
                'tiff'    =>    'image/tiff',
                'tif'    =>    'image/tiff',
                'webp'    =>    'image/webp',
                'svg' => 'image/svg+xml'
            );
            
            $tmp = explode('.', $file);
            $ext = end($tmp);


            if (in_array($ext, $mimes));
            {
                header("Content-type: ". $mimes[$ext]);
                require(COLPATH.$file);
                exit;
            }
        }
        die('Invalid Image File: '.current(explode('.', $file)) );
    }
}

?>