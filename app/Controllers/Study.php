<?php
namespace App\Controllers;

use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyQuestionModel;
use App\Models\StudyChoiceModel;
use App\Models\NoteModel;
use App\Models\SubscriptionModel;

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
        $data['title'] = 'Study Library';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('client/layout/header', $data)
            . view('client/study/categories', $data)
            . view('client/layout/footer');
    }

    public function subcategories($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/study'));
        $data['title'] = $category['name'];
        $data['category'] = $category;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['subcategories'] = $this->subcategories
            ->where('category_id', (int)$categoryId)
            ->orderBy('name')
            ->findAll();
        // Mark the first subcategory (by name) as free for onboarding
        $firstSub = $this->subcategories
            ->where('category_id', (int)$categoryId)
            ->orderBy('name')
            ->first();
        $data['freeSubcategoryId'] = $firstSub['id'] ?? null;
        return view('client/layout/header', $data)
            . view('client/study/subcategories', $data)
            . view('client/layout/footer');
    }

    public function questions($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('client/study'));
        $category = $this->categories->find((int)$subcategory['category_id']);

        // Allow free access to the first subcategory of this category; others require subscription
        $firstSub = $this->subcategories
            ->where('category_id', (int)$subcategory['category_id'])
            ->orderBy('name')
            ->first();
        $freeSubId = $firstSub['id'] ?? null;
        if ((int)$subcategoryId !== (int)$freeSubId) {
            $userId = session()->get('user_id');
            if (!$userId) {
                return redirect()->to(base_url('subscriptions'))
                    ->with('error', 'Subscribe to access this subcategory. The first one is free.');
            }
            $active = $this->subs->getActiveForUser((int)$userId);
            if (!$active) {
                // Send logged-in users to their portal subscription page
                return redirect()->to(base_url('client/subscription'))
                    ->with('error', 'Your subscription is inactive or missing. Subscribe to continue.');
            }
        }
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
}


