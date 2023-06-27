<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProductsTable extends Migration
{
    public function up()
    {
        $attributes = ['ENGINE' => 'InnoDB'];

        $feilds = [
            "productID" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "productName" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "imageLimit" => [
                "type" => "INT"
            ],
            "userLimit" => [
                "type" => "INT"
            ],
            "brandLimit" => [
                "type" => "INT"
            ],
            "appLimit" => [
                "type" => "INT"
            ],
        ];

        $this->forge->addField($feilds);
        $this->forge->addPrimaryKey('productID', 'product_key');
        $this->forge->createTable('products', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('products', true);
    }
}
