<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RedoNotifications extends Migration
{
    public function up()
    {
        // $this->db->disableForeignKeyChecks();

        $this->forge->dropColumn("notifications", ["clickAction", "data", "forceWall", "forceId"]);

        $fields = [
            "data" =>[
                "type" => "JSON",
            ]
        ];

        $this->forge->addColumn('notifications', $fields);

        // $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->forge->dropColumn("notifications", "data");

        $fields = [
            "clickAction" => [
                "type" => "VARCHAR",
                "constraint" => 255
            ],
            "data" => [
                "type" => "INT",
            ],
            "forceWall" => [
                "type" => "BOOLEAN",
            ],
            "forceId" => [
                "type" => "INT",
            ]
        ];

        $this->forge->addColumn('notifications', $fields);
    }
}
