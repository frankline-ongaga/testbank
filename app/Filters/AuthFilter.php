<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
 

class AuthFilter implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $uri = service('uri');
        $segments = $uri->getSegments();

        // If no segments, redirect to login
        if (empty($segments)) {
            return redirect()->to('/login')->with('error', 'Please login to continue');
        }

        // Determine role from URI (handle index.php prefix)
        $segmentIndex = 0;
        if (!empty($segments) && strtolower($segments[0]) === 'index.php') {
            $segmentIndex = 1;
        }
        $role = $segments[$segmentIndex] ?? '';
        if (!in_array($role, ['admin', 'instructor', 'client'])) {
            // Skip auth check for login routes
            if ($role === 'login') {
                return;
            }
            return redirect()->to('/login')->with('error', 'Invalid portal access');
        }

        // Check if user is logged in
        if (!session()->get('user_id')) {
            return redirect()->to('/login/' . $role)->with('error', 'Please login to continue');
        }

        // Check if user has the correct DB role for this portal
        // portal->db role mapping
        $portalToDbRole = [
            'admin' => 'admin',
            'instructor' => 'instructor',
            'client' => 'student',
        ];
        $requiredDbRole = $portalToDbRole[$role] ?? null;
        $userRoles = session()->get('roles');
        if (!$requiredDbRole || !is_array($userRoles) || !in_array($requiredDbRole, $userRoles)) {
            return redirect()->to('/login/' . $role)->with('error', 'You do not have access to this portal');
        }

        // Persist current portal for controllers/views that rely on it
        session()->set('current_role', $role);

        return true;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No-op
    }
}