<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMockQuestions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'subcategory_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'stem' => ['type' => 'TEXT'],
            'image_path' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'rationale' => ['type' => 'TEXT', 'null' => true],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['subcategory_id']);
        $this->forge->createTable('mock_questions', true);

        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'question_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'label' => ['type' => 'VARCHAR', 'constraint' => 10],
            'content' => ['type' => 'TEXT'],
            'is_correct' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'explanation' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['question_id']);
        $this->forge->createTable('mock_choices', true);
    }

    public function down()
    {
        $this->forge->dropTable('mock_choices', true);
        $this->forge->dropTable('mock_questions', true);
    }
}
