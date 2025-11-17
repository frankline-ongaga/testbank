<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\QuestionModel;
use App\Models\ChoiceModel;
use App\Models\TaxonomyModel;
use App\Models\SubscriptionModel;

class Tests extends BaseController
{
    protected $testModel;
    protected $questionModel;
    protected $choiceModel;
    protected $taxonomyModel;
    protected $subs;
    

    public function __construct()
    {
        helper(['form', 'url']);
        $this->testModel = new TestModel();
        $this->questionModel = new QuestionModel();
        $this->choiceModel = new ChoiceModel();
        $this->taxonomyModel = new TaxonomyModel();
        $this->subs = new SubscriptionModel();
    }

    public function index()
    {
        $currentRole = session()->get('current_role') ?: 'client';
        
        // Clients: show free tests regardless of subscription; paid tests require active subscription
        if ($currentRole === 'client') {
            $userId = (int) (session()->get('user_id') ?? 0);
            $activeSub = $this->subs->getActiveForUser($userId);
            $freeTests = $this->testModel->getActiveFreeTests();
            $paidTests = $this->testModel->getActivePaidTests();
            $data = [
                'title' => 'Available Tests',
                'freeTests' => $freeTests,
                'paidTests' => $paidTests,
                'hasSubscription' => (bool)$activeSub,
            ];
            return view('client/layout/header', $data)
                . view('client/tests/index', $data)
                . view('client/layout/footer');
        }
        
        // Get tests based on role
        if ($currentRole === 'admin') {
            $tests = $this->testModel->getTestsWithCounts();
            $data = [
                'title' => 'Manage Tests',
                'tests' => $tests
            ];
            return view('admin/layout/header', $data)
                . view('admin/tests/index', $data)
                . view('admin/layout/footer');
        } 
        elseif ($currentRole === 'instructor') {
            $userId = (int) (session()->get('user_id') ?? 0);
            $tests = $this->testModel->getOwnerTests($userId);
            $data = [
                'title' => 'My Tests',
                'tests' => $tests
            ];
            return view('instructor/layout/header', $data)
                . view('instructor/tests/index', $data)
                . view('instructor/layout/footer');
        }
        else { // student view (fallback)
            $tests = $this->testModel->getActiveTests();
            $data = [
                'title' => 'Available Tests',
                'tests' => $tests
            ];
            return view('client/layout/header', $data)
                . view('client/tests/index', $data)
                . view('client/layout/footer');
        }
    }

    public function create()
    {
        return $this->renderCreate(false);
    }

    public function createFree()
    {
        return $this->renderCreate(true);
    }

    protected function renderCreate(bool $isFree)
    {
        $currentRole = session()->get('current_role') ?: '';
        
        // Only admin and instructors can create tests
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/tests')->with('error', 'Access denied');
        }

        $data = [
            'title' => $isFree ? 'Create Free Test' : 'Create Test',
            'is_free' => $isFree,
        ];
        
