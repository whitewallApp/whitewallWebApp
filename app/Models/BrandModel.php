<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    
    /**
     * Gets a column of the table based on an account ID. Use $getBy to do additional filtering
     *
     * @param  array|string $column The column of the table to get
     * @param  int $accountID The account id of the user/brand
     * @param  array $getBy An array of key value pairs to use for filtering. EX: ["account_active" => 1]
     * @return array
     */
    public function getCollumn($column, $accountID, $getBy=[]): array{
        $builder = $this->db->table('brand');
        $builder->select($column)->where("account_id", $accountID);

        if (count($getBy) > 0){
            $keys = array_keys($getBy);
            foreach ($keys as $key) {
                $builder->where($key, $getBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach($return as $thing){
            array_push($returnArray, $thing);
        }

        return $returnArray;
    }

    /**
     * Grabs a row in the database by a value of a spesified column
     * @param mixed $id the value of what you want to fetchBy
     * @param string $fetchBy the column you want to fetch by. NOTE: default is ID column
     * @param array $filter defaults to grabbing the whole row. filer the row with this input
     * @return array
     */
    public function getBrand($id, $fetchBy="id", $filter = [], $assoc=false): array{
        $builder = $this->db->table('brand');
        
        if (count($filter) > 0){
            $builder->select($filter)->where($fetchBy, $id);
            $brand = $builder->get()->getResultArray()[0];

            if (!$assoc){
                if (count($filter) > 1){
                    $array = [];

                    foreach ($filter as $thing){
                        array_push($array, $brand[$thing]);
                    }

                    return $array;
                }else{
                    return $brand[$filter[0]];
                }
            }else{
                return $brand;
            }

        }else{
            $builder->select("*")->where($fetchBy, $id);
            $brand = $builder->get()->getResultArray()[0];
            return $brand;
        }
    }
}