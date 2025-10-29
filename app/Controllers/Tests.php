<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\QuestionModel;
use App\Models\SubscriptionModel;

class Tests extends BaseController
{
    protected $testModel;
    protected $questionModel;
    protected $subs;
    

    public function __construct()
    {
        helper(['form', 'url']);
        $this->testModel = new TestModel();
        $this->questionModel = new QuestionModel();
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
        
        // Load questions list for selection excluding ones already linked to any test
        $db = \Config\Database::connect();
        $usedIds = $db->table('test_questions')->select('question_id')->get()->getResultArray();
        $usedIds = array_map(fn($r) => (int) $r['question_id'], $usedIds);

        $builder = $this->questionModel->orderBy('id', 'DESC');
        // For free tests we allow reuse, otherwise exclude used questions
        if (!$isFree && !empty($usedIds)) {
            $builder = $builder->whereNotIn('id', $usedIds);
        }
        $questions = $builder->findAll(200);

        // Optionally load categories for filter (left empty if not using taxonomy here)
        $categories = [];

        $data = [
            'title' => $isFree ? 'Create Free Test' : 'Create Test',
            'questions' => $questions,
            'categories' => $categories,
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

        // Add selected questions to the test (ensure not already used anywhere)
        $questionIds = array_filter(array_map('intval', (array) $this->request->getPost('question_ids')));
        // Enforce free test limit of 10 questions
        if ($isFree && count($questionIds) > 10) {
            return redirect()->back()->withInput()->with('errors', [
                'Free tests can include a maximum of 10 questions.'
            ]);
        }
        if (!empty($questionIds)) {
            $db = \Config\Database::connect();
            // Validate none of these are already assigned to any test unless this is a free test
            if (!$isFree) {
                $existing = $db->table('test_questions')
                    ->select('question_id')
                    ->whereIn('question_id', $questionIds)
                    ->get()->getResultArray();
                if (!empty($existing)) {
                    $existingIds = array_map(fn($r) => (int)$r['question_id'], $existing);
                    return redirect()->back()->withInput()->with('errors', [
                        'Some selected questions are already used in another test: ' . implode(', ', $existingIds)
                    ]);
                }
            }
            $rows = [];
            foreach ($questionIds as $i => $qid) {
                $rows[] = ['test_id' => $testId, 'question_id' => $qid, 'sort_order' => $i + 1];
            }
            $db->table('test_questions')->insertBatch($rows);
        }

        $message = $currentRole === 'admin' 
            ? 'Test created and activated'
            : 'Test created and submitted for approval';

        if ($currentRole === 'admin') {
            return redirect()->to('/admin/tests')->with('message', $message);
        }
        if ($currentRole === 'instructor') {
            return redirect()->to('/instructor/tests')->with('message', $message);
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
}