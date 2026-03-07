<?php
    $pageTitle  = 'Ticket Details';
    $activePage = 'tickets';

    ob_start();

    // Priority badge colors
    $priorityColors = [
    'low'      => 'success',
    'medium'   => 'info',
    'high'     => 'warning',
    'critical' => 'danger',
    ];

    // Status badge colors
    $statusColors = [
    'open'        => 'primary',
    'in_progress' => 'warning',
    'closed'      => 'secondary',
    ];

    // Category icons
    $categoryIcons = [
    'hardware' => 'cpu',
    'software' => 'app-indicator',
    'network'  => 'wifi',
    'access'   => 'key',
    'email'    => 'envelope',
    'other'    => 'question-circle',
    ];
?>

<style>
.ticket-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.ticket-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-top: 1rem;
}

.ticket-meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.ticket-body {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.comment-section {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.comment-item {
    border-left: 3px solid #667eea;
    padding: 1rem;
    margin-bottom: 1rem;
    background: #f8f9fa;
    border-radius: 5px;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.comment-author {
    font-weight: 600;
    color: #667eea;
}

.comment-time {
    font-size: 0.875rem;
    color: #6c757d;
}

.comment-body {
    color: #495057;
    line-height: 1.6;
}

.reply-form {
    margin-top: 1.5rem;
    padding: 1.5rem;
    background: #f8f9fa;
    border-radius: 10px;
}

.attachment-box {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #e3f2fd;
    border-radius: 5px;
    color: #1976d2;
    text-decoration: none;
    transition: all 0.3s;
}

.attachment-box:hover {
    background: #bbdefb;
    color: #0d47a1;
}
</style>

<div class="container-fluid">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="index.php?controller=dashboard&action=tickets" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Tickets
        </a>
    </div>

    <!-- Ticket Header -->
    <div class="ticket-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-2">
                    <i class="bi bi-ticket-detailed"></i>
                    #<?php echo $ticket['id'] ?> - <?php echo htmlspecialchars($ticket['subject']) ?>
                </h3>
                <div class="ticket-meta">
                    <div class="ticket-meta-item">
                        <span class="badge bg-<?php echo $statusColors[$ticket['status']] ?>">
                            <?php echo strtoupper($ticket['status']) ?>
                        </span>
                    </div>
                    <div class="ticket-meta-item">
                        <span class="badge bg-<?php echo $priorityColors[$ticket['priority']] ?>">
                            <i class="bi bi-flag-fill"></i> <?php echo strtoupper($ticket['priority']) ?>
                        </span>
                    </div>
                    <div class="ticket-meta-item">
                        <i class="bi bi-<?php echo $categoryIcons[$ticket['category']] ?>"></i>
                        <?php echo ucfirst($ticket['category']) ?>
                    </div>
                </div>
            </div>

            <?php if ($ticket['status'] != 'closed'): ?>
            <div>
                <a href="index.php?controller=dashboard&action=closeTicket&id=<?php echo $ticket['id'] ?>"
                   class="btn btn-light"
                   onclick="return confirm('Are you sure you want to close this ticket?')">
                    <i class="bi bi-check-circle"></i> Close Ticket
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Ticket Information Details -->
    <div class="row mb-3">
        <div class="col-md-8">
            <!-- Ticket Body/Description -->
            <div class="ticket-body">
                <h5 class="mb-3"><i class="bi bi-file-text"></i> Description</h5>
                <div class="ticket-description">
                    <?php echo nl2br(htmlspecialchars($ticket['message'] ?? $ticket['description'] ?? '')) ?>
                </div>

                <?php if (! empty($ticket['attachment'])): ?>
                <div class="mt-3">
                    <h6><i class="bi bi-paperclip"></i> Attachment:</h6>
                    <a href="../public/uploads/tickets/<?php echo $ticket['attachment'] ?>"
                       target="_blank"
                       class="attachment-box">
                        <i class="bi bi-download"></i>
                        <?php echo htmlspecialchars($ticket['attachment']) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Comments Section -->
            <div class="comment-section">
                <h5 class="mb-3">
                    <i class="bi bi-chat-left-text"></i>
                    Conversation (<?php echo count($comments) ?>)
                </h5>

                <?php if (empty($comments)): ?>
                    <p class="text-muted text-center py-4">
                        <i class="bi bi-chat-left-dots" style="font-size: 3rem;"></i><br>
                        No comments yet. Be the first to reply!
                    </p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment-item">
                            <div class="comment-header">
                                <div class="comment-author">
                                    <i class="bi bi-person-circle"></i>
                                    <?php echo htmlspecialchars($comment['full_name']) ?>
                                    <?php if ($comment['role'] == 'admin'): ?>
                                        <span class="badge bg-danger">IT Support</span>
                                    <?php endif; ?>
                                </div>
                                <div class="comment-time">
                                    <i class="bi bi-clock"></i>
                                    <?php echo date('M d, Y H:i', strtotime($comment['created_at'])) ?>
                                </div>
                            </div>
                            <div class="comment-body">
                                <?php echo nl2br(htmlspecialchars($comment['comment'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Reply Form -->
                <?php if ($ticket['status'] != 'closed'): ?>
                <div class="reply-form">
                    <h6 class="mb-3"><i class="bi bi-reply"></i> Add Reply</h6>
                    <form method="POST" action="index.php?controller=dashboard&action=addComment">
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket['id'] ?>">
                        <div class="mb-3">
                            <textarea name="comment"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Type your reply here..."
                                      required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Send Reply
                        </button>
                    </form>
                </div>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> This ticket is closed. No more replies can be added.
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Ticket Sidebar Info -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-info-circle"></i> Ticket Information
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="bi bi-person"></i> Submitted By:</strong><br>
                        <?php echo htmlspecialchars($ticket['full_name']) ?><br>
                        <small class="text-muted"><?php echo htmlspecialchars($ticket['email']) ?></small>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-building"></i> Department:</strong><br>
                        <?php echo htmlspecialchars($ticket['department'] ?? 'N/A') ?>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-calendar-plus"></i> Created:</strong><br>
                        <?php echo date('M d, Y H:i', strtotime($ticket['created_at'])) ?>
                    </div>

                    <div class="mb-3">
                        <strong><i class="bi bi-calendar-check"></i> Last Updated:</strong><br>
                        <?php echo date('M d, Y H:i', strtotime($ticket['updated_at'])) ?>
                    </div>

                    <?php if ($ticket['assigned_full_name']): ?>
                    <div class="mb-3">
                        <strong><i class="bi bi-person-badge"></i> Assigned To:</strong><br>
                        <?php echo htmlspecialchars($ticket['assigned_full_name']) ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($ticket['status'] == 'closed'): ?>
                    <div class="mb-3">
                        <strong><i class="bi bi-check-circle"></i> Closed At:</strong><br>
                        <?php echo date('M d, Y H:i', strtotime($ticket['closed_at'])) ?>
                    </div>
                    <div class="mb-3">
                        <strong><i class="bi bi-person-check"></i> Closed By:</strong><br>
                        <?php echo htmlspecialchars($ticket['closed_by_full_name'] ?? 'N/A') ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require_once '../app/Views/layouts/user_layout.php';
?>
