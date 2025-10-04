<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;
    

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
    }

    public function showLogin()
    {
        // Default to student login
        return redirect()->to('/login/student');
    }

    public function showLoginStudent()
    {
        $data = ['title' => 'Student Login', 'loginRole' => 'student', 'loginAction' => '/login/student'];
        return view('homepage/header', $data)
            . view('auth/login', $data)
            . view('homepage/footer');
    }

    public function showLoginInstructor()
    {
        $data = ['title' => 'Instructor Login', 'loginRole' => 'instructor', 'loginAction' => '/login/instructor'];
        return view('homepage/header', $data)
            . view('auth/login', $data)
            . view('homepage/footer');
    }

    public function showLoginAdmin()
    {
        $data = ['title' => 'Admin Login', 'loginRole' => 'admin', 'loginAction' => '/login/admin'];
        return view('homepage/header', $data)
            . view('auth/login', $data)
            . view('homepage/footer');
    }

    public function loginStudent()
    {
        return $this->authenticateAndRedirect('student');
    }

    public function loginInstructor()
    {
        return $this->authenticateAndRedirect('instructor');
    }

    public function loginAdmin()
    {
        return $this->authenticateAndRedirect('admin');
    }

    public function showRegister()
    {
        $data['title'] = 'Create Account';
        return view('homepage/header', $data)
            . view('auth/register')
            . view('homepage/footer');
    }

    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[users.email]',
            'username' => 'permit_empty|min_length[3]|max_length[100]',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->insert([
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => 'active',
        ], true);

        $this->userModel->assignRole($userId, 'student');

        // Standard session for student
        session()->set([
            'user_id' => $userId,
            'roles' => ['student'],
            'user_email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
        ]);

        return redirect()->to('/client');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function showForgotPassword()
    {
        $data['title'] = 'Forgot Password';
        return view('homepage/header', $data)
            . view('auth/forgot')
            . view('homepage/footer');
    }

    public function sendReset()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $email = $this->request->getPost('email');
        $user = $this->userModel->findByEmail($email);
        if ($user) {
            $token = bin2hex(random_bytes(32));
            $this->userModel->update($user['id'], [
                'reset_token' => $token,
                'reset_expires_at' => date('Y-m-d H:i:s', time() + 3600),
            ]);
            // TODO: send email via configured email service
        }
        return redirect()->back()->with('message', 'If the email exists, a reset link has been sent.');
    }

    public function showReset($token)
    {
        $data = ['title' => 'Reset Password', 'token' => $token];
        return view('homepage/header', $data)
            . view('auth/reset', $data)
            . view('homepage/footer');
    }

    public function doReset($token)
    {
        $rules = [
            'password' => 'required|min_length[6]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_expires_at >=', date('Y-m-d H:i:s'))
            ->first();
        if (!$user) {
            return redirect()->to('/login')->with('error', 'Invalid or expired token');
        }
        $this->userModel->update($user['id'], [
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_expires_at' => null,
        ]);

        return redirect()->to('/login')->with('message', 'Password updated.');
    }

    private function authenticateAndRedirect(string $requiredRole)
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);
        if (!$user || empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password');
        }
        if ($user['status'] !== 'active') {
            return redirect()->back()->with('error', 'Account not active');
        }

        $roles = $this->userModel->getUserRoles($user['id']);
        if (!in_array($requiredRole, $roles)) {
            return redirect()->back()->withInput()->with('error', 'You do not have access to this portal');
        }

        // Standard session data
        session()->set([
            'user_id' => $user['id'],
            'roles' => $roles,
            'user_email' => $user['email'] ?? null,
            'username' => $user['username'] ?? null,
        ]);

        if ($requiredRole === 'admin') {
            return redirect()->to('/admin');
        }
        if ($requiredRole === 'instructor') {
            return redirect()->to('/instructor');
        }
        return redirect()->to('/client');
    }
}