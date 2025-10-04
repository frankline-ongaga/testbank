<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudyCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Nursing Test Bank',
            'Maternal & Newborn',
            'Fundamentals',
            'Pharmacology',
            'Exit Exams',
            'Medical Surgical',
            'Mental Health',
            'Pathophysiology',
            'Pediatrics',
        ];

        $builder = $this->db->table('study_categories');
        foreach ($categories as $name) {
            $builder->insert([
                'name' => $name,
                'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}


