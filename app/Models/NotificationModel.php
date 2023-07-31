<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $table = "notifications";
    protected $allowedFields = ["title", "description", "clickAction", "data", "forceWall", "forceId", "sendTime", "status", "brand_id"];

    /**
     * Gets a column in teh database by the brandid
     *
     * @param string $column
     * @param int $brandID
     * @param array $getBy
     * @return array | An array of the column
     */
    public function getCollumn($column, $brandID, $getBy = [])
    {
        $builder = $this->db->table('notifications');
        $builder->select($column);
        $builder->where("brand_id", $brandID);

        if (count($getBy) > 0) {
            $keys = array_keys($getBy);
            foreach ($keys as $key) {
                $builder->where($key, $getBy[$key]);
            }
        }

        $return = $builder->get()->getResultArray();

        $returnArray = [];

        foreach ($return as $thing) {
            array_push($returnArray, $thing[$column]);
        }

        return $returnArray;
    }

    public function getNotification($id, $filter = [], $fetchBy="id", $assoc=false){
        $builder = $this->db->table('notifications');
        
        if (count($filter) > 0){
            $builder->select($filter)->where($fetchBy, $id);
            $notification = $builder->get()->getResultArray()[0];

            if (!$assoc){
                if (count($filter) > 1){
                    $array = [];

                    foreach ($filter as $thing){
                        array_push($array, $notification[$thing]);
                    }

                    return $array;
                }else{
                    return $notification[$filter[0]];
                }
            }else{
                if (count($filter) == 1) {
                    return $notification[$filter[0]];
                }else{
                    return $notification;
                }
            }

        }else{
            $builder->select("*")->where($fetchBy, $id);
            $notification = $builder->get()->getResultArray();
            return $notification;
        }
    }

    public function like(string $column, array|string $query)
    {
        $builder = $this->db->table('notifications');
        return $builder->orLike($column, $query, insensitiveSearch: true)->get()->getResultArray();
    }
}