<?php
    $pageTitle  = 'Dashboard';
    $activePage = 'dashboard';

    ob_start();
?>
<h4 class="mb-4">Welcome, <?php echo htmlspecialchars($user['full_name']) ?>! 👋</h4>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Open Tickets</p>
                        <h3><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></h3>
                    </div>
                    <i class="bi bi-ticket text-primary" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card card-stats shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-muted mb-1">Announcements</p>
                        <h3><?php echo count($announcements) ?></h3>
                    </div>
                    <i class="bi bi-megaphone text-warning" style="font-size: 2.5rem;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcements -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-megaphone"></i> <strong>Pengumuman Terbaru</strong>
    </div>
    <div class="card-body">
        <?php if (empty($announcements)): ?>
        <p class="text-muted">Tidak ada pengumuman.</p>
        <?php else: ?>
        <?php foreach (array_slice($announcements, 0, 3) as $announcement): ?>
        <div class="mb-3 pb-3 border-bottom">
            <h6><?php echo $announcement['title'] ?></h6>
            <p class="mb-1"><?php echo $announcement['content'] ?></p>
            <small class="text-muted">
                <i class="bi bi-person"></i> <?php echo htmlspecialchars($announcement['author']) ?> |
                <i class="bi bi-clock"></i> <?php echo date('d M Y', strtotime($announcement['created_at'])) ?>
            </small>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Recent Tickets -->
<div class="card shadow-sm">
    <div class="card-header bg-info text-white">
        <i class="bi bi-ticket"></i> <strong>My Recent Tickets</strong>
    </div>
    <div class="card-body">
        <?php if (empty($tickets)): ?>
        <p class="text-muted">Belum ada tiket.</p>
        <a href="index.php?controller=dashboard&action=createTicket" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Buat Tiket Baru
        </a>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($tickets, 0, 5) as $ticket): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($ticket['subject']) ?></td>
                        <td>
                            <?php
                                $badge = [
                                    'open'        => 'bg-danger',
                                    'in_progress' => 'bg-warning',
                                    'closed'      => 'bg-success',
                                ];
                            ?>
                            <span class="badge <?php echo $badge[$ticket['status']] ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $ticket['status'])) ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($ticket['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="index.php?controller=dashboard&action=tickets" class="btn btn-outline-primary">
            View All Tickets
        </a>
        <?php endif; ?>
    </div>
</div>
<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>