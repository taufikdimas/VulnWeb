<?php
    $pageTitle  = 'Announcement Detail';
    $activePage = 'announcements';

    ob_start();
?>
<style>
.detail-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s;
}

.detail-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
}

.detail-header {
    padding: 2rem;
    border-bottom: 1px solid #e2e8f0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.detail-header h5 {
    margin: 0;
    color: white;
    font-size: 1.25rem;
    font-weight: 600;
}

.detail-header .text-muted {
    color: rgba(255, 255, 255, 0.9) !important;
    font-size: 0.95rem;
}

.detail-content {
    padding: 2rem;
}

.detail-row {
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 1.5rem;
    padding: 1.25rem 0;
    border-bottom: 1px solid #f1f5f9;
    align-items: start;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.detail-label i {
    color: #94a3b8;
    font-size: 1rem;
    width: 18px;
    display: inline-flex;
    justify-content: center;
}

.detail-value {
    color: #1e293b;
    font-size: 0.95rem;
    word-break: break-word;
}

.detail-value .badge {
    padding: 0.4rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 600;
}

.detail-value .text-muted {
    color: #64748b !important;
    font-size: 0.9rem;
}

.detail-value strong {
    color: #1e293b;
    font-weight: 600;
}

.detail-value a {
    color: #4299e1;
    transition: all 0.2s;
}

.detail-value a:hover {
    color: #3182ce;
}

.announcement-content {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    line-height: 1.7;
}

.attachment-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem 1.25rem;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.2s;
    text-decoration: none !important;
}

.attachment-card:hover {
    background: #e2e8f0;
    border-color: #cbd5e0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.attachment-card i {
    font-size: 1.5rem;
    color: #4299e1;
}

.attachment-card .attachment-name {
    color: #1e293b;
    font-weight: 600;
    font-size: 0.95rem;
}

.attachment-preview {
    margin-top: 1rem;
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.attachment-preview img {
    max-width: 100%;
    height: auto;
    display: block;
}

.attachment-preview iframe,
.attachment-preview embed {
    width: 100%;
    min-height: 600px;
    border: none;
}

.preview-header {
    background: #f8f9fa;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.preview-header .file-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 600;
}

.preview-header .file-info i {
    font-size: 1rem;
}

.btn-download {
    background: #0d6efd;
    color: white;
    border: none;
    padding: 0.4rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
}

.btn-download:hover {
    background: #0b5ed7;
    color: white !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
}

.action-buttons {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-top: 1.5rem;
}

.action-button {
    height: 50px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    text-decoration: none !important;
}

.action-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    text-decoration: none !important;
}

.action-button i {
    font-size: 1.1rem;
}

.btn-update {
    background-color: #0d6efd;
    color: white !important;
}

.btn-update:hover {
    background-color: #0b5ed7;
    color: white !important;
    box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4) !important;
}

.btn-delete {
    background-color: #dc3545;
    color: white !important;
}

.btn-delete:hover {
    background-color: #bb2d3b;
    color: white !important;
    box-shadow: 0 8px 20px rgba(220, 53, 69, 0.4) !important;
}

