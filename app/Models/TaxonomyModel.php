<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxonomyModel extends Model
{
    protected $table = 'taxonomy_terms';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['type', 'name', 'parent_id'];

    public function getTermsByType(string $type): array
    {
        return $this->where('type', $type)
            ->orderBy('name', 'ASC')
            ->findAll();
    }
}




