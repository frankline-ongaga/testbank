<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NoteCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Fundamentals of Nursing',
                'description' => 'Basic nursing concepts and principles',
                'slug' => 'fundamentals',
                'order' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Medical-Surgical Nursing',
                'description' => 'Care of adult patients in medical-surgical units',
                'slug' => 'med-surg',
                'order' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pediatric Nursing',
                'description' => 'Care of children and adolescents',
                'slug' => 'pediatrics',
                'order' => 3,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Maternal-Child Nursing',
                'description' => 'Care during pregnancy, childbirth, and postpartum',
                'slug' => 'maternal',
                'order' => 4,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Mental Health Nursing',
                'description' => 'Psychiatric and mental health care',
                'slug' => 'mental-health',
                'order' => 5,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Community Health Nursing',
                'description' => 'Public health and community-based care',
                'slug' => 'community',
                'order' => 6,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Leadership & Management',
                'description' => 'Nursing leadership and healthcare management',
                'slug' => 'leadership',
                'order' => 7,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Pharmacology',
                'description' => 'Medication administration and drug classifications',
                'slug' => 'pharmacology',
                'order' => 8,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Critical Care',
                'description' => 'Intensive care and emergency nursing',
                'slug' => 'critical-care',
                'order' => 9,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Test-Taking Strategies',
                'description' => 'Tips and techniques for NCLEX success',
                'slug' => 'test-strategies',
                'order' => 10,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('note_categories')->insertBatch($data);
    }
}


