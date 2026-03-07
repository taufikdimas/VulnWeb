<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IntraCorp Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .login-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: none;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .login-header i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        .card-body {
            padding: 2.5rem;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
        }
        .password-toggle:hover {
            color: #3b82f6;
        }
        .btn-login {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        .form-label {
            font-weight: 500;
            color: #334155;
            margin-bottom: 0.5rem;
        }
        a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s;
        }
        a:hover {
            color: #2563eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="bi bi-building"></i>
                        <h2 class="mb-2">IntraCorp Portal</h2>
                        <p class="mb-0 opacity-75">Employee Management System</p>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center mb-4 fw-bold">Welcome Back</h4>

                        <?php if (isset($error)): ?>
                            <div class="alert <?php echo isset($suspended) ? 'alert-warning' : 'alert-danger' ?> alert-dismissible fade show" role="alert">
                                <i class="bi <?php echo isset($suspended) ? 'bi-ban' : 'bi-exclamation-triangle' ?>"></i>
                                <strong><?php echo isset($suspended) ? 'Account Suspended' : 'Error' ?></strong><br>
                                <?php echo $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle"></i> <?php echo $success ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?controller=auth&action=login">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-person"></i> Username
                                </label>
                                <input type="text" class="form-control" name="username"
                                       placeholder="Enter your username" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-lock"></i> Password
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control" id="password"
                                           name="password" placeholder="Enter your password" required>
                                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">
                                        Remember me
                                    </label>
                                </div>
                                <a href="index.php?controller=auth&action=forgotPassword" class="small">
                                    Forgot Password?
                                </a>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-login">
                                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Don't have an account?
                                <a href="index.php?controller=auth&action=register" class="fw-semibold">Sign Up</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
