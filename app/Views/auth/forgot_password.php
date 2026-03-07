<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - IntraCorp Portal</title>
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
        .forgot-card {
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            border: none;
            overflow: hidden;
        }
        .forgot-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }
        .btn-submit {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        .token-box {
            background: #f8fafc;
            border: 2px dashed #3b82f6;
            border-radius: 10px;
            padding: 1rem;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card forgot-card">
                    <div class="forgot-header">
                        <i class="bi bi-key" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">Lupa Password</h3>
                        <p class="mb-0">Reset password Anda</p>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($success) && $success): ?>
                            <div class="alert alert-success" role="alert">
                                <i class="bi bi-check-circle"></i> <strong>Link Reset Berhasil Dibuat!</strong>
                            </div>

                            <div class="mb-3">
                                <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($email) ?></p>
                                <p class="mb-2"><strong>Token Reset:</strong></p>
                                <div class="token-box">
                                    <code><?php echo htmlspecialchars($token) ?></code>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Klik tombol di bawah untuk reset password:
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <a href="<?php echo htmlspecialchars($link) ?>" class="btn btn-primary btn-submit">
                                    <i class="bi bi-arrow-right-circle"></i> Reset Password Sekarang
                                </a>
                            </div>

                        <?php else: ?>
                            <h5 class="text-center mb-4">Masukkan Email Anda</h5>

                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle"></i> <?php echo $error ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="index.php?controller=auth&action=forgotPassword">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-envelope"></i> Email Address
                                    </label>
                                    <input type="email" class="form-control form-control-lg" name="email"
                                           placeholder="nama@perusahaan.com" required>
                                    <small class="text-muted">Masukkan email yang terdaftar di sistem</small>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-submit">
                                        <i class="bi bi-send"></i> Kirim Link Reset
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

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
</body>
</html>
