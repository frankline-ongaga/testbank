<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExamProducts extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TABLE IF NOT EXISTS products (
                id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(120) NOT NULL,
                slug VARCHAR(80) NOT NULL,
                short_name VARCHAR(40) NULL,
                description TEXT NULL,
                monthly_price DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                quarterly_price DECIMAL(8,2) NOT NULL DEFAULT 0.00,
                status ENUM('active','inactive') NOT NULL DEFAULT 'active',
                sort_order INT(11) NOT NULL DEFAULT 0,
                created_at DATETIME NULL,
                updated_at DATETIME NULL,
                PRIMARY KEY (id),
                UNIQUE KEY products_slug_unique (slug)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $now = date('Y-m-d H:i:s');
        $products = [
            ['NCLEX', 'nclex', 'NCLEX', 'NCLEX practice tests, rationales, and review resources.', 49.00, 99.00, 1],
            ['ATI TEAS 7', 'ati-teas-7', 'TEAS 7', 'ATI TEAS 7 preparation tests and review resources.', 30.00, 50.00, 2],
            ['HESI', 'hesi', 'HESI', 'HESI preparation tests and review resources.', 30.00, 50.00, 3],
        ];

        foreach ($products as $product) {
            $this->db->query(
                "INSERT INTO products (name, slug, short_name, description, monthly_price, quarterly_price, status, sort_order, created_at, updated_at)
                 VALUES (?, ?, ?, ?, ?, ?, 'active', ?, ?, ?)
                 ON DUPLICATE KEY UPDATE
                    name = VALUES(name),
                    short_name = VALUES(short_name),
                    description = VALUES(description),
                    monthly_price = VALUES(monthly_price),
                    quarterly_price = VALUES(quarterly_price),
                    status = 'active',
                    sort_order = VALUES(sort_order),
                    updated_at = VALUES(updated_at)",
                [$product[0], $product[1], $product[2], $product[3], $product[4], $product[5], $product[6], $now, $now]
            );
        }

        if ($this->db->tableExists('subscriptions')) {
            if (!$this->db->fieldExists('product_id', 'subscriptions')) {
                $this->forge->addColumn('subscriptions', [
                    'product_id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'null' => true,
                        'after' => 'user_id',
                    ],
                ]);
            }

            try {
                $this->db->query("ALTER TABLE subscriptions MODIFY plan VARCHAR(32) NOT NULL");
            } catch (\Throwable $e) {
                log_message('warning', 'Unable to normalize subscription plan column: {message}', ['message' => $e->getMessage()]);
            }

            $nclexId = $this->db->table('products')->select('id')->where('slug', 'nclex')->get()->getRow('id');
            if ($nclexId) {
                $this->db->table('subscriptions')->where('product_id', null)->update(['product_id' => (int) $nclexId]);
            }

            try {
                $this->db->query('ALTER TABLE subscriptions ADD INDEX subscriptions_product_id_index (product_id)');
            } catch (\Throwable $e) {
                // Already present in some local databases.
            }

            try {
                $this->db->query('ALTER TABLE subscriptions ADD CONSTRAINT subscriptions_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL ON UPDATE CASCADE');
            } catch (\Throwable $e) {
                // Already present in some local databases.
            }
        }

        $this->db->query("
            CREATE TABLE IF NOT EXISTS test_products (
                test_id INT(11) UNSIGNED NOT NULL,
                product_id INT(11) UNSIGNED NOT NULL,
                created_at DATETIME NULL,
                PRIMARY KEY (test_id, product_id),
                KEY test_products_product_id_index (product_id),
                CONSTRAINT test_products_test_id_foreign FOREIGN KEY (test_id) REFERENCES tests(id) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT test_products_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");

        $nclexId = $this->db->table('products')->select('id')->where('slug', 'nclex')->get()->getRow('id');
        if ($nclexId && $this->db->tableExists('tests')) {
            $this->db->query(
                'INSERT IGNORE INTO test_products (test_id, product_id, created_at)
                 SELECT id, ?, ? FROM tests',
                [(int) $nclexId, $now]
            );
        }
    }

    public function down()
    {
        if ($this->db->tableExists('subscriptions') && $this->db->fieldExists('product_id', 'subscriptions')) {
            try {
                $this->db->query('ALTER TABLE subscriptions DROP FOREIGN KEY subscriptions_product_id_foreign');
            } catch (\Throwable $e) {
                // Ignore if missing.
            }

            try {
                $this->db->query('ALTER TABLE subscriptions DROP INDEX subscriptions_product_id_index');
            } catch (\Throwable $e) {
                // Ignore if missing.
            }

            $this->forge->dropColumn('subscriptions', 'product_id');
        }

        $this->forge->dropTable('test_products', true);
        $this->forge->dropTable('products', true);
    }
}
