<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tests', [
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'pending', 'active', 'inactive'],
                'default' => 'draft',
                'after' => 'is_adaptive'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tests', 'status');
    }
}


