<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Client extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function index()
    {
        $data['title'] = 'Student Dashboard';
        return view('client/layout/header', $data)
            . view('client/dashboard/index', $data)
            . view('client/layout/footer');
    }

    public function profile()
    {
        $userId = $this->session->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $user = $this->userModel->find($userId);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $data = [
            'title' => 'My Profile',
            'user' => $user
        ];
        
        return view('client/layout/header', $data)
            . view('client/profile', $data)
            . view('client/layout/footer');
    }

    public function updateProfile()
    {
        $userId = $this->session->get('user_id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $rules = [
            'username' => 'required|min_length[3]',
            'email'    => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($userId, [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
        ]);

        return redirect()->to('/client/profile')->with('message', 'Profile updated successfully.');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}