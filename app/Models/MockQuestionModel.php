<?php
namespace App\Models;

use CodeIgniter\Model;

class MockQuestionModel extends Model
{
    protected $table = 'mock_questions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['subcategory_id', 'stem', 'image_path', 'rationale', 'created_by'];
    protected $useTimestamps = true;
}
