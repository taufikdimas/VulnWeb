<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - IntraCorp Portal</title>
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
        .reset-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: none;
            overflow: hidden;
        }
        .reset-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .btn-reset {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-reset:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        .password-wrapper {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
        }
        .password-toggle:hover {
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card reset-card">
                    <div class="reset-header">
                        <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">Reset Password</h3>
                        <p class="mb-0">Buat password baru Anda</p>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="text-center mb-4">Password Baru</h5>

                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <i class="bi bi-exclamation-triangle"></i> <?php echo $error ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($email)): ?>
                            <div class="alert alert-info mb-4">
                                <i class="bi bi-person"></i> Reset untuk: <strong><?php echo htmlspecialchars($email) ?></strong>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="index.php?controller=auth&action=resetPassword">
                            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token ?? '') ?>">

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-lock"></i> Password Baru
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control form-control-lg"
                                           id="newPassword" name="password"
                                           placeholder="Masukkan password baru" required>
                                    <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                </div>
                                <small class="text-muted">Gunakan password yang kuat dan mudah diingat</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="bi bi-lock-fill"></i> Konfirmasi Password
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control form-control-lg"
                                           id="confirmPassword"
                                           placeholder="Ketik ulang password" required>
                                    <i class="bi bi-eye password-toggle" id="toggleConfirm"></i>
                                </div>
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-reset">
                                    <i class="bi bi-check-circle"></i> Reset Password
                                </button>
                            </div>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a href="index.php?controller=auth&action=login" class="text-decoration-none">
                                <i class="bi bi-arrow-left"></i> Kembali ke Login
                            </a>
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
        const passwordInput = document.getElementById('newPassword');
        const toggleConfirm = document.getElementById('toggleConfirm');
        const confirmInput = document.getElementById('confirmPassword');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        toggleConfirm.addEventListener('click', function() {
            const type = confirmInput.type === 'password' ? 'text' : 'password';
            confirmInput.type = type;
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });

        // Validate password match
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('Password tidak cocok! Silakan coba lagi.');
                confirmInput.focus();
            }
        });
    </script>
</body>
</html>
