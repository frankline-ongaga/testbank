<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleQuestionsSeeder extends Seeder
{
    public function run()
    {
        // Find admin author
        $admin = $this->db->table('users')->where('email', 'admin@example.com')->get()->getRowArray();
        $authorId = $admin['id'] ?? null;

        // Insert question
        $this->db->table('questions')->insert([
            'author_id' => $authorId,
            'type' => 'mcq',
            'stem' => 'A nurse is caring for a client with contact precautions. Which action is most appropriate to prevent the spread of infection?',
            'rationale' => 'Proper use of personal protective equipment and hand hygiene reduces transmission.',
            'is_active' => 1,
        ]);
        $q = $this->db->table('questions')->orderBy('id','DESC')->get(1)->getRowArray();
        if (!$q) return;

        // Choices
        $choices = [
            ['question_id' => $q['id'], 'label' => 'A', 'content' => 'Place the client in a negative-pressure room', 'is_correct' => 0],
            ['question_id' => $q['id'], 'label' => 'B', 'content' => 'Wear a gown and gloves when entering the room', 'is_correct' => 1],
            ['question_id' => $q['id'], 'label' => 'C', 'content' => 'Keep the door to the client\'s room open', 'is_correct' => 0],
            ['question_id' => $q['id'], 'label' => 'D', 'content' => 'Use an N95 respirator at all times', 'is_correct' => 0],
        ];
        $this->db->table('choices')->insertBatch($choices);

        // Link taxonomy terms (if present)
        $termNames = [
            ['type' => 'nclex', 'name' => 'Safe Care Environment'],
            ['type' => 'difficulty', 'name' => 'Medium'],
            ['type' => 'bloom', 'name' => 'Understand'],
        ];
        foreach ($termNames as $tn) {
            $term = $this->db->table('taxonomy_terms')->where('type', $tn['type'])->where('name', $tn['name'])->get()->getRowArray();
            if ($term) {
                $this->db->table('question_terms')->insert([
                    'question_id' => $q['id'],
                    'term_id' => $term['id'],
                ]);
            }
        }
    }
}





