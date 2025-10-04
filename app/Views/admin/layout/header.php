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
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="admin-brand">
                <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Logo" class="admin-logo">
                <span class="admin-brand-name">NCLEX Admin</span>
            </div>
        </div>
        <div class="admin-header-right">
            <button class="admin-action-btn" title="Notifications">
                <i class="fa-solid fa-bell"></i>
                <span class="admin-badge">3</span>
            </button>
            <button class="admin-action-btn js-theme-toggle" title="Toggle theme">
                <i class="fa-solid fa-palette"></i>
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
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-user-dropdown">
                    <?php if (!empty($userEmail)): ?>
                    <li class="admin-user-info">
                        <div class="admin-user-email"><?= esc($userEmail) ?></div>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('admin/profile'); ?>"><i class="fa-solid fa-user"></i> Profile</a></li>
                    <li><a class="dropdown-item" href="<?= base_url(); ?>" target="_blank"><i class="fa-solid fa-external-link"></i> View Site</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <nav class="admin-sidebar">
        <div class="admin-nav-section">
            <div class="admin-nav-title">Main</div>
            <a class="admin-nav-link" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/analytics'); ?>">
                <i class="fa-solid fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Users</div>
            <a class="admin-nav-link" href="<?= base_url('admin/users'); ?>">
                <i class="fa-solid fa-users"></i>
                <span>Users</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Test Bank Questions</div>

            <a class="admin-nav-link" href="<?= base_url('admin/questions/create'); ?>">
                <i class="fa-solid fa-plus-circle"></i>
                <span>Add Question</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('admin/questions/pending'); ?>">
                <i class="fa-solid fa-eye"></i>
                <span>Review Questions</span>
            </a>

            <a class="admin-nav-link" href="<?= base_url('admin/questions'); ?>">
                <i class="fa-solid fa-circle-question"></i>
                <span>Questions</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Test</div>

             <a class="admin-nav-link" href="<?= base_url('admin/tests/create'); ?>">
                <i class="fa-solid fa-plus-square"></i>
                <span>Create Test</span>
            </a>
          
            <a class="admin-nav-link" href="<?= base_url('admin/tests'); ?>">
                <i class="fa-solid fa-file-lines"></i>
                <span>Tests</span>
            </a>
           
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Study Materials</div>
          
            <a class="admin-nav-link" href="<?= base_url('admin/study'); ?>">
                <i class="fa-solid fa-layer-group"></i>
                <span>Study Questions</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Payments</div>
            <a class="admin-nav-link" href="<?= base_url('admin/subscriptions'); ?>">
                <i class="fa-solid fa-credit-card"></i>
                <span>Payments</span>
            </a>
        </div>
    </nav>
    
    <main class="admin-main">
        <div class="admin-page-header">
            <h1 class="admin-page-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></h1>
        </div>
        <div class="admin-content">

