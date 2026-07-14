<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'Learner Dashboard' ?> - NCLEX Prep Course</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('panel_assets/css/praxis-panel.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('panel_assets/css/nclex-panel-bridge.css'); ?>">
</head>
<body class="ielts-panel-body ielts-panel-body--client">
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

    $clientHasNclexAccess = (bool) ($clientHasNclexAccess ?? false);

    $navSections = [
        [
            'title' => 'Overview',
            'items' => [
                ['path' => 'client', 'label' => 'Dashboard', 'icon' => 'grid', 'active' => ['client']],
                ['path' => 'client/analytics', 'label' => 'Analytics', 'icon' => 'calendar', 'active' => ['client/analytics', 'client/analytics/*']],
            ],
        ],
        [
            'title' => 'Practice',
            'items' => [
                ['path' => 'client/tests', 'label' => 'Practice Tests', 'icon' => 'book', 'active' => ['client/tests', 'client/tests/*']],
                ['path' => 'client/subscription', 'label' => 'My Access', 'icon' => 'card', 'active' => ['client/subscription', 'subscriptions']],
            ],
        ],
    ];

    if ($clientHasNclexAccess) {
        $navSections[] = [
            'title' => 'Study',
            'items' => [
                ['path' => 'client/study', 'label' => 'Study Questions', 'icon' => 'grid', 'active' => ['client/study', 'client/study/*']],
                ['path' => 'client/study-bank-pdfs', 'label' => 'Study Bank Docs', 'icon' => 'book', 'active' => ['client/study-bank-pdfs', 'client/study-bank-pdfs/*']],
                ['path' => 'client/cheat-sheets', 'label' => 'Cheat Sheets', 'icon' => 'audio', 'active' => ['client/cheat-sheets', 'client/cheat-sheets/*']],
                ['path' => 'client/mock-questions', 'label' => 'Mock Questions', 'icon' => 'pen', 'active' => ['client/mock-questions', 'client/mock-questions/*']],
                ['path' => 'client/nursing-care-plans', 'label' => 'Nursing Care Plans', 'icon' => 'folder', 'active' => ['client/nursing-care-plans', 'client/nursing-care-plans/*']],
                ['path' => 'client/nursing-nclex-reviews', 'label' => 'Nursing NCLEX Reviews', 'icon' => 'book', 'active' => ['client/nursing-nclex-reviews', 'client/nursing-nclex-reviews/*']],
            ],
        ];
    }

    $navSections[] = [
        'title' => 'Account',
        'items' => [
            ['path' => 'client/profile', 'label' => 'Profile', 'icon' => 'user', 'active' => ['client/profile', 'client/profile/*']],
        ],
    ];

    $userEmail = (string) (session()->get('user_email') ?? '');
    $userName = (string) (session()->get('username') ?: 'Learner');
?>
<div class="ielts-panel-mobilebar">
    <a class="ielts-panel-mobilebrand" href="<?= base_url('client') ?>">
        <img src="<?= base_url('assets/media/logo.png') ?>" alt="NCLEX Prep Course">
    </a>
    <a class="ielts-panel-mobilelogout" href="<?= base_url('logout') ?>">Logout</a>
</div>
<div class="ielts-panel-shell">
    <aside class="ielts-panel-sidebar">
        <a class="ielts-panel-brand" href="<?= base_url('client') ?>">
            <img src="<?= base_url('assets/media/logo.png') ?>" alt="NCLEX Prep Course">
            <small>Learning Hub</small>
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
                <small>Signed in as learner</small>
                <span><?= esc($userName) ?></span>
            </div>
            <div class="ielts-panel-topbar-meta">
                <span><?= esc($userEmail) ?></span>
            </div>
            <div class="ielts-panel-topbar-actions">
                <a class="ielts-panel-toplink" href="<?= base_url('client/profile') ?>">Profile</a>
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
            <h1><?= isset($title) ? esc($title) : 'Learner Dashboard' ?></h1>
        </section>

        <div class="ielts-panel-content">
