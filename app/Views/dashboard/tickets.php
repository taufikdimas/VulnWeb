<?php
    $pageTitle  = 'IT Support Tickets';
    $activePage = 'tickets';

    ob_start();

    // Priority badge colors
    $priorityColors = [
    'low'      => 'success',
    'medium'   => 'info',
    'high'     => 'warning',
    'critical' => 'danger',
    ];

    // Status badge colors
    $statusColors = [
    'open'        => 'primary',
    'in_progress' => 'warning',
    'closed'      => 'secondary',
    ];

    // Category icons
    $categoryIcons = [
    'hardware' => 'cpu',
    'software' => 'app-indicator',
    'network'  => 'wifi',
    'access'   => 'key',
    'email'    => 'envelope',
    'other'    => 'question-circle',
    ];
?>

<style>
/* Statistics Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
}

.stat-card.total {
    border-left: 4px solid #2563eb;
}

.stat-card.open {
    border-left: 4px solid #dc2626;
}

.stat-card.in-progress {
    border-left: 4px solid #f59e0b;
}

.stat-card.closed {
    border-left: 4px solid #16a34a;
}

.stat-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
}

.stat-card-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-card-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.stat-card.total .stat-card-icon {
    background: #dbeafe;
    color: #2563eb;
}

.stat-card.open .stat-card-icon {
    background: #fee2e2;
    color: #dc2626;
}

.stat-card.in-progress .stat-card-icon {
    background: #fef3c7;
    color: #f59e0b;
}

.stat-card.closed .stat-card-icon {
    background: #dcfce7;
    color: #16a34a;
}

.stat-card-value {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

/* Search & Filters */
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

/* Table */
.table-card {
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
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
    border-left: 4px solid transparent;
}

.table-modern tbody tr.priority-critical {
    border-left-color: #dc2626;
}

.table-modern tbody tr.priority-high {
    border-left-color: #f59e0b;
}

.table-modern tbody tr.priority-medium {
    border-left-color: #0dcaf0;
}

.table-modern tbody tr.priority-low {
    border-left-color: #16a34a;
}

