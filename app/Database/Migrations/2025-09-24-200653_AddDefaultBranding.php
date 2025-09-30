<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDefaultBranding extends Migration
{
    public function up()
    {
        $this->db->table("variables")->insert(["name" => "Default_Branding", "value" => ""]);
    }

    public function down()
    {
        //
    }
}
