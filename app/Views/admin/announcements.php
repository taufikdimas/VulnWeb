<?php
    $pageTitle  = 'Announcements';
    $activePage = 'announcements';

    ob_start();
?>

<style>
.search-wrapper {
    margin-bottom: 1.5rem;
}

.search-input-wrapper {
    position: relative;
}

.search-input-wrapper i {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1rem;
    z-index: 10;
}

.search-input-wrapper .form-control {
    padding-left: 48px;
    height: 48px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.search-input-wrapper .form-control:focus {
    border-color: #4299e1;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
}

.btn-action {
    height: 48px;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    border: none;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
}

.btn-action.btn-primary {
    background-color: #0d6efd;
}

.btn-action.btn-primary:hover {
    background-color: #0b5ed7;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.4);
}

.btn-action.btn-danger {
    background-color: #dc3545;
}

.btn-action.btn-danger:hover {
    background-color: #bb2d3b;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.table-card {
    background: white;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
}

.table-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    background: #f8f9fa;
}

.table-header h5 {
    margin: 0;
    color: #1e293b;
    font-size: 1rem;
    font-weight: 600;
}

.table-modern {
    margin: 0;
}

.table-modern thead th {
    background: #f8f9fa;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.7rem;
    letter-spacing: 0.5px;
    color: #64748b;
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 2px solid #e2e8f0;
}

.table-modern tbody td {
    padding: 1rem 1.5rem;
    vertical-align: middle;
    border: none;
    border-bottom: 1px solid #f1f5f9;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    cursor: pointer;
}

.table-modern tbody tr:hover {
    background: #e2e8f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transform: translateY(-1px);
}

.attachment-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    background: #e0f2fe;
    border-radius: 4px;
    font-size: 0.75rem;
    color: #0284c7;
    margin-left: 0.5rem;
}
</style>

<!-- Search & Actions -->
<div class="search-wrapper">
    <form method="GET" action="index.php" id="searchForm">
        <input type="hidden" name="controller" value="admin">
        <input type="hidden" name="action" value="announcements">

        <div class="row g-2">
            <!-- Search -->
            <div class="col-lg-9 col-md-7">
                <div class="search-input-wrapper">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           class="form-control"
                           name="search"
                           placeholder="Search announcements by title or content..."
                           value="<?php echo htmlspecialchars($search ?? '') ?>">
                </div>
            </div>

            <!-- Clear Search -->
            <div class="col-lg-1 col-md-2">
                <button type="button"
                        class="btn btn-danger w-100 btn-action"
                        onclick="window.location.href='index.php?controller=admin&action=announcements'"
                        title="Clear Search">
                    <i class="bi bi-x-circle"></i> Clear
                </button>
            </div>

            <!-- Add New Announcement -->
            <div class="col-lg-2 col-md-3">
                <a href="index.php?controller=admin&action=createAnnouncement"
                   class="btn btn-primary w-100 btn-action">
                    <i class="bi bi-plus-circle"></i> Add New
                </a>
            </div>
        </div>
    </form>
</div>

<!-- Announcements List -->
<div class="table-card">
    <div class="table-responsive">
        <?php if (empty($announcements)): ?>
            <div class="text-center py-5">
                <i class="bi bi-megaphone" style="font-size: 4rem; color: #cbd5e0;"></i>
                <p class="text-muted mt-3">No announcements found.</p>
                <a href="index.php?controller=admin&action=createAnnouncement" class="btn btn-primary btn-action">
                    <i class="bi bi-plus-circle"></i> Create First Announcement
                </a>
            </div>
        <?php else: ?>
            <table class="table table-modern mb-0">
                <thead>
                    <tr>
                        <th style="width: 5%">#</th>
                        <th style="width: 35%">TITLE</th>
                        <th style="width: 35%">CONTENT</th>
                        <th style="width: 12%">AUTHOR</th>
                        <th style="width: 10%">DATE</th>
                        <th style="width: 8%" class="text-center">DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;foreach ($announcements as $announcement): ?>
                    <tr onclick="window.location.href='index.php?controller=admin&action=viewAnnouncement&id=<?php echo $announcement['id'] ?>'">
                        <td><span class="text-muted"><?php echo $no++ ?></span></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <strong class="text-dark"><?php echo htmlspecialchars($announcement['title']) ?></strong>
                                <?php if (! empty($announcement['attachment'])): ?>
                                    <span class="attachment-badge">
                                        <i class="bi bi-paperclip"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.9rem;">
                                <?php
                                    $content = strip_tags($announcement['content']);
                                    echo strlen($content) > 100 ? substr($content, 0, 100) . '...' : $content;
                                ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.875rem;">
                                <i class="bi bi-person-circle"></i>
                                <?php echo htmlspecialchars($announcement['author']) ?>
                            </span>
                        </td>
                        <td>
                            <span class="text-muted" style="font-size: 0.875rem;">
                                <?php echo date('d M Y', strtotime($announcement['created_at'])) ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="index.php?controller=admin&action=viewAnnouncement&id=<?php echo $announcement['id'] ?>"
                               class="btn btn-sm btn-primary"
                               onclick="event.stopPropagation();">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="px-3 py-3 text-muted small border-top">
                Showing <?php echo count($announcements) ?> announcement(s)
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/admin_layout.php';
?>

