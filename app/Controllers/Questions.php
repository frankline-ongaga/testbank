<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\ChoiceModel;
use App\Models\TaxonomyModel;
use CodeIgniter\Files\File;

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

        $mediaPath = null;
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$image->isValid() || $image->hasMoved()) {
                return redirect()->back()->withInput()->with('errors', ['Please upload a valid image file.']);
            }

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower((string)$image->getClientExtension());
            if (!in_array($ext, $allowedExt, true)) {
                return redirect()->back()->withInput()->with('errors', ['Image must be JPG, PNG, GIF, or WEBP.']);
            }

            if ((int)$image->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('errors', ['Image is too large. Max 5MB.']);
            }

            $targetDir = WRITEPATH . 'uploads/questions';
            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                return redirect()->back()->withInput()->with('errors', ['Could not create upload directory.']);
            }

            $newName = $image->getRandomName();
            $image->move($targetDir, $newName);
            $mediaPath = 'writable/uploads/questions/' . $newName;
        }

        $questionId = $this->questionModel->insert([
            'author_id' => (int) ($this->session->get('user_id') ?: 0),
            'type' => $this->request->getPost('type'),
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
            'media_path' => $mediaPath,
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

        $update = [
            'type' => $this->request->getPost('type'),
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
        ];

        $image = $this->request->getFile('image');
        $hasNewImage = $image && $image->getError() !== UPLOAD_ERR_NO_FILE;
        $removeImage = (int)($this->request->getPost('remove_image') ?? 0) === 1;

        $deleteExisting = function () use ($question) {
            $existing = (string)($question['media_path'] ?? '');
            if ($existing !== '' && strpos($existing, 'writable/uploads/questions/') === 0) {
                $filename = basename($existing);
                $path = WRITEPATH . 'uploads/questions/' . $filename;
                if (is_file($path)) {
                    @unlink($path);
                }
            }
        };

        if ($hasNewImage) {
            if (!$image->isValid() || $image->hasMoved()) {
                return redirect()->back()->withInput()->with('errors', ['Please upload a valid image file.']);
            }

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower((string)$image->getClientExtension());
            if (!in_array($ext, $allowedExt, true)) {
                return redirect()->back()->withInput()->with('errors', ['Image must be JPG, PNG, GIF, or WEBP.']);
            }

            if ((int)$image->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('errors', ['Image is too large. Max 5MB.']);
            }

            $targetDir = WRITEPATH . 'uploads/questions';
            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                return redirect()->back()->withInput()->with('errors', ['Could not create upload directory.']);
            }

            $newName = $image->getRandomName();
            $image->move($targetDir, $newName);
            $deleteExisting();
            $update['media_path'] = 'writable/uploads/questions/' . $newName;
        } elseif ($removeImage) {
            $deleteExisting();
            $update['media_path'] = null;
        }

        // Update question
        $this->questionModel->update($id, $update);

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
        $existing = (string)($question['media_path'] ?? '');
        if ($existing !== '' && strpos($existing, 'writable/uploads/questions/') === 0) {
            $filename = basename($existing);
            $path = WRITEPATH . 'uploads/questions/' . $filename;
            if (is_file($path)) {
                @unlink($path);
            }
        }
        $this->choiceModel->where('question_id', $id)->delete();
        // Remove taxonomy links
        $this->db->table('question_terms')->where('question_id', $id)->delete();
        $this->questionModel->delete($id);
        return redirect()->to('/admin/questions')->with('message', 'Question deleted');
    }

    public function media($id)
    {
        $question = $this->questionModel->find((int)$id);
        if (!$question || empty($question['media_path'])) {
            return $this->response->setStatusCode(404);
        }

        $existing = (string)$question['media_path'];
        if (strpos($existing, 'writable/uploads/questions/') !== 0) {
            return $this->response->setStatusCode(404);
        }

        $filename = basename($existing);
        $path = WRITEPATH . 'uploads/questions/' . $filename;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = 'application/octet-stream';
        try {
            $mime = (new File($path))->getMimeType() ?: $mime;
        } catch (\Throwable $e) {
            // ignore
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody((string) file_get_contents($path));
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
