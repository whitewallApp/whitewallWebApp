<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CallToAction extends Migration
{
    public function up()
    {
        $fields = [
            'callToAction' => [
                'type'       => 'VARCHAR',
                'constraint' => 510,
                "default" => '{"name": "\"Click here for Details\"", "link": ""}'
            ],
        ];

        $this->forge->addColumn("wallpaper", $fields);
    }

    public function down()
    {
        $this->forge->dropColumn("wallpaper", "callToAction");
    }
}
