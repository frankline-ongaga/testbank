<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudyQuestionTerms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'question_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'term_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['question_id']);
        $this->forge->addKey(['term_id']);
        $this->forge->createTable('study_question_terms');
    }

    public function down()
    {
        $this->forge->dropTable('study_question_terms');
    }
}


