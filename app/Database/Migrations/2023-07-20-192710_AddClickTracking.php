<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClickTracking extends Migration
{
    public function up()
    {
        $fields = [
            'wallpaperClick' => [
                'type'       => 'INT',
                "default" => 0
            ],
            'linkClick' => [
                'type'       => 'INT',
                "default" => 0
            ],
        ];

        $this->forge->addColumn("wallpaper", $fields);
    }

    public function down()
    {
        $this->forge->dropColumn("wallpaper", "wallpaperClick");
        $this->forge->dropColumn("wallpaper", "linkClick");
    }
}
