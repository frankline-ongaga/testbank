<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTestsAndAttempts extends Migration
{
    public function up()
    {
        // Tests
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true,
            ],
            'owner_id' => [
                'type' => 'INT', 'constraint' => 11, 'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR', 'constraint' => 200,
            ],
            'mode' => [
                'type' => 'ENUM', 'constraint' => ['practice', 'evaluation'], 'default' => 'practice',
            ],
            'time_limit_minutes' => [
                'type' => 'INT', 'constraint' => 11, 'null' => true,
            ],
            'is_adaptive' => [
                'type' => 'TINYINT', 'constraint' => 1, 'default' => 0,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('owner_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tests', true);

        // Test Questions linking with order
        $this->forge->addField([
            'test_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'question_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'sort_order' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey(['test_id', 'question_id'], true);
        $this->forge->addForeignKey('test_id', 'tests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('test_questions', true);

        // Attempts
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'test_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'started_at' => ['type' => 'DATETIME', 'null' => true],
            'completed_at' => ['type' => 'DATETIME', 'null' => true],
            'score' => ['type' => 'DECIMAL', 'constraint' => '5,2', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('test_id', 'tests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attempts', true);

        // Attempt Answers
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'attempt_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'question_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'choice_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'is_correct' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('attempt_id', 'attempts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('choice_id', 'choices', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attempt_answers', true);
    }

    public function down()
    {
        $this->forge->dropTable('attempt_answers', true);
        $this->forge->dropTable('attempts', true);
        $this->forge->dropTable('test_questions', true);
        $this->forge->dropTable('tests', true);
    }
}


