<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropResolution extends Migration
{
    public function up()
    {
        $this->forge->dropColumn("wallpaper", "resolution");
    }

    public function down()
    {
        $feilds = [
            "resolution" => [
                "type" => "VARCHAR",
                "constraint" => 45,
            ],
        ];

        $this->forge->addColumn("wallpaper", $feilds);
    }
}
