<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NotesCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'NCLEX Basics'],
            ['name' => 'Pharmacology'],
            ['name' => 'Pediatrics'],
            ['name' => 'Maternal-Newborn'],
            ['name' => 'Mental Health'],
        ];
        $this->db->table('notes_categories')->insertBatch($categories);
    }
}




