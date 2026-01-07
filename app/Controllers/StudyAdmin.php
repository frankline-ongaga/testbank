<?php
namespace App\Controllers;

use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyQuestionModel;
use App\Models\StudyChoiceModel;
use App\Models\StudyQuestionCategoryModel;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Response;

class StudyAdmin extends BaseController
{
    protected $categories;
    protected $subcategories;
    protected $questions;
    protected $choices;
    protected $questionCategories;

    public function __construct()
    {
        $this->categories = new StudyCategoryModel();
        $this->subcategories = new StudySubcategoryModel();
        $this->questions = new StudyQuestionModel();
        $this->choices = new StudyChoiceModel();
        $this->questionCategories = new StudyQuestionCategoryModel();
    }

    public function index()
    {
        $data['title'] = 'Study Categories';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/categories_index', $data)
            . view('admin/layout/footer');
    }

    public function createCategory()
    {
        $data['title'] = 'Add Study Category';
        return view('admin/layout/header', $data)
            . view('admin/study/category_form', $data)
            . view('admin/layout/footer');
    }

    public function storeCategory()
    {
        $name = trim($this->request->getPost('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $this->categories->insert(['name' => $name, 'slug' => $slug, 'description' => $this->request->getPost('description')]);
        return redirect()->to(base_url('admin/study')); 
    }

    public function subcategories($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study'));
        $data['title'] = 'Subcategories - ' . $category['name'];
        $data['category'] = $category;
        $data['subcategories'] = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/subcategories_index', $data)
            . view('admin/layout/footer');
    }

    public function createSubcategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study'));
        $data['title'] = 'Add Subcategory - ' . $category['name'];
        $data['category'] = $category;
        return view('admin/layout/header', $data)
            . view('admin/study/subcategory_form', $data)
            . view('admin/layout/footer');
    }

    public function storeSubcategory($categoryId)
    {
        $name = trim($this->request->getPost('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $this->subcategories->insert([
            'category_id' => (int)$categoryId,
            'name' => $name,
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to(base_url('admin/study/'.$categoryId.'/subcategories'));
    }

    public function editSubcategory($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Edit Subcategory - ' . $category['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        return view('admin/layout/header', $data)
            . view('admin/study/subcategory_edit', $data)
            . view('admin/layout/footer');
    }

    public function updateSubcategory($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $name = trim($this->request->getPost('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $this->subcategories->update((int)$subcategoryId, [
            'name' => $name,
            'slug' => $slug,
            'description' => $this->request->getPost('description'),
        ]);
        return redirect()->to(base_url('admin/study/'.$subcategory['category_id'].'/subcategories'));
    }

    public function deleteSubcategory($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if ($subcategory) {
            // Optionally: also delete child questions and choices
            $questionIds = array_column($this->questions->where('subcategory_id', (int)$subcategoryId)->findAll(), 'id');
            if (!empty($questionIds)) {
                $this->choices->whereIn('question_id', $questionIds)->delete();
                $this->questions->whereIn('id', $questionIds)->delete();
            }
            $this->subcategories->delete((int)$subcategoryId);
        }
        return redirect()->to(base_url('admin/study/'.$subcategory['category_id'].'/subcategories'));
    }

    // --- Custom Question Categories (per subcategory) ---
    public function listQuestionCategories($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Question Categories - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['qcategories'] = $this->questionCategories->where('subcategory_id', (int)$subcategoryId)->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/qcategories_index', $data)
            . view('admin/layout/footer');
    }

    public function createQuestionCategory($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Add Question Category - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        return view('admin/layout/header', $data)
            . view('admin/study/qcategory_form', $data)
            . view('admin/layout/footer');
    }

    public function storeQuestionCategory($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $name = trim($this->request->getPost('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $this->questionCategories->insert([
            'subcategory_id' => (int)$subcategoryId,
            'name' => $name,
            'slug' => $slug,
        ]);
        return redirect()->to(base_url('admin/study/subcategory/'.$subcategoryId.'/qcategories'));
    }

    public function editQuestionCategory($qcategoryId)
    {
        $qc = $this->questionCategories->find((int)$qcategoryId);
        if (!$qc) return redirect()->to(base_url('admin/study'));
        $subcategory = $this->subcategories->find((int)$qc['subcategory_id']);
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Edit Question Category - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['qcategory'] = $qc;
        return view('admin/layout/header', $data)
            . view('admin/study/qcategory_edit', $data)
            . view('admin/layout/footer');
    }

    public function updateQuestionCategory($qcategoryId)
    {
        $qc = $this->questionCategories->find((int)$qcategoryId);
        if (!$qc) return redirect()->to(base_url('admin/study'));
        $name = trim($this->request->getPost('name'));
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        $this->questionCategories->update((int)$qcategoryId, [ 'name' => $name, 'slug' => $slug ]);
        return redirect()->to(base_url('admin/study/subcategory/'.$qc['subcategory_id'].'/qcategories'));
    }

    public function deleteQuestionCategory($qcategoryId)
    {
        $qc = $this->questionCategories->find((int)$qcategoryId);
        if ($qc) {
            // Null out category reference on questions in this subcategory
            $this->questions->where('study_question_category_id', (int)$qcategoryId)->set(['study_question_category_id' => null])->update();
            $this->questionCategories->delete((int)$qcategoryId);
            return redirect()->to(base_url('admin/study/subcategory/'.$qc['subcategory_id'].'/qcategories'));
        }
        return redirect()->to(base_url('admin/study'));
    }

    public function questions($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Study Questions - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['questions'] = $this->questions->where('subcategory_id', (int)$subcategoryId)->orderBy('id','DESC')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/questions_index', $data)
            . view('admin/layout/footer');
    }

    public function questionImage($questionId)
    {
        $q = $this->questions->find((int)$questionId);
        if (!$q || empty($q['image_path'])) {
            return $this->response->setStatusCode(404);
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

    public function createQuestion($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $data['title'] = 'Add Study Question - ' . $subcategory['name'];
        $data['subcategory'] = $subcategory;
        $data['question_categories'] = $this->questionCategories->where('subcategory_id', (int)$subcategoryId)->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/question_form', $data)
            . view('admin/layout/footer');
    }

    public function storeQuestion($subcategoryId)
    {
        $imagePath = null;
        $image = $this->request->getFile('image');
        if ($image && $image->getError() !== UPLOAD_ERR_NO_FILE) {
            if (!$image->isValid() || $image->hasMoved()) {
                return redirect()->back()->withInput()->with('error', 'Please upload a valid image file.');
            }

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower((string)$image->getClientExtension());
            if (!in_array($ext, $allowedExt, true)) {
                return redirect()->back()->withInput()->with('error', 'Image must be JPG, PNG, GIF, or WEBP.');
            }

            if ((int)$image->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Image is too large. Max 5MB.');
            }

            $targetDir = WRITEPATH . 'uploads/study_questions';
            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                return redirect()->back()->withInput()->with('error', 'Could not create upload directory.');
            }

            $newName = $image->getRandomName();
            $image->move($targetDir, $newName);
            $imagePath = 'writable/uploads/study_questions/' . $newName;
        }

        $questionId = $this->questions->insert([
            'subcategory_id' => (int)$subcategoryId,
            'stem' => $this->request->getPost('stem'),
            'image_path' => $imagePath,
            'rationale' => $this->request->getPost('rationale'),
            'created_by' => (int)session()->get('user_id'),
        ], true);

        $labels = $this->request->getPost('labels') ?? [];
        $contents = $this->request->getPost('contents') ?? [];
        $correct = $this->request->getPost('correct') ?? [];
        $explanations = $this->request->getPost('explanations') ?? [];
        $studyQuestionCategoryId = (int)($this->request->getPost('study_question_category_id') ?? 0);

        foreach ($contents as $idx => $content) {
            if (trim((string)$content) === '') continue;
            $this->choices->insert([
                'question_id' => $questionId,
                'label' => $labels[$idx] ?? '',
                'content' => $content,
                'is_correct' => isset($correct[$idx]) ? 1 : 0,
                'explanation' => $explanations[$idx] ?? null,
            ]);
        }

        if ($studyQuestionCategoryId > 0) {
            $this->questions->update($questionId, [
                'study_question_category_id' => $studyQuestionCategoryId,
            ]);
        }

        return redirect()->to(base_url('admin/study/subcategory/'.$subcategoryId.'/questions'));
    }

    public function editQuestion($questionId)
    {
        $q = $this->questions->find((int)$questionId);
        if (!$q) return redirect()->to(base_url('admin/study'));
        $subcategory = $this->subcategories->find((int)$q['subcategory_id']);
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Edit Study Question - ' . $subcategory['name'];
        $data['subcategory'] = $subcategory;
        $data['category'] = $category;
        $data['question'] = $q;
        $data['question_categories'] = $this->questionCategories->where('subcategory_id', (int)$subcategory['id'])->orderBy('name')->findAll();
        $data['choices'] = $this->choices->where('question_id', (int)$questionId)->orderBy('label')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study/question_edit', $data)
            . view('admin/layout/footer');
    }

    public function updateQuestion($questionId)
    {
        $q = $this->questions->find((int)$questionId);
        if (!$q) return redirect()->to(base_url('admin/study'));

        $studyQuestionCategoryId = (int)($this->request->getPost('study_question_category_id') ?? 0);
        $update = [
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
            'study_question_category_id' => $studyQuestionCategoryId ?: null,
        ];

        $image = $this->request->getFile('image');
        $hasNewImage = $image && $image->getError() !== UPLOAD_ERR_NO_FILE;
        $removeImage = (int)($this->request->getPost('remove_image') ?? 0) === 1;

        $deleteExisting = function () use ($q) {
            $existing = (string)($q['image_path'] ?? '');
            if ($existing !== '' && strpos($existing, 'writable/uploads/study_questions/') === 0) {
                $filename = basename($existing);
                $path = WRITEPATH . 'uploads/study_questions/' . $filename;
                if (is_file($path)) {
                    @unlink($path);
                }
            }
        };

        if ($hasNewImage) {
            if (!$image->isValid() || $image->hasMoved()) {
                return redirect()->back()->withInput()->with('error', 'Please upload a valid image file.');
            }

            $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower((string)$image->getClientExtension());
            if (!in_array($ext, $allowedExt, true)) {
                return redirect()->back()->withInput()->with('error', 'Image must be JPG, PNG, GIF, or WEBP.');
            }

            if ((int)$image->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'Image is too large. Max 5MB.');
            }

            $targetDir = WRITEPATH . 'uploads/study_questions';
            if (!is_dir($targetDir) && !mkdir($targetDir, 0755, true) && !is_dir($targetDir)) {
                return redirect()->back()->withInput()->with('error', 'Could not create upload directory.');
            }

            $newName = $image->getRandomName();
            $image->move($targetDir, $newName);
            $deleteExisting();
            $update['image_path'] = 'writable/uploads/study_questions/' . $newName;
        } elseif ($removeImage) {
            $deleteExisting();
            $update['image_path'] = null;
        }

        $this->questions->update((int)$questionId, $update);

        // Replace choices
        $this->choices->where('question_id', (int)$questionId)->delete();
        $labels = $this->request->getPost('labels') ?? [];
        $contents = $this->request->getPost('contents') ?? [];
        $correct = $this->request->getPost('correct') ?? [];
        $explanations = $this->request->getPost('explanations') ?? [];
        foreach ($contents as $idx => $content) {
            if (trim((string)$content) === '') continue;
            $this->choices->insert([
                'question_id' => (int)$questionId,
                'label' => $labels[$idx] ?? '',
                'content' => $content,
                'is_correct' => isset($correct[$idx]) ? 1 : 0,
                'explanation' => $explanations[$idx] ?? null,
            ]);
        }

        return redirect()->to(base_url('admin/study/subcategory/'.$q['subcategory_id'].'/questions'));
    }

    public function deleteQuestion($questionId)
    {
        $q = $this->questions->find((int)$questionId);
        if ($q) {
            $this->choices->where('question_id', (int)$questionId)->delete();
            $existing = (string)($q['image_path'] ?? '');
            if ($existing !== '' && strpos($existing, 'writable/uploads/study_questions/') === 0) {
                $filename = basename($existing);
                $path = WRITEPATH . 'uploads/study_questions/' . $filename;
                if (is_file($path)) {
                    @unlink($path);
                }
            }
            $this->questions->delete((int)$questionId);
            return redirect()->to(base_url('admin/study/subcategory/'.$q['subcategory_id'].'/questions'));
        }
        return redirect()->to(base_url('admin/study'));
    }

    public function downloadQuestionTemplate($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));

        $filename = 'study-questions-template-subcat-' . (int)$subcategoryId . '.csv';
        $fh = fopen('php://temp', 'r+');
        $headers = [
            'stem',
            'rationale',
            'topic',
            'choice_a',
            'choice_a_correct',
            'choice_a_explanation',
            'choice_b',
            'choice_b_correct',
            'choice_b_explanation',
            'choice_c',
            'choice_c_correct',
            'choice_c_explanation',
            'choice_d',
            'choice_d_correct',
            'choice_d_explanation',
        ];
        fputcsv($fh, $headers);
        fputcsv($fh, [
            'What is the normal range for adult heart rate?',
            'Reference range question for vital signs.',
            'Vitals',
            '60-100 bpm',
            1,
            'Normal resting range',
            '40-50 bpm',
            0,
            'Too low for normal adult at rest',
            '90-120 bpm',
            0,
            'Upper end exceeds typical resting range',
            '30-40 bpm',
            0,
            'Marked bradycardia',
        ]);
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);
        return $this->response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="'.$filename.'"')
            ->setBody($csv);
    }

