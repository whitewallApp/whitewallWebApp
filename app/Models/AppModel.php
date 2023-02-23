<?php

namespace App\Models;

use CodeIgniter\Model;

class AppModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    public function getBrandIdById($id){
        $builder = $this->db->table('mobleapp');

        $builder->select("id")->where("brand_id", $id);

        return $builder->get()->getResultArray()[0];
    }

    public function getIdByBrandId($id){
        $builder = $this->db->table('mobleapp');

        $builder->select("brand_id")->where("id", $id);

        return $builder->get()->getResultArray()[0];
    }
}