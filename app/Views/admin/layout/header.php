<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Admin' ?> - NCLEX Admin</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
</head>
<body class="admin-body">
<div class="admin-layout">
    <header class="admin-header">
        <div class="admin-header-left">
            <button class="admin-menu-toggle js-mobile-toggle" aria-label="Toggle mobile menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-brand">
                <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Logo" class="admin-logo">
            </div>
        </div>
        <div class="admin-header-right">
            <button class="admin-action-btn" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="admin-badge">3</span>
            </button>
            <button class="admin-action-btn js-theme-toggle" title="Toggle theme" aria-pressed="false">
                <i class="fas fa-toggle-off"></i>
            </button>
            <div class="admin-user-menu">
                <?php
                    $userEmail = session()->get('user_email');
                    $userName = session()->get('username');
                    $displayName = $userName ?: 'Admin';
                    $avatarName = urlencode($displayName);
                ?>
                <button class="admin-user-btn" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=<?= $avatarName ?>&background=6366f1&color=fff" alt="User" class="admin-avatar">
                    <span class="admin-user-name"><?= esc($displayName) ?></span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-user-dropdown">
                    <?php if (!empty($userEmail)): ?>
                    <li class="admin-user-info">
                        <div class="admin-user-email"><?= esc($userEmail) ?></div>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile'); ?>"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>" target="_blank"><i class="fas fa-external-link"></i> View Site</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <nav class="admin-sidebar">
        <div class="admin-nav-section">
            <div class="admin-nav-title">Main</div>
            <a class="admin-nav-link" href="<?= base_url('admin'); ?>" data-path="admin">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/analytics'); ?>" data-path="admin/analytics">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Users</div>
            <a class="admin-nav-link" href="<?= base_url('admin/users'); ?>" data-path="admin/users">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Test</div>

             <a class="admin-nav-link" href="<?= base_url('admin/tests/create'); ?>" data-path="admin/tests/create">
                <i class="fas fa-plus-square"></i>
                <span>Create Test</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/tests/create-free'); ?>" data-path="admin/tests/create-free">
                <i class="fas fa-gift"></i>
                <span>Create Free Test</span>
            </a>
          
            <a class="admin-nav-link" href="<?= base_url('admin/tests'); ?>" data-path="admin/tests">
                <i class="fas fa-file-lines"></i>
                <span>Tests</span>
            </a>
           
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Test Bank Questions</div>

            <a class="admin-nav-link" href="<?= base_url('admin/questions/create'); ?>" data-path="admin/questions/create">
                <i class="fas fa-plus-circle"></i>
                <span>Add Question</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/questions/pending'); ?>" data-path="admin/questions/pending">
                <i class="fas fa-eye"></i>
                <span>Review Questions</span>
            </a>

            <a class="admin-nav-link" href="<?= base_url('admin/questions'); ?>" data-path="admin/questions">
                <i class="fas fa-circle-question"></i>
                <span>Questions</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/taxonomy/nclex'); ?>" data-path="admin/taxonomy/nclex">
                <i class="fas fa-list"></i>
                <span>Question Categories</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Study Materials</div>
          
            <a class="admin-nav-link" href="<?= base_url('admin/study'); ?>" data-path="admin/study">
                <i class="fas fa-layer-group"></i>
                <span>Study Questions</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Payments</div>
            <a class="admin-nav-link" href="<?= base_url('admin/subscriptions'); ?>" data-path="admin/subscriptions">
                <i class="fas fa-credit-card"></i>
                <span>Payments</span>
            </a>
        </div>
    </nav>
    
    <script>
    // Robust exact-match active highlighting using hrefs
    document.addEventListener('DOMContentLoaded', function() {
        const appBasePath = "<?= rtrim((string)(parse_url(base_url(), PHP_URL_PATH) ?: ''), '/') ?>";
        function normalizePath(pathname) {
            let p = pathname || '';
            if (appBasePath && p.startsWith(appBasePath)) p = p.slice(appBasePath.length);
            p = p.replace(/^\//, '').replace(/\/$/, '');
            p = p.replace(/^index\.php\//, '');
            return p;
        }
        const current = normalizePath(window.location.pathname);
        const links = document.querySelectorAll('.admin-nav-link[data-path], .admin-nav-link[href]');
        links.forEach(link => {
            const href = link.getAttribute('href') || '';
            try {
                const url = new URL(href, window.location.origin);
                const linkPath = normalizePath(url.pathname);
                if (current === linkPath) link.classList.add('active');
                else link.classList.remove('active');
            } catch (e) {
                // ignore invalid URLs
            }
        });
    });
    </script>
    
    <main class="admin-main">
        <div class="admin-page-header">
            <h1 class="admin-page-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></h1>
        </div>
        <div class="admin-content">

