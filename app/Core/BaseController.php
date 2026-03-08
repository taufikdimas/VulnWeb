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
        $this->db = Database::getInstance();
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

    // Serve attachment from database (shared method)
    protected function serveAttachment($modelName, $id, $attachmentField = 'attachment_data', $mimeField = 'attachment_mime_type', $nameField = 'attachment')
    {
        $model      = $this->model($modelName);
        $methodName = 'get' . str_replace('Model', '', $modelName) . 'ById';
        $data       = $model->$methodName($id);

        if ($data && isset($data[$attachmentField]) && $data[$attachmentField]) {
            header('Content-Type: ' . ($data[$mimeField] ?? 'application/octet-stream'));
            header('Content-Disposition: inline; filename="' . ($data[$nameField] ?? 'file') . '"');
            header('Content-Length: ' . strlen($data[$attachmentField]));
            echo $data[$attachmentField];
            exit;
        } else {
            http_response_code(404);
            echo 'File not found';
            exit;
        }
    }

    // Serve profile picture from database (specialized helper)
    protected function serveProfilePicture($userId)
    {
        $this->serveAttachment('UserModel', $userId, 'profile_picture_data', 'profile_picture_mime_type', 'profile_picture');
    }
}
