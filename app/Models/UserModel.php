<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'google_id',
        'status',
        'reset_token',
        'reset_expires_at',
    ];

    public function findByEmail(string $email): ?array
    {
        $user = $this->where('email', $email)->first();
        return $user ?: null;
    }

    public function assignRole(int $userId, string $roleName): bool
    {
        $db = \Config\Database::connect();
        $role = $db->table('roles')->where('name', $roleName)->get()->getRowArray();
        if (!$role) {
            return false;
        }
        return (bool) $db->table('user_roles')->insert([
            'user_id' => $userId,
            'role_id' => $role['id'],
        ]);
    }

    public function getUserRoles(int $userId): array
    {
        $db = \Config\Database::connect();
        $builder = $db->table('user_roles ur')
            ->select('r.name')
            ->join('roles r', 'r.id = ur.role_id', 'inner')
            ->where('ur.user_id', $userId);

        $rows = $builder->get()->getResultArray();
        return array_map(static fn($r) => $r['name'], $rows);
    }
}