@media (max-width: 768px) {
    .detail-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
        padding: 1rem 0;
    }

    .detail-label {
        font-size: 0.8rem;
    }

    .action-buttons {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .detail-header {
        padding: 1.5rem;
    }

    .detail-content {
        padding: 1.5rem;
    }
}
</style>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <!-- Back Button -->
        <div class="mb-3">
            <a href="index.php?controller=admin&action=announcements" class="btn btn-link text-decoration-none ps-0">
                <i class="bi bi-arrow-left"></i> Back to Announcements List
            </a>
        </div>

        <!-- Announcement Detail Card -->
        <div class="detail-card">
            <div class="detail-header">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="mb-1">
                            <i class="bi bi-megaphone-fill me-2"></i><?php echo htmlspecialchars($announcement['title']) ?>
                        </h5>
                        <span class="text-muted">
                            <i class="bi bi-person-circle me-1"></i>
                            by <?php echo htmlspecialchars($announcement['author']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="detail-content">
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-hash"></i>Announcement ID
                    </div>
                    <div class="detail-value">
                        <span class="badge bg-primary text-white" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">#<?php echo $announcement['id'] ?></span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-type"></i>Title
                    </div>
                    <div class="detail-value">
                        <strong><?php echo htmlspecialchars($announcement['title']) ?></strong>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-file-text"></i>Content
                    </div>
                    <div class="detail-value">
                        <div class="announcement-content">
                            <?php echo nl2br(htmlspecialchars($announcement['content'])) ?>
                        </div>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-person-badge"></i>Author
                    </div>
                    <div class="detail-value">
                        <span class="badge bg-light text-dark border" style="font-size: 0.85rem; padding: 0.4rem 0.8rem;">
                            <i class="bi bi-person-fill me-1"></i><?php echo htmlspecialchars($announcement['author']) ?>
                        </span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-calendar-plus"></i>Created At
                    </div>
                    <div class="detail-value">
                        <span class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <?php echo date('d M Y, H:i', strtotime($announcement['created_at'])) ?>
                        </span>
                    </div>
                </div>

                <?php if (! empty($announcement['attachment'])): ?>
                <div class="detail-row">
                    <div class="detail-label">
                        <i class="bi bi-paperclip"></i>Attachment
                    </div>
                    <div class="detail-value">
                        <a href="index.php?controller=admin&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                           class="attachment-card"
                           download="<?php echo htmlspecialchars($announcement['attachment']) ?>">
                            <i class="bi bi-file-earmark-arrow-down"></i>
                            <div>
                                <div class="attachment-name"><?php echo htmlspecialchars($announcement['attachment']) ?></div>
                                <small class="text-muted">Click to download</small>
                            </div>
                        </a>

                        <?php
                            // Get file extension and mime type for preview
                            $filename = $announcement['attachment'];
                            $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                            $mimeType = $announcement['attachment_mime'] ?? '';

                            // Check if it's an image
                            $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'];
                            $isImage   = in_array($ext, $imageExts) || strpos($mimeType, 'image/') === 0;

                            // Check if it's a PDF
                            $isPdf = $ext === 'pdf' || strpos($mimeType, 'application/pdf') === 0;
                        ?>

                        <?php if ($isImage): ?>
                            <!-- Image Preview -->
                            <div class="attachment-preview mt-3">
                                <div class="preview-header">
                                    <div class="file-info">
                                        <i class="bi bi-image"></i>
                                        <span>Image Preview</span>
                                    </div>
                                    <a href="index.php?controller=admin&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                                       class="btn-download"
                                       download="<?php echo htmlspecialchars($announcement['attachment']) ?>">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                                <div class="p-3">
                                    <img src="index.php?controller=admin&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                                         alt="<?php echo htmlspecialchars($announcement['attachment']) ?>"
                                         class="img-fluid">
                                </div>
                            </div>
                        <?php elseif ($isPdf): ?>
                            <!-- PDF Preview -->
                            <div class="attachment-preview mt-3">
                                <div class="preview-header">
                                    <div class="file-info">
                                        <i class="bi bi-file-pdf"></i>
                                        <span>PDF Preview</span>
                                    </div>
                                    <a href="index.php?controller=admin&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                                       class="btn-download"
                                       download="<?php echo htmlspecialchars($announcement['attachment']) ?>">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                </div>
                                <embed src="index.php?controller=admin&action=getAnnouncementAttachment&id=<?php echo $announcement['id'] ?>"
                                       type="application/pdf">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="index.php?controller=admin&action=editAnnouncement&id=<?php echo $announcement['id'] ?>"
               class="action-button btn-update">
                <i class="bi bi-pencil-fill"></i> Update Announcement
            </a>

            <a href="index.php?controller=admin&action=deleteAnnouncement&id=<?php echo $announcement['id'] ?>"
               class="action-button btn-delete"
               onclick="return confirm('Are you sure you want to delete this announcement? This action cannot be undone.')">
                <i class="bi bi-trash-fill"></i> Delete Announcement
            </a>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>
