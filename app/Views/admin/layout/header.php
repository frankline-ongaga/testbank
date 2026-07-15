<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Admin' ?> - NCLEX Prep Course</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('panel_assets/css/praxis-panel.css') . '?v=' . filemtime(FCPATH . 'panel_assets/css/praxis-panel.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('panel_assets/css/nclex-panel-bridge.css') . '?v=' . filemtime(FCPATH . 'panel_assets/css/nclex-panel-bridge.css'); ?>">
</head>
<body class="ielts-panel-body ielts-panel-body--admin">
<?php
    $currentPath = trim(service('uri')->getPath(), '/');
    if (strpos($currentPath, 'index.php/') === 0) {
        $currentPath = substr($currentPath, strlen('index.php/'));
    }

    $isActive = static function (array $patterns) use ($currentPath): bool {
        foreach ($patterns as $pattern) {
            $pattern = trim($pattern, '/');
            if ($pattern === $currentPath) {
                return true;
            }
            if (str_contains($pattern, '*') && fnmatch($pattern, $currentPath)) {
                return true;
            }
        }
        return false;
    };

    $navSections = [
        [
            'title' => 'Overview',
            'items' => [
                ['path' => 'admin', 'label' => 'Dashboard', 'icon' => 'grid', 'active' => ['admin']],
                ['path' => 'admin/analytics', 'label' => 'Analytics', 'icon' => 'calendar', 'active' => ['admin/analytics', 'admin/analytics/*']],
            ],
        ],
        [
            'title' => 'People',
            'items' => [
                ['path' => 'admin/users', 'label' => 'Users', 'icon' => 'user', 'active' => ['admin/users', 'admin/users/*', 'admin/viewUsers', 'admin/addUser', 'admin/editUser', 'admin/editUser/*']],
            ],
        ],
        [
            'title' => 'Tests',
            'items' => [
                ['path' => 'admin/tests/create', 'label' => 'Create Test', 'icon' => 'book', 'active' => ['admin/tests/create']],
                ['path' => 'admin/tests/create-free', 'label' => 'Create Free Test', 'icon' => 'audio', 'active' => ['admin/tests/create-free']],
                ['path' => 'admin/tests', 'label' => 'Manage Tests', 'icon' => 'book', 'active' => ['admin/tests', 'admin/tests/edit/*', 'admin/tests/*/questions*']],
            ],
        ],
        [
            'title' => 'Questions',
            'items' => [
                ['path' => 'admin/questions/create', 'label' => 'Add Question', 'icon' => 'pen', 'active' => ['admin/questions/create']],
                ['path' => 'admin/questions/pending', 'label' => 'Review Questions', 'icon' => 'chat', 'active' => ['admin/questions/pending']],
                ['path' => 'admin/questions', 'label' => 'Question Bank', 'icon' => 'book', 'active' => ['admin/questions', 'admin/questions/edit/*', 'admin/questions/media/*', 'admin/questions/preview/*']],
                ['path' => 'admin/taxonomy/nclex', 'label' => 'Question Categories', 'icon' => 'calendar', 'active' => ['admin/taxonomy/nclex', 'admin/taxonomy/nclex/*']],
            ],
        ],
        [
            'title' => 'Study',
            'items' => [
                ['path' => 'admin/study', 'label' => 'Study Questions', 'icon' => 'grid', 'active' => ['admin/study', 'admin/study/*']],
                ['path' => 'admin/mock-questions', 'label' => 'Mock Tests', 'icon' => 'chat', 'active' => ['admin/mock-questions', 'admin/mock-questions/*']],
                ['path' => 'admin/study-bank-pdfs', 'label' => 'Study Bank Docs', 'icon' => 'book', 'active' => ['admin/study-bank-pdfs', 'admin/study-bank-pdfs/*']],
                ['path' => 'admin/cheat-sheets', 'label' => 'Cheat Sheets', 'icon' => 'card', 'active' => ['admin/cheat-sheets', 'admin/cheat-sheets/*']],
            ],
        ],
        [
            'title' => 'Billing',
            'items' => [
                ['path' => 'admin/subscriptions', 'label' => 'Payments', 'icon' => 'card', 'active' => ['admin/subscriptions', 'admin/subscriptions/*']],
            ],
        ],
    ];

    $userEmail = (string) (session()->get('user_email') ?? '');
    $userName = (string) (session()->get('username') ?: 'Admin');
?>
<div class="ielts-panel-mobilebar">
    <a class="ielts-panel-mobilebrand" href="<?= base_url('admin') ?>">
        <img src="<?= base_url('assets/media/logo.png') ?>" alt="NCLEX Prep Course">
    </a>
    <a class="ielts-panel-mobilelogout" href="<?= base_url('logout') ?>">Logout</a>
</div>
<div class="ielts-panel-shell">
    <aside class="ielts-panel-sidebar">
        <a class="ielts-panel-brand" href="<?= base_url('admin') ?>">
            <img src="<?= base_url('assets/media/logo.png') ?>" alt="NCLEX Prep Course">
            <small>Admin Suite</small>
        </a>
        <nav class="ielts-panel-nav">
            <?php foreach ($navSections as $section): ?>
                <span class="ielts-panel-section"><?= esc($section['title']) ?></span>
                <?php foreach ($section['items'] as $item): ?>
                    <?php $active = $isActive($item['active']); ?>
                    <a class="<?= $active ? 'active' : '' ?>" data-icon="<?= esc($item['icon']) ?>" href="<?= base_url($item['path']) ?>">
                        <span><?= esc($item['label']) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </nav>
    </aside>
    <main class="ielts-panel-main">
        <header class="ielts-panel-topbar">
            <div>
                <small>Signed in as admin</small>
                <span><?= esc($userName) ?></span>
            </div>
            <div class="ielts-panel-topbar-meta">
                <span><?= esc($userEmail) ?></span>
            </div>
            <div class="ielts-panel-topbar-actions">
                <a class="ielts-panel-toplink" href="<?= base_url() ?>" target="_blank">View Site</a>
                <a class="ielts-panel-toplink" href="<?= base_url('admin/profile') ?>">Profile</a>
                <a class="ielts-panel-logout" href="<?= base_url('logout') ?>">Logout</a>
            </div>
        </header>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="ielts-alert ielts-alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="ielts-alert ielts-alert-error"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="ielts-alert ielts-alert-error">
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <div><?= esc($error) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="ielts-panel-pagehead">
            <small>NCLEX Prep Course</small>
            <h1><?= isset($title) ? esc($title) : 'Admin Dashboard' ?></h1>
        </section>

        <div class="ielts-panel-content">
