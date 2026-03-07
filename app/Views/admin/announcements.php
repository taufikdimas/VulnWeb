<?php
    $pageTitle  = 'Announcements';
    $activePage = 'announcements';

    ob_start();
?>

<style>
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

.announcement-table th {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #495057;
    padding: 1rem;
    border: none;
}

.announcement-table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f0f0f0;
}

.announcement-table tbody tr:hover {
    background: #f8f9fa;
}

.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    transition: all 0.2s;
}

.action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.clear-search-btn {
    height: 46px;
    width: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.clear-search-btn:hover {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
    transform: rotate(90deg);
}
</style>

<!-- Search & Actions -->
<div class="card shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" action="index.php" id="searchForm">
            <input type="hidden" name="controller" value="admin">
            <input type="hidden" name="action" value="announcements">

            <div class="row g-3 align-items-center">
                <!-- Search -->
                <div class="col-lg-9 col-md-8">
                    <div class="position-relative">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text"
                               class="form-control search-input"
                               name="search"
                               placeholder="Search announcements by title or content..."
                               value="<?php echo htmlspecialchars($search ?? '') ?>">
                    </div>
                </div>

                <!-- Clear Search -->
                <div class="col-lg-1 col-md-1">
                    <button type="button"
                            class="btn btn-outline-secondary clear-search-btn w-100"
                            onclick="window.location.href='index.php?controller=admin&action=announcements'"
                            title="Clear Search">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>

                <!-- Add New Announcement -->
                <div class="col-lg-2 col-md-3">
                    <a href="index.php?controller=admin&action=createAnnouncement"
                       class="btn btn-primary w-100"
                       style="height: 46px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                        <i class="bi bi-plus-circle"></i> <span class="ms-1">Add New</span>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Announcements List -->
<div class="card shadow-sm">
    <div class="card-header bg-warning text-white">
        <i class="bi bi-megaphone"></i>
        <strong>Manage Announcements</strong>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <?php if (empty($announcements)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-megaphone" style="font-size: 4rem; color: #ccc;"></i>
                    <p class="text-muted mt-3">No announcements found.</p>
                    <a href="index.php?controller=admin&action=createAnnouncement" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create First Announcement
                    </a>
                </div>
            <?php else: ?>
                <table class="table announcement-table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 30%">Title</th>
                            <th style="width: 35%">Content</th>
                            <th style="width: 15%">Author</th>
                            <th style="width: 10%">Date</th>
                            <th style="width: 5%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;foreach ($announcements as $announcement): ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <strong><?php echo htmlspecialchars($announcement['title']) ?></strong>
                                    <?php if (! empty($announcement['attachment'])): ?>
                                        <i class="bi bi-paperclip text-primary ms-2" title="Has attachment"></i>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php
                                        $content = strip_tags($announcement['content']);
                                        echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content;
                                    ?>
                                </small>
                            </td>
                            <td>
                                <small>
                                    <i class="bi bi-person"></i>
                                    <?php echo htmlspecialchars($announcement['author']) ?>
                                </small>
                            </td>
                            <td>
                                <small class="text-muted">
                                    <?php echo date('d M Y', strtotime($announcement['created_at'])) ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <a href="index.php?controller=admin&action=editAnnouncement&id=<?php echo $announcement['id'] ?>"
                                       class="btn btn-warning action-btn"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="index.php?controller=admin&action=deleteAnnouncement&id=<?php echo $announcement['id'] ?>"
                                       class="btn btn-danger action-btn"
                                       onclick="return confirm('Delete this announcement?')"
                                       title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="mt-3 text-muted small">
                    Showing <?php echo count($announcements) ?> announcement(s)
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>

