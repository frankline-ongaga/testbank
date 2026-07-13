<?php
namespace App\Controllers;

use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyQuestionModel;
use App\Models\StudyChoiceModel;
use App\Models\NoteModel;
use App\Models\SubscriptionModel;
use CodeIgniter\Files\File;

class Study extends BaseController
{
    protected $categories;
    protected $subcategories;
    protected $questions;
    protected $choices;
    protected $notes;
    protected $subs;

    public function __construct()
    {
        helper(['text']);
        $this->categories = new StudyCategoryModel();
        $this->subcategories = new StudySubcategoryModel();
        $this->questions = new StudyQuestionModel();
        $this->choices = new StudyChoiceModel();
        $this->notes = new NoteModel();
        $this->subs = new SubscriptionModel();
    }

    public function index()
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Study Questions')) {
            return $redirect;
        }

        $data['title'] = 'Study Library';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('client/layout/header', $data)
            . view('client/study/categories', $data)
            . view('client/layout/footer');
    }

    public function subcategories($categoryId)
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Study Questions')) {
            return $redirect;
        }

        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/study'));
        $data['title'] = $category['name'];
        $data['category'] = $category;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $subcategories = $this->subcategories
            ->where('category_id', (int)$categoryId)
            ->orderBy('name')
            ->findAll();
        $data['subcategories'] = $subcategories;

        $subcategoryIds = array_map(static fn ($sub) => (int) $sub['id'], $subcategories);
        $data['questionCounts'] = [];
        $data['noteCounts'] = [];

        if (!empty($subcategoryIds)) {
            $db = \Config\Database::connect();

            $questionRows = $db->table('study_questions')
                ->select('subcategory_id, COUNT(*) AS total')
                ->whereIn('subcategory_id', $subcategoryIds)
                ->groupBy('subcategory_id')
                ->get()
                ->getResultArray();

            foreach ($questionRows as $row) {
                $data['questionCounts'][(int) $row['subcategory_id']] = (int) $row['total'];
            }

            $noteRows = $db->table('notes')
                ->select('subcategory_id, COUNT(*) AS total')
                ->whereIn('subcategory_id', $subcategoryIds)
                ->where('status', 'published')
                ->groupBy('subcategory_id')
                ->get()
                ->getResultArray();

            foreach ($noteRows as $row) {
                $data['noteCounts'][(int) $row['subcategory_id']] = (int) $row['total'];
            }
        }

        $userId = (int) (session()->get('user_id') ?? 0);
        $data['hasStudyAccess'] = $userId > 0 && $this->hasActiveProductAccess($userId, 'nclex');

        return view('client/layout/header', $data)
            . view('client/study/subcategories', $data)
            . view('client/layout/footer');
    }

    public function questions($subcategoryId)
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Study Questions')) {
            return $redirect;
        }

        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('client/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);

        $data['title'] = $subcategory['name'] . ' Questions';
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['questions'] = $this->questions->where('subcategory_id', (int)$subcategoryId)->orderBy('id','DESC')->findAll();
        // group choices by question id
        $choices = $this->choices->whereIn('question_id', array_column($data['questions'], 'id') ?: [0])->findAll();
        $choicesByQ = [];
        foreach ($choices as $c) { $choicesByQ[$c['question_id']][] = $c; }
        $data['choicesByQ'] = $choicesByQ;
        // published notes for this subcategory
        $data['notes'] = $this->notes->getNotesWithCategory('published', (int)$subcategoryId);
        return view('client/layout/header', $data)
            . view('client/study/questions', $data)
            . view('client/layout/footer');
    }

    public function questionImage($questionId)
    {
        $q = $this->questions->find((int)$questionId);
        if (!$q || empty($q['image_path'])) {
            return $this->response->setStatusCode(404);
        }

        $subcategoryId = (int)($q['subcategory_id'] ?? 0);
        $subcategory = $this->subcategories->find($subcategoryId);
        if (!$subcategory) {
            return $this->response->setStatusCode(404);
        }

        $userId = (int)(session()->get('user_id') ?? 0);
        if (!$userId || !$this->hasActiveProductAccess($userId, 'nclex')) {
            return $this->response->setStatusCode(403);
        }

        $existing = (string)$q['image_path'];
        if (strpos($existing, 'writable/uploads/study_questions/') !== 0) {
            return $this->response->setStatusCode(404);
        }

        $filename = basename($existing);
        $path = WRITEPATH . 'uploads/study_questions/' . $filename;
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
}
