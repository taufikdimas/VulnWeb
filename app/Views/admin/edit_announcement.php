<?php
    $pageTitle  = 'Edit Announcement';
    $activePage = 'announcements';

    ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <i class="bi bi-pencil"></i>
                <strong>Edit Announcement</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?controller=admin&action=editAnnouncement&id=<?php echo $announcement['id'] ?>" enctype="multipart/form-data">
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-type"></i> Title *
                        </label>
                        <input type="text"
                               class="form-control"
                               name="title"
                               value="<?php echo htmlspecialchars($announcement['title']) ?>"
                               required>
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-file-text"></i> Content *
                        </label>
                        <textarea class="form-control"
                                  name="content"
                                  rows="8"
                                  required
                                  placeholder="Write your announcement content here..."><?php echo htmlspecialchars($announcement['content']) ?></textarea>
                        <div class="form-text">Detailed information about this announcement</div>
                    </div>

                    <!-- Current Attachment -->
                    <?php if (! empty($announcement['attachment'])): ?>
                    <div class="mb-3">
                        <div class="alert alert-info">
                            <i class="bi bi-paperclip"></i>
                            <strong>Current Attachment:</strong>
                            <a href="<?php echo htmlspecialchars($announcement['attachment']) ?>" target="_blank" class="alert-link">
                                <?php echo basename($announcement['attachment']) ?>
                            </a>
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="remove_attachment" value="1" id="removeAttachment">
                                <label class="form-check-label" for="removeAttachment">
                                    Remove current attachment
                                </label>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- New Attachment -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-paperclip"></i>
                            <?php echo ! empty($announcement['attachment']) ? 'Replace Attachment (Optional)' : 'Add Attachment (Optional)' ?>
                        </label>
                        <input type="file" class="form-control" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip">
                        <div class="form-text">
                            Allowed types: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP. Maximum size: 5MB
                        </div>
                    </div>

                    <!-- Metadata Info -->
                    <div class="card mb-3 bg-light">
                        <div class="card-body">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                <strong>Created by:</strong> <?php echo htmlspecialchars($announcement['author']) ?>
                                on <?php echo date('M d, Y H:i', strtotime($announcement['created_at'])) ?>
                            </small>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Update Announcement
                        </button>
                        <a href="index.php?controller=admin&action=announcements" class="btn btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>

