<?php

namespace App\Models;

use CodeIgniter\Model;

class VariablesModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "variables";
    protected $allowedFields = ["name", "value"];


    /**
     * get variable
     *
     * @param  mixed $id The value you want to get the row by
     * @param  mixed $fetchBy The column you want it to search for the $id in
     * @param  mixed $filter An array of values you want it to return from 
     * @param  mixed $assoc If you want the return array to be an associate array or not
     * @return array
     */
    public function getVariable($id, $fetchBy = "name", $filter = [], $assoc = false): mixed
    {
        $builder = $this->db->table('variables');

        if (count($filter) > 0) {
            $builder->select($filter)->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];

            if (!$assoc) {
                if (count($filter) > 1) {
                    $array = [];

                    foreach ($filter as $thing) {
                        array_push($array, $collection[$thing]);
                    }

                    return $array;
                } else {
                    if (count($filter) == 1) {
                        return $collection[$filter[0]];
                    } else {
                        return $collection;
                    }
                }
            } else {
                return $collection;
            }
        } else {
            $builder->select("*")->where($fetchBy, $id);
            $collection = $builder->get()->getResultArray()[0];
            return $collection;
        }
    }
}
