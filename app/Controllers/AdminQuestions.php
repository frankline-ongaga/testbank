<?php

namespace App\Controllers;

use App\Models\QuestionModel;

class AdminQuestions extends BaseController
{
    protected $questionModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
    }

    public function index()
    {
        $pending = $this->questionModel->where('is_active', 0)->orderBy('id', 'DESC')->findAll(50);
        $data = ['title' => 'Pending Questions', 'questions' => $pending];
        return view('admin/questions_pending', $data);
    }

    public function approve($id)
    {
        $this->questionModel->update((int)$id, ['is_active' => 1]);
        return redirect()->back()->with('message', 'Question approved');
    }

    public function deactivate($id)
    {
        $this->questionModel->update((int)$id, ['is_active' => 0]);
        return redirect()->back()->with('message', 'Question deactivated');
    }
}