    public function importQuestions($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study'));
        $file = $this->request->getFile('questions_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please upload a valid CSV file.');
        }

        $ext = strtolower($file->getClientExtension());
        if (!in_array($ext, ['csv'])) {
            return redirect()->back()->with('error', 'Only CSV files are supported. Please save your Excel as CSV.');
        }

        $path = $file->getTempName();
        $handle = fopen($path, 'r');
        if (!$handle) {
            return redirect()->back()->with('error', 'Could not read uploaded file.');
        }

        $header = fgetcsv($handle);
        $normalizedHeader = array_map(function ($h) {
            return strtolower(trim((string)$h));
        }, $header ?: []);

        $requiredCols = ['stem', 'choice_a', 'choice_b'];
        foreach ($requiredCols as $col) {
            if (!in_array($col, $normalizedHeader, true)) {
                fclose($handle);
                return redirect()->back()->with('error', 'Missing required column: '.$col);
            }
        }

        $colIndex = array_flip($normalizedHeader);
        $created = 0;
        $skipped = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $get = function ($key) use ($colIndex, $row) {
                return array_key_exists($key, $colIndex) ? ($row[$colIndex[$key]] ?? '') : '';
            };

            $stem = trim((string)$get('stem'));
            if ($stem === '') { $skipped++; continue; }
            $rationale = trim((string)$get('rationale'));
            $topicName = trim((string)$get('topic'));

