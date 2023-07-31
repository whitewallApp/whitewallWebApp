<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = "menu";
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createDate';
    protected $updatedField  = 'updatedDate';
    protected $allowedFields = ["title", "target", "sequence", "externalLink", "internalContext", "brand_id"];

    /**
     * Gets a column in the database by the brand_id
     *
     * @param string $column
     * @param int $brandID
     * @param array $getBy
     * @return array | an array of the column you want
     */
    public function getCollumn($column, $brandID, $getBy=[]){
        $builder = $this->db->table('menu');
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

    public function getMenuItem($id, $filter = [], $fetchBy="id", $assoc=false){
        $builder = $this->db->table('menu');
        
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
                    if (count($filter) == 1) {
                        return $collection[$filter[0]];
                    }else{
                        return $collection;
                    }
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
}