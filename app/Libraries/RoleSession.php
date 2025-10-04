<?php

namespace App\Libraries;

use Config\Services;

class RoleSession
{
    private static $cookieNames = [
        'admin' => 'ci_session_admin',
        'instructor' => 'ci_session_instructor',
        'client' => 'ci_session_client'
    ];

    private $session;
    private $currentRole;

    public function __construct()
    {
        $this->session = Services::session();
    }

    public function startSession($role)
    {
        if (!isset(static::$cookieNames[$role])) {
            throw new \InvalidArgumentException('Invalid role: ' . $role);
        }

        $this->currentRole = $role;

        // Get the session config
        $config = config('Session');
        
        // Set role-specific cookie name
        $config->cookieName = static::$cookieNames[$role];
        
        // Set role-specific save path
        $config->savePath = WRITEPATH . 'session/' . $role;
        
        // Ensure directory exists
        if (!is_dir($config->savePath)) {
            mkdir($config->savePath, 0700, true);
        }

        // Close any active session so ini settings can change (CSRF may have started default session)
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }

        // Create a SHARED session instance so calls to session() return this role-specific session
        $this->session = Services::session($config, true);
        if (session_status() !== PHP_SESSION_ACTIVE) {
            $this->session->start();
        }

        return $this;
    }

    /**
     * Set session data
     * @param string|array $key Key or array of key-value pairs
     * @param mixed $value Value (optional if $key is array)
     * @return $this
     */
    public function setData($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $this->session->set($key, $value);
            }
        } else {
            $this->session->set($data, func_get_arg(1));
        }
        return $this;
    }

    /**
     * Get session data
     * @param string $key
     * @return mixed
     */
    public function getData($key)
    {
        return $this->session->get($key);
    }

    /**
     * Remove session data
     * @param string $key
     * @return $this
     */
    public function removeData($key)
    {
        $this->session->remove($key);
        return $this;
    }

    /**
     * Destroy the current session
     */
    public function destroy()
    {
        if ($this->currentRole && isset(static::$cookieNames[$this->currentRole])) {
            $this->session->destroy();
        }
    }

    /**
     * Get current role
     * @return string|null
     */
    public function getCurrentRole()
    {
        return $this->currentRole;
    }
}