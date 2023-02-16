<?php

namespace App\Controllers;
use App\Models\ImageModel;

class Image extends BaseController
{
    public function index()
    {
        // Grab all images from the database
        $imageModel = new ImageModel;
        $ids = $imageModel->getAllIds("Beautiful AI");
        $images = [];
        foreach ($ids as $id) {
            $image = [
                "id" => $id,
                "path" => $imageModel->getPathById($id)["path"], 
                "name" => $imageModel->getNameById($id), 
                "collection" => $imageModel->getCollById($id)["name"],
                "category" => $imageModel->getCatById($id)["name"]
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
