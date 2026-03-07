<?php
// =========================================
// Base Controller
// IntraCorp Portal (Vulnerable Edition)
// =========================================

class BaseController
{
    protected $db;

    public function __construct()
    {
        require_once '../Config/db_config.php';
        $this->db = new Database();
    }

    // Load model
    protected function model($model)
    {
        require_once '../app/Models/' . $model . '.php';
        return new $model();
    }

    // Load view
    protected function view($view, $data = [])
    {
        extract($data);
        require_once '../app/Views/' . $view . '.php';
    }

    // Redirect helper
    protected function redirect($url)
    {
        header('Location: ' . $url);
        exit();
    }

    // Check if user is logged in
    protected function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    // Get current user
    protected function getCurrentUser()
    {
        if ($this->isLoggedIn()) {
            return [
                'id'        => $_SESSION['user_id'],
                'username'  => $_SESSION['username'],
                'role'      => $_SESSION['role'],
                'full_name' => $_SESSION['full_name'],
            ];
        }
        return null;
    }

    // Check if user is admin (Vulnerable - can be bypassed)
    protected function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] == 'admin';
    }

    // Require login
    protected function requireLogin()
    {
        if (! $this->isLoggedIn()) {
            $this->redirect('index.php?controller=auth&action=login');
        }
    }

    // Require admin (Vulnerable - weak check)
    protected function requireAdmin()
    {
        if (! $this->isAdmin()) {
            $this->redirect('index.php?controller=dashboard&action=index');
        }
    }
}
