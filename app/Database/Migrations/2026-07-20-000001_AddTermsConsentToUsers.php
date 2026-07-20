<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTermsConsentToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'terms_accepted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status',
            ],
            'terms_version' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'terms_accepted_at',
            ],
            'terms_source' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'terms_version',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['terms_accepted_at', 'terms_version', 'terms_source']);
    }
}
