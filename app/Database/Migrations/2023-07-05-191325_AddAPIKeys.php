<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAPIKeys extends Migration
{
    public function up()
    {
        $feild = [
            "apikey" => [
                "type" => "VARCHAR",
                "constraint" => 64,
            ]
        ];

        $this->forge->addColumn("brand", $feild);
    }

    public function down()
    {
        $this->forge->dropColumn("brand", "apikey");
    }
}
