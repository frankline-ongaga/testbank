<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubcategoryIdToNotes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('notes', [
            'subcategory_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true, 'after' => 'category_id' ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('notes', 'subcategory_id');
    }
}


