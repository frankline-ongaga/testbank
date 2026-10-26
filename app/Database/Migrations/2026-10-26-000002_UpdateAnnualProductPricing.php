<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAnnualProductPricing extends Migration
{
    public function up()
    {
        $this->db->table('products')->where('slug', 'nclex')->update([
            'annual_price' => 149.00,
        ]);
        $this->db->table('products')->where('slug !=', 'nclex')->update([
            'annual_price' => null,
        ]);
    }

    public function down()
    {
        foreach (['ati-teas-7' => 99.00, 'nclex' => 179.00] as $slug => $price) {
            $this->db->table('products')->where('slug', $slug)->update([
                'annual_price' => $price,
            ]);
        }
    }
}
