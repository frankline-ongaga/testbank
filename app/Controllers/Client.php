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