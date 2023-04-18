<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getCollumn($column, $accountID, $getBy = []): mixed
    {
        $builder = $this->db->table('user');
        $builder->select($column)->where("account_id", $accountID);

        if (count($getBy) > 0) {
            $keys = array_keys($getBy);
            foreach ($keys as $key) {
                $builder->where($key, $getBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach ($return as $thing) {
            array_push($returnArray, $thing);
        }

        return $returnArray;
    }

    public function getUser($id, $fetchBy = "id", $filter = [], $assoc = true): mixed
    {
        $builder = $this->db->table('user');

        if (count($filter) > 0) {
            $builder->select($filter)->where($fetchBy, $id);
            $brand = $builder->get()->getResultArray()[0];

            if (!$assoc) {
                if (count($filter) > 1) {
                    $array = [];

                    foreach ($filter as $thing) {
                        array_push($array, $brand[$thing]);
                    }

                    return $array;
                } else {
                    return $brand[$filter[0]];
                }
            } else {
                return $brand;
            }
        } else {
            $builder->select("*")->where($fetchBy, $id);
            $brand = $builder->get()->getResultArray()[0];
            return $brand;
        }
    }
}