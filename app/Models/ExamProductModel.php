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
        'annual_price',
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

    public static function accessPlans(array $product): array
    {
        $plans = [
            'monthly' => [
                'label' => '1 Month',
                'amount' => (float) $product['monthly_price'],
                'stored_plan' => '1-month',
                'period' => '+30 days',
                'access' => '30 days',
            ],
            'quarterly' => [
                'label' => '3 Months',
                'amount' => (float) $product['quarterly_price'],
                'stored_plan' => '3-month',
                'period' => '+90 days',
                'access' => '90 days',
            ],
        ];

        if (($product['slug'] ?? '') === 'nclex' && (float) ($product['annual_price'] ?? 0) > 0) {
            $plans['annual'] = [
                'label' => '12 Months',
                'amount' => (float) $product['annual_price'],
                'stored_plan' => '12-month',
                'period' => '+12 months',
                'access' => '12 months',
            ];
        }

        return $plans;
    }

    public static function findAccessPlan(array $product, string $plan): ?array
    {
        $key = [
            '1-month' => 'monthly',
            '3-month' => 'quarterly',
            '12-month' => 'annual',
        ][$plan] ?? $plan;

        return self::accessPlans($product)[$key] ?? null;
    }
}
