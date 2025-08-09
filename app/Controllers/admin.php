<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Admin extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    public function viewUsers()
    {
        $data['users'] = $this->userModel->findAll();
        return view('admin/users', $data);
    }

    public function deleteUser($id = null)
    {
        if ($id && $this->userModel->find($id)) {
            $this->userModel->delete($id);
            return redirect()->to('/admin/viewUsers')->with('message', 'User deleted successfully.');
        }
        return redirect()->back()->with('error', 'User not found.');
    }

    public function editUser($id = null)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }
        $data['user'] = $user;
        return view('admin/edit_user', $data);
    }

    public function updateUser()
    {
        $id = $this->request->getPost('id');

        if ($id && $this->userModel->find($id)) {
            $this->userModel->update($id, [
                'username' => $this->request->getPost('username'),
                'email'    => $this->request->getPost('email'),
                // Add other fields as needed
            ]);
            return redirect()->to('/admin/viewUsers')->with('message', 'User updated successfully.');
        }

        return redirect()->back()->with('error', 'Failed to update user.');
    }

    public function addUser()
    {
        return view('admin/add_user');
    }

    public function saveUser()
    {
        $this->userModel->save([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('/admin/viewUsers')->with('message', 'New user added.');
    }
}
