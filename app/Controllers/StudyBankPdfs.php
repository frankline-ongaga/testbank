<?php
namespace App\Controllers;

use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\StudyBankPdfModel;
use App\Models\SubscriptionModel;

class StudyBankPdfs extends BaseController
{
    protected $categories;
    protected $subcategories;
    protected $pdfs;
    protected $subs;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->categories = new StudyCategoryModel();
        $this->subcategories = new StudySubcategoryModel();
        $this->pdfs = new StudyBankPdfModel();
        $this->subs = new SubscriptionModel();
    }

    // --- Category-level manager (hide subcategory step) ---
    public function adminPdfsByCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $subs = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        $subIds = array_column($subs, 'id');
        $docs = [];
        if (!empty($subIds)) {
            $docs = $this->pdfs->whereIn('subcategory_id', $subIds)->orderBy('created_at', 'DESC')->findAll();
        }
        $subMap = [];
        foreach ($subs as $s) { $subMap[(int)$s['id']] = $s['name']; }
        $data = [
            'title' => 'Documents - ' . $category['name'],
            'category' => $category,
            'pdfs' => $docs,
            'subcategoryMap' => $subMap,
        ];
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/category_pdfs_index', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadFormCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $data = [
            'title' => 'Upload Document - ' . $category['name'],
            'category' => $category,
        ];
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/category_upload_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study-bank-pdfs'));
        // Auto-use or create a 'General' subcategory under this category
        $subcategoryId = $this->ensureGeneralSubcategory((int)$categoryId);

        $file = $this->request->getFile('pdf_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid document file.');
        }
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
        $ext = strtolower((string)$file->getClientExtension());
        if (!in_array($ext, $allowedExtensions, true)) {
            return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, DOC, DOCX, XLS, XLSX, TXT.');
        }
        $uploadPath = WRITEPATH . 'uploads/study_bank_pdfs/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);
        $this->pdfs->insert([
            'subcategory_id' => $subcategoryId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $uploadPath . $newName,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'created_by' => (int)session()->get('user_id'),
        ]);
        return redirect()->to(base_url('admin/study-bank-pdfs/category/' . (int)$categoryId . '/docs'))
            ->with('message', 'Document uploaded successfully.');
    }

    private function ensureGeneralSubcategory(int $categoryId): int
    {
        $general = $this->subcategories
            ->where('category_id', $categoryId)
            ->where('slug', 'general')
            ->first();
        if ($general) {
            return (int)$general['id'];
        }
        $id = $this->subcategories->insert([
            'category_id' => $categoryId,
            'name' => 'General',
            'slug' => 'general',
            'description' => 'Auto-created for category-level documents',
        ], true);
        return (int)$id;
    }
    // ============ ADMIN METHODS ============

    public function adminIndex()
    {
        $data['title'] = 'Study Bank Docs';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/categories_index', $data)
            . view('admin/layout/footer');
    }

    public function adminSubcategories($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $data['title'] = 'Docs Subcategories - ' . $category['name'];
        $data['category'] = $category;
        $data['subcategories'] = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/subcategories_index', $data)
            . view('admin/layout/footer');
    }

    public function adminPdfs($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Documents - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['pdfs'] = $this->pdfs->where('subcategory_id', (int)$subcategoryId)->orderBy('created_at', 'DESC')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/pdfs_index', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadForm($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Upload Document - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/upload_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUpload($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/study-bank-pdfs'));

        $file = $this->request->getFile('pdf_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid document file.');
        }

        // Validate file type
        $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
        $ext = strtolower((string)$file->getClientExtension());
        if (!in_array($ext, $allowedExtensions, true)) {
            return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, DOC, DOCX, XLS, XLSX, TXT.');
        }

        // Create upload directory if it doesn't exist
        $uploadPath = WRITEPATH . 'uploads/study_bank_pdfs/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        // Save to database
        $this->pdfs->insert([
            'subcategory_id' => (int)$subcategoryId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $uploadPath . $newName,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'created_by' => (int)session()->get('user_id'),
        ]);

        return redirect()->to(base_url('admin/study-bank-pdfs/subcategory/' . $subcategoryId . '/pdfs'))
            ->with('message', 'Document uploaded successfully.');
    }

    public function adminEdit($pdfId)
    {
        $pdf = $this->pdfs->find((int)$pdfId);
        if (!$pdf) return redirect()->to(base_url('admin/study-bank-pdfs'));
        $subcategory = $this->subcategories->find((int)$pdf['subcategory_id']);
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Edit Document - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['pdf'] = $pdf;
        return view('admin/layout/header', $data)
            . view('admin/study_bank_pdfs/edit_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUpdate($pdfId)
    {
        $pdf = $this->pdfs->find((int)$pdfId);
        if (!$pdf) return redirect()->to(base_url('admin/study-bank-pdfs'));

        $updateData = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        // Check if a new file is uploaded
        $file = $this->request->getFile('pdf_file');
        if ($file && $file->isValid()) {
            // Validate file type
            $allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt'];
            $ext = strtolower((string)$file->getClientExtension());
            if (!in_array($ext, $allowedExtensions, true)) {
                return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, DOC, DOCX, XLS, XLSX, TXT.');
            }

            // Delete old file
            if (file_exists($pdf['file_path'])) {
                unlink($pdf['file_path']);
            }

            // Upload new file
            $uploadPath = WRITEPATH . 'uploads/study_bank_pdfs/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $updateData['file_path'] = $uploadPath . $newName;
            $updateData['file_name'] = $file->getClientName();
            $updateData['file_size'] = $file->getSize();
        }

        $this->pdfs->update((int)$pdfId, $updateData);

        return redirect()->to(base_url('admin/study-bank-pdfs/subcategory/' . $pdf['subcategory_id'] . '/pdfs'))
            ->with('message', 'Document updated successfully.');
    }

    public function adminDelete($pdfId)
    {
        $pdf = $this->pdfs->find((int)$pdfId);
        if ($pdf) {
            // Delete file from filesystem
            if (file_exists($pdf['file_path'])) {
                unlink($pdf['file_path']);
            }
            // Delete from database
            $this->pdfs->delete((int)$pdfId);
            return redirect()->to(base_url('admin/study-bank-pdfs/subcategory/' . $pdf['subcategory_id'] . '/pdfs'))
                ->with('message', 'Document deleted successfully.');
        }
        return redirect()->to(base_url('admin/study-bank-pdfs'));
    }

    // ============ CLIENT METHODS ============

    public function clientIndex()
    {
        // Check if user has active subscription
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to(base_url('subscriptions'))
                ->with('error', 'Please login and subscribe to access Study Bank Docs.');
        }
        $active = $this->subs->getActiveForUser((int)$userId);
        if (!$active) {
            return redirect()->to(base_url('client/subscription'))
                ->with('error', 'Your subscription is inactive. Please subscribe to access Study Bank Docs.');
        }

        $data['title'] = 'Study Bank Docs';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('client/layout/header', $data)
            . view('client/study_bank_pdfs/categories', $data)
            . view('client/layout/footer');
    }

    public function clientSubcategories($categoryId)
    {
        // Check if user has active subscription
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to(base_url('subscriptions'))
                ->with('error', 'Please login and subscribe to access Study Bank Docs.');
        }
        $active = $this->subs->getActiveForUser((int)$userId);
        if (!$active) {
            return redirect()->to(base_url('client/subscription'))
                ->with('error', 'Your subscription is inactive. Please subscribe to access Study Bank Docs.');
        }

        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/study-bank-pdfs'));
        $data['title'] = $category['name'] . ' - Study Bank Docs';
        $data['category'] = $category;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['subcategories'] = $this->subcategories
            ->where('category_id', (int)$categoryId)
            ->orderBy('name')
            ->findAll();
        return view('client/layout/header', $data)
            . view('client/study_bank_pdfs/subcategories', $data)
            . view('client/layout/footer');
    }

    public function clientPdfs($subcategoryId)
    {
        // Check if user has active subscription
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to(base_url('subscriptions'))
                ->with('error', 'Please login and subscribe to access Study Bank Docs.');
        }
        $active = $this->subs->getActiveForUser((int)$userId);
        if (!$active) {
            return redirect()->to(base_url('client/subscription'))
                ->with('error', 'Your subscription is inactive. Please subscribe to access Study Bank Docs.');
        }

        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('client/study-bank-pdfs'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = $subcategory['name'] . ' - Docs';
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['pdfs'] = $this->pdfs->where('subcategory_id', (int)$subcategoryId)->orderBy('created_at', 'DESC')->findAll();
        return view('client/layout/header', $data)
            . view('client/study_bank_pdfs/pdfs', $data)
            . view('client/layout/footer');
    }

    public function clientPdfsByCategory($categoryId)
    {
        // Check if user has active subscription
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to(base_url('subscriptions'))
                ->with('error', 'Please login and subscribe to access Study Bank Docs.');
        }
        $active = $this->subs->getActiveForUser((int)$userId);
        if (!$active) {
            return redirect()->to(base_url('client/subscription'))
                ->with('error', 'Your subscription is inactive. Please subscribe to access Study Bank Docs.');
        }

        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/study-bank-pdfs'));

        $subs = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        $subIds = array_column($subs, 'id');
        $docs = [];
        if (!empty($subIds)) {
            $docs = $this->pdfs->whereIn('subcategory_id', $subIds)->orderBy('created_at', 'DESC')->findAll();
        }
        $subMap = [];
        foreach ($subs as $s) { $subMap[(int)$s['id']] = $s['name']; }

        $data = [
            'title' => $category['name'] . ' - Docs',
            'category' => $category,
            'pdfs' => $docs,
            'subcategoryMap' => $subMap,
        ];
        return view('client/layout/header', $data)
            . view('client/study_bank_pdfs/category_docs', $data)
            . view('client/layout/footer');
    }
    public function clientDownload($pdfId)
    {
        // Check if user has active subscription
        $userId = session()->get('user_id');
        if (!$userId) {
            return redirect()->to(base_url('subscriptions'))
                ->with('error', 'Please login and subscribe to access Study Bank Docs.');
        }
        $active = $this->subs->getActiveForUser((int)$userId);
        if (!$active) {
            return redirect()->to(base_url('client/subscription'))
                ->with('error', 'Your subscription is inactive. Please subscribe to access Study Bank Docs.');
        }

        $pdf = $this->pdfs->find((int)$pdfId);
        if (!$pdf || !file_exists($pdf['file_path'])) {
            return redirect()->back()->with('error', 'Document file not found.');
        }

        return $this->response->download($pdf['file_path'], null)->setFileName($pdf['file_name']);
    }
}

