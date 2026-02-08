<?php

namespace App\Controllers;

use App\Models\CheatSheetModel;
use App\Models\StudyCategoryModel;
use App\Models\StudySubcategoryModel;
use App\Models\SubscriptionModel;
use CodeIgniter\Files\File;

class CheatSheets extends BaseController
{
    protected $categories;
    protected $subcategories;
    protected $cheatSheets;
    protected $subs;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->categories = new StudyCategoryModel();
        $this->subcategories = new StudySubcategoryModel();
        $this->cheatSheets = new CheatSheetModel();
        $this->subs = new SubscriptionModel();
    }

    private function uploadDir(): string
    {
        // `writable/` permissions may vary (e.g., XAMPP user mismatch), so store
        // uploads in a project-local directory and serve them through controllers.
        return ROOTPATH . 'storage/uploads/cheat_sheets/';
    }

    // --- Category-level manager (hide subcategory step) ---
    public function adminCheatSheetsByCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/cheat-sheets'));
        $subs = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        $subIds = array_column($subs, 'id');
        $docs = [];
        if (!empty($subIds)) {
            $docs = $this->cheatSheets->whereIn('subcategory_id', $subIds)->orderBy('created_at', 'DESC')->findAll();
        }
        $subMap = [];
        foreach ($subs as $s) { $subMap[(int)$s['id']] = $s['name']; }
        $data = [
            'title' => 'Cheat Sheets - ' . $category['name'],
            'category' => $category,
            'cheatSheets' => $docs,
            'subcategoryMap' => $subMap,
        ];
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/category_docs_index', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadFormCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/cheat-sheets'));
        $data = [
            'title' => 'Upload Cheat Sheet - ' . $category['name'],
            'category' => $category,
        ];
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/category_upload_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadCategory($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/cheat-sheets'));
        $subcategoryId = $this->ensureGeneralSubcategory((int)$categoryId);

        $file = $this->request->getFile('cheat_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid file.');
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower((string)$file->getClientExtension());
        if (!in_array($ext, $allowedExtensions, true)) {
            return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, JPG, PNG, GIF, WEBP.');
        }

        $uploadPath = $this->uploadDir();
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
            return redirect()->back()->with('error', 'Upload directory is not writable. Please fix permissions for storage/uploads/cheat_sheets.');
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $this->cheatSheets->insert([
            'subcategory_id' => $subcategoryId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $uploadPath . $newName,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'created_by' => (int)session()->get('user_id'),
        ]);

        return redirect()->to(base_url('admin/cheat-sheets/category/' . (int)$categoryId . '/docs'))
            ->with('message', 'Cheat sheet uploaded successfully.');
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
            'description' => 'Auto-created for category-level cheat sheets',
        ], true);
        return (int)$id;
    }

    // ============ ADMIN METHODS ============

    public function adminIndex()
    {
        $data['title'] = 'Cheat Sheets';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/categories_index', $data)
            . view('admin/layout/footer');
    }

    public function adminSubcategories($categoryId)
    {
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('admin/cheat-sheets'));
        $data['title'] = 'Cheat Sheet Subcategories - ' . $category['name'];
        $data['category'] = $category;
        $data['subcategories'] = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/subcategories_index', $data)
            . view('admin/layout/footer');
    }

    public function adminCheatSheets($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/cheat-sheets'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Cheat Sheets - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['cheatSheets'] = $this->cheatSheets->where('subcategory_id', (int)$subcategoryId)->orderBy('created_at', 'DESC')->findAll();
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/docs_index', $data)
            . view('admin/layout/footer');
    }

    public function adminUploadForm($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/cheat-sheets'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = 'Upload Cheat Sheet - ' . $subcategory['name'];
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/upload_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUpload($subcategoryId)
    {
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('admin/cheat-sheets'));

        $file = $this->request->getFile('cheat_file');
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Please select a valid file.');
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
        $ext = strtolower((string)$file->getClientExtension());
        if (!in_array($ext, $allowedExtensions, true)) {
            return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, JPG, PNG, GIF, WEBP.');
        }

        $uploadPath = $this->uploadDir();
        if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
            return redirect()->back()->with('error', 'Upload directory is not writable. Please fix permissions for storage/uploads/cheat_sheets.');
        }
        $newName = $file->getRandomName();
        $file->move($uploadPath, $newName);

        $this->cheatSheets->insert([
            'subcategory_id' => (int)$subcategoryId,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'file_path' => $uploadPath . $newName,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'created_by' => (int)session()->get('user_id'),
        ]);

        return redirect()->to(base_url('admin/cheat-sheets/subcategory/' . $subcategoryId . '/docs'))
            ->with('message', 'Cheat sheet uploaded successfully.');
    }

    public function adminEdit($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return redirect()->to(base_url('admin/cheat-sheets'));
        $subcategory = $this->subcategories->find((int)$doc['subcategory_id']);
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data = [
            'title' => 'Edit Cheat Sheet - ' . $subcategory['name'],
            'category' => $category,
            'subcategory' => $subcategory,
            'doc' => $doc,
        ];
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/edit_form', $data)
            . view('admin/layout/footer');
    }

    public function adminUpdate($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return redirect()->to(base_url('admin/cheat-sheets'));

        $updateData = [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        $file = $this->request->getFile('cheat_file');
        if ($file && $file->isValid()) {
            $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower((string)$file->getClientExtension());
            if (!in_array($ext, $allowedExtensions, true)) {
                return redirect()->back()->with('error', 'Invalid file type. Allowed: PDF, JPG, PNG, GIF, WEBP.');
            }

            if (!empty($doc['file_path']) && is_file($doc['file_path'])) {
                @unlink($doc['file_path']);
            }

            $uploadPath = $this->uploadDir();
            if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true) && !is_dir($uploadPath)) {
                return redirect()->back()->with('error', 'Upload directory is not writable. Please fix permissions for storage/uploads/cheat_sheets.');
            }
            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $updateData['file_path'] = $uploadPath . $newName;
            $updateData['file_name'] = $file->getClientName();
            $updateData['file_size'] = $file->getSize();
        }

        $this->cheatSheets->update((int)$id, $updateData);

        return redirect()->to(base_url('admin/cheat-sheets/subcategory/' . (int)$doc['subcategory_id'] . '/docs'))
            ->with('message', 'Cheat sheet updated successfully.');
    }

    public function adminDelete($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if ($doc) {
            if (!empty($doc['file_path']) && is_file($doc['file_path'])) {
                @unlink($doc['file_path']);
            }
            $this->cheatSheets->delete((int)$id);
            return redirect()->to(base_url('admin/cheat-sheets/subcategory/' . (int)$doc['subcategory_id'] . '/docs'))
                ->with('message', 'Cheat sheet deleted successfully.');
        }
        return redirect()->to(base_url('admin/cheat-sheets'));
    }

    public function adminView($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return redirect()->to(base_url('admin/cheat-sheets'));
        $subcategory = $this->subcategories->find((int)$doc['subcategory_id']);
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data = [
            'title' => 'View Cheat Sheet',
            'category' => $category,
            'subcategory' => $subcategory,
            'doc' => $doc,
        ];
        return view('admin/layout/header', $data)
            . view('admin/cheat_sheets/view', $data)
            . view('admin/layout/footer');
    }

    public function adminFile($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return $this->response->setStatusCode(404);
        return $this->serveFile((string)($doc['file_path'] ?? ''), (string)($doc['file_name'] ?? 'file'), true);
    }

    public function adminDownload($id)
    {
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc || empty($doc['file_path']) || !is_file($doc['file_path'])) {
            return redirect()->back()->with('error', 'File not found.');
        }
        return $this->response->download($doc['file_path'], null)->setFileName($doc['file_name']);
    }

    // ============ CLIENT METHODS ============

    public function clientIndex()
    {
        $this->enforcePaidClient();
        $data['title'] = 'Cheat Sheets';
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        return view('client/layout/header', $data)
            . view('client/cheat_sheets/categories', $data)
            . view('client/layout/footer');
    }

    public function clientSubcategories($categoryId)
    {
        $this->enforcePaidClient();
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/cheat-sheets'));
        $data['title'] = $category['name'] . ' - Cheat Sheets';
        $data['category'] = $category;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['subcategories'] = $this->subcategories
            ->where('category_id', (int)$categoryId)
            ->orderBy('name')
            ->findAll();
        return view('client/layout/header', $data)
            . view('client/cheat_sheets/subcategories', $data)
            . view('client/layout/footer');
    }

    public function clientCheatSheets($subcategoryId)
    {
        $this->enforcePaidClient();
        $subcategory = $this->subcategories->find((int)$subcategoryId);
        if (!$subcategory) return redirect()->to(base_url('client/cheat-sheets'));
        $category = $this->categories->find((int)$subcategory['category_id']);
        $data['title'] = $subcategory['name'] . ' - Cheat Sheets';
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        $data['categories'] = $this->categories->orderBy('name')->findAll();
        $data['cheatSheets'] = $this->cheatSheets->where('subcategory_id', (int)$subcategoryId)->orderBy('created_at', 'DESC')->findAll();
        return view('client/layout/header', $data)
            . view('client/cheat_sheets/docs', $data)
            . view('client/layout/footer');
    }

    public function clientCheatSheetsByCategory($categoryId)
    {
        $this->enforcePaidClient();
        $category = $this->categories->find((int)$categoryId);
        if (!$category) return redirect()->to(base_url('client/cheat-sheets'));

        $subs = $this->subcategories->where('category_id', (int)$categoryId)->orderBy('name')->findAll();
        $subIds = array_column($subs, 'id');
        $docs = [];
        if (!empty($subIds)) {
            $docs = $this->cheatSheets->whereIn('subcategory_id', $subIds)->orderBy('created_at', 'DESC')->findAll();
        }
        $subMap = [];
        foreach ($subs as $s) { $subMap[(int)$s['id']] = $s['name']; }

        $data = [
            'title' => $category['name'] . ' - Cheat Sheets',
            'category' => $category,
            'cheatSheets' => $docs,
            'subcategoryMap' => $subMap,
        ];
        return view('client/layout/header', $data)
            . view('client/cheat_sheets/category_docs', $data)
            . view('client/layout/footer');
    }

    public function clientView($id)
    {
        $this->enforcePaidClient();
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return redirect()->to(base_url('client/cheat-sheets'))->with('error', 'Cheat sheet not found.');
        $subcategory = $this->subcategories->find((int)$doc['subcategory_id']);
        $category = $subcategory ? $this->categories->find((int)$subcategory['category_id']) : null;
        $data = [
            'title' => 'Cheat Sheet Viewer',
            'doc' => $doc,
            'subcategory' => $subcategory,
            'category' => $category,
        ];
        return view('client/layout/header', $data)
            . view('client/cheat_sheets/view', $data)
            . view('client/layout/footer');
    }

    public function clientFile($id)
    {
        $this->enforcePaidClient();
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc) return $this->response->setStatusCode(404);
        return $this->serveFile((string)($doc['file_path'] ?? ''), (string)($doc['file_name'] ?? 'file'), true);
    }

    public function clientDownload($id)
    {
        $this->enforcePaidClient();
        $doc = $this->cheatSheets->find((int)$id);
        if (!$doc || empty($doc['file_path']) || !is_file($doc['file_path'])) {
            return redirect()->back()->with('error', 'File not found.');
        }
        return $this->response->download($doc['file_path'], null)->setFileName($doc['file_name']);
    }

    private function enforcePaidClient(): void
    {
        $userId = (int)(session()->get('user_id') ?? 0);
        if (!$userId) {
            redirect()->to(base_url('subscriptions'))->send();
            exit;
        }
        $active = $this->subs->getActiveForUser($userId);
        if (!$active) {
            redirect()->to(base_url('client/subscription'))->with('error', 'Your subscription is inactive. Please subscribe to access Cheat Sheets.')->send();
            exit;
        }
    }

    private function serveFile(string $path, string $originalName, bool $inline)
    {
        $baseDir = rtrim($this->uploadDir(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $realBase = realpath($baseDir);
        $realPath = $path !== '' ? realpath($path) : false;
        if (!$realBase || !$realPath || strpos($realPath, $realBase) !== 0 || !is_file($realPath)) {
            return $this->response->setStatusCode(404);
        }

        $mime = 'application/octet-stream';
        try {
            $mime = (new File($realPath))->getMimeType() ?: $mime;
        } catch (\Throwable $e) {
            // ignore
        }

        $disp = $inline ? 'inline' : 'attachment';
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', $disp . '; filename="' . basename($originalName) . '"')
            ->setBody((string)file_get_contents($realPath));
    }
}