            $questionId = $this->questions->insert([
                'subcategory_id' => (int)$subcategoryId,
                'stem' => $stem,
                'rationale' => $rationale,
                'created_by' => (int)session()->get('user_id'),
            ], true);

            $qcategoryId = null;
            if ($topicName !== '') {
                $existing = $this->questionCategories
                    ->where('subcategory_id', (int)$subcategoryId)
                    ->where('name', $topicName)
                    ->first();
                if ($existing) {
                    $qcategoryId = (int)$existing['id'];
                } else {
                    $qcategoryId = (int)$this->questionCategories->insert([
                        'subcategory_id' => (int)$subcategoryId,
                        'name' => $topicName,
                        'slug' => strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $topicName))),
                    ], true);
                }
                $this->questions->update($questionId, ['study_question_category_id' => $qcategoryId]);
            }

            $letters = ['a','b','c','d'];
            $anyChoice = false;
            foreach ($letters as $idx => $letter) {
                $content = trim((string)$get('choice_'.$letter));
                if ($content === '') continue;
                $anyChoice = true;
                $isCorrect = in_array(strtolower((string)$get('choice_'.$letter.'_correct')), ['1','true','yes','y'], true) ? 1 : 0;
                $explanation = trim((string)$get('choice_'.$letter.'_explanation'));
                $this->choices->insert([
                    'question_id' => $questionId,
                    'label' => strtoupper($letter),
                    'content' => $content,
                    'is_correct' => $isCorrect,
                    'explanation' => $explanation ?: null,
                ]);
            }

            if (!$anyChoice) {
                // Remove question with no choices
                $this->questions->delete($questionId);
                $skipped++;
                continue;
            }

            $created++;
        }
        fclose($handle);

        $msg = $created . ' questions imported.';
        if ($skipped > 0) $msg .= ' Skipped '.$skipped.' row(s) with no question text or choices.';
        return redirect()->to(base_url('admin/study/subcategory/'.$subcategoryId.'/questions'))
            ->with('success', $msg);
    }
}
