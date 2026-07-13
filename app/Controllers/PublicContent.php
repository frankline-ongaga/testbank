<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PublicContent extends Controller
{
    public function test(int $id, ?string $slug = null)
    {
        helper('url');

        $db = \Config\Database::connect();
        $questionCountSubquery = '(SELECT test_id, COUNT(*) AS question_count FROM test_questions GROUP BY test_id) AS q';
        $productListSubquery = "(SELECT tp.test_id, GROUP_CONCAT(p.name ORDER BY p.sort_order SEPARATOR ', ') AS product_names, GROUP_CONCAT(p.slug ORDER BY p.sort_order SEPARATOR ',') AS product_slugs FROM test_products tp INNER JOIN products p ON p.id = tp.product_id GROUP BY tp.test_id) AS tp";

        $test = $db->table('tests t')
            ->select('t.*, COALESCE(q.question_count, 0) AS question_count, COALESCE(tp.product_names, "") AS product_names, COALESCE(tp.product_slugs, "") AS product_slugs')
            ->join($questionCountSubquery, 'q.test_id = t.id', 'left')
            ->join($productListSubquery, 'tp.test_id = t.id', 'left')
            ->where('t.id', $id)
            ->where('t.status', 'active')
            ->get()
            ->getRowArray();

        if (!$test) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Practice test not found');
        }

        $canonicalSlug = $this->slugify($test['title'] ?? 'practice-test');
        if ($slug !== $canonicalSlug) {
            return redirect()->to(base_url('practice-test/' . $id . '/' . $canonicalSlug), 301);
        }

        $sampleQuestions = [];
        if ((int) ($test['is_free'] ?? 0) === 1) {
            $sampleQuestions = $db->table('test_questions tq')
                ->select('q.id, q.stem, q.updated_at')
                ->join('questions q', 'q.id = tq.question_id', 'inner')
                ->where('tq.test_id', $id)
                ->where('q.is_active', 1)
                ->orderBy('tq.sort_order', 'ASC')
                ->limit(6)
                ->get()
                ->getResultArray();

            foreach ($sampleQuestions as &$question) {
                $question['public_url'] = base_url('practice-question/' . (int) $question['id'] . '/' . $this->slugify($question['stem'] ?? 'question'));
            }
            unset($question);
        }

        $productNames = array_filter(array_map('trim', explode(',', (string) ($test['product_names'] ?? ''))));
        $duration = !empty($test['time_limit_minutes']) ? (int) $test['time_limit_minutes'] . ' minutes' : 'Untimed';
        $questionCount = (int) ($test['question_count'] ?? 0);
        $title = trim(($test['title'] ?? 'Practice Test') . ' | NCLEX Prep Course');
        $description = 'Preview ' . ($test['title'] ?? 'this practice test') . ' with ' . $questionCount . ' exam-style questions, clear practice structure, and product-specific preparation for ' . (!empty($productNames) ? implode(', ', $productNames) : 'nursing exam prep') . '.';

        $data = [
            'title' => $title,
            'description' => $description,
            'test' => $test,
            'productNames' => $productNames,
            'duration' => $duration,
            'questionCount' => $questionCount,
            'sampleQuestions' => $sampleQuestions,
            'canonicalUrl' => base_url('practice-test/' . $id . '/' . $canonicalSlug),
        ];

        return view('homepage/header', $data)
            . view('homepage/public_test', $data)
            . view('homepage/footer', $data);
    }

    public function question(int $id, ?string $slug = null)
    {
        helper('url');

        $db = \Config\Database::connect();
        $question = $db->table('questions q')
            ->select('q.*')
            ->where('q.id', $id)
            ->where('q.is_active', 1)
            ->get()
            ->getRowArray();

        if (!$question) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Practice question not found');
        }

        $linkedTests = $db->table('test_questions tq')
            ->select('t.id, t.title, t.is_free')
            ->join('tests t', 't.id = tq.test_id', 'inner')
            ->where('tq.question_id', $id)
            ->where('t.status', 'active')
            ->where('t.is_free', 1)
            ->orderBy('tq.sort_order', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($linkedTests)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Practice question not found');
        }

        $canonicalSlug = $this->slugify($question['stem'] ?? 'practice-question');
        if ($slug !== $canonicalSlug) {
            return redirect()->to(base_url('practice-question/' . $id . '/' . $canonicalSlug), 301);
        }

        $choices = $db->table('choices')
            ->select('id, question_id, label, content')
            ->where('question_id', $id)
            ->orderBy('label', 'ASC')
            ->get()
            ->getResultArray();

        $primaryTest = $linkedTests[0];
        $testSlug = $this->slugify($primaryTest['title'] ?? 'practice-test');
        $plainStem = $this->plainText($question['stem'] ?? '');
        $summaryStem = mb_strlen($plainStem) > 145 ? mb_substr($plainStem, 0, 142) . '...' : $plainStem;

        $data = [
            'title' => 'Practice Question: ' . ($summaryStem ?: 'NCLEX Review') . ' | NCLEX Prep Course',
            'description' => 'Review this free practice question from ' . ($primaryTest['title'] ?? 'our practice test') . ' and continue with exam-style nursing questions on NCLEX Prep Course.',
            'question' => $question,
            'questionHeading' => $plainStem ?: 'Practice Question',
            'choices' => $choices,
            'linkedTests' => $linkedTests,
            'primaryTestUrl' => base_url('practice-test/' . (int) $primaryTest['id'] . '/' . $testSlug),
            'takeTestUrl' => base_url('free/test/' . (int) $primaryTest['id']),
            'canonicalUrl' => base_url('practice-question/' . $id . '/' . $canonicalSlug),
        ];

        return view('homepage/header', $data)
            . view('homepage/public_question', $data)
            . view('homepage/footer', $data);
    }

    private function slugify(string $value): string
    {
        $value = $this->plainText($value);
        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? '';
        $value = trim($value, '-');
        $value = substr($value, 0, 90);

        return $value !== '' ? $value : 'item';
    }

    private function plainText(string $value): string
    {
        $value = trim(strip_tags(html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $value = preg_replace('/\s+/', ' ', $value) ?? '';
        $value = preg_replace('/^[\s\.\-:;]+/', '', $value) ?? '';

        return trim($value);
    }
}
