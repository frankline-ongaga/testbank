<?php

namespace App\Controllers;

use App\Models\NoteModel;
use App\Models\NoteCategoryModel;
use App\Models\NoteAttachmentModel;
use App\Models\StudySubcategoryModel;

class Notes extends BaseController
{
    protected $noteModel;
    protected $categoryModel;
    protected $attachmentModel;
    protected $session;
    protected $studySubcategoryModel;
    protected $db;

    public function __construct()
    {
        helper(['form', 'url', 'text']);
        $this->noteModel = new NoteModel();
        $this->categoryModel = new NoteCategoryModel();
        $this->attachmentModel = new NoteAttachmentModel();
        $this->session = session();
        $this->studySubcategoryModel = new StudySubcategoryModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $currentRole = $this->session->get('current_role');
        $subcategoryId = (int)($this->request->getGet('subcategory_id') ?? 0);

        if ($currentRole === 'admin' || $currentRole === 'instructor') {
            $notes = $this->noteModel->getNotesWithCategory(null, $subcategoryId ?: null);
        } else {
            $notes = $this->noteModel->getNotesWithCategory('published', $subcategoryId ?: null);
        }

        $data = [
            'title' => 'Study Notes',
            'notes' => $notes,
            // Replace category sidebar with study subcategories list
            'subcategories' => $this->studySubcategoryModel->orderBy('name')->findAll(),
            'subcategory_id' => $subcategoryId ?: null,
        ];

        if ($currentRole === 'admin') {
            return view('admin/layout/header', $data)
                . view('admin/notes/index', $data)
                . view('admin/layout/footer');
        } elseif ($currentRole === 'instructor') {
            return view('instructor/layout/header', $data)
                . view('instructor/notes/index', $data)
                . view('instructor/layout/footer');
        } else {
            return view('client/layout/header', $data)
                . view('client/notes/index', $data)
                . view('client/layout/footer');
        }
    }

    public function create()
    {
        $currentRole = $this->session->get('current_role');
        $subcategoryId = (int)($this->request->getGet('subcategory_id') ?? 0);
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/notes')->with('error', 'Access denied');
        }

        $data = [
            'title' => 'Create Study Note',
            'categories' => $this->categoryModel->getActiveCategories(),
            'subcategory_id' => $subcategoryId ?: null,
            'subcategory' => $subcategoryId ? $this->studySubcategoryModel->find($subcategoryId) : null,
        ];

