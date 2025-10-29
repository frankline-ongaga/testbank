<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsFreeToTests extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tests', [
            'is_free' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'is_adaptive'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tests', 'is_free');
    }
}







