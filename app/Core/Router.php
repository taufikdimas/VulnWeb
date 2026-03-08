<?php
// =========================================
// Simple Router for MVC
// IntraCorp Portal (Vulnerable Edition)
// =========================================

class Router
{
    private $controller = 'AuthController';
    private $method     = 'login';
    private $params     = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        // Check for controller
        if (isset($_GET['controller'])) {
            $controller     = ucfirst($_GET['controller']) . 'Controller';
            $controllerFile = '../app/Controllers/' . $controller . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $controller;
                require_once $controllerFile;
            } else {
                $this->controller = 'AuthController';
                require_once '../app/Controllers/AuthController.php';
            }
        } else {
            require_once '../app/Controllers/AuthController.php';
        }

        // Instantiate controller
        $this->controller = new $this->controller;

        // Check for method
        if (isset($_GET['action'])) {
            if (method_exists($this->controller, $_GET['action'])) {
                $this->method = $_GET['action'];
            }
        }

        // Get params
        $this->params = $_GET;

        // Call method with params
        call_user_func_array([$this->controller, $this->method], [$this->params]);
    }

    private function parseUrl()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return explode('/', filter_var(rtrim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
