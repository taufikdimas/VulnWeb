<?php
    $pageTitle  = 'Change Password';
    $activePage = '';

    ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-key"></i> Change Password</h5>
            </div>
            <div class="card-body">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?php echo $success ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> <?php echo $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="index.php?controller=dashboard&action=changePassword">
                    <div class="mb-3">
                        <label class="form-label">Current Password *</label>
                        <input type="password" class="form-control" name="current_password" required>
                        <small class="text-muted">Enter your current password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password *</label>
                        <input type="password" class="form-control" name="new_password" required>
                        <small class="text-muted">Enter your new password</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password *</label>
                        <input type="password" class="form-control" name="confirm_password" required>
                        <small class="text-muted">Re-enter your new password</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Password
                        </button>
                        <a href="index.php?controller=dashboard&action=index" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back to Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-shield-check"></i> Password Security Tips</h6>
                <ul class="small text-muted mb-0">
                    <li>Use a strong password with at least 8 characters</li>
                    <li>Include uppercase, lowercase, numbers, and symbols</li>
                    <li>Don't use common words or personal information</li>
                    <li>Change your password regularly</li>
                    <li>Don't share your password with anyone</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/user_layout.php';
?>
