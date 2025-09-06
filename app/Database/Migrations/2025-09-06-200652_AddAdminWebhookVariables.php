<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdminWebhookVariables extends Migration
{
    public function up()
    {
        $this->db->table("variables")->insert(["name" => "STRIPE_WEBHOOK_SECRET", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "STRIPE_CLIENT_PORTAL", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "STRIPE_API_KEY", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "STRIPE_PRICING_TABLE", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "STRIPE_PUBLIC_KEY", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "Whitewall_Unicycle_P_ID", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "Whitewall_Sedan_P_ID", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "Whitewall_Unlimited_P_ID", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "MAILGUN_API", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "MAILGUN_URL", "value" => ""]);
        $this->db->table("variables")->insert(["name" => "GOOGLE_CLIENT_ID", "value" => ""]);
    }

    public function down()
    {
        //
    }
}
