<?php
    $pageTitle  = 'All Support Tickets';
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
    <h4 class="mb-4"><i class="bi bi-ticket-detailed"></i> IT Support Tickets Management</h4>

    <!-- Ticket Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm bg-primary text-white">
                <div class="card-body">
                    <h6>Total Tickets</h6>
                    <h3><?php echo $stats['total'] ?? count($tickets) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-danger text-white">
                <div class="card-body">
                    <h6>Open</h6>
                    <h3><?php echo $stats['open'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-warning text-white">
                <div class="card-body">
                    <h6>In Progress</h6>
                    <h3><?php echo $stats['in_progress'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'in_progress')) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm bg-success text-white">
                <div class="card-body">
                    <h6>Closed</h6>
                    <h3><?php echo $stats['closed'] ?? count(array_filter($tickets, fn($t) => $t['status'] == 'closed')) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($tickets)): ?>
        <!-- Empty State -->
        <div class="card shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-ticket" style="font-size: 5rem; color: #e0e0e0;"></i>
                <h5 class="mt-3 text-muted">No Tickets Yet</h5>
                <p class="text-muted">There are no support tickets in the system.</p>
            </div>
        </div>
    <?php else: ?>
        <!-- Tickets List -->
        <div class="row">
            <?php foreach ($tickets as $ticket): ?>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card ticket-card priority-<?php echo $ticket['priority'] ?> shadow-sm"
                         onclick="window.location='index.php?controller=admin&action=viewTicket&id=<?php echo $ticket['id'] ?>'">
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
                                <i class="bi bi-person"></i> <?php echo htmlspecialchars($ticket['full_name']) ?>
                                <?php if (! empty($ticket['department'])): ?>
                                    - <?php echo htmlspecialchars($ticket['department']) ?>
                                <?php endif; ?>
                            </p>

                            <p class="text-muted small mb-2" style="max-height: 40px; overflow: hidden;">
                                <?php
                                    $message = $ticket['message'] ?? $ticket['description'] ?? '';
                                    echo htmlspecialchars(substr($message, 0, 80));
                                    echo strlen($message) > 80 ? '...' : '';
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
                                <?php if ($ticket['assigned_full_name']): ?>
                                <span class="badge bg-info">
                                    <i class="bi bi-person-badge"></i>
                                    <?php echo htmlspecialchars($ticket['assigned_full_name']) ?>
                                </span>
                                <?php endif; ?>
                            </div>

                            <div class="mt-2 small text-muted">
                                <i class="bi bi-calendar"></i>
                                <?php echo date('M d, Y H:i', strtotime($ticket['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>

