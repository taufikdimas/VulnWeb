<?php
    $pageTitle  = 'Create Announcement';
    $activePage = 'announcements';

    ob_start();
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white">
                <i class="bi bi-megaphone"></i>
                <strong>Create New Announcement</strong>
            </div>
            <div class="card-body">
                <form method="POST" action="index.php?controller=admin&action=createAnnouncement" enctype="multipart/form-data">
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-type"></i> Title *
                        </label>
                        <input type="text" class="form-control" name="title" required placeholder="Enter announcement title">
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-file-text"></i> Content *
                        </label>
                        <textarea class="form-control" name="content" rows="8" required placeholder="Write your announcement content here..."></textarea>
                        <div class="form-text">Detailed information about this announcement</div>
                    </div>

                    <!-- Attachment -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-paperclip"></i> Attachment (Optional)
                        </label>
                        <input type="file" class="form-control" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.zip">
                        <div class="form-text">
                            Allowed types: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG, ZIP. Maximum size: 5MB
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Create Announcement
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

