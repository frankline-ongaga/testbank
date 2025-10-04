<?php
namespace App\Models;

use CodeIgniter\Model;

class StudyCategoryModel extends Model
{
    protected $table = 'study_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'slug', 'description'];
    protected $useTimestamps = true;
}



