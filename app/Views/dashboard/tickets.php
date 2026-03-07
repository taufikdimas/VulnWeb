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

.ticket-card {
    border-left: 4px solid;
    transition: all 0.3s;
    cursor: pointer;
}

.ticket-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.ticket-card.priority-critical {
    border-left-color: #dc3545;
}

.ticket-card.priority-high {
    border-left-color: #ffc107;
}

.ticket-card.priority-medium {
    border-left-color: #0dcaf0;
}

.ticket-card.priority-low {
    border-left-color: #198754;
}

.ticket-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 0.5rem;
}
</style>

<div class="container-fluid">
    <!-- Search & Filters -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="index.php" id="filterForm">
                <input type="hidden" name="controller" value="dashboard">
                <input type="hidden" name="action" value="tickets">

                <div class="row g-3 align-items-center">
                    <!-- Search -->
                    <div class="col-lg-3 col-md-4">
                        <div class="position-relative">
                            <i class="bi bi-search search-icon"></i>
                            <input type="text"
                                   class="form-control search-input"
                                   name="search"
                                   placeholder="Search tickets..."
                                   value="<?php echo htmlspecialchars($filters['search'] ?? '') ?>">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="col-lg-2 col-md-2">
                        <select class="form-select filter-select" name="status" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="open" <?php echo($filters['status'] ?? '') == 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="in_progress" <?php echo($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="closed" <?php echo($filters['status'] ?? '') == 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>

                    <!-- Priority Filter -->
                    <div class="col-lg-2 col-md-2">
                        <select class="form-select filter-select" name="priority" onchange="this.form.submit()">
                            <option value="">All Priorities</option>
                            <option value="low" <?php echo($filters['priority'] ?? '') == 'low' ? 'selected' : '' ?>>Low</option>
                            <option value="medium" <?php echo($filters['priority'] ?? '') == 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="high" <?php echo($filters['priority'] ?? '') == 'high' ? 'selected' : '' ?>>High</option>
                            <option value="critical" <?php echo($filters['priority'] ?? '') == 'critical' ? 'selected' : '' ?>>Critical</option>
                        </select>
                    </div>

                    <!-- Category Filter -->
                    <div class="col-lg-2 col-md-2">
                        <select class="form-select filter-select" name="category" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <option value="hardware" <?php echo($filters['category'] ?? '') == 'hardware' ? 'selected' : '' ?>>Hardware</option>
                            <option value="software" <?php echo($filters['category'] ?? '') == 'software' ? 'selected' : '' ?>>Software</option>
                            <option value="network" <?php echo($filters['category'] ?? '') == 'network' ? 'selected' : '' ?>>Network</option>
                            <option value="access" <?php echo($filters['category'] ?? '') == 'access' ? 'selected' : '' ?>>Access</option>
                            <option value="email" <?php echo($filters['category'] ?? '') == 'email' ? 'selected' : '' ?>>Email</option>
                            <option value="other" <?php echo($filters['category'] ?? '') == 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>

                    <!-- Clear Filter -->
                    <div class="col-lg-1 col-md-1">
                        <button type="button"
                                class="btn btn-outline-secondary clear-filter-btn w-100"
                                onclick="window.location.href='index.php?controller=dashboard&action=tickets'"
                                title="Clear Filters">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>

                    <!-- Create Ticket Button -->
                    <div class="col-lg-2 col-md-3">
                        <a href="index.php?controller=dashboard&action=createTicket"
                           class="btn btn-primary w-100"
                           style="height: 46px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                            <i class="bi bi-plus-circle"></i> <span class="ms-1">New Ticket</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Active Filters Display -->
    <?php
        $hasFilters = ! empty($filters['search']) || ! empty($filters['status']) || ! empty($filters['priority']) || ! empty($filters['category']);
        if ($hasFilters):
    ?>
    <div class="mb-3">
        <span class="text-muted me-2">Active filters:</span>
        <?php if (! empty($filters['search'])): ?>
            <span class="badge bg-info me-1">
                Search: <?php echo htmlspecialchars($filters['search']) ?>
            </span>
        <?php endif; ?>
        <?php if (! empty($filters['status'])): ?>
            <span class="badge bg-info me-1">
                Status: <?php echo ucfirst(str_replace('_', ' ', $filters['status'])) ?>
            </span>
        <?php endif; ?>
        <?php if (! empty($filters['priority'])): ?>
            <span class="badge bg-info me-1">
                Priority: <?php echo ucfirst($filters['priority']) ?>
            </span>
        <?php endif; ?>
        <?php if (! empty($filters['category'])): ?>
            <span class="badge bg-info me-1">
                Category: <?php echo ucfirst($filters['category']) ?>
            </span>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($tickets)): ?>
        <!-- Empty State -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-ticket" style="font-size: 5rem; color: #e0e0e0;"></i>
                <h5 class="mt-3 text-muted">No Tickets Found</h5>
                <p class="text-muted">No tickets match your current filters.</p>
                <a href="index.php?controller=dashboard&action=createTicket" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Create New Ticket
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Ticket Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Tickets</h6>
                        <h3><?php echo count($tickets) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-danger text-white">
                    <div class="card-body">
                        <h6>Open</h6>
                        <h3><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-warning text-white">
                    <div class="card-body">
                        <h6>In Progress</h6>
                        <h3><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'in_progress')) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm bg-success text-white">
                    <div class="card-body">
                        <h6>Closed</h6>
                        <h3><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'closed')) ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="row">
            <?php foreach ($tickets as $ticket): ?>
                <div class="col-md-6 mb-3">
                    <div class="card ticket-card priority-<?php echo $ticket['priority'] ?> shadow-sm"
                         onclick="window.location='index.php?controller=dashboard&action=viewTicket&id=<?php echo $ticket['id'] ?>'">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="mb-0">
                                    <i class="bi bi-hash"></i><?php echo $ticket['id'] ?> -
                                    <?php echo htmlspecialchars($ticket['subject']) ?>
                                </h6>
                                <span class="badge bg-<?php echo $statusColors[$ticket['status']] ?>">
                                    <?php echo strtoupper(str_replace('_', ' ', $ticket['status'])) ?>
                                </span>
                            </div>

                            <p class="text-muted small mb-2">
                                <i class="bi bi-person-circle"></i>
                                <strong><?php echo htmlspecialchars($ticket['full_name']) ?></strong>
                                <small class="text-muted">(<?php echo htmlspecialchars($ticket['department']) ?>)</small>
                            </p>

                            <p class="text-muted small mb-2" style="max-height: 40px; overflow: hidden;">
                                <?php
                                    $message = $ticket['message'] ?? $ticket['description'] ?? '';
                                    echo htmlspecialchars(substr($message, 0, 100));
                                    echo strlen($message) > 100 ? '...' : '';
                                ?>
                            </p>

                            <div class="ticket-meta">
                                <span class="badge bg-<?php echo $priorityColors[$ticket['priority']] ?>">
                                    <i class="bi bi-flag-fill"></i> <?php echo ucfirst($ticket['priority']) ?>
                                </span>
                                <span class="badge bg-secondary">
                                    <i class="bi bi-<?php echo $categoryIcons[$ticket['category']] ?>"></i>
                                    <?php echo ucfirst($ticket['category']) ?>
                                </span>
                                <span class="text-muted small">
                                    <i class="bi bi-calendar"></i>
                                    <?php echo date('M d, Y H:i', strtotime($ticket['created_at'])) ?>
                                </span>
                            </div>

                            <?php if ($ticket['attachment']): ?>
                            <div class="mt-2">
                                <i class="bi bi-paperclip text-primary"></i>
                                <small class="text-primary">Has attachment</small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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


