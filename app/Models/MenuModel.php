<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getCollumn($column, $brandName, $getBy=[]){
        $builder = $this->db->table('brand');
        $builder->select("id")->where("name", $brandName);
        $brandID = $builder->get()->getResultArray()[0];

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
}