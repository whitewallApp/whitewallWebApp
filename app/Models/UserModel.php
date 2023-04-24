<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\BrandModel;

class UserModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "user";

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
        $builder->join("usersettings", "usersettings.user_id = user.id", "inner");

        if (count($filter) > 0) {
            $builder->select($filter)->where($fetchBy, $id);
            $user = $builder->get()->getResultArray()[0];

            if (!$assoc) {
                if (count($filter) > 1) {
                    $array = [];

                    foreach ($filter as $thing) {
                        array_push($array, $user[$thing]);
                    }

                    return $array;
                } else {
                    return $user[$filter[0]];
                }
            } else {
                return $user;
            }
        } else {
            $builder->select("*")->where($fetchBy, $id);
            $brand = $builder->get()->getResultArray()[0];
            return $brand;
        }
    }

    public function getPermissions($userId, $brandName, $area=[]): array {
        $brandModel = new BrandModel();
        $brandID = $brandModel->getBrand($brandName, "name", ["id"]);

        if (count($area) > 0){

            $builder = $this->db->table('permissions');

            $return = [];
            
            foreach($area as $areaName){
                $builder->select(["p_view", "p_add", "p_edit", "p_remove"])->where("user_id", $userId)->where("brand_id", $brandID)->where("area", $areaName);
                $query = $builder->get()->getResultArray()[0];

                $return[$areaName] = $query;
            }

            return $return;

        }else{
            $builder = $this->db->table('permissions');
            $builder->join("branduser", "branduser.user_id = permissions.user_id AND branduser.brand_id = permissions.brand_id", "inner");

            $builder->select("*")->where("permissions.user_id", $userId)->where("permissions.brand_id", $brandID);
            $query = $builder->get()->getResultArray();

            $return = [];
            $admin = false;

            foreach ($query as $permission) {
                $return[$permission["area"]] = [
                    "view" => $permission["p_view"],
                    "add" => $permission["p_add"],
                    "edit" => $permission["p_edit"],
                    "remove" => $permission["p_remove"],
                ];
                $admin = $permission["admin"];
            }

            $return["admin"] = $admin;

            return $return;
        }
    }
}