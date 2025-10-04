<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscriptionModel extends Model
{
    protected $table = 'subscriptions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['user_id','plan','status','paypal_order_id','amount','currency','start_at','end_at'];

    public function getActiveForUser(int $userId): ?array
    {
        $now = date('Y-m-d H:i:s');
        $row = $this->where('user_id', $userId)
            ->where('status', 'active')
            ->where('start_at <=', $now)
            ->where('end_at >=', $now)
            ->orderBy('id','DESC')
            ->first();
        return $row ?: null;
    }
}




