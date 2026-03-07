<?php
    $pageTitle  = 'Announcements';
    $activePage = 'announcements';

    ob_start();
?>

<style>
.announcement-card {
    transition: all 0.3s;
    border-left: 4px solid #ffc107;
}

.announcement-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}

.announcement-date {
    font-size: 0.85rem;
    color: #6c757d;
}

.attachment-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #e3f2fd;
    border-radius: 8px;
    color: #1976d2;
    text-decoration: none;
    transition: all 0.2s;
    font-size: 0.9rem;
}

.attachment-badge:hover {
    background: #bbdefb;
    color: #0d47a1;
    transform: translateX(5px);
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
</style>

<!-- Search Box -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="index.php">
            <input type="hidden" name="controller" value="dashboard">
            <input type="hidden" name="action" value="announcements">

            <div class="row align-items-center">
                <div class="col-md-10">
                    <div class="position-relative">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text"
                               class="form-control search-input"
                               name="search"
                               placeholder="Search announcements by title or content..."
                               value="<?php echo htmlspecialchars($search ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-outline-secondary w-100"
                            style="height: 46px; border-radius: 10px;"
                            onclick="window.location.href='index.php?controller=dashboard&action=announcements'">
                        <i class="bi bi-x-circle"></i> Clear
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Announcements List -->
<?php if (empty($announcements)): ?>
    <div class="text-center py-5">
        <i class="bi bi-megaphone" style="font-size: 5rem; color: #ccc;"></i>
        <h3 class="mt-3 text-muted">No Announcements Found</h3>
        <p class="text-muted">There are currently no announcements to display.</p>
    </div>
<?php else: ?>
    <?php foreach ($announcements as $announcement): ?>
        <div class="card announcement-card shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="card-title mb-2">
                            <i class="bi bi-megaphone-fill text-warning me-2"></i>
                            <?php echo htmlspecialchars($announcement['title']) ?>
                        </h4>
                        <div class="announcement-date">
                            <i class="bi bi-person-circle"></i>
                            <small><?php echo htmlspecialchars($announcement['author']) ?></small>
                            <span class="mx-2">•</span>
                            <i class="bi bi-calendar-event"></i>
                            <small><?php echo date('d M Y, H:i', strtotime($announcement['created_at'])) ?></small>
                        </div>
                    </div>
                </div>

                <div class="card-text">
                    <?php echo $announcement['content'] ?>
                </div>

                <?php if (! empty($announcement['attachment'])): ?>
                    <div class="mt-3 pt-3 border-top">
                        <h6 class="mb-2"><i class="bi bi-paperclip"></i> Attachment:</h6>
                        <a href="index.php?controller=dashboard&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                           class="attachment-badge"
                           target="_blank"
                           download="<?php echo htmlspecialchars($announcement['attachment']) ?>">
                            <i class="bi bi-download me-2"></i>
                            <?php
                                $fileName = $announcement['attachment'];
                                $fileExt  = strtoupper(pathinfo($fileName, PATHINFO_EXTENSION));
                                echo htmlspecialchars($fileName) . ' (' . $fileExt . ')';
                            ?>
                        </a>

                        <?php
                            // Check if file is an image
                            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            $extension       = strtolower(pathinfo($announcement['attachment'], PATHINFO_EXTENSION));

                            if (in_array($extension, $imageExtensions)):
                        ?>
                            <div class="mt-3">
                                <img src="index.php?controller=dashboard&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                                     alt="Attachment Preview"
                                     class="img-fluid rounded"
                                     style="max-width: 100%; max-height: 400px; object-fit: contain; border: 1px solid #dee2e6;">
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
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
