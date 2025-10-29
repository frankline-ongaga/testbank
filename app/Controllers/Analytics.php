<?php

namespace App\Controllers;

use App\Libraries\RoleSession;
use App\Models\TestModel;
use App\Models\UserModel;
use App\Models\AttemptModel;

class Analytics extends BaseController
{
    protected $roleSession;
    protected $testModel;
    protected $userModel;
    protected $attemptModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->roleSession = new RoleSession();
        $this->testModel = new TestModel();
        $this->userModel = new UserModel();
        $this->attemptModel = new AttemptModel();
    }

    public function index()
    {
        $currentRole = session()->get('current_role');
        
        if (!$currentRole) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();
        $userId = (int) (session()->get('user_id') ?? 0);

        // Shared metrics
        $totalTests = $this->testModel->countAllResults();
        $totalAttempts = $currentRole === 'client' && $userId
            ? $this->attemptModel->where('user_id', $userId)->countAllResults()
            : $this->attemptModel->countAllResults();
        $avgScoreRow = $this->attemptModel->select('AVG(score) as avg_score');
        if ($currentRole === 'client' && $userId) {
            $avgScoreRow->where('user_id', $userId);
        }
        $avgScore = (float) ($avgScoreRow->get()->getRow()->avg_score ?? 0);

        // Active users last 30 days (distinct users who attempted)
        $since30 = date('Y-m-d 00:00:00', strtotime('-30 days'));
        $activeUsersRow = $db->table('attempts')->select('COUNT(DISTINCT user_id) AS cnt')->where('created_at >=', $since30)->get()->getRowArray();
        $activeUsers = (int) ($activeUsersRow['cnt'] ?? 0);

        // Questions used percent
        $totalQuestions = $db->table('questions')->countAllResults();
        $usedQuestionsRow = $db->table('attempt_answers')->select('COUNT(DISTINCT question_id) AS cnt')->get()->getRowArray();
        $questionsUsedPct = $totalQuestions ? round(((int)($usedQuestionsRow['cnt'] ?? 0)) / $totalQuestions * 100, 1) : 0.0;

        // Recent attempts list (admin/global or client-specific)
        if ($currentRole === 'client' && $userId) {
            $recentAttempts = $this->attemptModel->where('user_id', $userId)->orderBy('id', 'DESC')->findAll(10);
        } else {
            $recentAttempts = $db->table('attempts a')
                ->select('a.*, u.email as user_email, u.first_name as user_first_name, t.title as test_title')
                ->join('users u', 'u.id = a.user_id', 'left')
                ->join('tests t', 't.id = a.test_id', 'left')
                ->orderBy('a.id', 'DESC')
                ->limit(10)
                ->get()->getResultArray();
        }

        // Category performance (NCLEX taxonomy): question count, avg correctness, usage
        $categories = [];
        try {
            $rows = $db->table('taxonomy_terms t')
                ->select('t.id, t.name, COUNT(DISTINCT q.id) as questions, ROUND(AVG(aa.is_correct)*100, 0) as avg_score, COUNT(DISTINCT a.id) as attempts')
                ->join('question_terms qt', 'qt.term_id = t.id', 'left')
                ->join('questions q', 'q.id = qt.question_id', 'left')
                ->join('attempt_answers aa', 'aa.question_id = q.id', 'left')
                ->join('attempts a', 'a.id = aa.attempt_id', 'left')
                ->where('t.type', 'nclex')
                ->groupBy('t.id')
                ->orderBy('attempts', 'DESC')
                ->limit(6)
                ->get()->getResultArray();
            $maxAttempts = 0;
            foreach ($rows as $r) { $maxAttempts = max($maxAttempts, (int)($r['attempts'] ?? 0)); }
            foreach ($rows as $r) {
                $usage = $maxAttempts ? round(((int)($r['attempts'] ?? 0)) / $maxAttempts * 100) : 0;
                $categories[] = [
                    'name' => $r['name'] ?? 'Unknown',
                    'questions' => (int)($r['questions'] ?? 0),
                    'avg_score' => (int)($r['avg_score'] ?? 0),
                    'usage' => $usage,
                    'trend' => 0,
                ];
            }
        } catch (\Throwable $e) {
            // Fallback: empty categories if mapping tables not present
            $categories = [];
        }

        // Monthly stats for charts
        $monthlyStats = $this->buildMonthlyStats($currentRole, $userId);

        // Client & Payments tab metrics
        $now = date('Y-m-d H:i:s');
        // Total clients (students)
        $studentRow = $db->table('users u')
            ->select('COUNT(DISTINCT u.id) AS cnt')
            ->join('user_roles ur', 'ur.user_id = u.id', 'inner')
            ->join('roles r', 'r.id = ur.role_id', 'inner')
            ->where('r.name', 'student')
            ->get()->getRowArray();
        $totalClients = (int) ($studentRow['cnt'] ?? 0);

        // Active subscriptions
        $activeSubsRow = $db->table('subscriptions')
            ->select('COUNT(*) AS cnt')
            ->where('status', 'active')
            ->where('start_at <=', $now)
            ->where('end_at >=', $now)
            ->get()->getRowArray();
        $activeSubscriptions = (int) ($activeSubsRow['cnt'] ?? 0);

        // Subscribed vs Unsubscribed clients
        $subscribedRow = $db->table('subscriptions')
            ->select('COUNT(DISTINCT user_id) AS cnt')
            ->where('status', 'active')
            ->where('start_at <=', $now)
            ->where('end_at >=', $now)
            ->get()->getRowArray();
        $subscribedClients = (int) ($subscribedRow['cnt'] ?? 0);
        $unsubscribedClients = max(0, $totalClients - $subscribedClients);

        // Payments KPIs
        $revenue30Row = $db->table('payments')->selectSum('amount')->where('created_at >=', $since30)->where('status', 'COMPLETED')->get()->getRowArray();
        $revenue30d = (float) ($revenue30Row['amount'] ?? 0);
        $avgOrder30Row = $db->table('payments')->selectAvg('amount')->where('created_at >=', $since30)->where('status', 'COMPLETED')->get()->getRowArray();
        $avgOrder30d = (float) ($avgOrder30Row['amount'] ?? 0);
        $failed30Row = $db->table('payments')->select('COUNT(*) AS cnt')->where('created_at >=', $since30)->where('status !=', 'COMPLETED')->get()->getRowArray();
        $failedPayments30d = (int) ($failed30Row['cnt'] ?? 0);

        $latestPayments = $db->table('payments p')
            ->select('p.*, u.email as user_email, u.first_name as user_first_name, s.plan as subscription_plan')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->join('subscriptions s', 's.id = p.subscription_id', 'left')
            ->orderBy('p.created_at', 'DESC')
            ->limit(10)
            ->get()->getResultArray();

        // Package performance by plan
        $packagePerformance = [];
        // Active clients by plan
        $activeByPlan = $db->table('subscriptions')
            ->select('plan, COUNT(DISTINCT user_id) AS active_clients')
            ->where('status', 'active')
            ->where('start_at <=', $now)
            ->where('end_at >=', $now)
            ->groupBy('plan')->get()->getResultArray();
        foreach ($activeByPlan as $row) {
            $plan = $row['plan'] ?? 'unknown';
            $packagePerformance[$plan]['active_clients'] = (int) ($row['active_clients'] ?? 0);
        }
        // Total subscriptions by plan
        $totalByPlan = $db->table('subscriptions')
            ->select('plan, COUNT(*) AS total_subscriptions')
            ->groupBy('plan')->get()->getResultArray();
        foreach ($totalByPlan as $row) {
            $plan = $row['plan'] ?? 'unknown';
            $packagePerformance[$plan]['total_subscriptions'] = (int) ($row['total_subscriptions'] ?? 0);
        }
        // Revenue and counts by plan (last 30 days)
        $revByPlan = $db->table('payments p')
            ->select('s.plan, SUM(p.amount) AS revenue_30d, COUNT(*) AS payments_30d, AVG(p.amount) AS avg_order_30d')
            ->join('subscriptions s', 's.id = p.subscription_id', 'left')
            ->where('p.created_at >=', $since30)
            ->where('p.status', 'COMPLETED')
            ->groupBy('s.plan')->get()->getResultArray();
        foreach ($revByPlan as $row) {
            $plan = $row['plan'] ?? 'unknown';
            $packagePerformance[$plan]['revenue_30d'] = (float) ($row['revenue_30d'] ?? 0);
            $packagePerformance[$plan]['payments_30d'] = (int) ($row['payments_30d'] ?? 0);
            $packagePerformance[$plan]['avg_order_30d'] = (float) ($row['avg_order_30d'] ?? 0);
        }

        $data = [
            'title' => 'Analytics',
            'total_tests' => $totalTests,
            'total_attempts' => $totalAttempts,
            'avg_score' => $avgScore,
            'active_users' => $activeUsers,
            'questions_used_pct' => $questionsUsedPct,
            'recent_attempts' => $recentAttempts,
            'categories' => $categories,
            'monthly_stats' => $monthlyStats,
            'question_stats' => [
                'easy' => 30,
                'medium' => 50,
                'hard' => 20
            ],
            'recent_activities' => [],
            // Clients & Payments tab data
            'total_clients' => $totalClients,
            'active_subscriptions' => $activeSubscriptions,
            'subscribed_clients' => $subscribedClients,
            'unsubscribed_clients' => $unsubscribedClients,
            'revenue_30d' => $revenue30d,
            'avg_order_30d' => $avgOrder30d,
            'failed_payments_30d' => $failedPayments30d,
            'latest_payments' => $latestPayments,
            'package_performance' => $packagePerformance,
        ];

        switch ($currentRole) {
            case 'admin':
                return view('admin/layout/header', $data)
                    . view('admin/analytics/index', $data)
                    . view('admin/layout/footer');
            case 'instructor':
                return view('instructor/layout/header', $data)
                    . view('instructor/analytics/index', $data)
                    . view('instructor/layout/footer');
            case 'client':
                return view('client/layout/header', $data)
                    . view('client/analytics/index', $data)
                    . view('client/layout/footer');
            default:
                return redirect()->to('/login');
        }
    }

    private function buildMonthlyStats(string $role, int $userId): array
    {
        $labels = [];
        $scores = [];
        $attempts = [];

        // Last 6 months buckets
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = date('Y-m-01 00:00:00', strtotime("-$i month"));
            $monthEnd = date('Y-m-t 23:59:59', strtotime("-$i month"));
            $labels[] = date('M', strtotime($monthStart));

            $builder = $this->attemptModel
                ->select('AVG(score) as avg_score, COUNT(*) as cnt')
                ->where('completed_at >=', $monthStart)
                ->where('completed_at <=', $monthEnd)
                ->where('score IS NOT NULL', null, false);
            if ($role === 'client' && $userId) {
                $builder->where('user_id', $userId);
            }
            $row = $builder->get()->getRowArray();
            $scores[] = isset($row['avg_score']) ? round((float)$row['avg_score']) : 0;
            $attempts[] = isset($row['cnt']) ? (int)$row['cnt'] : 0;
        }

        return [
            'labels' => $labels,
            'scores' => $scores,
            'attempts' => $attempts,
        ];
    }

    public function categories()
    {
        $currentRole = session()->get('current_role');
        
        if (!$currentRole) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Category Analytics',
            'categories' => [
                [
                    'name' => 'Medical-Surgical',
                    'questions' => 450,
                    'avg_score' => 78,
                    'usage' => 85,
                    'trend' => 5,
                    'details' => [
                        'easy_questions' => 150,
                        'medium_questions' => 200,
                        'hard_questions' => 100,
                        'total_attempts' => 2500,
                        'pass_rate' => 85
                    ]
                ],
                [
                    'name' => 'Pediatric Nursing',
                    'questions' => 320,
                    'avg_score' => 75,
                    'usage' => 70,
                    'trend' => 3,
                    'details' => [
                        'easy_questions' => 100,
                        'medium_questions' => 150,
                        'hard_questions' => 70,
                        'total_attempts' => 1800,
                        'pass_rate' => 80
                    ]
                ],
                [
                    'name' => 'Mental Health',
                    'questions' => 280,
                    'avg_score' => 72,
                    'usage' => 65,
                    'trend' => -2,
                    'details' => [
                        'easy_questions' => 90,
                        'medium_questions' => 130,
                        'hard_questions' => 60,
                        'total_attempts' => 1500,
                        'pass_rate' => 75
                    ]
                ]
            ]
        ];

        switch ($currentRole) {
            case 'admin':
                return view('admin/layout/header', $data)
                    . view('admin/analytics/categories', $data)
                    . view('admin/layout/footer');
            case 'instructor':
                return view('instructor/layout/header', $data)
                    . view('instructor/analytics/categories', $data)
                    . view('instructor/layout/footer');
            case 'client':
                return view('client/layout/header', $data)
                    . view('client/analytics/categories', $data)
                    . view('client/layout/footer');
            default:
                return redirect()->to('/login');
        }
    }
}