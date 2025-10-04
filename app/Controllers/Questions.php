<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\ChoiceModel;
use App\Models\TaxonomyModel;

class Questions extends BaseController
{
    protected $questionModel;
    protected $choiceModel;
    protected $session;
    protected $taxonomyModel;
    protected $db;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->questionModel = new QuestionModel();
        $this->choiceModel = new ChoiceModel();
        $this->session = session();
        $this->taxonomyModel = new TaxonomyModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $builder = $this->questionModel->orderBy('id', 'DESC');

        $type = $this->request->getGet('type');
        $search = $this->request->getGet('q');
        if ($type) {
            $builder->where('type', $type);
        }
        if ($search) {
            $builder->like('stem', $search);
        }
        $questions = $builder->findAll(50);

        $data = [
            'title' => 'Questions',
            'questions' => $questions,
            'filter_type' => $type,
            'filter_q' => $search,
            'nclex_terms' => $this->taxonomyModel->getTermsByType('nclex'),
            'difficulty_terms' => $this->taxonomyModel->getTermsByType('difficulty'),
            'bloom_terms' => $this->taxonomyModel->getTermsByType('bloom'),
        ];
        
        // Check if user is admin and use admin layout
        if ($this->isAdmin()) {
            return view('admin/layout/header', $data)
                . view('questions/index', $data)
                . view('admin/layout/footer');
        }
        
