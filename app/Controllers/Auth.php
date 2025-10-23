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
        return view('auth/design', $data);
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
        return view('auth/register_design', $data);
    }

    public function register()
    {
        $rules = [
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'first_name' => 'required|min_length[2]'
        ];

        $messages = [
            'email' => [
                'is_unique'   => 'Email is already in use',
                'required'    => 'Email is required',
                'valid_email' => 'Enter a valid email address',
            ],
            'password' => [
                'required'   => 'Password is required',
                'min_length' => 'Password must be at least 6 characters',
            ],
            'first_name' => [
                'required'   => 'First name is required',
                'min_length' => 'First name must be at least 2 characters',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->insert([
            'first_name' => $this->request->getPost('first_name'),
            'email' => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => 'active',
        ], true);

        $this->userModel->assignRole($userId, 'student');

        // Standard session for student
        session()->set([
            'user_id' => $userId,
            'roles' => ['student'],
            'user_email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('first_name'),
        ]);

        // Auto-login already set above. Redirect to client subscriptions to complete payment
        return redirect()->to('/client/subscription')->with('message', 'Account created. Choose a plan to complete signup.');
    }

    public function logout()
    {
        $roles = session()->get('roles') ?? [];
        session()->destroy();
        if (in_array('student', $roles)) {
            return redirect()->to('/login/student');
        }
        if (in_array('admin', $roles)) {
            return redirect()->to('/login/admin');
        }
        if (in_array('instructor', $roles)) {
            return redirect()->to('/login/instructor');
        }
        return redirect()->to('/login');
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

    public function google()
    {
        $idToken = $this->request->getPost('credential');
        if (!$idToken) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Missing token']);
        }
        // Verify with Google tokeninfo (server-side). In production, prefer Google PHP client.
        $verifyUrl = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);
        try {
            $context = stream_context_create(['http' => ['timeout' => 5]]);
            $json = file_get_contents($verifyUrl, false, $context);
            if ($json === false) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Verification failed']);
            }
            $payload = json_decode($json, true) ?: [];
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Verification error']);
        }
        if (empty($payload['email']) || empty($payload['sub'])) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid token']);
        }
        $email = strtolower($payload['email']);
        $firstName = $payload['given_name'] ?? null;
        $googleId = $payload['sub'];

        // Find or create user
        $user = $this->userModel->findByEmail($email);
        if (!$user) {
            $userId = $this->userModel->insert([
                'email' => $email,
                'first_name' => $firstName,
                'google_id' => $googleId,
                'status' => 'active',
            ], true);
            $this->userModel->assignRole($userId, 'student');
            $user = $this->userModel->find($userId);
        } else {
            if (empty($user['google_id'])) {
                $this->userModel->update($user['id'], ['google_id' => $googleId]);
            }
        }
        // Start session
        $roles = $this->userModel->getUserRoles($user['id']);
        session()->set([
            'user_id' => $user['id'],
            'roles' => $roles ?: ['student'],
            'user_email' => $user['email'],
            'username' => $user['first_name'] ?? ($user['username'] ?? null),
        ]);
        return $this->response->setJSON(['ok' => true, 'redirect' => base_url('client/subscription')]);
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
            'username' => $user['first_name'] ?? ($user['username'] ?? null),
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