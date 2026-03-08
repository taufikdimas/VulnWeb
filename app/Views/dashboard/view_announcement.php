<?php
    $pageTitle  = 'Announcement Detail';
    $activePage = 'announcements';

    ob_start();
?>

<style>
.announcement-detail-header {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.detail-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.detail-icon {
    width: 48px;
    height: 48px;
    background: #fbbf24;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.detail-icon i {
    color: white;
    font-size: 1.3rem;
}

.detail-meta {
    display: flex;
    gap: 1.5rem;
    font-size: 0.9rem;
    color: #718096;
}

.detail-meta-item {
    display: flex;
    align-items: center;
    gap: 0.4rem;
}

.detail-content-box {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.content-text {
    font-size: 1rem;
    line-height: 1.7;
    color: #2d3748;
    white-space: pre-line;
}

.attachment-box {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1.5rem;
}

.attachment-item {
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0;
}

.attachment-info-group {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.file-icon {
    width: 44px;
    height: 44px;
    background: #4299e1;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.3rem;
}

.file-details {
    display: flex;
    flex-direction: column;
}

.file-name {
    font-weight: 500;
    color: #1a202c;
    margin-bottom: 0.2rem;
    font-size: 0.9rem;
}

.file-type {
    font-size: 0.8rem;
    color: #718096;
}

.download-button {
    background: #4299e1;
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.download-button:hover {
    background: #3182ce;
    color: white;
}

.image-container {
    margin-top: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    padding: 0.75rem;
    background: #f7fafc;
}

.image-container img {
    width: 100%;
    height: auto;
    border-radius: 4px;
}

.pdf-container {
    margin-top: 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
    background: #f7fafc;
}

.pdf-container embed {
    width: 100%;
    min-height: 600px;
    border: none;
    display: block;
}

.back-button {
    margin-bottom: 1.5rem;
}
</style>

<div class="back-button">
    <a href="index.php?controller=dashboard&action=announcements" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Announcements
    </a>
</div>

<div class="announcement-detail-header">
    <div class="detail-title">
        <div class="detail-icon">
            <i class="bi bi-megaphone-fill"></i>
        </div>
        <div>
            <?php echo htmlspecialchars($announcement['title']) ?>
        </div>
    </div>
    <div class="detail-meta">
        <div class="detail-meta-item">
            <i class="bi bi-person-circle"></i>
            <span><?php echo htmlspecialchars($announcement['author']) ?></span>
        </div>
        <div class="detail-meta-item">
            <i class="bi bi-calendar3"></i>
            <span><?php echo date('d M Y', strtotime($announcement['created_at'])) ?></span>
        </div>
        <div class="detail-meta-item">
            <i class="bi bi-clock"></i>
            <span><?php echo date('H:i', strtotime($announcement['created_at'])) ?></span>
        </div>
    </div>
</div>

<div class="detail-content-box">
    <h5 style="font-weight: 600; color: #1a202c; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="bi bi-file-text"></i>
        Description
    </h5>
    <div class="content-text">
        <?php echo htmlspecialchars($announcement['content']) ?>
    </div>
</div>

<?php if (! empty($announcement['attachment'])): ?>
<div class="attachment-box">
    <h5 style="font-weight: 600; color: #1a202c; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
        <i class="bi bi-paperclip"></i>
        Attachment
    </h5>

    <div class="attachment-item">
        <div class="attachment-info-group">
            <div class="file-icon">
                <?php
                    $extension       = strtolower(pathinfo($announcement['attachment'], PATHINFO_EXTENSION));
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                    $isImage         = in_array($extension, $imageExtensions);
                    $isPdf           = $extension === 'pdf';

                    if ($isImage) {
                        echo '<i class="bi bi-image"></i>';
                    } elseif ($isPdf) {
                        echo '<i class="bi bi-file-pdf"></i>';
                    } elseif (in_array($extension, ['doc', 'docx'])) {
                        echo '<i class="bi bi-file-word"></i>';
                    } elseif (in_array($extension, ['xls', 'xlsx'])) {
                        echo '<i class="bi bi-file-excel"></i>';
                    } else {
                        echo '<i class="bi bi-file-earmark"></i>';
                    }
                ?>
            </div>
            <div class="file-details">
                <div class="file-name"><?php echo htmlspecialchars($announcement['attachment']) ?></div>
                <div class="file-type"><?php echo strtoupper($extension) ?> File</div>
            </div>
        </div>
        <a href="index.php?controller=dashboard&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
            class="download-button" download="<?php echo htmlspecialchars($announcement['attachment']) ?>">
            <i class="bi bi-download"></i>
            Download
        </a>
    </div>

    <?php if ($isImage): ?>
    <div class="image-container">
        <img src="index.php?controller=dashboard&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
            alt="<?php echo htmlspecialchars($announcement['attachment']) ?>">
    </div>
    <?php elseif ($isPdf): ?>
    <div class="pdf-container">
        <embed src="index.php?controller=dashboard&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
               type="application/pdf">
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php
    $content = ob_get_clean();
require __DIR__ . '/../layouts/user_layout.php';
?>