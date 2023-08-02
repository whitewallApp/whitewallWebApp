<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAccountMakeWebhookVariable extends Migration
{
    public function up()
    {
        $this->db->table("variables")->insert(["name" => "account_make_webhook", "value" => ""]);
    }

    public function down()
    {
        //
    }
}
