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
            'monthly_stats' => [
                'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                'scores' => [72, 75, 73, 76, 75, 78],
                'attempts' => [150, 165, 180, 175, 190, 200]
            ],
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