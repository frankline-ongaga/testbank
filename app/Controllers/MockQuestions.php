<?php
namespace App\Controllers;

use App\Models\MockChoiceModel;
use App\Models\MockQuestionModel;
use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use CodeIgniter\Files\File;

class MockQuestions extends BaseController
{
    protected $categories;
    protected $subcategories;
    protected $questions;
    protected $choices;

    public function __construct()
    {
        $this->categories = new StudyCategoryModel();
        $this->subcategories = new StudySubcategoryModel();
        $this->questions = new MockQuestionModel();
        $this->choices = new MockChoiceModel();
    }

    public function clientIndex()
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Mock Tests')) {
            return $redirect;
        }

        $categories = $this->categories->orderBy('name')->findAll();
        if (!empty($categories)) {
            $firstCategory = reset($categories);
            return redirect()->to(base_url('client/mock-questions/' . (int) $firstCategory['id'] . '/subcategories'));
        }

        $data = [
            'title' => 'Mock Tests',
            'categories' => [],
            'subcategories' => [],
            'category' => null,
            'mockCounts' => [],
        ];

        return view('client/layout/header', $data)
            . view('client/mock_questions/subcategories', $data)
            . view('client/layout/footer');
    }

    public function adminIndex()
    {
        $data = [
            'title' => 'Mock Tests',
            'categories' => $this->categories->orderBy('name')->findAll(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/mock_questions/categories', $data)
            . view('admin/layout/footer');
    }

    public function clientSubcategories($categoryId)
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Mock Tests')) {
            return $redirect;
        }

        $category = $this->categories->find((int) $categoryId);
        if (!$category) {
            return redirect()->to(base_url('client/mock-questions'));
        }

        $subcategories = $this->subcategories
            ->where('category_id', (int) $categoryId)
            ->orderBy('name')
            ->findAll();

        $mockCounts = [];
        $subcategoryIds = array_map(static fn ($sub) => (int) $sub['id'], $subcategories);
        if (!empty($subcategoryIds)) {
            $rows = \Config\Database::connect()
                ->table('mock_questions')
                ->select('subcategory_id, COUNT(*) AS total')
                ->whereIn('subcategory_id', $subcategoryIds)
                ->groupBy('subcategory_id')
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {
                $mockCounts[(int) $row['subcategory_id']] = (int) $row['total'];
            }
        }

        $data = [
            'title' => $category['name'],
            'category' => $category,
            'categories' => $this->categories->orderBy('name')->findAll(),
            'subcategories' => $subcategories,
            'mockCounts' => $mockCounts,
        ];

        return view('client/layout/header', $data)
            . view('client/mock_questions/subcategories', $data)
            . view('client/layout/footer');
    }

    public function clientQuestions($subcategoryId)
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Mock Tests')) {
            return $redirect;
        }

        $subcategory = $this->subcategories->find((int) $subcategoryId);
        if (!$subcategory) {
            return redirect()->to(base_url('client/mock-questions'));
        }

        $category = $this->categories->find((int) $subcategory['category_id']);
        $questions = $this->questions
            ->where('subcategory_id', (int) $subcategoryId)
            ->orderBy('id', 'DESC')
            ->findAll();

        $choicesByQuestion = [];
        $questionIds = array_map(static fn ($question) => (int) $question['id'], $questions);
        if (!empty($questionIds)) {
            $choices = $this->choices
                ->whereIn('question_id', $questionIds)
                ->orderBy('label')
                ->findAll();

            foreach ($choices as $choice) {
                $choicesByQuestion[(int) $choice['question_id']][] = $choice;
            }
        }

        $data = [
            'title' => $subcategory['name'] . ' Mock Tests',
            'category' => $category,
            'subcategory' => $subcategory,
            'questions' => $questions,
            'choicesByQuestion' => $choicesByQuestion,
        ];

        return view('client/layout/header', $data)
            . view('client/mock_questions/questions', $data)
            . view('client/layout/footer');
    }

    public function clientImage($questionId)
    {
        if ($redirect = $this->requireProductAccess('nclex', 'Mock Tests')) {
            return $redirect;
        }

        return $this->serveImage((int) $questionId);
    }

    public function adminQuestions($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int) $subcategoryId);
        if (!$subcategory) {
            return redirect()->to(base_url('admin/study'));
        }

        $category = $this->categories->find((int) $subcategory['category_id']);
        $data = [
            'title' => 'Mock Tests - ' . $subcategory['name'],
            'category' => $category,
            'subcategory' => $subcategory,
            'questions' => $this->questions->where('subcategory_id', (int) $subcategoryId)->orderBy('id', 'DESC')->findAll(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/mock_questions/index', $data)
            . view('admin/layout/footer');
    }

    public function adminCreate($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int) $subcategoryId);
        if (!$subcategory) {
            return redirect()->to(base_url('admin/study'));
        }

        $data = [
            'title' => 'Add Mock Test - ' . $subcategory['name'],
            'subcategory' => $subcategory,
        ];

        return view('admin/layout/header', $data)
            . view('admin/mock_questions/form', $data)
            . view('admin/layout/footer');
    }

    public function adminStore($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int) $subcategoryId);
        if (!$subcategory) {
            return redirect()->to(base_url('admin/study'));
        }

        $imagePath = $this->storeImageFromRequest();
        if ($imagePath === false) {
            return redirect()->back()->withInput()->with('error', 'Please upload a valid JPG, PNG, GIF, or WEBP image under 5MB.');
        }

        $questionId = $this->questions->insert([
            'subcategory_id' => (int) $subcategoryId,
            'stem' => $this->request->getPost('stem'),
            'image_path' => $imagePath,
            'rationale' => $this->request->getPost('rationale'),
            'created_by' => (int) session()->get('user_id'),
        ], true);

        $this->replaceChoices((int) $questionId);

        return redirect()->to(base_url('admin/mock-questions/subcategory/' . (int) $subcategoryId . '/questions'))
            ->with('success', 'Mock question created.');
    }

    public function adminEdit($questionId)
    {
        $question = $this->questions->find((int) $questionId);
        if (!$question) {
            return redirect()->to(base_url('admin/study'));
        }

        $subcategory = $this->subcategories->find((int) $question['subcategory_id']);
        $data = [
            'title' => 'Edit Mock Test - ' . ($subcategory['name'] ?? 'Mock Tests'),
            'subcategory' => $subcategory,
            'question' => $question,
            'choices' => $this->choices->where('question_id', (int) $questionId)->orderBy('label')->findAll(),
        ];

        return view('admin/layout/header', $data)
            . view('admin/mock_questions/edit', $data)
            . view('admin/layout/footer');
    }

    public function adminUpdate($questionId)
    {
        $question = $this->questions->find((int) $questionId);
        if (!$question) {
            return redirect()->to(base_url('admin/study'));
        }

        $update = [
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
        ];

        $imagePath = $this->storeImageFromRequest();
        if ($imagePath === false) {
            return redirect()->back()->withInput()->with('error', 'Please upload a valid JPG, PNG, GIF, or WEBP image under 5MB.');
        }

        $removeImage = (int) ($this->request->getPost('remove_image') ?? 0) === 1;
        if (is_string($imagePath)) {
            $this->deleteImage($question);
            $update['image_path'] = $imagePath;
        } elseif ($removeImage) {
            $this->deleteImage($question);
            $update['image_path'] = null;
        }

        $this->questions->update((int) $questionId, $update);
        $this->replaceChoices((int) $questionId);

        return redirect()->to(base_url('admin/mock-questions/subcategory/' . (int) $question['subcategory_id'] . '/questions'))
            ->with('success', 'Mock question updated.');
    }

    public function adminDelete($questionId)
    {
        $question = $this->questions->find((int) $questionId);
        if (!$question) {
            return redirect()->to(base_url('admin/study'));
        }

        $subcategoryId = (int) $question['subcategory_id'];
        $this->choices->where('question_id', (int) $questionId)->delete();
        $this->deleteImage($question);
        $this->questions->delete((int) $questionId);

        return redirect()->to(base_url('admin/mock-questions/subcategory/' . $subcategoryId . '/questions'))
            ->with('success', 'Mock question deleted.');
    }

    public function adminImage($questionId)
    {
        return $this->serveImage((int) $questionId);
    }

    protected function replaceChoices(int $questionId): void
    {
        $this->choices->where('question_id', $questionId)->delete();

        $labels = $this->request->getPost('labels') ?? [];
        $contents = $this->request->getPost('contents') ?? [];
        $correct = $this->request->getPost('correct') ?? [];
        $explanations = $this->request->getPost('explanations') ?? [];

        foreach ($contents as $idx => $content) {
            if (trim((string) $content) === '') {
                continue;
            }

            $this->choices->insert([
                'question_id' => $questionId,
                'label' => $labels[$idx] ?? '',
                'content' => $content,
                'is_correct' => isset($correct[$idx]) ? 1 : 0,
                'explanation' => $explanations[$idx] ?? null,
            ]);
        }
    }

    protected function storeImageFromRequest()
    {
        $image = $this->request->getFile('image');
        if (!$image || $image->getError() === UPLOAD_ERR_NO_FILE) {
            return null;
        }

        if (!$image->isValid() || $image->hasMoved()) {
            return false;
        }

        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower((string) $image->getClientExtension());
        if (!in_array($ext, $allowedExt, true) || (int) $image->getSize() > 5 * 1024 * 1024) {
            return false;
        }

        $targetDir = WRITEPATH . 'uploads/mock_questions';
        if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
            return false;
        }

        $newName = $image->getRandomName();
        $image->move($targetDir, $newName);

        return 'writable/uploads/mock_questions/' . $newName;
    }

    protected function deleteImage(array $question): void
    {
        $existing = (string) ($question['image_path'] ?? '');
        if ($existing === '' || strpos($existing, 'writable/uploads/mock_questions/') !== 0) {
            return;
        }

        $path = WRITEPATH . 'uploads/mock_questions/' . basename($existing);
        if (is_file($path)) {
            @unlink($path);
        }
    }

    protected function serveImage(int $questionId)
    {
        $question = $this->questions->find($questionId);
        if (!$question || empty($question['image_path'])) {
            return $this->response->setStatusCode(404);
        }

        $existing = (string) $question['image_path'];
        if (strpos($existing, 'writable/uploads/mock_questions/') !== 0) {
            return $this->response->setStatusCode(404);
        }

        $filename = basename($existing);
        $path = WRITEPATH . 'uploads/mock_questions/' . $filename;
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = 'application/octet-stream';
        try {
            $mime = (new File($path))->getMimeType() ?: $mime;
        } catch (\Throwable $e) {
            // Keep the fallback mime.
        }

        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
            ->setBody((string) file_get_contents($path));
    }
}
