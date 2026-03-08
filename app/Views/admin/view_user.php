<?php
    $pageTitle  = 'User Detail';
    $activePage = 'users';

    ob_start();
?>
<style>
.detail-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
}

.detail-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.detail-header {
    padding: 2rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.detail-header h5 {
    margin: 0;
    color: white;
    font-size: 1.25rem;
    font-weight: 600;
}

.detail-header .text-muted {
    color: rgba(255, 255, 255, 0.9) !important;
    font-size: 0.95rem;
}

.detail-header .badge {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.detail-content {
    padding: 2rem;
}

.detail-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 1.5rem;
    padding: 1.25rem 0;
    border-bottom: 1px solid #f1f5f9;
    align-items: start;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-label i {
    color: #94a3b8;
    font-size: 1rem;
    width: 18px;
    display: inline-flex;
    justify-content: center;
}

.detail-value {
    color: #1e293b;
    font-size: 0.95rem;
    word-break: break-word;
}

.detail-value .badge {
    padding: 0.4rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.detail-value .text-success,
.detail-value .text-danger {
    font-weight: 500;
}

.detail-value .text-muted {
    color: #64748b !important;
    font-size: 0.9rem;
}

.detail-value strong {
    color: #1e293b;
    font-weight: 600;
}

.detail-value a {
    color: #4299e1;
    transition: all 0.2s;
}

.detail-value a:hover {
    color: #3182ce;
}

.user-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    background: white;
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}

.action-button {
    height: 50px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none !important;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    text-decoration: none !important;
}

.action-button i {
    font-size: 1.1rem;
}

.btn-update {
    background-color: #0d6efd;
    color: white !important;
}

.btn-update:hover {
    background-color: #0b5ed7;
    color: white !important;
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4) !important;
}

.btn-delete {
    background-color: #dc3545;
    color: white !important;
}

.btn-delete:hover {
    background-color: #bb2d3b;
    color: white !important;
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4) !important;
}

.btn-disabled-full {
    background: #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
}

.btn-disabled-full:hover {
    transform: none;
    box-shadow: none;
}

@media (max-width: 768px) {
    .detail-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
        padding: 1rem 0;
    }

    .detail-label {
        font-size: 0.8rem;
    }

    .action-buttons {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .user-avatar-large {
        width: 80px;
        height: 80px;
    }

    .detail-header {
        padding: 1.5rem;
    }

    .detail-content {
        padding: 1.5rem;
    }
}
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="index.php?controller=admin&action=users" class="btn btn-link text-decoration-none ps-0">
                <i class="bi bi-arrow-left"></i> Back to Users List
            </a>
        </div>

        <!-- User Detail Card -->
        <div class="detail-card">
            <div class="detail-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <?php if (! empty($user['profile_picture'])): ?>
                        <img src="index.php?controller=admin&action=getProfilePicture&id=<?php echo $user['id'] ?>"
                            class="user-avatar-large me-4" alt="Profile Picture">
                        <?php else: ?>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']) ?>&size=100&background=fff&color=667eea&bold=true"
                            class="user-avatar-large me-4">
                        <?php endif; ?>
                        <div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($user['full_name']) ?></h5>
                            <span class="text-muted">@<?php echo htmlspecialchars($user['username']) ?></span>
                        </div>
                    </div>
                    <div>
                        <?php if ($user['is_active']): ?>
                        <span class="badge bg-success">
                            <i class="bi bi-check-circle-fill"></i> Active
                        </span>
                        <?php else: ?>
                        <span class="badge bg-danger">
                            <i class="bi bi-x-circle-fill"></i> Suspended
                        </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="detail-content">
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-hash"></i>User ID
                    </div>
                    <div class="detail-value">
                        <span class="badge bg-primary text-white" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">#<?php echo $user['id'] ?></span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-person"></i>Username
                    </div>
                    <div class="detail-value">
                        <strong><?php echo htmlspecialchars($user['username']) ?></strong>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-envelope"></i>Email
                    </div>
                    <div class="detail-value">
                        <a href="mailto:<?php echo htmlspecialchars($user['email']) ?>" class="text-decoration-none">
                            <i class="bi bi-envelope-fill me-1"></i><?php echo htmlspecialchars($user['email']) ?>
                        </a>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-person-badge"></i>Full Name
                    </div>
                    <div class="detail-value">
                        <strong><i class="bi bi-person-fill me-1"></i><?php echo htmlspecialchars($user['full_name']) ?></strong>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-shield"></i>Role
                    </div>
                    <div class="detail-value">
                        <?php if ($user['role'] == 'admin'): ?>
                        <span class="badge bg-danger">
                            <i class="bi bi-shield-fill-check"></i> Admin
                        </span>
                        <?php else: ?>
                        <span class="badge bg-primary">
                            <i class="bi bi-person-fill"></i> Employee
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-building"></i>Department
                    </div>
                    <div class="detail-value">
                        <span class="badge bg-light text-dark border" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                            <i class="bi bi-building-fill me-1"></i><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?>
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-telephone"></i>Phone
                    </div>
                    <div class="detail-value">
                        <?php if (! empty($user['phone'])): ?>
                        <a href="tel:<?php echo htmlspecialchars($user['phone']) ?>" class="text-decoration-none">
                            <i class="bi bi-telephone-fill me-1"></i><?php echo htmlspecialchars($user['phone']) ?>
                        </a>
                        <?php else: ?>
                        <span class="text-muted">N/A</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-calendar-check"></i>Account Status
                    </div>
                    <div class="detail-value">
                        <?php if ($user['is_active']): ?>
                        <span class="text-success fw-semibold">
                            <i class="bi bi-check-circle-fill me-1"></i> Active - User can login
                        </span>
                        <?php else: ?>
                        <span class="text-danger fw-semibold">
                            <i class="bi bi-x-circle-fill me-1"></i> Suspended - User cannot login
                        </span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-clock"></i>Last Login
                    </div>
                    <div class="detail-value">
                        <span class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?php echo $user['last_login'] ? date('d M Y, H:i', strtotime($user['last_login'])) : 'Never logged in' ?>
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-calendar-plus"></i>Created At
                    </div>
                    <div class="detail-value">
                        <span class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?php echo date('d M Y, H:i', strtotime($user['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="index.php?controller=admin&action=editUser&id=<?php echo $user['id'] ?>"
               class="action-button btn-update">
                <i class="bi bi-pencil-fill"></i> Update User
            </a>

            <?php if ($user['id'] != $_SESSION['user_id']): ?>
            <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['id'] ?>"
               class="action-button btn-delete"
               onclick="return confirm('Are you sure you want to delete user <?php echo htmlspecialchars($user['username']) ?>? This action cannot be undone.')">
                <i class="bi bi-trash-fill"></i> Delete User
            </a>
            <?php else: ?>
            <button class="action-button btn-disabled-full" disabled title="Cannot delete yourself">
                <i class="bi bi-lock-fill"></i> Cannot Delete Yourself
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>
