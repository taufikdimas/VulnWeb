<?php
// =========================================
// Auth Controller
// IntraCorp Portal (Vulnerable Edition)
// =========================================

require_once '../app/Core/BaseController.php';
require_once '../app/Models/UserModel.php';

class AuthController extends BaseController
{
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->userModel = new UserModel();
    }

    // Display login page
    public function login()
    {
        // If already logged in, redirect to dashboard
        if ($this->isLoggedIn()) {
            $this->redirect('index.php?controller=dashboard&action=index');
        }

        // Handle login form submission
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Vulnerable login - SQL Injection possible
            $user = $this->userModel->login($username, $password);

            if ($user) {
                // Check if account is active
                if (! $user['is_active']) {
                    $error = "Your account has been suspended. Please contact administrator.";
                    $this->view('auth/login', ['error' => $error, 'suspended' => true]);
                    return;
                }

                // Update last login
                $this->userModel->updateLastLogin($user['id']);

                // Set session
                $_SESSION['user_id']   = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['role']      = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['profile_picture'] = $user['profile_picture'] ?? null;

                // Redirect based on role
                if ($user['role'] == 'admin') {
                    $this->redirect('index.php?controller=admin&action=dashboard');
                } else {
                    $this->redirect('index.php?controller=dashboard&action=index');
                }
            } else {
                $error = "Invalid username or password";
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }

    // Display register page
    public function register()
    {
        // If already logged in, redirect
        if ($this->isLoggedIn()) {
            $this->redirect('index.php?controller=dashboard&action=index');
        }

        // Handle registration
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username'   => $_POST['username'],
                'email'      => $_POST['email'],
                'password'   => $_POST['password'], // Plain text - vulnerable
                'full_name'  => $_POST['full_name'],
                'department' => $_POST['department'],
                'phone'      => $_POST['phone'],
            ];

            // No validation - vulnerable
            $userId = $this->userModel->register($data);

            if ($userId) {
                $success = "Registration successful! Please login.";
                $this->view('auth/login', ['success' => $success]);
            } else {
                $error = "Registration failed";
                $this->view('auth/register', ['error' => $error]);
            }
        } else {
            $this->view('auth/register');
        }
    }

    // Forgot password - display form
    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];

            // Check if user exists (Vulnerable - user enumeration)
            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                                               // Generate weak token (Vulnerable - predictable token)
                $token = md5($email . time()); // Weak token generation

                // Save token to database
                $this->userModel->createPasswordReset($email, $token);

                // Generate reset link
                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php?controller=auth&action=resetPassword&token=$token";

                // Display token on screen (for educational purposes, no email needed)
                $this->view('auth/forgot_password', [
                    'success' => true,
                    'email'   => $email,
                    'token'   => $token,
                    'link'    => $resetLink,
                ]);
            } else {
                // Vulnerable - reveals if email exists
                $error = "Email tidak ditemukan dalam sistem.";
                $this->view('auth/forgot_password', ['error' => $error]);
            }
        } else {
            $this->view('auth/forgot_password');
        }
    }

    // Reset password with token
    public function resetPassword()
    {
        $token = $_GET['token'] ?? '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token       = $_POST['token'];
            $newPassword = $_POST['password'];

            // Verify token (Vulnerable - no expiration check)
            $resetData = $this->userModel->getPasswordResetByToken($token);

            if ($resetData) {
                // Reset password (Vulnerable - plain text password)
                $this->userModel->resetPassword($resetData['email'], $newPassword);

                // Delete token
                $this->userModel->deletePasswordReset($token);

                $success = "Password berhasil direset! Silakan login dengan password baru.";
                $this->view('auth/login', ['success' => $success]);
            } else {
                $error = "Token invalid atau sudah kadaluarsa.";
                $this->view('auth/reset_password', ['error' => $error, 'token' => $token]);
            }
        } else {
            // Verify token exists
            $resetData = $this->userModel->getPasswordResetByToken($token);

            if ($resetData) {
                $this->view('auth/reset_password', ['token' => $token, 'email' => $resetData['email']]);
            } else {
                $error = "Token invalid atau sudah kadaluarsa.";
                $this->view('auth/login', ['error' => $error]);
            }
        }
    }

    // Logout
    public function logout()
    {
        session_destroy();
        $this->redirect('index.php?controller=auth&action=login');
    }
}
