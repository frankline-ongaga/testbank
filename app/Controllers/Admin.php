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
        $db = \Config\Database::connect();

        // Top-level metrics
        // Total Users = number of students
        $studentRow = $db->table('users u')
            ->select('COUNT(DISTINCT u.id) AS cnt')
            ->join('user_roles ur', 'ur.user_id = u.id', 'inner')
            ->join('roles r', 'r.id = ur.role_id', 'inner')
            ->where('r.name', 'student')
            ->get()->getRowArray();
        $totalUsers = (int) ($studentRow['cnt'] ?? 0);
        $activeTests = $db->table('tests')->where('status', 'active')->countAllResults();
        $questionsCount = $db->table('questions')->countAllResults();

        // Revenue (sum of payments.amount)
        $revenueRow = $db->table('payments')->selectSum('amount')->get()->getRowArray();
        $totalRevenue = (float) ($revenueRow['amount'] ?? 0);

        // Chart data: last 4 weeks average score and pass rate
        $since = date('Y-m-d 00:00:00', strtotime('-28 days'));
        $attempts = $db->table('attempts')
            ->select('score, completed_at')
            ->where('completed_at >=', $since)
            ->get()->getResultArray();

        $weeks = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = new \DateTime("-{$i} week");
            $start->modify('monday this week');
            $label = 'Week ' . (4 - $i);
            $weeks[] = [
                'label' => $label,
                'start' => (clone $start)->setTime(0,0,0),
                'end' => (clone $start)->modify('+6 days')->setTime(23,59,59),
            ];
        }

        $avgScores = [];
        $passRates = [];
        $labels = [];
        foreach ($weeks as $w) {
            $labels[] = $w['label'];
            $scores = [];
            $passes = 0; $total = 0;
            foreach ($attempts as $a) {
                if (empty($a['completed_at'])) continue;
                $dt = new \DateTime($a['completed_at']);
                if ($dt >= $w['start'] && $dt <= $w['end']) {
                    if ($a['score'] !== null) {
                        $scores[] = (float) $a['score'];
                        $total++;
                        if ((float)$a['score'] >= 75) { $passes++; }
                    }
                }
            }
            $avgScores[] = count($scores) ? round(array_sum($scores) / count($scores), 2) : null;
            $passRates[] = $total ? round(($passes / $total) * 100, 2) : null;
        }

        $data = [
            'title' => 'Admin Dashboard',
            'total_users' => $totalUsers,
            'active_tests' => $activeTests,
            'questions_count' => $questionsCount,
            'total_revenue' => $totalRevenue,
            // Chart metrics no longer shown on UI; kept if needed later
            'chart_labels' => $labels,
            'chart_avg_scores' => $avgScores,
            'chart_pass_rates' => $passRates,
        ];

        // Latest 10 transactions (payments)
        $latestPayments = $db->table('payments p')
            ->select('p.*, u.email as user_email, u.first_name as user_first_name, s.plan as subscription_plan')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->join('subscriptions s', 's.id = p.subscription_id', 'left')
            ->orderBy('p.created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
        $data['latest_payments'] = $latestPayments;

        return view('admin/layout/header', $data)
            . view('admin/dashboard', $data)
            . view('admin/layout/footer');
    }

    public function viewUsers()
    {
        $data['title'] = 'Manage Users';
        $data['users'] = $this->userModel->findAll();
        return view('admin/layout/header', $data)
            . view('admin/users', $data)
            . view('admin/layout/footer');
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
        $data['title'] = 'Edit User';
        $data['user'] = $user;
        return view('admin/layout/header', $data)
            . view('admin/edit_user', $data)
            . view('admin/layout/footer');
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
        $data['title'] = 'Add User';
        return view('admin/layout/header', $data)
            . view('admin/add_user', $data)
            . view('admin/layout/footer');
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        $data['user'] = [
            'username' => session()->get('username'),
            'email' => session()->get('user_email')
        ];
        return view('admin/layout/header', $data)
            . view('admin/profile', $data)
            . view('admin/layout/footer');
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