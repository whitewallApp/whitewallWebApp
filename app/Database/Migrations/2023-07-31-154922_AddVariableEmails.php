<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVariableEmails extends Migration
{
    public function up()
    {
        $this->db->table("variables")->insert(["name" => "admin_emails", "value" => "thomas.ed.dick@gmail.com;jonathan.steven.dick@gmail.com"]);
    }

    public function down()
    {
        
    }
}
