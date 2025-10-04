<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaxonomyTerms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['nclex', 'specialty', 'difficulty', 'bloom', 'tag'],
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'parent_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['type', 'name']);
        $this->forge->addForeignKey('parent_id', 'taxonomy_terms', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('taxonomy_terms', true);
    }

    public function down()
    {
        $this->forge->dropTable('taxonomy_terms', true);
    }
}





