<?php
    $pageTitle  = 'Admin Profile';
    $activePage = '';

    ob_start();
?>
<style>
.profile-img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    border: 5px solid #667eea;
}
</style>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <?php if (! empty($user['profile_picture'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($user['profile_picture']) ?>"
                    class="profile-img mb-3"
                    onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']) ?>&size=150&background=667eea&color=fff'">
                <?php else: ?>
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']) ?>&size=150&background=667eea&color=fff"
                    class="profile-img mb-3">
                <?php endif; ?>
                <h5><?php echo htmlspecialchars($user['full_name']) ?></h5>
                <p class="text-muted"><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?></p>
                <span class="badge bg-danger"><?php echo ucfirst($user['role']) ?></span>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning">
                <strong><i class="bi bi-person"></i> Profile Information</strong>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Username</th>
                        <td><?php echo htmlspecialchars($user['username']) ?></td>
                    </tr>
                    <tr>
                        <th>Full Name</th>
                        <td><?php echo htmlspecialchars($user['full_name']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user['email']) ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><span class="badge bg-danger"><?php echo ucfirst($user['role']) ?></span></td>
                    </tr>
                    <tr>
                        <th>Member Since</th>
                        <td><?php echo date('F d, Y', strtotime($user['created_at'] ?? 'now')) ?></td>
                    </tr>
                </table>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    To edit your profile information, please contact the system administrator or edit through the user management section.
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>
