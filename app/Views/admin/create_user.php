<?php
    $pageTitle  = 'Create New User';
    $activePage = 'users';

    ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-person-plus-fill"></i> Create New User</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?controller=admin&action=createUser">
                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required>
                        <small class="text-muted">Used for login</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="full_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="password" required>
                        <small class="text-muted">Set initial password for the user</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select" name="role" required>
                                <option value="employee" selected>Employee</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department <span class="text-danger">*</span></label>
                            <select class="form-select" name="department" required>
                                <option value="">Select Department</option>
                                <option value="IT">IT</option>
                                <option value="Finance">Finance</option>
                                <option value="HR">HR</option>
                                <option value="Marketing">Marketing</option>
                                <option value="Operations">Operations</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" class="form-control" name="phone">
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                <strong>Account Active</strong>
                                <small class="text-muted d-block">When disabled, user cannot login to the system</small>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-plus-fill"></i> Create User
                        </button>
                        <a href="index.php?controller=admin&action=users" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>
