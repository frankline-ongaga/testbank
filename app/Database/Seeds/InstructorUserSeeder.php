<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class InstructorUserSeeder extends Seeder
{
    public function run()
    {
        $password = password_hash('Instructor@12345', PASSWORD_DEFAULT);

        // Create instructor user if not exists
        $user = $this->db->table('users')->where('email', 'instructor@example.com')->get()->getRowArray();
        if (!$user) {
            $this->db->table('users')->insert([
                'username' => 'instructor',
                'email' => 'instructor@example.com',
                'password_hash' => $password,
                'status' => 'active',
                'created_at' => Time::now()->toDateTimeString(),
            ]);
            $user = $this->db->table('users')->where('email', 'instructor@example.com')->get()->getRowArray();
        }

        // Assign instructor role
        $role = $this->db->table('roles')->where('name', 'instructor')->get()->getRowArray();
        if ($user && $role) {
            $exists = $this->db->table('user_roles')
                ->where('user_id', $user['id'])
                ->where('role_id', $role['id'])
                ->get()->getRowArray();
            if (!$exists) {
                $this->db->table('user_roles')->insert([
                    'user_id' => $user['id'],
                    'role_id' => $role['id'],
                ]);
            }
        }
    }
}




