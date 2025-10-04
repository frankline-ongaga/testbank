<?php

namespace App\Controllers;

use App\Models\TestModel;
use App\Models\QuestionModel;

class Tests extends BaseController
{
    protected $testModel;
    protected $questionModel;
    

    public function __construct()
    {
        helper(['form', 'url']);
        $this->testModel = new TestModel();
        $this->questionModel = new QuestionModel();
        
    }

    public function index()
    {
        $currentRole = session()->get('current_role') ?: 'client';
        
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
        else { // student view
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
        $currentRole = session()->get('current_role') ?: '';
        
        // Only admin and instructors can create tests
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/tests')->with('error', 'Access denied');
        }
        
        // Load questions list for selection
        // Show most recent 200 questions; adjust as needed
        $questions = $this->questionModel
            ->orderBy('id', 'DESC')
            ->findAll(200);

        // Optionally load categories for filter (left empty if not using taxonomy here)
        $categories = [];

        $data = [
            'title' => 'Create Test',
            'questions' => $questions,
            'categories' => $categories,
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

        $rules = [
            'title' => 'required|min_length[3]',
            'mode' => 'required|in_list[practice,evaluation]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $testId = $this->testModel->insert([
            'owner_id' => (int) (session()->get('user_id') ?? 0),
            'title' => $this->request->getPost('title'),
            'mode' => $this->request->getPost('mode'),
            'time_limit_minutes' => (int) $this->request->getPost('time_limit'),
            'is_adaptive' => $this->request->getPost('is_adaptive') ? 1 : 0,
            'status' => $currentRole === 'admin' ? 'active' : 'pending'
        ], true);

        // Add selected questions to the test
        $questionIds = array_filter(array_map('intval', (array) $this->request->getPost('question_ids')));
        if (!empty($questionIds)) {
            $db = \Config\Database::connect();
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
        $this->testModel->update((int)$id, ['status' => 'active']);
        return redirect()->to('/admin/tests')->with('message', 'Test activated');
    }
}