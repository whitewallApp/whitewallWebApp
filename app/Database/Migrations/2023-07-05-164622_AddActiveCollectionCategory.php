<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActiveCollectionCategory extends Migration
{
    public function up()
    {
        $feild = [
            "active" => [
                "type" => "BOOLEAN",
                "default" => 0
            ]
        ];

        $this->forge->addColumn("category", $feild);
        $this->forge->addColumn("collection", $feild);
    }

    public function down()
    {
        $this->forge->dropColumn("category", "active");
        $this->forge->dropColumn("collection", "active");
    }
}