        if ($currentRole === 'admin') {
            return view('admin/layout/header', $data)
                . view('admin/tests/create', $data)
                . view('admin/layout/footer');
        } else {
            return view('instructor/layout/header', $data)
                . view('instructor/tests/create', $data)
                . view('instructor/layout/footer');
        }
    }

    public function edit($id)
    {
        $roles = session()->get('roles') ?? [];
        if (!in_array('admin', $roles)) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $test = $this->testModel->find((int)$id);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $data = ['title' => 'Edit Test', 'test' => $test];
        return view('admin/layout/header', $data)
            . view('admin/tests/edit', $data)
            . view('admin/layout/footer');
    }

    public function update($id)
    {
        $roles = session()->get('roles') ?? [];
        if (!in_array('admin', $roles)) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $rules = [
            'title' => 'required|min_length[3]',
            'mode' => 'required|in_list[practice,evaluation]',
            'status' => 'required|in_list[draft,pending,active,inactive]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $this->testModel->update((int)$id, [
            'title' => $this->request->getPost('title'),
            'mode' => $this->request->getPost('mode'),
            'time_limit_minutes' => (int) $this->request->getPost('time_limit_minutes'),
            'is_adaptive' => $this->request->getPost('is_adaptive') ? 1 : 0,
            'status' => $this->request->getPost('status')
        ]);
        return redirect()->to('/admin/tests')->with('message', 'Test updated');
    }

    public function store()
    {
        $currentRole = session()->get('current_role') ?: '';
        
        // Only admin and instructors can create tests
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/tests')->with('error', 'Access denied');
        }

        $isFree = $this->request->getPost('is_free') ? 1 : 0;
        $rules = [
            'title' => 'required|min_length[3]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $mode = $this->request->getPost('mode');
        $mode = $mode ? $mode : 'practice';
        $testId = $this->testModel->insert([
            'owner_id' => (int) (session()->get('user_id') ?? 0),
            'title' => $this->request->getPost('title'),
            'mode' => $isFree ? 'practice' : $mode,
            'time_limit_minutes' => $isFree ? 0 : (int) $this->request->getPost('time_limit'),
            'is_adaptive' => 1,
            'is_free' => $isFree,
            'status' => $currentRole === 'admin' ? 'active' : 'pending'
        ], true);

        $message = 'Test created. Add questions to this test.';
        // After creating a test, go directly to manage its questions (admin or instructor path)
        if ($currentRole === 'admin') {
            return redirect()->to('/admin/tests/' . $testId . '/questions')->with('message', $message);
        }
        if ($currentRole === 'instructor') {
            return redirect()->to('/instructor/tests/' . $testId . '/questions')->with('message', $message);
        }
        return redirect()->to('/tests')->with('message', $message);
    }

    // Admin: activate a test (publish)
    public function activate($id)
    {
        $roles = session()->get('roles') ?? [];
        if (!in_array('admin', $roles)) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        // If activating a free test, ensure only one active free test at a time
        $id = (int)$id;
        $test = $this->testModel->find($id);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        if (!empty($test['is_free'])) {
            // Deactivate any other active free test
            $this->testModel->where('is_free', 1)
                ->where('status', 'active')
                ->where('id !=', $id)
                ->set(['status' => 'inactive'])
                ->update();
        }
        $this->testModel->update($id, ['status' => 'active']);
        return redirect()->to('/admin/tests')->with('message', 'Test activated');
    }

    public function delete($id)
    {
        $roles = session()->get('roles') ?? [];
        if (!in_array('admin', $roles)) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }

        $id = (int)$id;
        $test = $this->testModel->find($id);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }

        // Remove relationships first
        $db = \Config\Database::connect();
        $db->table('test_questions')->where('test_id', $id)->delete();
        $db->table('attempts')->where('test_id', $id)->delete();

        // Delete the test
        $this->testModel->delete($id);
        return redirect()->to('/admin/tests')->with('message', 'Test deleted');
    }

    // --- Admin: Manage Questions within a Test ---
    public function manageQuestions($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $db = \Config\Database::connect();
        $questions = $db->table('test_questions tq')
            ->select('q.id, q.stem, q.type, tq.sort_order')
            ->join('questions q', 'q.id = tq.question_id', 'inner')
            ->where('tq.test_id', (int)$testId)
            ->orderBy('tq.sort_order', 'ASC')
            ->get()->getResultArray();
        $data = [
            'title' => 'Manage Questions: ' . ($test['title'] ?? ('Test #' . $testId)),
            'test' => $test,
            'questions' => $questions,
        ];
        // Use admin layout for admins, instructor layout for instructors
        if ($isAdmin) {
            return view('admin/layout/header', $data)
                . view('admin/tests/questions/index', $data)
                . view('admin/layout/footer');
        }
        return view('instructor/layout/header', $data)
            . view('admin/tests/questions/index', $data)
            . view('instructor/layout/footer');
    }

    public function createQuestion($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $data = [
            'title' => 'Add Question to: ' . ($test['title'] ?? ('Test #' . $testId)),
            'test' => $test,
            'nclex_terms' => $this->taxonomyModel->getTermsByType('nclex'),
        ];
        if ($isAdmin) {
            return view('admin/layout/header', $data)
                . view('admin/tests/questions/create', $data)
                . view('admin/layout/footer');
        }
        return view('instructor/layout/header', $data)
            . view('admin/tests/questions/create', $data)
            . view('instructor/layout/footer');
    }

    public function storeQuestion($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $rules = [
            'type' => 'required|in_list[mcq,sata]',
            'stem' => 'required|min_length[10]',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // Read choices (support both nested view format and global questions/create format)
        $choiceContents = (array) $this->request->getPost('contents');
        $choiceLabels = (array) $this->request->getPost('labels');
        $choiceCorrect = (array) $this->request->getPost('correct');
        if (empty($choiceContents)) {
            // fallback to alternative fields used earlier
            $choiceContents = (array) $this->request->getPost('choice_content');
            $choiceCorrect = (array) $this->request->getPost('choice_correct');
            $choiceLabels = [];
        }
        // Ensure at least one correct choice
        $hasCorrect = false;
        foreach ($choiceContents as $idx => $content) {
            if (!empty($choiceCorrect[$idx])) { $hasCorrect = true; break; }
        }
        if (!$hasCorrect) {
            return redirect()->back()->withInput()->with('errors', ['Select at least one correct choice.']);
        }
        // Insert question
        $questionId = $this->questionModel->insert([
            'author_id' => (int) (session()->get('user_id') ?? 0),
            'type' => $this->request->getPost('type'),
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
            'is_active' => 1,
        ], true);
        // Optional taxonomy linking (NCLEX category)
        $termIds = (array) $this->request->getPost('term_ids');
        if (!empty($termIds)) {
            $db = \Config\Database::connect();
            $rows = [];
            foreach ($termIds as $tid) {
                $tid = (int) $tid;
                if ($tid > 0) {
                    $rows[] = ['question_id' => $questionId, 'term_id' => $tid];
                }
            }
            if (!empty($rows)) {
                $db->table('question_terms')->insertBatch($rows);
            }
        }
        // Insert choices
        foreach ($choiceContents as $idx => $content) {
            $content = trim((string) $content);
            if ($content === '') continue;
            $label = isset($choiceLabels[$idx]) && $choiceLabels[$idx] !== '' ? (string)$choiceLabels[$idx] : chr(65 + $idx);
            $this->choiceModel->insert([
                'question_id' => $questionId,
                'label' => $label,
                'content' => $content,
                'is_correct' => !empty($choiceCorrect[$idx]) ? 1 : 0,
            ]);
        }
        // Link to test with next sort order
        $db = \Config\Database::connect();
        $max = $db->table('test_questions')->selectMax('sort_order')->where('test_id', (int)$testId)->get()->getRowArray();
        $nextSort = (int) ($max['sort_order'] ?? 0) + 1;
        $db->table('test_questions')->insert([
            'test_id' => (int)$testId,
            'question_id' => (int)$questionId,
            'sort_order' => $nextSort,
        ]);
        $base = $isAdmin ? '/admin' : '/instructor';
        return redirect()->to($base . '/tests/' . $testId . '/questions')->with('message', 'Question added to test.');
    }

    public function linkQuestion($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $db = \Config\Database::connect();
        $usedIdsAll = $db->table('test_questions')->select('question_id')->get()->getResultArray();
        $usedIdsAll = array_map(fn($r) => (int)$r['question_id'], $usedIdsAll);
        $usedByThis = $db->table('test_questions')->select('question_id')->where('test_id', (int)$testId)->get()->getResultArray();
        $usedByThis = array_map(fn($r) => (int)$r['question_id'], $usedByThis);
        $builder = $this->questionModel->orderBy('id', 'DESC');
        if (empty($test['is_free'])) {
            if (!empty($usedIdsAll)) {
                $builder->whereNotIn('id', $usedIdsAll);
            }
        } else {
            // Free tests can reuse; just exclude already linked to this test
            if (!empty($usedByThis)) {
                $builder->whereNotIn('id', $usedByThis);
            }
        }
        $questions = $builder->findAll(200);
        $data = [
            'title' => 'Link Existing Questions: ' . ($test['title'] ?? ('Test #' . $testId)),
            'test' => $test,
            'questions' => $questions,
        ];
        if ($isAdmin) {
            return view('admin/layout/header', $data)
                . view('admin/tests/questions/link', $data)
                . view('admin/layout/footer');
        }
        return view('instructor/layout/header', $data)
            . view('admin/tests/questions/link', $data)
            . view('instructor/layout/footer');
    }

    public function doLinkQuestion($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $questionIds = array_values(array_filter(array_map('intval', (array) $this->request->getPost('question_ids'))));
        if (empty($questionIds)) {
            return redirect()->back()->with('error', 'No questions selected.');
        }
        $db = \Config\Database::connect();
        // Free test limit of 10
        if (!empty($test['is_free'])) {
            $currentCount = (int) $db->table('test_questions')->where('test_id', (int)$testId)->countAllResults();
            if (($currentCount + count($questionIds)) > 10) {
                return redirect()->back()->with('error', 'Free tests can include a maximum of 10 questions.');
            }
        }
        // Compute next sort order start
        $max = $db->table('test_questions')->selectMax('sort_order')->where('test_id', (int)$testId)->get()->getRowArray();
        $nextSort = (int) ($max['sort_order'] ?? 0);
        $rows = [];
        foreach ($questionIds as $qid) {
            $nextSort++;
            $rows[] = ['test_id' => (int)$testId, 'question_id' => (int)$qid, 'sort_order' => $nextSort];
        }
        if (!empty($rows)) {
            $db->table('test_questions')->insertBatch($rows);
        }
        $base = $isAdmin ? '/admin' : '/instructor';
        return redirect()->to($base . '/tests/' . $testId . '/questions')->with('message', 'Questions linked to test.');
    }

    public function unlinkQuestion($testId, $questionId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $db = \Config\Database::connect();
        $db->table('test_questions')->where('test_id', (int)$testId)->where('question_id', (int)$questionId)->delete();
        $base = $isAdmin ? '/admin' : '/instructor';
        return redirect()->to($base . '/tests/' . $testId . '/questions')->with('message', 'Question removed from test.');
    }

    public function importQuestionsForm($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $data = [
            'title' => 'Import Questions: ' . ($test['title'] ?? ('Test #' . $testId)),
            'test' => $test,
        ];
        if ($isAdmin) {
            return view('admin/layout/header', $data)
                . view('admin/tests/questions/import', $data)
                . view('admin/layout/footer');
        }
        return view('instructor/layout/header', $data)
            . view('admin/tests/questions/import', $data)
            . view('instructor/layout/footer');
    }

    public function importQuestions($testId)
    {
        $roles = session()->get('roles') ?? [];
        $userId = (int) (session()->get('user_id') ?? 0);
        $test = $this->testModel->find((int)$testId);
        if (!$test) {
            return redirect()->to('/admin/tests')->with('error', 'Test not found');
        }
        $isAdmin = in_array('admin', $roles);
        $isInstructorOwner = in_array('instructor', $roles) && (int)($test['owner_id'] ?? 0) === $userId;
        if (!$isAdmin && !$isInstructorOwner) {
            return redirect()->to('/admin/tests')->with('error', 'Access denied');
        }
        $file = $this->request->getFile('csv_file');
        if (!$file || !$file->isValid()) {
            $base = $isAdmin ? '/admin' : '/instructor';
            return redirect()->to($base . '/tests/' . $testId . '/questions/import')->with('error', 'Upload a valid CSV file.');
        }
        $ext = strtolower($file->getExtension());
        if ($ext !== 'csv') {
            $base = $isAdmin ? '/admin' : '/instructor';
            return redirect()->to($base . '/tests/' . $testId . '/questions/import')->with('error', 'Only CSV files are supported. Please export your Excel sheet as CSV.');
        }
        $tmpPath = $file->getTempName();
        $handle = @fopen($tmpPath, 'r');
        if ($handle === false) {
            $base = $isAdmin ? '/admin' : '/instructor';
            return redirect()->to($base . '/tests/' . $testId . '/questions/import')->with('error', 'Could not read uploaded file.');
        }
        // Read header
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            $base = $isAdmin ? '/admin' : '/instructor';
            return redirect()->to($base . '/tests/' . $testId . '/questions/import')->with('error', 'CSV file is empty.');
        }
        $normalize = function($s) {
            $s = strtolower(trim((string)$s));
            $s = str_replace([' ', '-'], '_', $s);
            return $s;
        };
        $map = [];
        foreach ($header as $i => $h) {
            $map[$normalize($h)] = $i;
        }
        $required = ['type', 'stem', 'choice_a', 'choice_b', 'correct'];
        foreach ($required as $key) {
            if (!array_key_exists($key, $map)) {
                fclose($handle);
                $base = $isAdmin ? '/admin' : '/instructor';
                return redirect()->to($base . '/tests/' . $testId . '/questions/import')->with('error', 'Missing required column: ' . $key);
            }
        }
        // For free test, enforce 10 question max
        $db = \Config\Database::connect();
        $currentCount = (int) $db->table('test_questions')->where('test_id', (int)$testId)->countAllResults();
        $maxAllowed = null;
        if (!empty($test['is_free'])) {
            $maxAllowed = max(0, 10 - $currentCount);
            if ($maxAllowed <= 0) {
                fclose($handle);
                $base = $isAdmin ? '/admin' : '/instructor';
                return redirect()->to($base . '/tests/' . $testId . '/questions')->with('error', 'Free tests can include a maximum of 10 questions.');
            }
        }
        $imported = 0;
        $skipped = 0;
        $rowNum = 1; // header
        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            if ($maxAllowed !== null && $imported >= $maxAllowed) {
                $skipped++;
                continue;
            }
            $type = strtolower(trim((string)($row[$map['type']] ?? '')));
            if ($type !== 'mcq' && $type !== 'sata') {
                $skipped++;
                continue;
            }
            $stem = trim((string)($row[$map['stem']] ?? ''));
            if ($stem === '') { $skipped++; continue; }
            $rationale = isset($map['rationale']) ? (string)$row[$map['rationale']] : null;
            $choices = [];
            $labels = ['a','b','c','d','e','f'];
            foreach ($labels as $lbl) {
                $col = 'choice_' . $lbl;
                if (array_key_exists($col, $map)) {
                    $val = trim((string)($row[$map[$col]] ?? ''));
                    if ($val !== '') {
                        $choices[strtoupper($lbl)] = $val;
                    }
                }
            }
            if (count($choices) < 2) { $skipped++; continue; }
            $correctRaw = (string)($row[$map['correct']] ?? '');
            $correctParts = preg_split('/[;,\\s]+/', strtoupper(trim($correctRaw)));
            $correctSet = array_filter($correctParts, function($c) use ($choices) {
                return $c !== '' && array_key_exists($c, $choices);
            });
            if (empty($correctSet)) { $skipped++; continue; }
            // Create question
            $questionId = $this->questionModel->insert([
                'author_id' => $userId,
                'type' => $type,
                'stem' => $stem,
                'rationale' => $rationale,
                'is_active' => 1,
            ], true);
            // Insert choices
            foreach ($choices as $label => $content) {
                $this->choiceModel->insert([
                    'question_id' => $questionId,
                    'label' => $label,
                    'content' => $content,
                    'is_correct' => in_array($label, $correctSet, true) ? 1 : 0,
                ]);
            }
            // Link to test with next sort
            $max = $db->table('test_questions')->selectMax('sort_order')->where('test_id', (int)$testId)->get()->getRowArray();
            $nextSort = (int) ($max['sort_order'] ?? 0) + 1;
            $db->table('test_questions')->insert([
                'test_id' => (int)$testId,
                'question_id' => (int)$questionId,
                'sort_order' => $nextSort,
            ]);
            $imported++;
        }
        fclose($handle);
        $base = $isAdmin ? '/admin' : '/instructor';
        $summary = "Imported {$imported} question(s)";
        if ($skipped > 0) { $summary .= ", skipped {$skipped}."; } else { $summary .= "."; }
        return redirect()->to($base . '/tests/' . $testId . '/questions')->with('message', $summary);
    }

    public function importSample($testId)
    {
        // Provide a downloadable CSV template
        $filename = 'questions_sample.csv';
        $lines = [];
        $lines[] = 'type,stem,rationale,choice_a,choice_b,choice_c,choice_d,correct';
        $lines[] = 'mcq,"What is the normal adult respiratory rate?","Normal adult respiratory rate is 12-20 per minute",12-20,20-30,30-40,8-10,A';
        $lines[] = 'sata,"Select the signs of hypoglycemia.","Symptoms include shakiness, sweating, confusion",Shakiness,Sweating,Confusion,Bradycardia,"A;B;C"';
        $csv = implode("\r\n", $lines) . "\r\n";
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }
}