<?php

namespace App\Controllers;

use App\Models\DesignModelWriter;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Writer extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->session = session();
        $this->designModelWriter = new DesignModelWriter();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('Writer/index');
    }

    public function upload_paper()
    {
        \$order_id = \$this->request->getPost('order_id');
        \$file = \$this->request->getFile('upload_file');

        if (\$file->isValid() && !\$file->hasMoved()) {
            \$filename = \$file->getRandomName();
            \$file->move(WRITEPATH . 'uploads/', \$filename);

            \$data = [
                'order_id' => \$order_id,
                'upload_file' => \$filename,
            ];

            \$this->designModelWriter->insert_file(\$data);
            \$this->session->setFlashdata('success_msg', 'File uploaded successfully!');
        } else {
            \$this->session->setFlashdata('error_msg', 'Upload failed!');
        }

        return redirect()->to(base_url('writer'));
    }

    public function notifications()
    {
        return view('Writer/notifications');
    }

    public function help()
    {
        return view('Writer/help');
    }

    public function profile()
    {
        return view('Writer/profile');
    }

    public function completed_orders()
    {
        return view('Writer/completed_orders');
    }

    public function progress_orders()
    {
        return view('Writer/progress_orders');
    }

    public function revision_orders()
    {
        return view('Writer/revision_orders');
    }

    public function available_orders()
    {
        return view('Writer/available_orders');
    }

    public function my_orders()
    {
        return view('Writer/my_orders');
    }

    public function transaction()
    {
        return view('Writer/transaction');
    }

    public function payments()
    {
        return view('Writer/payments');
    }

    public function file_submissions()
    {
        return view('Writer/file_submissions');
    }

    public function view_order()
    {
        return view('Writer/view_order');
    }

    public function messages()
    {
        return view('Writer/messages');
    }
}
