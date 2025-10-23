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

        // Get analytics data
        $userId = (int) (session()->get('user_id') ?? 0);
        $data = [
            'title' => 'Analytics',
            'total_tests' => $this->testModel->countAllResults(),
            'total_users' => $this->userModel->countAllResults(),
            'total_attempts' => $currentRole === 'client' && $userId ? $this->attemptModel->where('user_id', $userId)->countAllResults() : $this->attemptModel->countAllResults(),
            'avg_score' => ($currentRole === 'client' && $userId) ? ($this->attemptModel->select('AVG(score) as avg_score')->where('user_id', $userId)->get()->getRow()->avg_score ?? 0) : ($this->attemptModel->select('AVG(score) as avg_score')->get()->getRow()->avg_score ?? 0),
            'recent_attempts' => ($currentRole === 'client' && $userId) ? $this->attemptModel->where('user_id', $userId)->orderBy('id', 'DESC')->findAll(10) : $this->attemptModel->orderBy('id', 'DESC')->limit(10)->find(),
            // TODO: replace static category analytics with real joins once category mapping exists
            'categories' => [
                [
                    'name' => 'Medical-Surgical',
                    'questions' => 450,
                    'avg_score' => 78,
                    'usage' => 85,
                    'trend' => 5
                ],
                [
                    'name' => 'Pediatric Nursing',
                    'questions' => 320,
                    'avg_score' => 75,
                    'usage' => 70,
                    'trend' => 3
                ],
                [
                    'name' => 'Mental Health',
                    'questions' => 280,
                    'avg_score' => 72,
                    'usage' => 65,
                    'trend' => -2
                ]
            ],
            'monthly_stats' => $this->buildMonthlyStats($currentRole, $userId),
            'question_stats' => [
                'easy' => 30,
                'medium' => 50,
                'hard' => 20
            ],
            'recent_activities' => [
                [
                    'type' => 'test_created',
                    'title' => 'Medical-Surgical Assessment',
                    'time' => '3h ago'
                ],
                [
                    'type' => 'questions_updated',
                    'title' => '20 questions updated in Pediatrics',
                    'time' => '5h ago'
                ],
                [
                    'type' => 'new_users',
                    'title' => '15 new users registered',
                    'time' => '1d ago'
                ]
            ]
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