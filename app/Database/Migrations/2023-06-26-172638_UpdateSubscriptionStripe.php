<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSubscriptionStripe extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("subscription", ["subscriptionType", "nextPaymentDate", "expirationDate", "paymentMethod", "status"]);
        $fields = [
            'subscriptionID' => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
            "productID" => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
        ];
        $this->forge->addColumn('subscription', $fields);
        // $this->forge->addUniqueKey("subscriptionID", "subscription_stripe_unique");
        // $this->forge->processIndexes('subscription');
    }

    public function down()
    {
        $fields = [
            'subscriptionType' => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
            "nextPaymentDate" => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
            "expirationDate" => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
            "paymentMethod" => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
            "status" => [
                "type" => "VARCHAR",
                "constraint" => 510,
            ],
        ];
        $this->forge->addColumn('subscription', $fields);
    }
}
