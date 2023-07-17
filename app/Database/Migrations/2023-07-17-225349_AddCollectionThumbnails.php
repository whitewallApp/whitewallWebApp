<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCollectionThumbnails extends Migration
{
    public function up()
    {
        $fields = [
            'thumbnail' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
        ];
        $this->forge->addColumn("collection", $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('collection', 'thumbnail'); // to drop one single column
    }
}
