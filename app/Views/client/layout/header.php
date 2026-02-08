<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Student Dashboard' ?> - NCLEX Prep Course</title>
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
                document.documentElement.classList.add('theme-dark');
                // Also add to HTML for immediate effect
                document.documentElement.setAttribute('data-theme', 'dark');
            }
        })();
    </script>
    <style>
        /* Prevent flash of light theme */
        html[data-theme="dark"] body.admin-body {
            background: #111827;
            color: #f9fafb;
        }
    </style>
</head>
<body class="admin-body">
<div class="admin-layout <?= $isStudy ? 'fullwidth' : '' ?>">
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
            <button class="admin-action-btn js-theme-toggle" title="Toggle theme" aria-pressed="false">
                <i class="fas fa-toggle-off"></i>
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
                    <i class="fas fa-chevron-down"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end admin-user-dropdown">
                    <?php if (!empty($userEmail)): ?>
                    <li class="admin-user-info">
                        <div class="admin-user-email"><?= esc($userEmail) ?></div>
                    </li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="<?= base_url('client/profile'); ?>"><i class="fas fa-user"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </header>
    
    <?php if (!$isStudy): ?>
    <style>
        .client-sidebar-beautiful .admin-sidebar {
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            border-right: 1px solid #e9ecef;
        }
        .client-sidebar-beautiful .admin-nav-section {
            padding: 1rem 0.75rem;
            margin-bottom: 0.5rem;
        }
        .client-sidebar-beautiful .admin-nav-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
            padding: 0.5rem 1rem;
            margin-bottom: 0.5rem;
        }
        .client-sidebar-beautiful .admin-nav-link {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 10px;
            color: #495057;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0.95rem;
            position: relative;
        }
        .client-sidebar-beautiful .admin-nav-link i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            color: #6c757d;
            transition: all 0.25s ease;
        }
        .client-sidebar-beautiful .admin-nav-link:hover {
            background: #f1f3f5;
            color: #212529;
            padding-left: 1.25rem;
        }
        .client-sidebar-beautiful .admin-nav-link:hover i {
            color: #007bff;
            transform: scale(1.1);
        }
        .client-sidebar-beautiful .admin-nav-link.active {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.25);
            font-weight: 600;
        }
        .client-sidebar-beautiful .admin-nav-link.active i {
            color: white;
        }
        .client-sidebar-beautiful .admin-nav-link.active:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            padding-left: 1rem;
        }
        .client-sidebar-beautiful .admin-nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 60%;
            background: white;
            border-radius: 0 3px 3px 0;
        }
        
        /* Dark Mode Styles - Apply from both body and html level */
        body.theme-dark .client-sidebar-beautiful .admin-sidebar,
        html.theme-dark .client-sidebar-beautiful .admin-sidebar,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-sidebar {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            border-right: 1px solid #374151;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-title,
        html.theme-dark .client-sidebar-beautiful .admin-nav-title,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-title {
            color: #9ca3af;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link {
            color: #d1d5db;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link i,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link i,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link i {
            color: #9ca3af;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link:hover,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link:hover,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link:hover {
            background: #374151;
            color: #f9fafb;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link:hover i,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link:hover i,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link:hover i {
            color: #60a5fa;
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link.active,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link.active,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link.active {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        body.theme-dark .client-sidebar-beautiful .admin-nav-link.active:hover,
        html.theme-dark .client-sidebar-beautiful .admin-nav-link.active:hover,
        html[data-theme="dark"] .client-sidebar-beautiful .admin-nav-link.active:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        }
    </style>
    <div class="client-sidebar-beautiful">
    <nav class="admin-sidebar">
        <div class="admin-nav-section">
            <div class="admin-nav-title">Main</div>
            <a class="admin-nav-link" href="<?= base_url('client'); ?>">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('client/analytics'); ?>">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Tests</div>
            <a class="admin-nav-link" href="<?= base_url('client/tests'); ?>">
                <i class="fas fa-file-lines"></i>
                <span>Take Tests</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Study</div>
            <a class="admin-nav-link" href="<?= base_url('client/study'); ?>">
                <i class="fas fa-layer-group"></i>
                <span>Study Questions</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('client/study-bank-pdfs'); ?>">
                <i class="fas fa-file-alt"></i>
                <span>Study Bank Docs</span>
            </a>
            <a class="admin-nav-link" href="<?= base_url('client/cheat-sheets'); ?>">
                <i class="fas fa-file-image"></i>
                <span>Cheat Sheets</span>
            </a>
        </div>
        <div class="admin-nav-section">
            <div class="admin-nav-title">Account</div>
            <a class="admin-nav-link" href="<?= base_url('client/subscription'); ?>">
                <i class="fas fa-credit-card"></i>
                <span>My Subscription</span>
            </a>
        </div>
    </nav>
    </div>
    <script>
        // Highlight active menu item
        (function() {
            const currentPath = window.location.pathname.replace(/\/$/, '');
            const links = document.querySelectorAll('.client-sidebar-beautiful .admin-nav-link');
            links.forEach(link => {
                const href = link.getAttribute('href');
                if (href) {
                    const linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '');
                    if (currentPath === linkPath || (linkPath !== '/client' && currentPath.startsWith(linkPath))) {
                        link.classList.add('active');
                    }
                }
            });
        })();
    </script>
    <?php endif; ?>
    
    <main class="admin-main" <?= $isStudy ? 'style="margin-left:0;"' : '' ?> >
        <div class="admin-page-header">
            <?php if ($isStudy): ?>
            <div class="mb-2">
                <a href="<?= base_url('client') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Main Menu</a>
            </div>
            <?php endif; ?>
            <h1 class="admin-page-title"><?= isset($title) ? esc($title) : 'Dashboard' ?></h1>
        </div>
        <div class="admin-content">
