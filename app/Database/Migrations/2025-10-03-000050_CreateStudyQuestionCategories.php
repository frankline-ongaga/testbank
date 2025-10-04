<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudyQuestionCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'subcategory_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
            'name' => [ 'type' => 'VARCHAR', 'constraint' => 150 ],
            'slug' => [ 'type' => 'VARCHAR', 'constraint' => 180 ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['subcategory_id']);
        $this->forge->createTable('study_question_categories');

        // Alter study_questions to include optional study_question_category_id
        $this->forge->addColumn('study_questions', [
            'study_question_category_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'subcategory_id' ]
        ]);
    }

    public function down()
    {
        // remove added column first
        $this->forge->dropColumn('study_questions', 'study_question_category_id');
        $this->forge->dropTable('study_question_categories');
    }
}


