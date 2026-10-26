<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAnnualProductPricing extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('annual_price', 'products')) {
            $this->forge->addColumn('products', [
                'annual_price' => [
                    'type' => 'DECIMAL',
                    'constraint' => '8,2',
                    'null' => true,
                    'after' => 'quarterly_price',
                ],
            ]);
        }

        foreach (['ati-teas-7' => 99.00, 'nclex' => 179.00] as $slug => $price) {
            $this->db->table('products')->where('slug', $slug)->update([
                'annual_price' => $price,
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'annual_price');
    }
}
