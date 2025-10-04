<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudyChoices extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'question_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'label' => [ 'type' => 'VARCHAR', 'constraint' => 10 ],
            'content' => [ 'type' => 'TEXT' ],
            'is_correct' => [ 'type' => 'TINYINT', 'constraint' => 1, 'default' => 0 ],
            'explanation' => [ 'type' => 'TEXT', 'null' => true ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['question_id']);
        $this->forge->createTable('study_choices');
    }

    public function down()
    {
        $this->forge->dropTable('study_choices');
    }
}


