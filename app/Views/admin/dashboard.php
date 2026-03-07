<?php
    $pageTitle  = 'Dashboard';
    $activePage = 'dashboard';

    ob_start();
?>



<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="value"><?php echo count($users) ?></div>
            <div class="label">Total Users</div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="icon">
                <i class="bi bi-ticket"></i>
            </div>
            <div class="value"><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></div>
            <div class="label">Open Tickets</div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="icon">
                <i class="bi bi-megaphone"></i>
            </div>
            <div class="value"><?php echo count($announcements) ?></div>
            <div class="label">Announcements</div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="stats-card">
            <div class="icon">
                <i class="bi bi-shield-check"></i>
            </div>
            <div class="value"><?php echo count(array_filter($users, fn($u) => $u['role'] == 'admin')) ?></div>
            <div class="label">Admins</div>
        </div>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card mb-4">
    <div class="card-header">
        <strong><i class="bi bi-ticket-detailed"></i> Recent Tickets</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($tickets, 0, 8) as $ticket): ?>
                    <tr>
                        <td>#<?php echo $ticket['id'] ?></td>
                        <td><?php echo htmlspecialchars($ticket['full_name']) ?></td>
                        <td><?php echo htmlspecialchars(substr($ticket['subject'], 0, 40)) ?><?php echo strlen($ticket['subject']) > 40 ? '...' : '' ?></td>
                        <td>
                            <?php
                                $priorityBadge = [
                                    'low'      => 'badge-success',
                                    'medium'   => 'badge-info',
                                    'high'     => 'badge-warning',
                                    'critical' => 'badge-danger',
                                ];
                            ?>
                            <span class="badge <?php echo $priorityBadge[$ticket['priority']] ?>">
                                <?php echo ucfirst($ticket['priority']) ?>
                            </span>
                        </td>
                        <td>
                            <?php
                                $statusBadge = [
                                    'open'        => 'badge-danger',
                                    'in_progress' => 'badge-warning',
                                    'closed'      => 'badge-success',
                                ];
                            ?>
                            <span class="badge <?php echo $statusBadge[$ticket['status']] ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y H:i', strtotime($ticket['created_at'])) ?></td>
                        <td>
                            <a href="index.php?controller=admin&action=viewTicket&id=<?php echo $ticket['id'] ?>"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php?controller=admin&action=tickets" class="btn btn-primary">
            View All Tickets
        </a>
    </div>
</div>

<!-- Recent Users -->
<div class="card">
    <div class="card-header">
        <strong><i class="bi bi-people"></i> Recent Users</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Last Login</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($users, 0, 7) as $user): ?>
                    <tr>
                        <td><?php echo $user['id'] ?></td>
                        <td><?php echo htmlspecialchars($user['username']) ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']) ?></td>
                        <td>
                            <span
                                class="badge <?php echo $user['role'] == 'admin' ? 'badge-danger' : 'badge-primary' ?>">
                                <?php echo ucfirst($user['role']) ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($user['department'] ?? 'N/A') ?></td>
                        <td>
                            <?php if ($user['last_login']): ?>
                                <span class="text-success">
                                    <i class="bi bi-clock"></i>
                                    <?php echo date('d M Y H:i', strtotime($user['last_login'])) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">Never logged in</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php?controller=admin&action=users" class="btn btn-primary">
            View All Users
        </a>
    </div>
</div>
<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/admin_layout.php';
?>