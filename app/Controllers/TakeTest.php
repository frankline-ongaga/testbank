<?php

namespace App\Controllers;

use App\Models\AttemptModel;

class TakeTest extends BaseController
{
    protected $db;
    protected $attemptModel;
    protected $session;
    protected $subs;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->attemptModel = new AttemptModel();
        $this->session = session();
        $this->subs = new \App\Models\SubscriptionModel();
    }

    public function start($testId)
    {
        $userId = (int) $this->session->get('user_id');
        // Enforce subscription - no free trial for tests
        $active = $this->subs->getActiveForUser($userId);
        if (!$active) {
            return redirect()->to('/client/subscription')->with('error', 'Subscribe to access practice tests.');
        }
        $attemptId = $this->attemptModel->insert([
            'test_id' => (int) $testId,
            'user_id' => $userId,
            'started_at' => date('Y-m-d H:i:s'),
        ], true);
        // Redirect to client-specific take route
        return redirect()->to('/client/tests/take/'.$attemptId);
    }

    /**
     * Start an active free test without subscription enforcement
     */
    public function startFree($testId)
    {
        $userId = (int) $this->session->get('user_id');
        if (!$userId) {
            return redirect()->to('/login/student')->with('error', 'Please login to continue.');
        }
        $testId = (int) $testId;
        $test = $this->db->table('tests')
            ->where('id', $testId)
            ->where('is_free', 1)
            ->where('status', 'active')
            ->get()->getRowArray();
        if (!$test) {
            return redirect()->to('/')->with('error', 'Free test is not available.');
        }
        $attemptId = $this->attemptModel->insert([
            'test_id' => $testId,
            'user_id' => $userId,
            'started_at' => date('Y-m-d H:i:s'),
        ], true);
        return redirect()->to('/client/tests/take/'.$attemptId);
    }

    public function show($attemptId)
    {
        $attempt = $this->attemptModel->find((int)$attemptId);
        if (!$attempt) return redirect()->to('/client/tests');

        // Get test data
        $test = $this->db->table('tests')->where('id', $attempt['test_id'])->get()->getRowArray();
        if (!$test) return redirect()->to('/client/tests');

        $questions = $this->db->table('test_questions tq')
->select('q.id, q.stem, q.type')
            ->join('questions q', 'q.id = tq.question_id', 'inner')
            ->where('tq.test_id', $attempt['test_id'])
            ->orderBy('tq.sort_order', 'ASC')
            ->get()->getResultArray();

        $choicesByQ = [];
        if (!empty($questions)) {
            $qids = array_column($questions, 'id');
            $choiceRows = $this->db->table('choices')->whereIn('question_id', $qids)->orderBy('label','ASC')->get()->getResultArray();
            foreach ($choiceRows as $c) {
                $choicesByQ[$c['question_id']][] = $c;
            }
        }

        $data = [
            'title' => $test['title'] ?? 'Take Test',
            'test' => $test,
            'attempt' => $attempt,
            'questions' => $questions,
            'choicesByQ' => $choicesByQ,
        ];
        // For free tests, render within homepage layout
        if (!empty($test['is_free'])) {
            $data['renderInHomepage'] = true;
            return view('homepage/header', $data)
                . view('tests/take', $data)
                . view('homepage/footer', $data);
        }
        return view('tests/take', $data);
    }

    public function submit($attemptId)
    {
        $attempt = $this->attemptModel->find((int)$attemptId);
        if (!$attempt) return redirect()->to('/client/tests');

        $answers = (array) $this->request->getPost('answers');

        // Compute score
        $questionIds = array_map('intval', array_keys($answers));
        $correctMap = [];
        if (!empty($questionIds)) {
            $rows = $this->db->table('choices')
                ->select('question_id, id, is_correct')
                ->whereIn('question_id', $questionIds)
                ->get()->getResultArray();
            foreach ($rows as $r) {
                if (!isset($correctMap[$r['question_id']])) $correctMap[$r['question_id']] = [];
                if ($r['is_correct']) $correctMap[$r['question_id']][] = (int)$r['id'];
            }
        }

        $numCorrect = 0;
        $total = 0;
        foreach ($answers as $qid => $choiceIds) {
            $total++;
            $submitted = array_map('intval', (array)$choiceIds);
            sort($submitted);
            $expected = $correctMap[(int)$qid] ?? [];
            sort($expected);
            if ($submitted === $expected) $numCorrect++;

            // store attempt_answers
            foreach ($submitted as $cid) {
                $this->db->table('attempt_answers')->insert([
                    'attempt_id' => (int)$attemptId,
                    'question_id' => (int)$qid,
                    'choice_id' => (int)$cid,
                    'is_correct' => in_array((int)$cid, $expected, true) ? 1 : 0,
                ]);
            }
        }

        $score = $total > 0 ? round(($numCorrect / $total) * 100, 2) : 0.0;
        $this->attemptModel->update((int)$attemptId, [
            'completed_at' => date('Y-m-d H:i:s'),
            'score' => $score,
        ]);

        // If this was a free test, redirect to client panel tests list
        $test = $this->db->table('tests')->where('id', $attempt['test_id'])->get()->getRowArray();
        if (!empty($test['is_free'])) {
            return redirect()->to('/client/tests/results/'.$attemptId);
        }
        return redirect()->to('/client/tests/results/'.$attemptId);
    }

    public function results($attemptId)
    {
        $attempt = $this->attemptModel->find((int)$attemptId);
        if (!$attempt) return redirect()->to('/client/tests');

        // Get test questions with answers
        $questions = $this->db->table('test_questions tq')
            ->select('q.id, q.stem, q.type, q.rationale')
            ->join('questions q', 'q.id = tq.question_id', 'inner')
            ->where('tq.test_id', $attempt['test_id'])
            ->orderBy('tq.sort_order', 'ASC')
            ->get()->getResultArray();

        // Get all choices
        $choicesByQ = [];
        if (!empty($questions)) {
            $qids = array_column($questions, 'id');
            $choiceRows = $this->db->table('choices')
                ->whereIn('question_id', $qids)
                ->orderBy('label', 'ASC')
                ->get()->getResultArray();
            foreach ($choiceRows as $c) {
                $choicesByQ[$c['question_id']][] = $c;
            }
        }

        // Get user's answers
        $userAnswers = [];
        $answerRows = $this->db->table('attempt_answers aa')
            ->select('aa.question_id, aa.choice_id, aa.is_correct')
            ->where('aa.attempt_id', $attemptId)
            ->get()->getResultArray();
        
        foreach ($answerRows as $a) {
            if (!isset($userAnswers[$a['question_id']])) {
                $userAnswers[$a['question_id']] = [
                    'choices' => [],
                    'is_correct' => true
                ];
            }
            $userAnswers[$a['question_id']]['choices'][] = $a['choice_id'];
            if (!$a['is_correct']) {
                $userAnswers[$a['question_id']]['is_correct'] = false;
            }
        }

        $data = [
            'title' => 'Results',
            'attempt' => $attempt,
            'questions' => $questions,
            'choicesByQ' => $choicesByQ,
            'userAnswers' => $userAnswers
        ];
        return view('tests/results', $data);
    }
}


