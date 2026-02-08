<?php

namespace App\Models;

use CodeIgniter\Model;

class CheatSheetModel extends Model
{
    protected $table = 'cheat_sheets';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'subcategory_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'created_by',
    ];
}

