<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $table = "subscription";
    protected $allowedFields = ["subscriptionType", "nextPaymentDate", "expirationDate", "paymentMethod", "status", "account_id"];
}
