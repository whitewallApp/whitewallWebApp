<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVariablesTable extends Migration
{
    public function up()
    {
        $fields = [
            "id" => [
                'type' => "INT",
                'unsigned'       => true,
                "auto_increment" => true
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => 510,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addPrimaryKey("id");
        $this->forge->createTable("variables");
    }

    public function down()
    {
        $this->forge->dropTable("variables");
    }
}
