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
    <title><?php echo $pageTitle ?? ($isAdmin ? 'Admin' : 'Dashboard'); ?> - IntraCorp Portal</title>
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
    <?php
        // Configure layout based on user role
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

        $layoutConfig = [
            'admin' => [
                'icon'     => 'shield-lock',
                'title'    => 'Admin Panel',
                'subtitle' => 'IntraCorp',
                'menu'     => [
                    ['icon' => 'speedometer2', 'label' => 'Dashboard', 'url' => 'index.php?controller=admin&action=dashboard', 'page' => 'dashboard'],
                    ['icon' => 'people', 'label' => 'Manage Users', 'url' => 'index.php?controller=admin&action=users', 'page' => 'users'],
                    ['icon' => 'megaphone', 'label' => 'Announcements', 'url' => 'index.php?controller=admin&action=announcements', 'page' => 'announcements'],
                    ['icon' => 'ticket', 'label' => 'Tickets', 'url' => 'index.php?controller=admin&action=tickets', 'page' => 'tickets'],
                ],
            ],
            'user'  => [
                'icon'     => 'building',
                'title'    => 'IntraCorp',
                'subtitle' => 'Employee Portal',
                'menu'     => [
                    ['icon' => 'speedometer2', 'label' => 'Dashboard', 'url' => 'index.php?controller=dashboard&action=index', 'page' => 'dashboard'],
                    ['icon' => 'megaphone', 'label' => 'Announcements', 'url' => 'index.php?controller=dashboard&action=announcements', 'page' => 'announcements'],
                    ['icon' => 'ticket', 'label' => 'Tickets', 'url' => 'index.php?controller=dashboard&action=tickets', 'page' => 'tickets'],
                ],
            ],
        ];

        $config     = $layoutConfig[$isAdmin ? 'admin' : 'user'];
        $controller = $isAdmin ? 'admin' : 'dashboard';
    ?>

    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <i class="bi bi-<?php echo $config['icon']; ?>"></i>
                <h5><?php echo $config['title']; ?></h5>
                <small><?php echo $config['subtitle']; ?></small>
            </div>

            <ul class="sidebar-menu">
                <?php foreach ($config['menu'] as $item): ?>
                <li>
                    <a href="<?php echo $item['url']; ?>"
                       class="<?php echo($activePage ?? '') === $item['page'] ? 'active' : ''; ?>">
                        <i class="bi bi-<?php echo $item['icon']; ?>"></i>
                        <span><?php echo $item['label']; ?></span>
                    </a>
                </li>
                <?php endforeach; ?>
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
                    <h4 class="mb-0"><?php echo $pageTitle ?? ($isAdmin ? 'Admin Dashboard' : 'Dashboard'); ?></h4>
                </div>
                <div class="topbar-right">
                    <div class="dropdown">
                        <a href="#" class="user-info dropdown-toggle" id="userDropdown"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <?php if (! empty($_SESSION['profile_picture'])): ?>
                            <img src="index.php?controller=<?php echo $controller; ?>&action=getProfilePicture&id=<?php echo $_SESSION['user_id']; ?>"
                                class="topbar-profile-img"
                                onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username'] ?? 'User'); ?>&size=40&background=667eea&color=fff'">
                            <?php else: ?>
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username'] ?? 'User'); ?>&size=40&background=667eea&color=fff"
                                class="topbar-profile-img">
                            <?php endif; ?>
                            <span><?php echo $_SESSION['username'] ?? 'User'; ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="index.php?controller=<?php echo $controller; ?>&action=profile">
                                <i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=<?php echo $controller; ?>&action=changePassword">
                                <i class="bi bi-key"></i> Change Password</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="main-content">
                <?php
                    if (isset($contentView) && file_exists($contentView)) {
                        include $contentView;
                    } elseif (isset($content)) {
                        echo $content;
                    }
                ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/modern-theme.js"></script>
</body>
</html>
