<?php namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'category_id', 'stock'];
    protected $returnType = 'object'; // Can be 'array' or custom object
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation configuration
    protected $validationRules = [
        'name'  => 'required|min_length[3]|max_length[255]',
        'price' => 'required|decimal',
        'stock' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required',
            'min_length' => 'Name must be at least 3 characters'
        ],
        'price' => [
            'decimal' => 'Price must contain a valid decimal value'
        ]
    ];

    // Sample custom method to get expensive products
    public function getExpensiveProducts(float $minPrice = 100)
    {
        return $this->where('price >=', $minPrice)
                    ->orderBy('price', 'DESC')
                    ->findAll();
    }

    // Sample method to reduce stock
    public function reduceStock(int $productId, int $quantity = 1)
    {
        return $this->set('stock', "stock - $quantity", false)
                    ->where('id', $productId)
                    ->update();
    }
}