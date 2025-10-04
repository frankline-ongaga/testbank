<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubscriptions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'plan' => ['type' => 'ENUM', 'constraint' => ['monthly', 'quarterly']],
            'status' => ['type' => 'ENUM', 'constraint' => ['active','expired','cancelled'], 'default' => 'active'],
            'paypal_order_id' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '8,2', 'null' => true],
            'currency' => ['type' => 'VARCHAR', 'constraint' => 8, 'default' => 'USD'],
            'start_at' => ['type' => 'DATETIME', 'null' => true],
            'end_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('subscriptions', true);
    }

    public function down()
    {
        $this->forge->dropTable('subscriptions', true);
    }
}





