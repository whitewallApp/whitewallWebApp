<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\CategoryModel;
use CodeIgniter\Database\RawSql;

class ImageModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "wallpaper";
    protected $useAutoIncrement = true;

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';
    protected $allowedFields = ["link", "name", "description", "thumbnail", "imagePath", "resolution", "externalPath", "brand_id", "collection_id"];

    public function getAllIds($brandID){
        $builder = $this->db->table('wallpaper');
        $builder->select("id")->where("brand_id", $brandID);
        $query = $builder->get()->getResultArray();

        $ids = [];

        foreach($query as $id){
            array_push($ids, $id["id"]);
        }

        return $ids;
    }

    public function getCollumn($column, $brandID, $getBy=[]){
        $builder = $this->db->table('wallpaper');
        $builder->select($column);
        $builder->where("brand_id", $brandID);

        if (count($getBy) > 0){
            $keys = array_keys($getBy);
            foreach ($keys as $key) {
                $builder->where($key, $getBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach($return as $thing){
            array_push($returnArray, $thing[$column]);
        }

        return $returnArray;
    }

    public function getImage($id, String $fetchBy="id", Array $filter = [], Bool $assoc=false){
        $builder = $this->db->table('wallpaper');
        if (count($filter) > 0){
            $builder->select($filter)->where($fetchBy, $id);
            $image = $builder->get()->getResultArray()[0];

            if (!$assoc){
                if (count($filter) > 1){
                    $array = [];

                    foreach ($filter as $thing){
                        array_push($array, $image[$thing]);
                    }

                    return $array;
                }else{
                    if (count($filter) == 1) {
                        return $image[$filter[0]];
                    }else{
                        return $image;
                    }
                }
            }else{
                return $image;
            }
        }
        else{
            $builder->select("*")->where($fetchBy, $id);
            $imgID = $builder->get()->getResultArray();
            return $imgID;
        }
    }

    public function updateImage($data, $id = "", $updateBy="id"){
        $data["dateUpdated"] = new RawSql('CURRENT_TIMESTAMP');
        $brandModel = new BrandModel();
        $session = session();
        $userModel = new UserModel();
        $permission = $userModel->getPermissions($session->get("user_id"), $session->get("brand_id"), ["images"], ["p_add"]);

        if ($id != "" && $permission){
            $data["id"] = $id;
            $data["dateCreated"] = new RawSql('CURRENT_TIMESTAMP');
            $data["brand_id"] = $session->get("brand_id");
        }

        $builder = $this->db->table("wallpaper");
        $builder->upsert($data);
    }

    public function getImgByName($name){
        $builder = $this->db->table('wallpaper');
        $builder->select("*")->where("name", $name);
        $img = $builder->get()->getResultArray()[0];

        return $img;
    }

    public function like(string $column, array|string $query){
        $builder = $this->db->table('wallpaper');
        return $builder->orLike($column, $query, insensitiveSearch: true)->get()->getResultArray();
    }
}