<?php
namespace App\Models;

use CodeIgniter\Model;

class StudyQuestionCategoryModel extends Model
{
    protected $table = 'study_question_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['subcategory_id', 'name', 'slug'];
    protected $useTimestamps = true;
}


