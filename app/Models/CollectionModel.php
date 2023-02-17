<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "collection";

    protected $useTimestamps = true;
    protected $dateFormat    = 'timestamp';
    protected $createdField  = 'dateCreated';
    protected $updatedField  = 'dateUpdated';

    public function getCollNames(){
        return $this->findColumn("name");
    }
}