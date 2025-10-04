<?php
namespace App\Models;

use CodeIgniter\Model;

class StudyChoiceModel extends Model
{
    protected $table = 'study_choices';
    protected $primaryKey = 'id';
    protected $allowedFields = ['question_id', 'label', 'content', 'is_correct', 'explanation'];
    protected $useTimestamps = true;
}



