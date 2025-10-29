<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
    protected $table = 'tests';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'owner_id', 
        'title', 
        'mode', 
        'time_limit_minutes', 
        'is_adaptive',
        'is_free',
        'status'
    ];

    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'mode' => 'required|in_list[practice,evaluation]',
        'status' => 'required|in_list[draft,pending,active,inactive]'
    ];

    /**
     * Get tests with question counts
     */
    public function getTestsWithCounts()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get tests for a specific owner with question counts
     */
    public function getOwnerTests($ownerId)
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->where('tests.owner_id', $ownerId)
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get active tests with question counts
     */
    public function getActiveTests()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get active FREE tests with question counts
     */
    public function getActiveFreeTests()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->where('tests.is_free', 1)
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get active PAID tests with question counts
     */
    public function getActivePaidTests()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->where('tests.is_free', 0)
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }
}