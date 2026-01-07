<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImageToStudyQuestions extends Migration
{
    public function up()
    {
        $this->forge->addColumn('study_questions', [
            'image_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'stem',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('study_questions', 'image_path');
    }
}

