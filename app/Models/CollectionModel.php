<?php

namespace App\Models;

use CodeIgniter\Model;

use CodeIgniter\Database\RawSql;

class CollectionModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "collection";

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';
    protected $allowedFields = ["name", "description", "iconPath", "link", "category_id", "brand_id"];

    public function getAllIds($brandID){
        $builder = $this->db->table('collection');
        $builder->select("id")->where("brand_id", $brandID);
        $query = $builder->get()->getResultArray();

        $ids = [];

        foreach($query as $id){
            array_push($ids, $id["id"]);
        }

        return $ids;
    }

    public function getCollumn($column, $brandID, $getBy=[]){
        $builder = $this->db->table('collection');
        $builder->select($column)->where("brand_id", $brandID);

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

    public function getIdByName($name){
        $builder = $this->db->table('collection');
        $builder->select("id")->where("name", $name);
        
        return $builder->get()->getResultArray()[0];
    }

    public function getCollection($id, $filter = [], $fetchBy="id", $assoc=false){
        $builder = $this->db->table('collection');
        
        if (count($filter) > 0){
            $builder->select($filter)->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];

            if (!$assoc){
                if (count($filter) > 1){
                    $array = [];

                    foreach ($filter as $thing){
                        array_push($array, $collection[$thing]);
                    }

                    return $array;
                }else{
                    return $collection[$filter[0]];
                }
            }else{
                return $collection;
            }

        }else{
            $builder->select("*")->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];
            return $collection;
        }
    }

    public function updateCollection($id, $data, $updateBy="id"){
        $data["dateUpdated"] = new RawSql('CURRENT_TIMESTAMP');

        $builder = $this->db->table("collection");
        $builder->where($updateBy, $id);
        $builder->update($data);
    }

    public function like(string $column, array|string $query)
    {
        $builder = $this->db->table('collection');
        return $builder->orLike($column, $query, insensitiveSearch: true)->get()->getResultArray();
    }
}