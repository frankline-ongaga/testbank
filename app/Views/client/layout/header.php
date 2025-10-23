<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Student Dashboard' ?> - NCLEX Test Bank</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin.css'); ?>">
    <?php $uri = service('uri'); $currentPath = $uri->getPath(); $isStudy = strpos($currentPath, 'client/study') !== false; ?>
    <?php if ($isStudy): ?>
    <style>
        .admin-main { margin-left: 0 !important; }
        .admin-content { max-width: 100% !important; }
    </style>
    <?php endif; ?>
    <script>
        // Apply saved theme immediately to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('admin-theme');
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('theme-dark-loading');
            }
        })();
    </script>
</head>
<body class="admin-body">
<div class="admin-layout <?= $isStudy ? 'fullwidth' : '' ?>">
    <header class="admin-header">
        <div class="admin-header-left">
            <button class="admin-menu-toggle js-mobile-toggle" aria-label="Toggle mobile menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-brand">
                <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Logo" class="admin-logo">
                <span class="admin-brand-name">Student Portal</span>
            </div>
        </div>
        <div class="admin-header-right">
            <button class="admin-action-btn js-theme-toggle" title="Toggle theme">
                <i class="fa-solid fa-palette"></i>
            </button>
            <div class="admin-user-menu">
                <?php
                    $userEmail = session()->get('user_email');
                    $userName = session()->get('username');
                    $displayName = $userName ?: 'Student';
                    $avatarName = urlencode($displayName);
                ?>
                <button class="admin-user-btn" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=<?= $avatarName ?>&background=6366f1&color=fff" alt="User" class="admin-avatar">
                    <span class="admin-user-name"><?= esc($displayName) ?></span>
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-user-dropdown">
                    <?php if (!empty($userEmail)): ?>
                    <li class="admin-user-info">
                        <div class="admin-user-email"><?= esc($userEmail) ?></div>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('client/profile'); ?>"><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <?php if (!$isStudy): ?>
    <nav class="admin-sidebar">
        <div class="admin-nav-section">
            <div class="admin-nav-title">Main</div>
            <a class="admin-nav-link" href="<?= base_url('client'); ?>">
                <i class="fa-solid fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('client/analytics'); ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Tests</div>
            <a class="admin-nav-link" href="<?= base_url('client/tests'); ?>">
                <i class="fa-solid fa-file-lines"></i>
                <span>Take Tests</span>
            </a>
        </div>
            <!-- Removed practice to keep menu consistent -->
        <div class="admin-nav-section">
            
            <div class="admin-nav-title">Study</div>
            <a class="admin-nav-link" href="<?= base_url('client/study'); ?>">
                <i class="fa-solid fa-layer-group"></i>
                <span>Study Questions</span>
            </a>
         
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Account</div>
            <a class="admin-nav-link" href="<?= base_url('client/subscription'); ?>">
                <i class="fa-solid fa-credit-card"></i>
                <span>My Subscription</span>
            </a>
        </div>
    </nav>
    <?php endif; ?>
    
    <main class="admin-main" <?= $isStudy ? 'style="margin-left:0;"' : '' ?> >
        <div class="admin-page-header">
            <?php if ($isStudy): ?>
            <div class="mb-2">
                <a href="<?= base_url('client') ?>" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-left me-1"></i> Back to Main Menu</a>
            </div>
            <?php endif; ?>
            <h1 class="admin-page-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></h1>
        </div>
        <div class="admin-content">
