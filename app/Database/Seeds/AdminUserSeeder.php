<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('Admin@12345', PASSWORD_DEFAULT);

        $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password_hash' => $password,
            'status' => 'active',
            'created_at' => Time::now()->toDateTimeString(),
        ]);

        $adminRole = $this->db->table('roles')->where('name', 'admin')->get()->getRowArray();
        $adminUser = $this->db->table('users')->where('email', 'admin@example.com')->get()->getRowArray();

        if ($adminRole && $adminUser) {
            $this->db->table('user_roles')->insert([
                'user_id' => $adminUser['id'],
                'role_id' => $adminRole['id'],
            ]);
        }
    }
}





