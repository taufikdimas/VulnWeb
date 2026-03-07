<?php
    $pageTitle  = 'My Profile';
    $activePage = 'profile';

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
                                    <p class="text-muted"><?php echo htmlspecialchars($user['department']) ?></p>
                                    <span class="badge bg-primary"><?php echo ucfirst($user['role']) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <strong>Edit Profile</strong>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="index.php?controller=dashboard&action=editProfile"
                                        enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control"
                                                value="<?php echo htmlspecialchars($user['username']) ?>" disabled>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="full_name"
                                                value="<?php echo htmlspecialchars($user['full_name']) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email"
                                                value="<?php echo htmlspecialchars($user['email']) ?>" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Department</label>
                                                <select class="form-select" name="department" required>
                                                    <option value="IT"
                                                        <?php echo $user['department'] == 'IT' ? 'selected' : '' ?>>IT
                                                    </option>
                                                    <option value="Finance"
                                                        <?php echo $user['department'] == 'Finance' ? 'selected' : '' ?>>
                                                        Finance</option>
                                                    <option value="HR"
                                                        <?php echo $user['department'] == 'HR' ? 'selected' : '' ?>>HR
                                                    </option>
                                                    <option value="Marketing"
                                                        <?php echo $user['department'] == 'Marketing' ? 'selected' : '' ?>>
                                                        Marketing</option>
                                                    <option value="Operations"
                                                        <?php echo $user['department'] == 'Operations' ? 'selected' : '' ?>>
                                                        Operations</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="text" class="form-control" name="phone"
                                                    value="<?php echo htmlspecialchars($user['phone']) ?>">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Profile Photo</label>
                                            <input type="file" class="form-control" name="photo" accept="image/*">
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Update Profile
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>