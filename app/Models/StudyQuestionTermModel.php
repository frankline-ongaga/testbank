<?php
namespace App\Models;

use CodeIgniter\Model;

class StudyQuestionTermModel extends Model
{
    protected $table = 'study_question_terms';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question_id', 'term_id'];
}


