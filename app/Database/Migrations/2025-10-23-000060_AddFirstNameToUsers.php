<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFirstNameToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'first_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'username',
            ],
        ];
        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'first_name');
    }
}


