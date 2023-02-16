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

    public function getCatById($id){
        $builder = $this->db->table('category');
        $builder->select()->where("id", $id);
        $name = $builder->get()->getResultArray()[0];

        return $name;
    }
}