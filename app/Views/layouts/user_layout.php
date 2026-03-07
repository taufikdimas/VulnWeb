<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="<?php
                    $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
                    $host   = $_SERVER['HTTP_HOST'];
                    $path   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                echo htmlspecialchars($scheme . '://' . $host . $path . '/');
                ?>">
    <title><?php echo $pageTitle ?? 'Dashboard'; ?> - IntraCorp Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-building"></i>
                <h5>IntraCorp</h5>
                <small>Employee Portal</small>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="index.php?controller=dashboard&action=index" class="<?php echo($activePage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=dashboard&action=announcements" class="<?php echo($activePage ?? '') === 'announcements' ? 'active' : ''; ?>">
                        <i class="bi bi-megaphone"></i>
                        <span>Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=dashboard&action=tickets" class="<?php echo($activePage ?? '') === 'tickets' ? 'active' : ''; ?>">
                        <i class="bi bi-ticket"></i>
                        <span>Tickets</span>
                    </a>
                </li>
            </ul>

            <ul class="sidebar-menu mt-auto">
                <li>
                    <a href="index.php?controller=auth&action=logout">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div id="content" class="content">
            <!-- Top Navigation Bar -->
            <nav class="topbar">
                <div class="topbar-left">
                    <button type="button" id="sidebarToggle" class="btn btn-link">
                        <i class="bi bi-list"></i>
                    </button>
                    <h4 class="mb-0"><?php echo $pageTitle ?? 'Dashboard'; ?></h4>
                </div>
                <div class="topbar-right">
                    <div class="dropdown">
                        <a href="#" class="user-info dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i>
                            <span><?php echo $_SESSION['username'] ?? 'User'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=dashboard&action=profile"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=dashboard&action=changePassword"><i class="bi bi-key"></i> Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="main-content">
                <?php echo $content ?? ''; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/modern-theme.js"></script>
</body>
</html>
