<?php
    $pageTitle  = 'Create New Ticket';
    $activePage = 'tickets';

    ob_start();
?>

<style>
.form-section {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.form-section h6 {
    color: #667eea;
    margin-bottom: 1rem;
}

.priority-option, .category-option {
    padding: 1rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s;
    text-align: center;
}

.priority-option:hover, .category-option:hover {
    border-color: #667eea;
    background: #f0f0ff;
}

.priority-option input[type="radio"]:checked + label,
.category-option input[type="radio"]:checked + label {
    font-weight: bold;
}
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="index.php?controller=dashboard&action=tickets" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Tickets
                </a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Create New IT Support Ticket</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?controller=dashboard&action=createTicket" enctype="multipart/form-data">
                        <!-- Basic Information -->
                        <div class="form-section">
                            <h6><i class="bi bi-file-text"></i> Ticket Details</h6>

                            <div class="mb-3">
                                <label class="form-label">Subject / Title *</label>
                                <input type="text"
                                       class="form-control"
                                       name="subject"
                                       placeholder="Brief description of your issue"
                                       required>
                                <small class="text-muted">Example: "Cannot access email" or "Printer not working"</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description *</label>
                                <textarea class="form-control"
                                          name="description"
                                          rows="6"
                                          placeholder="Please provide detailed information about your issue..."
                                          required></textarea>
                                <small class="text-muted">Include any error messages, steps to reproduce, or what you've already tried.</small>
                            </div>
                        </div>

                        <!-- Priority Selection -->
                        <div class="form-section">
                            <h6><i class="bi bi-flag-fill"></i> Priority Level *</h6>
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="priority-option">
                                        <input type="radio" name="priority" value="low" id="priority_low" class="form-check-input">
                                        <label for="priority_low" class="d-block mt-2">
                                            <i class="bi bi-flag text-success" style="font-size: 1.5rem;"></i><br>
                                            <strong>Low</strong><br>
                                            <small>Minor issue</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="priority-option">
                                        <input type="radio" name="priority" value="medium" id="priority_medium" class="form-check-input" checked>
                                        <label for="priority_medium" class="d-block mt-2">
                                            <i class="bi bi-flag text-info" style="font-size: 1.5rem;"></i><br>
                                            <strong>Medium</strong><br>
                                            <small>Normal issue</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="priority-option">
                                        <input type="radio" name="priority" value="high" id="priority_high" class="form-check-input">
                                        <label for="priority_high" class="d-block mt-2">
                                            <i class="bi bi-flag text-warning" style="font-size: 1.5rem;"></i><br>
                                            <strong>High</strong><br>
                                            <small>Important issue</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="priority-option">
                                        <input type="radio" name="priority" value="critical" id="priority_critical" class="form-check-input">
                                        <label for="priority_critical" class="d-block mt-2">
                                            <i class="bi bi-flag text-danger" style="font-size: 1.5rem;"></i><br>
                                            <strong>Critical</strong><br>
                                            <small>Urgent!</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Selection -->
                        <div class="form-section">
                            <h6><i class="bi bi-grid-3x3-gap"></i> Category *</h6>
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="hardware" id="cat_hardware" class="form-check-input">
                                        <label for="cat_hardware" class="d-block mt-2">
                                            <i class="bi bi-cpu" style="font-size: 1.5rem;"></i><br>
                                            <strong>Hardware</strong><br>
                                            <small>PC, Laptop, Printer, etc</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="software" id="cat_software" class="form-check-input">
                                        <label for="cat_software" class="d-block mt-2">
                                            <i class="bi bi-app-indicator" style="font-size: 1.5rem;"></i><br>
                                            <strong>Software</strong><br>
                                            <small>Applications, OS issues</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="network" id="cat_network" class="form-check-input">
                                        <label for="cat_network" class="d-block mt-2">
                                            <i class="bi bi-wifi" style="font-size: 1.5rem;"></i><br>
                                            <strong>Network</strong><br>
                                            <small>Internet, WiFi, VPN</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="access" id="cat_access" class="form-check-input">
                                        <label for="cat_access" class="d-block mt-2">
                                            <i class="bi bi-key" style="font-size: 1.5rem;"></i><br>
                                            <strong>Access</strong><br>
                                            <small>Password, Permissions</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="email" id="cat_email" class="form-check-input">
                                        <label for="cat_email" class="d-block mt-2">
                                            <i class="bi bi-envelope" style="font-size: 1.5rem;"></i><br>
                                            <strong>Email</strong><br>
                                            <small>Email related issues</small>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <div class="category-option">
                                        <input type="radio" name="category" value="other" id="cat_other" class="form-check-input" checked>
                                        <label for="cat_other" class="d-block mt-2">
                                            <i class="bi bi-question-circle" style="font-size: 1.5rem;"></i><br>
                                            <strong>Other</strong><br>
                                            <small>Other IT issues</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attachment -->
                        <div class="form-section">
                            <h6><i class="bi bi-paperclip"></i> Attachment (Optional)</h6>
                            <div class="mb-3">
                                <input type="file"
                                       class="form-control"
                                       name="attachment"
                                       accept="image/*,.pdf,.doc,.docx,.txt">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i>
                                    Upload screenshots or documents to help us understand your issue better.
                                </small>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send"></i> Submit Ticket
                            </button>
                            <a href="index.php?controller=dashboard&action=tickets"
                               class="btn btn-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    $content = ob_get_clean();
    require __DIR__ . '/../layouts/user_layout.php';
?>

