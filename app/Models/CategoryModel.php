<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $useTimestamps = true;
    protected $dateFormat    = 'timestamp';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';

    public function getCollumn($column, $brandName){
        $builder = $this->db->table('brand');
        $builder->select("id")->where("name", $brandName);
        $brandID = $builder->get()->getResultArray()[0];

        $builder = $this->db->table('category');
        $builder->select($column)->where("brand_id", $brandID);
        $column = $builder->get()->getResultArray();

        return $column;
    }

    public function getCategoryById($id, $filter=[], $assoc=false){
        $builder = $this->db->table('category');
        
        if (count($filter) > 0){
            $builder->select($filter)->where("id", $id);
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
        }
        else{
            $builder->select("*")->where("id", $id);
            $collection = $builder->get()->getResultArray();
            return $collection;
        }
    }
}