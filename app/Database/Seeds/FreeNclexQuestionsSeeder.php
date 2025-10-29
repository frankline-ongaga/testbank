<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FreeNclexQuestionsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $questions = [
            [
                'stem' => 'A client with heart failure is prescribed furosemide. Which finding indicates the medication is effective?',
                'choices' => [
                    ['content' => 'Weight gain of 1 kg in 24 hours', 'correct' => false],
                    ['content' => 'Decreased peripheral edema', 'correct' => true],
                    ['content' => 'Crackles present in lung bases', 'correct' => false],
                    ['content' => 'Blood pressure 90/50 mm Hg', 'correct' => false],
                ],
            ],
            [
                'stem' => 'The nurse prepares to administer regular insulin subcutaneously. Which nursing action is appropriate?',
                'choices' => [
                    ['content' => 'Massage the site after injection', 'correct' => false],
                    ['content' => 'Rotate injection sites within the same anatomic region', 'correct' => true],
                    ['content' => 'Aspirate before injecting', 'correct' => false],
                    ['content' => 'Use a 1.5-inch needle', 'correct' => false],
                ],
            ],
            [
                'stem' => 'A postoperative client reports sudden shortness of breath and chest pain. What is the priority action?',
                'choices' => [
                    ['content' => 'Administer prescribed PRN morphine', 'correct' => false],
                    ['content' => 'Raise the head of the bed and assess oxygen saturation', 'correct' => true],
                    ['content' => 'Encourage incentive spirometry', 'correct' => false],
                    ['content' => 'Notify the provider after completing documentation', 'correct' => false],
                ],
            ],
            [
                'stem' => 'Which isolation precaution is required for a client with Clostridioides difficile infection?',
                'choices' => [
                    ['content' => 'Airborne precautions', 'correct' => false],
                    ['content' => 'Droplet precautions', 'correct' => false],
                    ['content' => 'Contact precautions with soap-and-water hand hygiene', 'correct' => true],
                    ['content' => 'Protective environment', 'correct' => false],
                ],
            ],
            [
                'stem' => 'A client receiving warfarin has an INR of 4.8. What action should the nurse take?',
                'choices' => [
                    ['content' => 'Administer vitamin K as prescribed', 'correct' => true],
                    ['content' => 'Give the next scheduled dose of warfarin', 'correct' => false],
                    ['content' => 'Encourage high-vitamin K foods', 'correct' => false],
                    ['content' => 'No action; this is a therapeutic value', 'correct' => false],
                ],
            ],
            [
                'stem' => 'Which statement by a client with asthma indicates correct use of an inhaled corticosteroid?',
                'choices' => [
                    ['content' => 'I will use it as a rescue inhaler for sudden wheezing', 'correct' => false],
                    ['content' => 'I will rinse my mouth after each use', 'correct' => true],
                    ['content' => 'I will stop it when I feel better', 'correct' => false],
                    ['content' => 'I should feel immediate relief after inhalation', 'correct' => false],
                ],
            ],
            [
                'stem' => 'The nurse teaches a client with heart failure about fluid restriction. Which instruction is appropriate?',
                'choices' => [
                    ['content' => 'Use ice chips to help control thirst', 'correct' => true],
                    ['content' => 'Increase fluids to promote diuresis', 'correct' => false],
                    ['content' => 'Focus only on solid food sodium content', 'correct' => false],
                    ['content' => 'Avoid daily weights', 'correct' => false],
                ],
            ],
            [
                'stem' => 'A client with type 1 diabetes is pale and diaphoretic with blood glucose of 50 mg/dL (2.8 mmol/L). What is the best initial action?',
                'choices' => [
                    ['content' => 'Administer 50% dextrose IV', 'correct' => false],
                    ['content' => 'Give 15 g of fast-acting carbohydrate', 'correct' => true],
                    ['content' => 'Notify the provider immediately', 'correct' => false],
                    ['content' => 'Give the scheduled insulin dose', 'correct' => false],
                ],
            ],
            [
                'stem' => 'A client with COPD is receiving oxygen. Which goal is most appropriate?',
                'choices' => [
                    ['content' => 'Maintain SpO2 between 88% and 92%', 'correct' => true],
                    ['content' => 'Maintain SpO2 at 100%', 'correct' => false],
                    ['content' => 'Use nonrebreather mask at all times', 'correct' => false],
                    ['content' => 'Encourage high-flow oxygen to prevent CO2 retention', 'correct' => false],
                ],
            ],
            [
                'stem' => 'Which finding requires immediate intervention in a client receiving blood transfusion?',
                'choices' => [
                    ['content' => 'Low-grade fever 37.8°C (100°F)', 'correct' => false],
                    ['content' => 'Back pain and chills', 'correct' => true],
                    ['content' => 'Mild anxiety', 'correct' => false],
                    ['content' => 'Slight increase in blood pressure', 'correct' => false],
                ],
            ],
            [
                'stem' => 'The nurse provides teaching about digoxin. Which statement indicates a need for further instruction?',
                'choices' => [
                    ['content' => 'I will check my pulse before taking the medication', 'correct' => false],
                    ['content' => 'If I have nausea and loss of appetite, I will notify my provider', 'correct' => false],
                    ['content' => 'If my pulse is 58/min, I will still take the dose', 'correct' => true],
                    ['content' => 'I will report visual changes like seeing yellow halos', 'correct' => false],
                ],
            ],
        ];

        foreach ($questions as $q) {
            $db->table('questions')->insert([
                'author_id' => 1,
                'type' => 'mcq',
                'stem' => $q['stem'],
                'rationale' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $qid = (int)$db->insertID();
            $label = 'A';
            foreach ($q['choices'] as $c) {
                $db->table('choices')->insert([
                    'question_id' => $qid,
                    'label' => $label,
                    'content' => $c['content'],
                    'is_correct' => $c['correct'] ? 1 : 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $label = chr(ord($label) + 1);
            }
        }
    }
}