.table-modern tbody tr:hover {
    background: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

@media (max-width: 1200px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container-fluid">
    <!-- Ticket Statistics -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-card-header">
                <span class="stat-card-title">Total Tickets</span>
                <div class="stat-card-icon">
                    <i class="bi bi-ticket-detailed-fill"></i>
                </div>
            </div>
            <h2 class="stat-card-value"><?php echo $stats['total'] ?? count($tickets) ?></h2>
        </div>

        <div class="stat-card open">
            <div class="stat-card-header">
                <span class="stat-card-title">Open</span>
                <div class="stat-card-icon">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
            </div>
            <h2 class="stat-card-value"><?php echo $stats['open'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></h2>
        </div>

        <div class="stat-card in-progress">
            <div class="stat-card-header">
                <span class="stat-card-title">In Progress</span>
                <div class="stat-card-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
            <h2 class="stat-card-value"><?php echo $stats['in_progress'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'in_progress')) ?></h2>
        </div>

        <div class="stat-card closed">
            <div class="stat-card-header">
                <span class="stat-card-title">Closed</span>
                <div class="stat-card-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <h2 class="stat-card-value"><?php echo $stats['closed'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'closed')) ?></h2>
        </div>
    </div>

    <!-- Search & Filters -->
    <form method="GET" action="index.php">
        <input type="hidden" name="controller" value="dashboard">
        <input type="hidden" name="action" value="tickets">

        <div class="search-wrapper">
            <div class="row g-3">
                <!-- Search -->
                <div class="col-lg-4 col-md-12">
                    <div class="search-input-wrapper">
                        <i class="bi bi-search"></i>
                        <input type="text"
                               class="form-control"
                               name="search"
                               placeholder="Search by ticket subject or ID..."
                               value="<?php echo htmlspecialchars($_GET['search'] ?? '') ?>">
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-lg-2 col-md-3">
                    <select class="form-select filter-select" name="status">
                        <option value="">All Status</option>
                        <option value="open" <?php echo(isset($_GET['status']) && $_GET['status'] == 'open') ? 'selected' : '' ?>>Open</option>
                        <option value="in_progress" <?php echo(isset($_GET['status']) && $_GET['status'] == 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                        <option value="closed" <?php echo(isset($_GET['status']) && $_GET['status'] == 'closed') ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>

                <!-- Priority Filter -->
                <div class="col-lg-2 col-md-3">
                    <select class="form-select filter-select" name="priority">
                        <option value="">All Priority</option>
                        <option value="critical" <?php echo(isset($_GET['priority']) && $_GET['priority'] == 'critical') ? 'selected' : '' ?>>Critical</option>
                        <option value="high" <?php echo(isset($_GET['priority']) && $_GET['priority'] == 'high') ? 'selected' : '' ?>>High</option>
                        <option value="medium" <?php echo(isset($_GET['priority']) && $_GET['priority'] == 'medium') ? 'selected' : '' ?>>Medium</option>
                        <option value="low" <?php echo(isset($_GET['priority']) && $_GET['priority'] == 'low') ? 'selected' : '' ?>>Low</option>
                    </select>
                </div>

                <!-- Category Filter -->
                <div class="col-lg-2 col-md-3">
                    <select class="form-select filter-select" name="category">
                        <option value="">All Category</option>
                        <option value="hardware" <?php echo(isset($_GET['category']) && $_GET['category'] == 'hardware') ? 'selected' : '' ?>>Hardware</option>
                        <option value="software" <?php echo(isset($_GET['category']) && $_GET['category'] == 'software') ? 'selected' : '' ?>>Software</option>
                        <option value="network" <?php echo(isset($_GET['category']) && $_GET['category'] == 'network') ? 'selected' : '' ?>>Network</option>
                        <option value="access" <?php echo(isset($_GET['category']) && $_GET['category'] == 'access') ? 'selected' : '' ?>>Access</option>
                        <option value="email" <?php echo(isset($_GET['category']) && $_GET['category'] == 'email') ? 'selected' : '' ?>>Email</option>
                        <option value="other" <?php echo(isset($_GET['category']) && $_GET['category'] == 'other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <!-- Clear & Create Buttons -->
                <div class="col-lg-2 col-md-3">
                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-danger btn-action"
                                style="width: 48px;"
                                onclick="window.location.href='index.php?controller=dashboard&action=tickets'"
                                title="Clear Filters">
                            <i class="bi bi-x-circle"></i>
                        </button>
                        <a href="index.php?controller=dashboard&action=createTicket"
                           class="btn btn-primary btn-action flex-grow-1">
                            <i class="bi bi-plus-circle"></i> New Ticket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <?php if (empty($tickets)): ?>
        <!-- Empty State -->
        <div class="table-card">
            <div class="text-center py-5">
                <i class="bi bi-ticket-detailed" style="font-size: 4rem; color: #cbd5e0;"></i>
                <p class="text-muted mt-3">No support tickets found.</p>
                <a href="index.php?controller=dashboard&action=createTicket" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Create Your First Ticket
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Tickets Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%">TICKET ID</th>
                            <th style="width: 25%">SUBJECT</th>
                            <th style="width: 15%">REQUESTER</th>
                            <th style="width: 10%">STATUS</th>
                            <th style="width: 10%">PRIORITY</th>
                            <th style="width: 10%">CATEGORY</th>
                            <th style="width: 12%">CREATED</th>
                            <th style="width: 10%">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tickets as $ticket): ?>
                            <tr class="priority-<?php echo $ticket['priority'] ?>"
                                onclick="window.location='index.php?controller=dashboard&action=viewTicket&id=<?php echo $ticket['id'] ?>'">
                                <td>
                                    <strong>#<?php echo $ticket['id'] ?></strong>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php if ($ticket['attachment']): ?>
                                            <i class="bi bi-paperclip text-primary me-2"></i>
                                        <?php endif; ?>
                                        <div>
                                            <div class="fw-semibold"><?php echo htmlspecialchars($ticket['subject']) ?></div>
                                            <small class="text-muted">
                                                <?php
                                                    $description = $ticket['description'] ?? $ticket['message'] ?? '';
                                                    echo htmlspecialchars(substr($description, 0, 50));
                                                    echo strlen($description) > 50 ? '...' : '';
                                                ?>
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="fw-semibold"><?php echo htmlspecialchars($ticket['full_name']) ?></div>
                                        <small class="text-muted"><?php echo htmlspecialchars($ticket['department']) ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $statusColors[$ticket['status']] ?>">
                                        <?php echo strtoupper(str_replace('_', ' ', $ticket['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $priorityColors[$ticket['priority']] ?>">
                                        <i class="bi bi-flag-fill"></i> <?php echo ucfirst($ticket['priority']) ?>
                                    </span>
                                </td>
                                <td>
                                    <i class="bi bi-<?php echo $categoryIcons[$ticket['category']] ?>"></i>
                                    <?php echo ucfirst($ticket['category']) ?>
                                </td>
                                <td>
                                    <small>
                                        <?php echo date('M d, Y', strtotime($ticket['created_at'])) ?><br>
                                        <?php echo date('H:i', strtotime($ticket['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <a href="index.php?controller=dashboard&action=viewTicket&id=<?php echo $ticket['id'] ?>"
                                       class="btn btn-sm btn-primary"
                                       onclick="event.stopPropagation()">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-center mt-3">
            <small class="text-muted">
                Showing <?php echo count($tickets) ?> ticket(s)
            </small>
        </div>
    <?php endif; ?>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/user_layout.php';
?>


