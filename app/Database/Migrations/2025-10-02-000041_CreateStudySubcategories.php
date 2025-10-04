<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudySubcategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'category_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'name' => [ 'type' => 'VARCHAR', 'constraint' => 150 ],
            'slug' => [ 'type' => 'VARCHAR', 'constraint' => 180 ],
            'description' => [ 'type' => 'TEXT', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['category_id']);
        $this->forge->createTable('study_subcategories');
    }

    public function down()
    {
        $this->forge->dropTable('study_subcategories');
    }
}


