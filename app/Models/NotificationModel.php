<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

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
}