<?php

namespace App\Models;

use CodeIgniter\Model;

class TestModel extends Model
{
    protected $table = 'tests';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'owner_id', 
        'title', 
        'mode', 
        'time_limit_minutes', 
        'is_adaptive',
        'is_free',
        'status'
    ];

    protected $validationRules = [
        'title' => 'required|min_length[3]',
        'mode' => 'required|in_list[practice,evaluation]',
        'status' => 'required|in_list[draft,pending,active,inactive]'
    ];

    /**
     * Get tests with question counts
     */
    public function getTestsWithCounts()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        $products = $this->productListSubquery();
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count, COALESCE(tp.product_names, "") as product_names, COALESCE(tp.product_slugs, "") as product_slugs')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->join($products, 'tp.test_id = tests.id', 'left')
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get tests for a specific owner with question counts
     */
    public function getOwnerTests($ownerId)
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        $products = $this->productListSubquery();
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count, COALESCE(tp.product_names, "") as product_names, COALESCE(tp.product_slugs, "") as product_slugs')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->join($products, 'tp.test_id = tests.id', 'left')
                    ->where('tests.owner_id', $ownerId)
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get active tests with question counts
     */
    public function getActiveTests()
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        $products = $this->productListSubquery();
        
        return $this->select('tests.*, COALESCE(q.question_count, 0) as question_count, COALESCE(tp.product_names, "") as product_names, COALESCE(tp.product_slugs, "") as product_slugs')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->join($products, 'tp.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->orderBy('tests.id', 'DESC')
                    ->findAll();
    }

    /**
     * Get active FREE tests with question counts
     */
    public function getActiveFreeTests(?array $productIds = null)
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        $products = $this->productListSubquery();
        
        $builder = $this->select('tests.*, COALESCE(q.question_count, 0) as question_count, COALESCE(tp.product_names, "") as product_names, COALESCE(tp.product_slugs, "") as product_slugs')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->join($products, 'tp.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->where('tests.is_free', 1);

        $this->applyProductFilter($builder, $productIds);

        return $builder->orderBy('tests.id', 'DESC')->findAll();
    }

    /**
     * Get active PAID tests with question counts
     */
    public function getActivePaidTests(?array $productIds = null)
    {
        $subquery = "(SELECT test_id, COUNT(*) as question_count FROM test_questions GROUP BY test_id) as q";
        $products = $this->productListSubquery();
        
        $builder = $this->select('tests.*, COALESCE(q.question_count, 0) as question_count, COALESCE(tp.product_names, "") as product_names, COALESCE(tp.product_slugs, "") as product_slugs')
                    ->join($subquery, 'q.test_id = tests.id', 'left')
                    ->join($products, 'tp.test_id = tests.id', 'left')
                    ->where('tests.status', 'active')
                    ->where('tests.is_free', 0);

        $this->applyProductFilter($builder, $productIds);

        return $builder->orderBy('tests.id', 'DESC')->findAll();
    }

    public function getProductIds(int $testId): array
    {
        $rows = $this->db->table('test_products')
            ->select('product_id')
            ->where('test_id', $testId)
            ->get()
            ->getResultArray();

        return array_map('intval', array_column($rows, 'product_id'));
    }

    public function syncProducts(int $testId, array $productIds): void
    {
        $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        $table = $this->db->table('test_products');
        $table->where('test_id', $testId)->delete();

        if (empty($productIds)) {
            return;
        }

        $now = date('Y-m-d H:i:s');
        $rows = [];
        foreach ($productIds as $productId) {
            $rows[] = [
                'test_id' => $testId,
                'product_id' => $productId,
                'created_at' => $now,
            ];
        }

        $table->insertBatch($rows);
    }

    protected function productListSubquery(): string
    {
        return "(SELECT tp.test_id, GROUP_CONCAT(p.name ORDER BY p.sort_order SEPARATOR ', ') as product_names, GROUP_CONCAT(p.slug ORDER BY p.sort_order SEPARATOR ',') as product_slugs FROM test_products tp INNER JOIN products p ON p.id = tp.product_id GROUP BY tp.test_id) as tp";
    }

    protected function applyProductFilter($builder, ?array $productIds): void
    {
        if ($productIds === null) {
            return;
        }

        $productIds = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        if (empty($productIds)) {
            $builder->where('1 =', 0, false);
            return;
        }

        $builder->whereIn('tests.id', static function ($subquery) use ($productIds) {
            $subquery->select('test_id')
                ->from('test_products')
                ->whereIn('product_id', $productIds);
        });
    }
}
