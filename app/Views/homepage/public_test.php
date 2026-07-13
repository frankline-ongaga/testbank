<?php
$test = $test ?? [];
$productNames = $productNames ?? [];
$sampleQuestions = $sampleQuestions ?? [];
$isFree = (int)($test['is_free'] ?? 0) === 1;
$ctaUrl = $isFree ? base_url('free/test/' . (int)($test['id'] ?? 0)) : base_url('register');
$ctaLabel = $isFree ? 'Start Free Test' : 'Get Access';
?>

<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1><?= esc($test['title'] ?? 'Practice Test') ?></h1>
                <img src="<?= base_url('assets/media/shapes/tag-2.png'); ?>" alt="" class="tag">
            </div>
            <div class="educate-tilt"
                data-tilt-options='{ "glare": false, "maxGlare": 0, "maxTilt": 2, "speed": 700, "scale": 1 }'>
                <img src="<?= base_url('assets/media/resources/page_title.png'); ?>" alt="" class="main_img">
            </div>
            <img src="<?= base_url('assets/media/shapes/circle-lines-2.png'); ?>" alt="" class="circle_vector">
        </div>
    </div>
</section>

<style>
    .page_title_banner .content .title {
        max-width: min(1120px, 100%);
        flex: 1 1 620px;
        min-width: 0;
    }
    .page_title_banner .title h1 {
        white-space: normal !important;
        overflow-wrap: anywhere;
        word-break: break-word;
        hyphens: auto;
        margin-bottom: 0;
    }
    .public-test-page {
        --seo-blue: #0aa6d7;
        --seo-blue-dark: #088fb8;
        --seo-orange: #f59e0b;
        --seo-ink: #172033;
        --seo-muted: #64748b;
        --seo-line: #dbeafe;
        padding: 70px 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }
    .public-test-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 360px;
        gap: 34px;
        align-items: start;
    }
    .public-test-panel,
    .public-test-sidebar {
        border: 1px solid var(--seo-line);
        border-radius: 18px;
        background: #ffffff;
        box-shadow: 0 18px 42px rgba(15, 23, 42, .08);
    }
    .public-test-panel { padding: 34px; }
    .public-test-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        color: var(--seo-blue-dark);
        font-weight: 800;
        text-transform: uppercase;
        font-size: .85rem;
    }
    .public-test-panel h2 {
        margin-bottom: 16px;
        color: var(--seo-ink);
        font-size: clamp(2rem, 4vw, 3rem);
        line-height: 1.15;
        letter-spacing: 0;
    }
    .public-test-panel p {
        color: var(--seo-muted);
        font-size: 1.08rem;
        line-height: 1.75;
    }
    .public-test-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 24px 0 30px;
    }
    .public-test-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 13px;
        border-radius: 999px;
        background: rgba(10, 166, 215, .12);
        color: #075f7a;
        font-weight: 800;
        font-size: .9rem;
    }
    .public-test-stats {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin: 30px 0;
    }
    .public-test-inline-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin: 4px 0 10px;
        padding: 14px 22px;
        border-radius: 12px;
        background: var(--seo-orange);
        color: #ffffff;
        font-weight: 900;
        text-decoration: none;
        box-shadow: 0 12px 24px rgba(245, 158, 11, .24);
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    .public-test-inline-cta:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(217, 119, 6, .24);
    }
    .public-test-stat {
        padding: 18px;
        border: 1px solid #e5edf8;
        border-radius: 14px;
        background: #fbfdff;
    }
    .public-test-stat strong {
        display: block;
        color: var(--seo-ink);
        font-size: 1.45rem;
        line-height: 1;
        margin-bottom: 8px;
    }
    .public-test-stat span {
        color: var(--seo-muted);
        font-weight: 700;
        font-size: .9rem;
    }
    .public-test-sidebar {
        position: sticky;
        top: 110px;
        overflow: hidden;
    }
    .public-test-sidebar-head {
        padding: 26px;
        background: linear-gradient(135deg, rgba(10, 166, 215, .16), rgba(245, 158, 11, .16));
        border-bottom: 1px solid var(--seo-line);
    }
    .public-test-sidebar-head h3 {
        margin: 0 0 8px;
        color: var(--seo-ink);
        font-size: 1.45rem;
        letter-spacing: 0;
    }
    .public-test-sidebar-head p {
        margin: 0;
        color: var(--seo-muted);
        line-height: 1.6;
    }
    .public-test-sidebar-body { padding: 26px; }
    .public-test-cta {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 14px 18px;
        border-radius: 12px;
        background: var(--seo-blue);
        color: #fff;
        font-weight: 900;
        text-decoration: none;
    }
    .public-test-cta:hover {
        background: var(--seo-blue-dark);
        color: #fff;
    }
    .public-question-links {
        margin-top: 30px;
        display: grid;
        gap: 14px;
    }
    .public-question-link {
        display: block;
        padding: 18px;
        border: 1px solid #e5edf8;
        border-left: 4px solid var(--seo-orange);
        border-radius: 12px;
        color: var(--seo-ink);
        background: #fff;
        text-decoration: none;
        line-height: 1.55;
        transition: border-color .2s ease, transform .2s ease, box-shadow .2s ease;
    }
    .public-question-link:hover {
        transform: translateY(-2px);
        border-color: var(--seo-orange);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        color: var(--seo-ink);
    }
    .public-test-note {
        margin-top: 20px;
        color: var(--seo-muted);
        font-size: .95rem;
        line-height: 1.65;
    }
    @media (max-width: 991px) {
        .public-test-layout { grid-template-columns: 1fr; }
        .public-test-sidebar { position: static; }
    }
    @media (max-width: 640px) {
        .public-test-page { padding: 44px 0; }
        .public-test-panel { padding: 24px; }
        .public-test-stats { grid-template-columns: 1fr; }
    }
