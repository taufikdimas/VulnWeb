<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IntraCorp Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            min-height: 100vh;
            padding: 40px 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .register-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: none;
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .register-header i {
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }
        .card-body {
            padding: 2.5rem;
        }
        .form-control, .form-select {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
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
        .btn-register {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .btn-register:hover {
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
            <div class="col-md-7">
                <div class="card register-card">
                    <div class="register-header">
                        <i class="bi bi-person-plus"></i>
                        <h2 class="mb-2">Create Account</h2>
                        <p class="mb-0 opacity-75">Join IntraCorp Portal</p>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center mb-4 fw-bold">Employee Registration</h4>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> <?php echo $error ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?controller=auth&action=register">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person"></i> Username *
                                    </label>
                                    <input type="text" class="form-control" name="username"
                                           placeholder="Choose a username" required autofocus>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-envelope"></i> Email *
                                    </label>
                                    <input type="email" class="form-control" name="email"
                                           placeholder="your.email@company.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-lock"></i> Password *
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control" id="password"
                                           name="password" placeholder="Create a strong password" required>
                                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-card-text"></i> Full Name *
                                </label>
                                <input type="text" class="form-control" name="full_name"
                                       placeholder="Enter your full name" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-building"></i> Department *
                                    </label>
                                    <select class="form-select" name="department" required>
                                        <option value="">Select Department</option>
                                        <option value="IT">IT</option>
                                        <option value="Finance">Finance</option>
                                        <option value="HR">HR</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Operations">Operations</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-telephone"></i> Phone
                                    </label>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Optional">
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-register">
                                    <i class="bi bi-check-circle"></i> Create Account
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <p class="mb-0">Already have an account?
                                <a href="index.php?controller=auth&action=login" class="fw-semibold">Sign In</a>
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
