<?php

namespace App\Models;

use CodeIgniter\Model;

class ChoiceModel extends Model
{
    protected $table = 'choices';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'question_id', 'label', 'content', 'is_correct'
    ];
}




