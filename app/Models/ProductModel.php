<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $primaryKey = 'productID';
    protected $returnType = 'array';
    protected $table = "products";
    protected $allowedFields = ["productName", "imageLimit", "userLimit", "brandLimit", "appLimit"];
}
