<?php
    $pageTitle  = 'Manage Users';
    $activePage = 'users';

    ob_start();
?>
<style>
.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.search-input {
    padding-left: 45px;
    border-radius: 10px;
    height: 46px;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
}

.filter-select {
    border-radius: 10px;
    height: 46px;
}

.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.user-table th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #495057;
    padding: 1rem;
    border: none;
}

.user-table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f0f0f0;
}

.user-table tbody tr:hover {
    background: #f8f9fa;
}

.filter-badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
}

.clear-filter-btn {
    height: 46px;
    width: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.clear-filter-btn:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: rotate(90deg);
}
</style>

<!-- Search, Filters & Actions -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="index.php" id="filterForm">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="users">

            <div class="row g-3 align-items-center mb-3">
                <!-- Search -->
                <div class="col-lg-3 col-md-5">
                    <div class="position-relative">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control search-input" name="search"
                            placeholder="Search by username, email, or full name..."
                            value="<?php echo $_GET['search'] ?? '' ?>">
                    </div>
                </div>

                <!-- Role Filter -->
                <div class="col-lg-2 col-md-2">
                    <select class="form-select filter-select" name="role" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <option value="admin"
                            <?php echo(isset($_GET['role']) && $_GET['role'] == 'admin') ? 'selected' : '' ?>>Admin
                        </option>
                        <option value="employee"
                            <?php echo(isset($_GET['role']) && $_GET['role'] == 'employee') ? 'selected' : '' ?>>
                            Employee</option>
                    </select>
                </div>

                <!-- Department Filter -->
                <div class="col-lg-2 col-md-2">
                    <select class="form-select filter-select" name="department" onchange="this.form.submit()">
                        <option value="">All Departments</option>
                        <option value="IT"
                            <?php echo(isset($_GET['department']) && $_GET['department'] == 'IT') ? 'selected' : '' ?>>
                            IT</option>
                        <option value="Finance"
                            <?php echo(isset($_GET['department']) && $_GET['department'] == 'Finance') ? 'selected' : '' ?>>
                            Finance</option>
                        <option value="HR"
                            <?php echo(isset($_GET['department']) && $_GET['department'] == 'HR') ? 'selected' : '' ?>>
                            HR</option>
                        <option value="Marketing"
                            <?php echo(isset($_GET['department']) && $_GET['department'] == 'Marketing') ? 'selected' : '' ?>>
                            Marketing</option>
                        <option value="Operations"
                            <?php echo(isset($_GET['department']) && $_GET['department'] == 'Operations') ? 'selected' : '' ?>>
                            Operations</option>
                    </select>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-2">
                    <select class="form-select filter-select" name="status" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active"
                            <?php echo(isset($_GET['status']) && $_GET['status'] == 'active') ? 'selected' : '' ?>>
                            Active</option>
                        <option value="suspended"
                            <?php echo(isset($_GET['status']) && $_GET['status'] == 'suspended') ? 'selected' : '' ?>>
                            Suspended</option>
                    </select>
                </div>

                <!-- Clear Filter -->
                <div class="col-lg-1 col-md-1 col-auto">
                    <a href="index.php?controller=admin&action=users" class="btn btn-outline-danger clear-filter-btn"
                        data-bs-toggle="tooltip" title="Clear all filters">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>

                <!-- Add User Button -->
                <div class="col-lg-2 col-md-12">
                    <a href="index.php?controller=admin&action=createUser" class="btn btn-primary w-100"
                        style="height: 46px; display: flex; align-items: center; justify-content: center; white-space: nowrap;">
                        <i class="bi bi-plus-circle me-2"></i>Add User
                    </a>
                </div>
            </div>

            <!-- Active Filters Display -->
            <?php if (! empty($_GET['search']) || ! empty($_GET['role']) || ! empty($_GET['department']) || ! empty($_GET['status'])): ?>
            <div class="d-flex align-items-center gap-2 flex-wrap pt-2 mt-2 border-top">
                <small class="text-muted fw-semibold">Active filters:</small>
                <?php if (! empty($_GET['search'])): ?>
                <span class="badge bg-primary filter-badge">
                    <i class="bi bi-search me-1"></i><?php echo htmlspecialchars($_GET['search']) ?>
                </span>
                <?php endif; ?>
                <?php if (! empty($_GET['role'])): ?>
                <span class="badge bg-danger filter-badge">
                    <i class="bi bi-person me-1"></i><?php echo ucfirst($_GET['role']) ?>
                </span>
                <?php endif; ?>
                <?php if (! empty($_GET['department'])): ?>
                <span class="badge bg-info filter-badge">
                    <i class="bi bi-building me-1"></i><?php echo $_GET['department'] ?>
                </span>
                <?php endif; ?>
                <?php if (! empty($_GET['status'])): ?>
                <span class="badge bg-success filter-badge">
                    <i class="bi bi-check-circle me-1"></i><?php echo ucfirst($_GET['status']) ?>
                </span>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold"><i class="bi bi-list-ul me-2"></i>All Users</h5>
            <span class="badge bg-white text-primary px-3 py-2"><?php echo count($users) ?> users</span>
        </div>
    </div>
    <div class="card-body p-0">
        <?php if (count($users) > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover user-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">ID</th>
                        <th style="width: 30%;">USER</th>
                        <th style="width: 25%;">EMAIL</th>
                        <th style="width: 12%;">ROLE</th>
                        <th style="width: 13%;">DEPARTMENT</th>
                        <th class="text-center" style="width: 10%;">STATUS</th>
                        <th class="text-center" style="width: 10%;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="ps-4 align-middle">
                            <span class="badge bg-light text-dark">#<?php echo $user['id'] ?></span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']) ?>&size=40&background=667eea&color=fff&bold=true"
                                    class="user-avatar me-3">
                                <div>
                                    <div class="fw-semibold text-dark">
                                        <?php echo htmlspecialchars($user['full_name']) ?></div>
                                    <small class="text-muted">@<?php echo htmlspecialchars($user['username']) ?></small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <span class="text-muted small"><?php echo htmlspecialchars($user['email']) ?></span>
                        </td>
                        <td class="align-middle">
                            <?php if ($user['role'] == 'admin'): ?>
                            <span class="badge bg-danger">
                                <i class="bi bi-shield-fill-check"></i> Admin
                            </span>
                            <?php else: ?>
                            <span class="badge bg-primary">
                                <i class="bi bi-person-fill"></i> Employee
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle">
                            <span class="text-dark"><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?></span>
                        </td>
                        <td class="align-middle text-center">
                            <?php if ($user['is_active']): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle-fill"></i> Active
                            </span>
                            <?php else: ?>
                            <span class="badge bg-danger">
                                <i class="bi bi-x-circle-fill"></i> Suspended
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="align-middle text-center">
                            <div class="d-inline-flex gap-2">
                                <a href="index.php?controller=admin&action=editUser&id=<?php echo $user['id'] ?>"
                                    class="btn btn-warning action-btn" data-bs-toggle="tooltip" title="Edit User">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                <a href="index.php?controller=admin&action=deleteUser&id=<?php echo $user['id'] ?>"
                                    class="btn btn-danger action-btn" data-bs-toggle="tooltip" title="Delete User"
                                    onclick="return confirm('Delete user <?php echo htmlspecialchars($user['username']) ?>?')">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                                <?php else: ?>
                                <button class="btn btn-secondary action-btn" disabled data-bs-toggle="tooltip"
                                    title="Cannot delete yourself">
                                    <i class="bi bi-lock-fill"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center py-5">
            <i class="bi bi-inbox display-1 text-muted"></i>
            <h5 class="mt-3 text-muted">No users found</h5>
            <p class="text-muted">Try adjusting your search or filters</p>
            <a href="index.php?controller=admin&action=users" class="btn btn-primary mt-2">
                <i class="bi bi-arrow-clockwise me-2"></i>Reset Filters
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Initialize tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(el) {
        return new bootstrap.Tooltip(el);
    });

    // Auto-submit search
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                if (this.value.length >= 3 || this.value.length === 0) {
                    this.form.submit();
                }
            }, 600);
        });
    }
});
</script>

<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/admin_layout.php';
?>