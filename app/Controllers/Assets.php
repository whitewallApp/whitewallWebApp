<?php

namespace App\Controllers;

class Assets extends BaseController {
    
    /**
     * Constructor
     *
     * @access    public
     */
    public function __construct(){
        define('PATH', 'C:/images/');
        define('COLPATH', 'C:/images/collections/');
        define('CATPATH', 'C:/images/categories/');
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
                'webp'    =>    'image/webp'
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
        die('Invalid Image File: '.current(explode('.', $file)) );
    }

    function catImage($file)
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
                'webp'    =>    'image/webp'
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

    function colImage($file)
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
                'webp'    =>    'image/webp'
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