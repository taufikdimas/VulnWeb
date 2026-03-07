<?php
    $pageTitle  = 'Edit User';
    $activePage = 'users';

    ob_start();
?>
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <strong>Edit User: <?php echo htmlspecialchars($user['username']) ?></strong>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="index.php?controller=admin&action=editUser&id=<?php echo $user['id'] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($user['username']) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']) ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Full Name</label>
                                            <input type="text" class="form-control" name="full_name" value="<?php echo htmlspecialchars($user['full_name']) ?>" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Role</label>
                                                <select class="form-select" name="role" required>
                                                    <option value="employee" <?php echo $user['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
                                                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Department</label>
                                                <select class="form-select" name="department" required>
                                                    <option value="IT" <?php echo $user['department'] == 'IT' ? 'selected' : '' ?>>IT</option>
                                                    <option value="Finance" <?php echo $user['department'] == 'Finance' ? 'selected' : '' ?>>Finance</option>
                                                    <option value="HR" <?php echo $user['department'] == 'HR' ? 'selected' : '' ?>>HR</option>
                                                    <option value="Marketing" <?php echo $user['department'] == 'Marketing' ? 'selected' : '' ?>>Marketing</option>
                                                    <option value="Operations" <?php echo $user['department'] == 'Operations' ? 'selected' : '' ?>>Operations</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Phone</label>
                                            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($user['phone']) ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">New Password (leave empty to keep current)</label>
                                            <input type="text" class="form-control" name="password">
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                                       <?php echo $user['is_active'] ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="is_active">
                                                    <strong>Account Active</strong>
                                                    <small class="text-muted d-block">When disabled, user cannot login to the system</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save"></i> Update User
                                            </button>
                                            <a href="index.php?controller=admin&action=users" class="btn btn-secondary">
                                                Cancel
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>
