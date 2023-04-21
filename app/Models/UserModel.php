<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\BrandModel;

class UserModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getCollumn($column, $brandName, $getBy = []): mixed
    {
        $brandModel = new BrandModel();

        $brandId = $brandModel->getBrand($brandName, "name", ["id"]);

        $builder = $this->db->table('user');
        $builder->join("branduser", "branduser.user_id = user.id", "inner");
        $builder->select($column)->where("brand_id", $brandId);

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

    public function getUser($id, $fetchBy = "user.id", $filter = [], $assoc = true): mixed
    {
        $builder = $this->db->table('user');
        $builder->join("branduser", "branduser.user_id = user.id", "inner");

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

    public function getPermissions($id, $area = []): array {
        if (count($area) == 0){
            $builder = $this->db->table('permissions');
            $builder->select("*")->where("user_id", $id);
            $query = $builder->get()->getResultArray();

            $return = [];

            foreach($query as $permission){
                $return[$permission["area"]] = [
                    "view" => $permission["p_view"],
                    "add" => $permission["p_add"],
                    "edit" => $permission["p_edit"],
                    "remove" => $permission["p_remove"],
                ];
            }

            return $return;
        }else{

        }

        return [];
    }
}