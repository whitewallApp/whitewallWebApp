<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CategoryModel;

class ImageModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $dateFormat    = 'timestamp';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';

    public function getAllIds($brandName){
        $builder = $this->db->table('brand');
        $builder->select("id")->where("name", $brandName);
        $brandID = $builder->get()->getResultArray()[0];

        $builder = $this->db->table('image');
        $builder->select("id")->where("brand_id", $brandID);
        $query = $builder->get()->getResultArray();

        $ids = [];

        foreach($query as $id){
            array_push($ids, $id["id"]);
        }

        return $ids;
    }

    public function getExternalPath($id){
        $builder = $this->db->table('image');
        $builder->select("externalPath")->where("id", $id);
        $query = $builder->get()->getResultArray();

        if ($query){
            return true;
        }else{
            return false;
        }
    }

    public function getPathById($id){
        $builder = $this->db->table('image');
        $builder->select()->where("id", $id);
        $imageData = $builder->get()->getResultArray();

        $image = [
            "path" => $imageData[0]["imagePath"],
            "externalPath" => $this->getExternalPath($id)
        ];

        return $image;
    }

    public function getThumbById($id){
        $builder = $this->db->table('image');
        $builder->select()->where("id", $id);
        $imageData = $builder->get()->getResultArray();

        $image = [
            "thumbPath" => $imageData[0]["thumbnail"],
            "externalPath" => $this->getExternalPath($id)
        ];

        return $image;
    }

    public function getNameById(int $id){
        $builder = $this->db->table('image');
        $builder->select("wallpaper_id")->where("id", $id);
        $wallId = $builder->get()->getResultArray()[0];

        $builder = $this->db->table('wallpaper');
        $builder->select("name")->where("id", $wallId);
        $name = $builder->get()->getResultArray()[0]["name"];

        return $name;
    }

    public function getCollById($id){
        $builder = $this->db->table('wallpaper');
        $builder->select("collection_id")->where("id", $id);
        $imgID = $builder->get()->getResultArray()[0];

        $builder = $this->db->table('collection');
        $builder->select()->where("id", $imgID);
        $coll = $builder->get()->getResultArray()[0];

        return $coll;
    }

    public function getCatById($id){
        $catModel = new CategoryModel;

        $catID = $this->getCollById($id)["category_id"];
        $cat = $catModel->getCatById($catID);

        return $cat;
    }
}