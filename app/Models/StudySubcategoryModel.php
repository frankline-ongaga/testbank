<?php
namespace App\Models;

use CodeIgniter\Model;

class StudySubcategoryModel extends Model
{
    protected $table = 'study_subcategories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['category_id', 'name', 'slug', 'description'];
    protected $useTimestamps = true;
}



