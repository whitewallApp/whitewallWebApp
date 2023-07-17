<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeAppTable extends Migration
{
    public function up()
    {
        $fields = [
            'id' => [
                'type'       => 'INT',
                "auto_increment" => true
            ],
            'brand_id' => [
                'type'       => 'INT',
            ],
            "appName" => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            "versionName" => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            "iosState" => [
                "type" => "BOOLEAN",
                "default" => false,
            ],
            "androidState" => [
                "type" => "BOOLEAN",
                "default" => false,
            ]
        ];
        $attributes = ['ENGINE' => 'InnoDB'];


        $this->forge->addField($fields);
        $this->forge->addPrimaryKey("id", "app_primary");
        $this->forge->addForeignKey("brand_id", "brand", "id");
        $this->forge->createTable("app", true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable("app");
    }
}
