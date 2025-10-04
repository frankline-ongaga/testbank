<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudyQuestions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'subcategory_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'stem' => [ 'type' => 'TEXT' ],
            'rationale' => [ 'type' => 'TEXT', 'null' => true ],
            'created_by' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['subcategory_id']);
        $this->forge->createTable('study_questions');
    }

    public function down()
    {
        $this->forge->dropTable('study_questions');
    }
}