</style>

<main class="public-test-page">
    <div class="container">
        <div class="public-test-layout">
            <article class="public-test-panel">
                <div class="public-test-kicker">
                    <i class="fas fa-clipboard-check"></i>
                    <span><?= $isFree ? 'Free practice test' : 'Premium practice test' ?></span>
                </div>
                <h2><?= esc($test['title'] ?? 'Practice Test') ?></h2>
                <p>
                    Use this practice test to build exam stamina, review nursing-style question patterns, and identify the topics that need another pass before test day.
                    Each test is organized for focused preparation instead of random guessing.
                </p>

                <div class="public-test-tags">
                    <?php foreach ($productNames as $productName): ?>
                        <span class="public-test-tag"><i class="fas fa-layer-group"></i><?= esc($productName) ?></span>
                    <?php endforeach; ?>
                    <span class="public-test-tag"><i class="fas fa-clock"></i><?= esc($duration ?? 'Untimed') ?></span>
                </div>

                <div class="public-test-stats">
                    <div class="public-test-stat">
                        <strong><?= esc((string)($questionCount ?? 0)) ?></strong>
                        <span>Questions</span>
                    </div>
                    <div class="public-test-stat">
                        <strong><?= esc(ucfirst((string)($test['mode'] ?? 'practice'))) ?></strong>
                        <span>Mode</span>
                    </div>
                    <div class="public-test-stat">
                        <strong><?= $isFree ? 'Free' : 'Paid' ?></strong>
                        <span>Access</span>
                    </div>
                </div>

                <a class="public-test-inline-cta" href="<?= esc($ctaUrl) ?>">
                    <span><?= esc($ctaLabel) ?></span>
                    <i class="fas fa-arrow-right"></i>
                </a>

                <h3>What this test helps you practice</h3>
                <p>
                    Work through realistic prompts, sharpen answer elimination, and use the result as a study signal.
                    If you are reviewing NCLEX, ATI TEAS 7, or HESI material, the assigned product label tells you where this test belongs.
                </p>

                <?php if (!empty($sampleQuestions)): ?>
                    <h3 class="mt-5">Sample indexed questions</h3>
                    <div class="public-question-links">
                        <?php foreach ($sampleQuestions as $sampleQuestion): ?>
                            <?php
                                $stem = trim(preg_replace('/\s+/', ' ', strip_tags((string)($sampleQuestion['stem'] ?? ''))));
                                $stem = mb_strlen($stem) > 155 ? mb_substr($stem, 0, 152) . '...' : $stem;
                            ?>
                            <a class="public-question-link" href="<?= esc($sampleQuestion['public_url']) ?>">
                                <?= esc($stem ?: 'View this practice question') ?>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>

            <aside class="public-test-sidebar">
                <div class="public-test-sidebar-head">
                    <h3><?= $isFree ? 'Ready to try it?' : 'Unlock this test' ?></h3>
                    <p><?= $isFree ? 'Start the full free test and review your result after submission.' : 'Create an account to access this product and the matching learner dashboard.' ?></p>
                </div>
                <div class="public-test-sidebar-body">
                    <a class="public-test-cta" href="<?= esc($ctaUrl) ?>">
                        <span><?= esc($ctaLabel) ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <p class="public-test-note">
                        These public pages are designed for discovery. Your full test-taking experience, progress, and results remain inside the practice flow.
                    </p>
                </div>
            </aside>
        </div>
    </div>
</main>
