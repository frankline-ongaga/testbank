<?php

namespace App\Models;

use CodeIgniter\Model;

class ExamProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'name',
        'slug',
        'short_name',
        'description',
        'monthly_price',
        'quarterly_price',
        'status',
        'sort_order',
    ];

    public function getActiveProducts(): array
    {
        return $this->where('status', 'active')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('name', 'ASC')
            ->findAll();
    }

    public function findBySlug(string $slug): ?array
    {
        $product = $this->where('slug', $slug)->first();
        return $product ?: null;
    }
}
