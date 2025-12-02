<?php

namespace App\Models;

use CodeIgniter\Model;

class StudyBankPdfModel extends Model
{
    protected $table = 'study_bank_pdfs';
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

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}

