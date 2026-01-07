<?php
namespace App\Models;

use CodeIgniter\Model;

class StudyQuestionModel extends Model
{
    protected $table = 'study_questions';
    protected $primaryKey = 'id';
    protected $allowedFields = ['subcategory_id', 'study_question_category_id', 'stem', 'image_path', 'rationale', 'created_by'];
    protected $useTimestamps = true;
}