        if ($currentRole === 'admin') {
            return view('admin/layout/header', $data)
                . view('admin/notes/create', $data)
                . view('admin/layout/footer');
        } else {
            return view('instructor/layout/header', $data)
                . view('instructor/notes/create', $data)
                . view('instructor/layout/footer');
        }
    }

    public function store()
    {
        $currentRole = $this->session->get('current_role');
        $subcategoryId = (int)($this->request->getPost('subcategory_id') ?? 0);
        
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/notes')->with('error', 'Access denied');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'content' => 'required|min_length[10]'
        ];

        // Conditionally validate attachments only if any file was provided
        $allFiles = $this->request->getFiles();
        $hasUploads = isset($allFiles['attachments']) && is_array($allFiles['attachments'])
            ? (bool) array_filter($allFiles['attachments'], function($f) { return $f && $f->getName(); })
            : false;
        if ($hasUploads) {
            $rules['attachments.*'] = 'max_size[attachments,10240]|ext_in[attachments,pdf,doc,docx,xls,xlsx,ppt,pptx,zip]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Start transaction
        $this->db->transStart();

        try {
            // Determine category (auto-detect default when none is provided)
            $categoryId = (int)($this->request->getPost('category_id') ?? 0);
            if (!$categoryId) {
                $general = $this->categoryModel->where('slug', 'general')->first();
                if ($general) {
                    $categoryId = (int)$general['id'];
                } else {
                    $categoryId = (int)$this->categoryModel->insert([
                        'name' => 'General',
                        'slug' => 'general',
                        'description' => 'Default category',
                        'order' => 0,
                    ], true);
                }
            }

            // Create note
            $noteId = $this->noteModel->insert([
                'author_id' => $this->session->get('user_id'),
                'category_id' => $categoryId,
                'subcategory_id' => $subcategoryId ?: null,
                'title' => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'status' => $currentRole === 'admin' ? 'published' : 'draft',
                'is_featured' => $this->request->getPost('is_featured') ? 1 : 0
            ]);

            // Handle file uploads
            $files = $this->request->getFiles();
            if ($files && isset($files['attachments']) && is_array($files['attachments'])) {
                foreach ($files['attachments'] as $file) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move(WRITEPATH . 'uploads/notes', $newName);
                        
                        // Save attachment record
                        $this->attachmentModel->insert([
                            'note_id' => $noteId,
                            'filename' => $newName,
                            'original_name' => $file->getClientName(),
                            'file_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize()
                        ]);
                    }
                }
            }

            $this->db->transComplete();

            $redirectTo = '/notes' . ($subcategoryId ? ('?subcategory_id=' . $subcategoryId) : '');
            return redirect()->to($redirectTo)->with('message', 'Study note created successfully');
        } catch (\Exception $e) {
            $this->db->transRollback();
            log_message('error', 'Error creating note: ' . $e->getMessage());
            return redirect()->back()->withInput()
                ->with('error', 'Error creating note. Please try again.');
        }
    }

    public function uploadImage()
    {
        $currentRole = $this->session->get('current_role');
        
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return $this->response->setJSON(['error' => 'Access denied'])->setStatusCode(403);
        }

        if ($file = $this->request->getFile('file')) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads/notes/images', $newName);
                
                return $this->response->setJSON([
                    'location' => base_url('writable/uploads/notes/images/' . $newName)
                ]);
            }
        }

        return $this->response->setJSON(['error' => 'No file uploaded'])->setStatusCode(400);
    }

    public function view($id)
    {
        $currentRole = $this->session->get('current_role');
        $builder = $this->noteModel->select('notes.*, note_categories.name as category_name, users.username as author_name')
            ->join('note_categories', 'note_categories.id = notes.category_id')
            ->join('users', 'users.id = notes.author_id')
            ->where('notes.id', (int)$id);
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            $builder->where('notes.status', 'published');
        }
        $note = $builder->first();
        if (!$note) {
            return redirect()->to('/notes')->with('error', 'Note not found');
        }

        $data = [
            'title' => $note['title'],
            'note' => $note,
        ];

        if ($currentRole === 'admin') {
            return view('admin/layout/header', $data)
                . view('admin/notes/view', $data)
                . view('admin/layout/footer');
        } elseif ($currentRole === 'instructor') {
            return view('instructor/layout/header', $data)
                . view('instructor/notes/view', $data)
                . view('instructor/layout/footer');
        }
        return view('client/layout/header', $data)
            . view('client/notes/view', $data)
            . view('client/layout/footer');
    }

    public function edit($id)
    {
        $currentRole = $this->session->get('current_role');
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/notes')->with('error', 'Access denied');
        }
        $note = $this->noteModel->find((int)$id);
        if (!$note) {
            return redirect()->to('/notes')->with('error', 'Note not found');
        }
        if ($currentRole === 'instructor' && (int)$note['author_id'] !== (int)$this->session->get('user_id')) {
            return redirect()->to('/notes')->with('error', 'You cannot edit this note');
        }

        $data = [
            'title' => 'Edit Study Note',
            'note' => $note,
            'categories' => $this->categoryModel->getActiveCategories(),
        ];

        if ($currentRole === 'admin') {
            return view('admin/layout/header', $data)
                . view('admin/notes/edit', $data)
                . view('admin/layout/footer');
        }
        return view('instructor/layout/header', $data)
            . view('instructor/notes/edit', $data)
            . view('instructor/layout/footer');
    }

    public function update($id)
    {
        $currentRole = $this->session->get('current_role');
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/notes')->with('error', 'Access denied');
        }
        $note = $this->noteModel->find((int)$id);
        if (!$note) {
            return redirect()->to('/notes')->with('error', 'Note not found');
        }
        if ($currentRole === 'instructor' && (int)$note['author_id'] !== (int)$this->session->get('user_id')) {
            return redirect()->to('/notes')->with('error', 'You cannot edit this note');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'content' => 'required|min_length[10]',
            'category_id' => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'category_id' => (int)$this->request->getPost('category_id'),
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
        ];
        if ($currentRole === 'admin') {
            $data['status'] = $this->request->getPost('status') === 'published' ? 'published' : 'draft';
        }

        $this->noteModel->update((int)$id, $data);

        return redirect()->to('/notes')->with('message', 'Study note updated');
    }

    public function delete($id)
    {
        $currentRole = $this->session->get('current_role');
        if (!in_array($currentRole, ['admin', 'instructor'])) {
            return redirect()->to('/notes')->with('error', 'Access denied');
        }
        $note = $this->noteModel->find((int)$id);
        if (!$note) {
            return redirect()->to('/notes')->with('error', 'Note not found');
        }
        if ($currentRole === 'instructor' && (int)$note['author_id'] !== (int)$this->session->get('user_id')) {
            return redirect()->to('/notes')->with('error', 'You cannot delete this note');
        }

        // Delete attachments (db records only)
        $this->attachmentModel->where('note_id', (int)$id)->delete();
        $this->noteModel->delete((int)$id);
        return redirect()->to('/notes')->with('message', 'Study note deleted');
    }
}