<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\AttemptModel;
use App\Models\SubscriptionModel;
use CodeIgniter\Controller;

class Client extends BaseController
{
    protected $userModel;
    protected $session;
    protected $attempts;
    protected $subs;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
        $this->session = session();
        $this->attempts = new AttemptModel();
        $this->subs = new SubscriptionModel();
    }

    public function index()
    {
        $data['title'] = 'Student Dashboard';

        $userId = (int) $this->session->get('user_id');
        if (!$userId) {
            return redirect()->to('/login/student');
        }

        // Metrics
        $testsTaken = (int) $this->attempts
            ->where('user_id', $userId)
            ->where('completed_at IS NOT NULL', null, false)
            ->countAllResults();

        $lastAttempt = $this->attempts
            ->where('user_id', $userId)
            ->where('completed_at IS NOT NULL', null, false)
            ->orderBy('completed_at', 'DESC')
            ->first();
        $lastTestAt = $lastAttempt['completed_at'] ?? null;

        $avgRow = $this->attempts
            ->selectAvg('score', 'avg_score')
            ->where('user_id', $userId)
            ->where('score IS NOT NULL', null, false)
            ->get()->getRowArray();
        $avgScore = isset($avgRow['avg_score']) ? (float) $avgRow['avg_score'] : null;

        $activeSub = $this->subs->getActiveForUser($userId);
        $daysRemaining = null;
        if ($activeSub) {
            $now = time();
            $endTs = strtotime($activeSub['end_at']);
            $daysRemaining = $endTs > $now ? (int) ceil(($endTs - $now) / 86400) : 0;
        }

        // Study time last 30 days
        $since = date('Y-m-d H:i:s', strtotime('-30 days'));
        $recentForTime = $this->attempts
            ->where('user_id', $userId)
            ->where('completed_at >=', $since)
            ->findAll();
        $totalSeconds = 0;
        foreach ($recentForTime as $a) {
            $start = !empty($a['started_at']) ? strtotime($a['started_at']) : null;
            $end = !empty($a['completed_at']) ? strtotime($a['completed_at']) : null;
            if ($start && $end && $end > $start) {
                $totalSeconds += ($end - $start);
            }
        }
        $studyHours = round($totalSeconds / 3600, 1);

        // Trend
        $trendRowsDesc = $this->attempts
            ->select('completed_at, score')
            ->where('user_id', $userId)
            ->where('completed_at IS NOT NULL', null, false)
            ->where('score IS NOT NULL', null, false)
            ->orderBy('completed_at', 'DESC')
            ->findAll(8);
        $trendRows = array_reverse($trendRowsDesc);
        $trendLabels = [];
        $trendScores = [];
        foreach ($trendRows as $r) {
            $trendLabels[] = date('M j', strtotime($r['completed_at']));
            $trendScores[] = (float) $r['score'];
        }

        // Recent attempts
        $recentAttempts = $this->attempts
            ->where('user_id', $userId)
            ->orderBy('id', 'DESC')
            ->findAll(5);

        $data['metrics'] = [
            'testsTaken' => $testsTaken,
            'averageScore' => $avgScore,
            'lastTestAt' => $lastTestAt,
            'studyHours' => $studyHours,
            'daysRemaining' => $daysRemaining,
        ];
        $data['trend'] = [
            'labels' => $trendLabels,
            'scores' => $trendScores,
        ];
        $data['recentAttempts'] = $recentAttempts;

        return view('client/layout/header', $data)
            . view('client/dashboard/index', $data)
            . view('client/layout/footer');
    }

    public function profile()
    {
        $userId = (int) ($this->session->get('user_id') ?? 0);
        if (!$userId) return redirect()->to('/login/student');

        $user = $this->userModel->find($userId);
        $data = [
            'title' => 'My Profile',
            'user' => $user,
        ];
        return view('client/layout/header', $data)
            . view('client/profile', $data)
            . view('client/layout/footer');
    }

    public function updateProfile()
    {
        $userId = (int) ($this->session->get('user_id') ?? 0);
        if (!$userId) return redirect()->to('/login/student');

        $rules = [
            'first_name' => 'required|min_length[2]',
            'email' => 'required|valid_email',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $first = $this->request->getPost('first_name');
        $email = $this->request->getPost('email');
        $this->userModel->update($userId, [
            'first_name' => $first,
            'email' => $email,
        ]);
        session()->set('username', $first);
        session()->set('user_email', $email);
        return redirect()->to('/client/profile')->with('message', 'Profile updated');
    }

    public function changePassword()
    {
        $userId = (int) ($this->session->get('user_id') ?? 0);
        if (!$userId) return redirect()->to('/login/student');

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];
        $messages = [
            'confirm_password' => [
                'matches' => 'Passwords do not match'
            ]
        ];
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find($userId);
        $current = $this->request->getPost('current_password');
        if (!isset($user['password_hash']) || !password_verify($current, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Current password is incorrect');
        }
        $new = $this->request->getPost('new_password');
        $this->userModel->update($userId, [
            'password_hash' => password_hash($new, PASSWORD_DEFAULT)
        ]);
        return redirect()->to('/client/profile')->with('message', 'Password updated');
    }

    // removed duplicate legacy methods
}