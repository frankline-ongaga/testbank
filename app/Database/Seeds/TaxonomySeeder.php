<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    public function run()
    {
        $terms = [
            // NCLEX categories
            ['type' => 'nclex', 'name' => 'Safe Care Environment'],
            ['type' => 'nclex', 'name' => 'Health Promotion'],
            ['type' => 'nclex', 'name' => 'Psychosocial Integrity'],
            ['type' => 'nclex', 'name' => 'Physiological Integrity'],
            // Difficulty
            ['type' => 'difficulty', 'name' => 'Easy'],
            ['type' => 'difficulty', 'name' => 'Medium'],
            ['type' => 'difficulty', 'name' => 'Hard'],
            // Bloom's
            ['type' => 'bloom', 'name' => 'Remember'],
            ['type' => 'bloom', 'name' => 'Understand'],
            ['type' => 'bloom', 'name' => 'Apply'],
            ['type' => 'bloom', 'name' => 'Analyze'],
            ['type' => 'bloom', 'name' => 'Evaluate'],
            ['type' => 'bloom', 'name' => 'Create'],
        ];

        $this->db->table('taxonomy_terms')->insertBatch($terms);
    }
}





