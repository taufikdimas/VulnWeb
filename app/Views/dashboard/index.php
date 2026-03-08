<?php
    $pageTitle  = 'Dashboard';
    $activePage = 'dashboard';

    ob_start();
?>
<style>
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.stats-card {
    border: none;
    border-radius: 12px;
    transition: transform 0.2s, box-shadow 0.2s;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
}

.announcement-card {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    background: white;
    cursor: pointer;
}

.announcement-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateX(5px);
}

.announcement-title {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-size: 1.05rem;
}

.announcement-content {
    color: #64748b;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 0.75rem;
}

.announcement-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: #94a3b8;
}

.ticket-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    background: white;
    cursor: pointer;
}

.ticket-card:hover {
    border-color: #667eea;
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
}

.ticket-subject {
    font-weight: 500;
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.ticket-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.85rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state-icon {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.badge-status {
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 500;
}
</style>

<div class="welcome-section">
    <h3 class="mb-2">Welcome back, <?php echo htmlspecialchars($user['full_name']) ?>! 👋</h3>
    <p class="mb-0 opacity-90">Here's what's happening with your account today.</p>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-6 mb-3">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Open Tickets</p>
                        <h2 class="mb-0"><?php echo count(array_filter($tickets, fn($t) => $t['status'] == 'open')) ?></h2>
                    </div>
                    <div class="stats-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-ticket"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card stats-card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1 small">Announcements</p>
                        <h2 class="mb-0"><?php echo count($announcements) ?></h2>
                    </div>
                    <div class="stats-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-megaphone"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Announcements -->
<div class="section-header">
    <h5 class="section-title">
        <i class="bi bi-megaphone text-primary"></i>
        Pengumuman Terbaru
    </h5>
    <a href="index.php?controller=dashboard&action=announcements" class="btn btn-sm btn-outline-primary">
        <i class="bi bi-arrow-right"></i> View All
    </a>
</div>

<?php if (empty($announcements)): ?>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-megaphone"></i></div>
            <p class="text-muted mb-0">Tidak ada pengumuman saat ini.</p>
        </div>
    </div>
</div>
<?php else: ?>
<div class="mb-4">
    <?php foreach (array_slice($announcements, 0, 3) as $announcement): ?>
    <div class="announcement-card" onclick="window.location.href='index.php?controller=dashboard&action=announcements'">
        <div class="announcement-title"><?php echo htmlspecialchars($announcement['title']) ?></div>
        <div class="announcement-content">
            <?php
                $content = htmlspecialchars($announcement['content']);
                echo strlen($content) > 150 ? substr($content, 0, 150) . '...' : $content;
            ?>
        </div>
        <div class="announcement-meta">
            <span><i class="bi bi-person"></i> <?php echo htmlspecialchars($announcement['author']) ?></span>
            <span><i class="bi bi-clock"></i> <?php echo date('d M Y', strtotime($announcement['created_at'])) ?></span>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Recent Tickets -->
<div class="section-header">
    <h5 class="section-title">
        <i class="bi bi-ticket text-info"></i>
        My Recent Tickets
    </h5>
    <a href="index.php?controller=dashboard&action=createTicket" class="btn btn-sm btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Tiket Baru
    </a>
</div>

<?php if (empty($tickets)): ?>
<div class="card shadow-sm">
    <div class="card-body">
        <div class="empty-state">
            <div class="empty-state-icon"><i class="bi bi-inbox"></i></div>
            <h6 class="text-muted mb-3">Belum ada tiket</h6>
            <a href="index.php?controller=dashboard&action=createTicket" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Buat Tiket Baru
            </a>
        </div>
    </div>
</div>
<?php else: ?>
<div>
    <?php foreach (array_slice($tickets, 0, 5) as $ticket): ?>
    <div class="ticket-card" onclick="window.location.href='index.php?controller=dashboard&action=viewTicket&id=<?php echo $ticket['id'] ?>'">
        <div class="ticket-subject">
            <?php echo htmlspecialchars($ticket['subject']) ?>
        </div>
        <div class="ticket-meta">
            <span class="text-muted">
                <i class="bi bi-calendar3"></i>
                <?php echo date('d M Y', strtotime($ticket['created_at'])) ?>
            </span>
            <span>
                <?php
                    $badges = [
                        'open'        => 'bg-danger',
                        'in_progress' => 'bg-warning text-dark',
                        'closed'      => 'bg-success',
                    ];
                    $statusText = [
                        'open'        => 'Open',
                        'in_progress' => 'In Progress',
                        'closed'      => 'Closed',
                    ];
                ?>
                <span class="badge <?php echo $badges[$ticket['status']] ?> badge-status">
                    <?php echo $statusText[$ticket['status']] ?>
                </span>
            </span>
        </div>
    </div>
    <?php endforeach; ?>

    <div class="text-center mt-3">
        <a href="index.php?controller=dashboard&action=tickets" class="btn btn-outline-primary">
            <i class="bi bi-list-ul"></i> View All Tickets
        </a>
    </div>
</div>
<?php endif; ?>
<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>