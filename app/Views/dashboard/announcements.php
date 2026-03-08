<?php
    $pageTitle  = 'Announcements';
    $activePage = 'announcements';

    ob_start();
?>

<style>
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
}

.search-wrapper {
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper i {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
    z-index: 10;
}

.search-input-wrapper input {
    padding-left: 48px;
    height: 48px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.search-input-wrapper input:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    outline: none;
}

.btn-clear {
    height: 48px;
    border-radius: 8px;
    font-weight: 600;
}

.announcement-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1rem;
    transition: all 0.3s;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.announcement-card::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #fbbf24;
    transition: width 0.3s;
}

.announcement-card:hover {
    border-color: #fbbf24;
    box-shadow: 0 4px 16px rgba(251, 191, 36, 0.15);
    transform: translateY(-2px);
}

.announcement-card:hover::before {
    width: 6px;
}

.announcement-header {
    display: flex;
    align-items: start;
    gap: 1rem;
    margin-bottom: 1rem;
}

.announcement-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(251, 191, 36, 0.3);
}

.announcement-icon i {
    color: white;
    font-size: 1.25rem;
}

.announcement-content {
    flex: 1;
}

.announcement-title {
    font-size: 1.15rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.announcement-meta {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    font-size: 0.85rem;
    color: #64748b;
    flex-wrap: wrap;
}

.announcement-meta span {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.announcement-meta i {
    color: #94a3b8;
}

.announcement-text {
    color: #475569;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.announcement-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 0.75rem;
    border-top: 1px solid #f1f5f9;
}

.attachment-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.8rem;
    color: #475569;
    font-weight: 500;
}

.attachment-badge i {
    color: #64748b;
}

.read-more-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.85rem;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
}

.read-more-btn:hover {
    background: #2563eb;
    color: white;
    transform: translateX(2px);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 12px;
    border: 2px dashed #e2e8f0;
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e0;
    margin-bottom: 1rem;
}

.empty-state h5 {
    color: #475569;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #94a3b8;
    margin: 0;
}
</style>

<!-- Search Box -->
<div class="search-wrapper">
    <form method="GET" action="index.php">
        <input type="hidden" name="controller" value="dashboard">
        <input type="hidden" name="action" value="announcements">

        <div class="row g-3">
            <div class="col-md-11">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search announcements by title or content..."
                           value="<?php echo htmlspecialchars($search ?? '') ?>">
                </div>
            </div>
            <div class="col-md-1">
                <button type="button"
                        class="btn btn-danger w-100 btn-clear"
                        onclick="window.location.href='index.php?controller=dashboard&action=announcements'"
                        title="Clear Search">
                    <i class="bi bi-x-circle"></i> Clear
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Announcements List -->
<?php if (empty($announcements)): ?>
    <div class="empty-state">
        <i class="bi bi-megaphone"></i>
        <h5>No Announcements Found</h5>
        <p>There are currently no announcements to display.</p>
    </div>
<?php else: ?>
    <?php foreach ($announcements as $announcement): ?>
        <div class="announcement-card" onclick="window.location.href='index.php?controller=dashboard&action=viewAnnouncement&id=<?php echo $announcement['id'] ?>'">
            <div class="announcement-header">
                <div class="announcement-icon">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div class="announcement-content">
                    <div class="announcement-title">
                        <?php echo htmlspecialchars($announcement['title']) ?>
                    </div>
                    <div class="announcement-meta">
                        <span>
                            <i class="bi bi-person-circle"></i>
                            <?php echo htmlspecialchars($announcement['author']) ?>
                        </span>
                        <span>
                            <i class="bi bi-calendar3"></i>
                            <?php echo date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="announcement-text">
                <?php
                    $content = htmlspecialchars($announcement['content']);
                    if (strlen($content) > 200) {
                        echo substr($content, 0, 200) . '...';
                    } else {
                        echo $content;
                    }
                ?>
            </div>

            <div class="announcement-footer">
                <div>
                    <?php if (!empty($announcement['attachment'])): ?>
                        <?php
                            $extension = strtolower(pathinfo($announcement['attachment'], PATHINFO_EXTENSION));
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            $isImage = in_array($extension, $imageExtensions);
                        ?>
                        <span class="attachment-badge">
                            <i class="bi bi-<?php echo $isImage ? 'image' : 'paperclip' ?>"></i>
                            <?php echo $isImage ? 'Image attached' : 'File attached' ?>
                        </span>
                    <?php endif; ?>
                </div>
                <a href="index.php?controller=dashboard&action=viewAnnouncement&id=<?php echo $announcement['id'] ?>"
                   class="read-more-btn"
                   onclick="event.stopPropagation()">
                    Read More
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <small class="text-muted">
            Showing <?php echo count($announcements) ?> announcement(s)
        </small>
    </div>
<?php endif; ?>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/user_layout.php';
?>
