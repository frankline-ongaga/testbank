<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id','product_id','plan','status','paypal_order_id','amount','currency','start_at','end_at'];

    public function getActiveForUser(int $userId, ?int $productId = null): ?array
    {
        $now = date('Y-m-d H:i:s');
        $builder = $this->where('user_id', $userId)
            ->where('status', 'active')
            ->where('start_at <=', $now)
            ->where('end_at >=', $now);

        if ($productId !== null) {
            $builder->where('product_id', $productId);
        }

        $row = $builder->orderBy('id','DESC')->first();
        return $row ?: null;
    }

    public function getActiveProductsForUser(int $userId): array
    {
        $now = date('Y-m-d H:i:s');

        return $this->select('subscriptions.*, products.name as product_name, products.slug as product_slug, products.short_name as product_short_name')
            ->join('products', 'products.id = subscriptions.product_id', 'left')
            ->where('subscriptions.user_id', $userId)
            ->where('subscriptions.status', 'active')
            ->where('subscriptions.start_at <=', $now)
            ->where('subscriptions.end_at >=', $now)
            ->orderBy('subscriptions.end_at', 'DESC')
            ->findAll();
    }
}




