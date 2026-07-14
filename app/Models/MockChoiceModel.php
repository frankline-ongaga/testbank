<?php
namespace App\Models;

use CodeIgniter\Model;

class MockChoiceModel extends Model
{
    protected $table = 'mock_choices';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['question_id', 'label', 'content', 'is_correct', 'explanation'];
    protected $useTimestamps = true;
}
