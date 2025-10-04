<?php

namespace App\Models;

use CodeIgniter\Model;

class NoteCategoryModel extends Model
{
    protected $table = 'note_categories';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'name',
        'description',
        'slug',
        'order'
    ];

    protected $validationRules = [
        'name' => 'required|min_length[3]|is_unique[note_categories.name,id,{id}]',
        'slug' => 'required|alpha_dash|is_unique[note_categories.slug,id,{id}]'
    ];

    public function getActiveCategories()
    {
        return $this->orderBy('order', 'ASC')
                    ->findAll();
    }
}