        return view('homepage/header', $data)
            . view('questions/index', $data)
            . view('homepage/footer');
    }

    public function create()
    {
        $data['title'] = 'Create Question';
        $data['nclex_terms'] = $this->taxonomyModel->getTermsByType('nclex');
        $data['difficulty_terms'] = $this->taxonomyModel->getTermsByType('difficulty');
        $data['bloom_terms'] = $this->taxonomyModel->getTermsByType('bloom');
        
        // Check if user is admin and use admin layout
        if ($this->isAdmin()) {
            return view('admin/layout/header', $data)
                . view('questions/create', $data)
                . view('admin/layout/footer');
        }
        
        return view('homepage/header', $data)
            . view('questions/create', $data)
            . view('homepage/footer');
    }

    public function store()
    {
        $rules = [
            'type' => 'required|in_list[mcq,sata]',
            'stem' => 'required|min_length[10]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $questionId = $this->questionModel->insert([
            'author_id' => (int) ($this->session->get('user_id') ?: 0),
            'type' => $this->request->getPost('type'),
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
            'is_active' => $this->isAdmin() ? 1 : 0,
        ], true);

        $labels = $this->request->getPost('labels') ?? [];
        $contents = $this->request->getPost('contents') ?? [];
        $correct = $this->request->getPost('correct') ?? [];

        foreach ($contents as $i => $content) {
            $this->choiceModel->insert([
                'question_id' => $questionId,
                'label' => $labels[$i] ?? chr(65 + $i),
                'content' => $content,
                'is_correct' => isset($correct[$i]) ? 1 : 0,
            ]);
        }

        // Assign taxonomy terms
        $termIds = $this->request->getPost('term_ids') ?? [];
        if (!empty($termIds)) {
            $db = \Config\Database::connect();
            $rows = [];
            foreach ($termIds as $tid) {
                $rows[] = ['question_id' => $questionId, 'term_id' => (int)$tid];
            }
            if (!empty($rows)) {
                $db->table('question_terms')->insertBatch($rows);
            }
        }

        return redirect()->to('/admin/questions')->with('message', 'Question created successfully');
    }

    public function edit($id)
    {
        $question = $this->questionModel->find((int)$id);
        if (!$question) {
            return redirect()->to('/admin/questions')->with('error', 'Question not found');
        }
        $choices = $this->choiceModel->where('question_id', (int)$id)->orderBy('label')->findAll();
        $data = [
            'title' => 'Edit Question',
            'question' => $question,
            'choices' => $choices,
            'nclex_terms' => $this->taxonomyModel->getTermsByType('nclex'),
            'difficulty_terms' => $this->taxonomyModel->getTermsByType('difficulty'),
            'bloom_terms' => $this->taxonomyModel->getTermsByType('bloom'),
        ];

        return view('admin/layout/header', $data)
            . view('questions/edit', $data)
            . view('admin/layout/footer');
    }

    public function update($id)
    {
        $id = (int)$id;
        $question = $this->questionModel->find($id);
        if (!$question) {
            return redirect()->to('/admin/questions')->with('error', 'Question not found');
        }

        $rules = [
            'type' => 'required|in_list[mcq,sata]',
            'stem' => 'required|min_length[10]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update question
        $this->questionModel->update($id, [
            'type' => $this->request->getPost('type'),
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
        ]);

        // Replace choices
        $this->choiceModel->where('question_id', $id)->delete();
        $labels = $this->request->getPost('labels') ?? [];
        $contents = $this->request->getPost('contents') ?? [];
        $correct = $this->request->getPost('correct') ?? [];
        foreach ($contents as $i => $content) {
            if (trim((string)$content) === '') continue;
            $this->choiceModel->insert([
                'question_id' => $id,
                'label' => $labels[$i] ?? chr(65 + $i),
                'content' => $content,
                'is_correct' => isset($correct[$i]) ? 1 : 0,
            ]);
        }

        // Update taxonomy terms mapping
        $termIds = $this->request->getPost('term_ids') ?? [];
        $this->db->table('question_terms')->where('question_id', $id)->delete();
        if (!empty($termIds)) {
            $rows = [];
            foreach ($termIds as $tid) {
                if ((int)$tid > 0) {
                    $rows[] = ['question_id' => $id, 'term_id' => (int)$tid];
                }
            }
            if (!empty($rows)) {
                $this->db->table('question_terms')->insertBatch($rows);
            }
        }

        return redirect()->to('/admin/questions')->with('message', 'Question updated successfully');
    }

    public function delete($id)
    {
        $id = (int)$id;
        $question = $this->questionModel->find($id);
        if (!$question) {
            return redirect()->to('/admin/questions')->with('error', 'Question not found');
        }
        $this->choiceModel->where('question_id', $id)->delete();
        // Remove taxonomy links
        $this->db->table('question_terms')->where('question_id', $id)->delete();
        $this->questionModel->delete($id);
        return redirect()->to('/admin/questions')->with('message', 'Question deleted');
    }

    public function preview($id)
    {
        $id = (int)$id;
        $question = $this->questionModel->find($id);
        if (!$question) {
            return redirect()->to('/admin/questions')->with('error', 'Question not found');
        }
        $choices = $this->choiceModel->where('question_id', $id)->orderBy('label')->findAll();
        $data = [
            'title' => 'Preview Question',
            'question' => $question,
            'choices' => $choices,
        ];
        return view('admin/layout/header', $data)
            . view('questions/preview', $data)
            . view('admin/layout/footer');
    }

    public function pending()
    {
        // Only admins can review pending
        if (!$this->isAdmin()) {
            return redirect()->to('/admin/questions');
        }

        $questions = $this->questionModel
            ->where('is_active', 0)
            ->orderBy('id', 'DESC')
            ->findAll(100);

        $data = [
            'title' => 'Pending Questions',
            'questions' => $questions,
            'filter_type' => null,
            'filter_q' => null,
            'nclex_terms' => $this->taxonomyModel->getTermsByType('nclex'),
            'difficulty_terms' => $this->taxonomyModel->getTermsByType('difficulty'),
            'bloom_terms' => $this->taxonomyModel->getTermsByType('bloom'),
        ];

        return view('admin/layout/header', $data)
            . view('questions/index', $data)
            . view('admin/layout/footer');
    }

    public function approve($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/admin/questions');
        }

        $this->questionModel->update((int)$id, ['is_active' => 1]);
        return redirect()->to('/admin/questions/pending')->with('message', 'Question approved');
    }

    public function reject($id)
    {
        if (!$this->isAdmin()) {
            return redirect()->to('/admin/questions');
        }

        $qid = (int)$id;
        $this->choiceModel->where('question_id', $qid)->delete();
        $this->questionModel->delete($qid);
        return redirect()->to('/admin/questions/pending')->with('message', 'Question rejected and removed');
    }

    /**
     * Check if current user is admin
     */
    private function isAdmin()
    {
        $userRoles = $this->session->get('roles');
        return $userRoles && in_array('admin', $userRoles);
    }
}