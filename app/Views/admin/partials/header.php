<?php
$uri = service('uri');
$currentPath = $uri ? trim($uri->getPath(), '/') : '';
$normalizedPath = preg_replace('#^index\.php/#', '', $currentPath);
?>
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
    <?php
        $currentRole = session()->get('current_role');
        $isAdmin = $currentRole === 'admin';
        $isInstructor = $currentRole === 'instructor';
        $isStudent = $currentRole === 'client';
        $dashboardUrl = $isAdmin ? base_url('admin') : ($isInstructor ? base_url('instructor') : base_url('client'));
    ?>
    <header class="admin-header">
        <div class="admin-header-left">
            <button class="admin-menu-toggle js-mobile-toggle" aria-label="Toggle mobile menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="admin-brand">
                <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Logo" class="admin-logo">
                <span class="admin-brand-name">NCLEX</span>
            </div>
        </div>
        <div class="admin-header-center"></div>
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
                    $displayRole = $isAdmin ? 'Admin' : ($isInstructor ? 'Instructor' : 'Client');
                    $displayName = $userName ?: $displayRole;
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
            <a class="admin-nav-link <?= $normalizedPath === 'admin' ? 'active' : '' ?>" 
               href="<?= $dashboardUrl; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link <?= strpos($normalizedPath, 'admin/analytics') === 0 ? 'active' : '' ?>" 
               href="<?= base_url('admin/analytics'); ?>">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Management</div>
            <?php if ($isAdmin): ?>
                <a class="admin-nav-link <?= strpos($normalizedPath, 'admin/users') === 0 ? 'active' : '' ?>" 
                   href="<?= base_url('admin/users'); ?>">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                    <span class="admin-nav-badge">12</span>
                </a>
            <?php endif; ?>

            <?php if ($isAdmin || $isInstructor): ?>
            <a class="admin-nav-link <?= $normalizedPath === 'admin/tests' ? 'active' : '' ?>" 
               href="<?= base_url('admin/tests'); ?>">
                <i class="fas fa-file-lines"></i>
                <span>Tests</span>
            </a>
            <?php endif; ?>
            <?php if ($isAdmin || $isInstructor): ?>
                <a class="admin-nav-link <?= $normalizedPath === 'admin/tests/create' ? 'active' : '' ?>" 
                   href="<?= base_url('admin/tests/create'); ?>">
                    <i class="fas fa-plus-square"></i>
                    <span>Create Test</span>
                </a>
            <?php endif; ?>

            <?php if ($isAdmin || $isInstructor): ?>
            <a class="admin-nav-link <?= $normalizedPath === 'admin/questions' ? 'active' : '' ?>"
               href="<?= base_url('admin/questions'); ?>">
                    <i class="fas fa-circle-question"></i>
                    <span>Questions</span>
                </a>
                <a class="admin-nav-link <?= $normalizedPath === 'admin/questions/create' ? 'active' : '' ?>" 
                   href="<?= base_url('admin/questions/create'); ?>">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Question</span>
                </a>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
                <a class="admin-nav-link <?= $normalizedPath === 'admin/questions/pending' ? 'active' : '' ?>" 
                   href="<?= base_url('admin/questions/pending'); ?>">
                    <i class="fas fa-eye"></i>
                    <span>Review Questions</span>
                    <span class="admin-nav-badge">3</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Study Materials</div>
            <a class="admin-nav-link <?= $currentPath === 'admin/notes' ? 'active' : '' ?>" 
               href="<?= base_url('admin/notes'); ?>">
                <i class="fas fa-book"></i>
                <span>Study Notes</span>
            </a>
            <?php if ($isAdmin || $isInstructor): ?>
                <a class="admin-nav-link <?= $currentPath === 'admin/notes/create' ? 'active' : '' ?>" 
                   href="<?= base_url('admin/notes/create'); ?>">
                    <i class="fas fa-plus"></i>
                    <span>Add Note</span>
                </a>
            <?php endif; ?>
            <?php if ($isAdmin || $isInstructor): ?>
                <a class="admin-nav-link <?= strpos($currentPath, 'admin/study') === 0 ? 'active' : '' ?>" 
                   href="<?= base_url('admin/study'); ?>">
                    <i class="fas fa-layer-group"></i>
                    <span>Study Questions</span>
                </a>
            <?php endif; ?>
            <?php if ($isAdmin || $isInstructor): ?>
                <a class="admin-nav-link <?= strpos($currentPath, 'admin/study-bank-pdfs') === 0 ? 'active' : '' ?>" 
                   href="<?= base_url('admin/study-bank-pdfs'); ?>">
                    <i class="fas fa-file"></i>
                    <span>Study Bank Docs</span>
                </a>
            <?php endif; ?>
            <?php if ($isAdmin || $isInstructor): ?>
                <a class="admin-nav-link <?= strpos($currentPath, 'admin/cheat-sheets') === 0 ? 'active' : '' ?>"
                   href="<?= base_url('admin/cheat-sheets'); ?>">
                    <i class="fas fa-file-image"></i>
                    <span>Cheat Sheets</span>
                </a>
            <?php endif; ?>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Business</div>
            <a class="admin-nav-link <?= strpos($currentPath, 'admin/subscriptions') === 0 ? 'active' : '' ?>" 
               href="<?= base_url('admin/subscriptions'); ?>">
                <i class="fas fa-credit-card"></i>
                <span>Subscriptions</span>
            </a>
        </div>
    </nav>
    
    <main class="admin-main">
        <div class="admin-page-header">
            <h1 class="admin-page-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></h1>
            <div class="admin-page-actions">
                <!-- Page-specific actions can go here -->
            </div>
        </div>
        <div class="admin-content">
