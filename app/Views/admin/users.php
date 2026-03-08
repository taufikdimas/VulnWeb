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

.search-wrapper {
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
    z-index: 10;
}

.search-input-wrapper .form-control {
    padding-left: 48px;
    height: 48px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.search-input-wrapper .form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.filter-select {
    height: 48px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.filter-select:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.btn-action {
    height: 48px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.btn-action.btn-primary {
    background-color: #0d6efd;
}

.btn-action.btn-primary:hover {
    background-color: #0b5ed7;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
}

.btn-action.btn-danger {
    background-color: #dc3545;
}

.btn-action.btn-danger:hover {
    background-color: #bb2d3b;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.action-btn {
    padding: 0.5rem 1.1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s ease;
    border: none;
    font-size: 0.875rem;
    font-weight: 500;
    gap: 0.5rem;
    text-decoration: none !important;
    line-height: 1;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    text-decoration: none !important;
}

/* Remove custom btn-view - now using Bootstrap's btn-sm btn-primary */

.table-card {
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.table-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f8f9fa;
}

.table-header h5 {
    margin: 0;
    color: #1e293b;
    font-size: 1rem;
    font-weight: 600;
}

.table-modern {
    margin: 0;
}

.table-modern thead th {
    background: #f8f9fa;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #64748b;
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 2px solid #e2e8f0;
}

.table-modern tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #f1f5f9;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    cursor: pointer;
}

.table-modern tbody tr:hover {
    background: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

.filter-badge {
    font-size: 0.75rem;
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
}
</style>

<!-- Search & Filters -->
<div class="search-wrapper">
    <form method="GET" action="index.php" id="filterForm">
        <input type="hidden" name="controller" value="admin">
        <input type="hidden" name="action" value="users">

        <div class="row g-2">
            <!-- Search -->
            <div class="col-lg-4 col-md-4">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control" name="search"
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
            <div class="col-lg-1 col-md-1">
                <button type="button" class="btn btn-danger w-100 btn-action"
                    onclick="window.location.href='index.php?controller=admin&action=users'" title="Clear Filters">
                    <i class="bi bi-x-circle"></i> Clear
                </button>
            </div>

            <!-- Add User Button -->
            <div class="col-lg-1 col-md-1">
                <a href="index.php?controller=admin&action=createUser" class="btn btn-primary w-100 btn-action"
                    title="Add New User">
                    <i class="bi bi-plus-circle"></i> Add
                </a>
            </div>
        </div>

        <!-- Active Filters Display -->
        <?php if (! empty($_GET['search']) || ! empty($_GET['role']) || ! empty($_GET['department']) || ! empty($_GET['status'])): ?>
        <div class="d-flex align-items-center gap-2 flex-wrap pt-3 mt-3 border-top">
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

<!-- Users Table -->
<div class="table-card">
    <?php if (count($users) > 0): ?>
    <div class="table-responsive">
        <table class="table table-modern">
            <thead>
                <tr>
                    <th style="width: 60px;">ID</th>
                    <th style="width: 30%;">USER</th>
                    <th style="width: 25%;">EMAIL</th>
                    <th style="width: 12%;">ROLE</th>
                    <th style="width: 13%;">DEPARTMENT</th>
                    <th class="text-center" style="width: 10%;">STATUS</th>
                    <th class="text-center" style="width: 10%;">DETAIL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr
                    onclick="window.location.href='index.php?controller=admin&action=viewUser&id=<?php echo $user['id'] ?>'">
                    <td>
                        <span class="badge bg-light text-dark">#<?php echo $user['id'] ?></span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <?php if (! empty($user['profile_picture'])): ?>
                            <img src="index.php?controller=admin&action=getProfilePicture&id=<?php echo $user['id'] ?>"
                                class="user-avatar me-3" alt="Profile Picture">
                            <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['full_name']) ?>&size=40&background=667eea&color=fff&bold=true"
                                class="user-avatar me-3">
                            <?php endif; ?>
                            <div>
                                <div class="fw-semibold text-dark">
                                    <?php echo htmlspecialchars($user['full_name']) ?></div>
                                <small class="text-muted">@<?php echo htmlspecialchars($user['username']) ?></small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted small"><?php echo htmlspecialchars($user['email']) ?></span>
                    </td>
                    <td>
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
                    <td>
                        <span class="text-dark"><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?></span>
                    </td>
                    <td class="text-center">
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
                    <td class="text-center">
                        <a href="index.php?controller=admin&action=viewUser&id=<?php echo $user['id'] ?>"
                            class="btn btn-sm btn-primary" onclick="event.stopPropagation();">
                            <i class="bi bi-eye"></i> View
                        </a>
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