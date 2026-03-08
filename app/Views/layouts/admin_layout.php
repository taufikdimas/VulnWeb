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
    <title><?php echo $pageTitle ?? 'Admin'; ?> - IntraCorp Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/modern-theme.css">
    <style>
    .topbar-profile-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #667eea;
        margin-right: 10px;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-shield-lock"></i>
                <h5>Admin Panel</h5>
                <small>IntraCorp</small>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="index.php?controller=admin&action=dashboard"
                        class="<?php echo($activePage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=users"
                        class="<?php echo($activePage ?? '') === 'users' ? 'active' : ''; ?>">
                        <i class="bi bi-people"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=announcements"
                        class="<?php echo($activePage ?? '') === 'announcements' ? 'active' : ''; ?>">
                        <i class="bi bi-megaphone"></i>
                        <span>Announcements</span>
                    </a>
                </li>
                <li>
                    <a href="index.php?controller=admin&action=tickets"
                        class="<?php echo($activePage ?? '') === 'tickets' ? 'active' : ''; ?>">
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
                    <h4 class="mb-0"><?php echo $pageTitle ?? 'Admin Dashboard'; ?></h4>
                </div>
                <div class="topbar-right">
                    <div class="dropdown">
                        <a href="#" class="user-info dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <?php if (! empty($_SESSION['profile_picture'])): ?>
                            <img src="index.php?controller=admin&action=getProfilePicture&id=<?php echo $_SESSION['user_id'] ?>"
                                class="topbar-profile-img"
                                onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username'] ?? 'Admin') ?>&size=40&background=667eea&color=fff'">
                            <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username'] ?? 'Admin') ?>&size=40&background=667eea&color=fff"
                                class="topbar-profile-img">
                            <?php endif; ?>
                            <span><?php echo $_SESSION['username'] ?? 'Admin'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=admin&action=profile"><i
                                        class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=admin&action=changePassword"><i
                                        class="bi bi-key"></i> Change Password</a></li>
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