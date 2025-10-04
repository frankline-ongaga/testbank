<?php
namespace App\Controllers;

use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyQuestionModel;
use App\Models\StudyChoiceModel;
use App\Models\StudyQuestionCategoryModel;

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
        $questionId = $this->questions->insert([
            'subcategory_id' => (int)$subcategoryId,
            'stem' => $this->request->getPost('stem'),
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
        $this->questions->update((int)$questionId, [
            'stem' => $this->request->getPost('stem'),
            'rationale' => $this->request->getPost('rationale'),
            'study_question_category_id' => $studyQuestionCategoryId ?: null,
        ]);

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
            $this->questions->delete((int)$questionId);
            return redirect()->to(base_url('admin/study/subcategory/'.$q['subcategory_id'].'/questions'));
        }
        return redirect()->to(base_url('admin/study'));
    }
}


