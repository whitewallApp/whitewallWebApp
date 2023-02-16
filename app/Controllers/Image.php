<?php

namespace App\Controllers;
use App\Models\ImageModel;

class Image extends BaseController
{
    public function index()
    {
        // Grab all images from the database
        $imageModel = new ImageModel;
        $ids = $imageModel->getAllImageIds();
        $images = [];
        foreach ($ids as $id) {
            $image = [
                "path" => $imageModel->getImagePathById($id)["path"], 
                "name" => $imageModel->getImageNameById($id)
            ];
            array_push($images, $image);
        }

        // compile data to be sent to view
        $data = [
            "images" => $images
        ];
        return view('Image/Image_Detail', $data);
    }
}
