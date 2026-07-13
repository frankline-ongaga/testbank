<?php
$question = $question ?? [];
$questionHeading = $questionHeading ?? 'Practice Question';
$choices = $choices ?? [];
$linkedTests = $linkedTests ?? [];
?>

<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1><?= esc($questionHeading) ?></h1>
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
    .public-question-page {
        --seo-blue: #0aa6d7;
        --seo-blue-dark: #088fb8;
        --seo-orange: #f59e0b;
        --seo-ink: #172033;
        --seo-muted: #64748b;
        --seo-line: #dbeafe;
        padding: 70px 0;
        background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
    }
    .public-question-layout {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 34px;
        align-items: start;
    }
    .public-question-card,
    .public-question-side {
        border: 1px solid var(--seo-line);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 18px 42px rgba(15, 23, 42, .08);
    }
    .public-question-card { padding: 34px; }
    .question-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 18px;
        color: var(--seo-blue-dark);
        font-weight: 900;
        text-transform: uppercase;
        font-size: .85rem;
    }
    .public-question-stem {
        margin-bottom: 26px;
        color: var(--seo-ink);
        font-size: clamp(1.35rem, 3vw, 2rem);
        line-height: 1.45;
        letter-spacing: 0;
    }
    .public-question-media {
        margin: 0 0 26px;
    }
    .public-question-media img {
        max-width: 100%;
        max-height: 440px;
        border-radius: 14px;
        border: 1px solid #e5edf8;
    }
    .public-question-inline-cta {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin: 24px 0 0;
        padding: 14px 22px;
        border-radius: 12px;
        background: var(--seo-orange);
        color: #ffffff;
        font-weight: 900;
        text-decoration: none;
        box-shadow: 0 12px 24px rgba(245, 158, 11, .24);
        transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
    }
    .public-question-inline-cta:hover {
        background: #d97706;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(217, 119, 6, .24);
    }
    .choice-list {
        display: grid;
        gap: 12px;
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .choice-item {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr);
        gap: 14px;
        align-items: start;
        padding: 17px;
        border: 1px solid #e5edf8;
        border-radius: 14px;
        background: #fbfdff;
    }
    .choice-letter {
        display: inline-flex;
        width: 42px;
        height: 42px;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(10, 166, 215, .12);
        color: #075f7a;
        font-weight: 900;
    }
    .choice-content {
        color: #334155;
        line-height: 1.6;
    }
    .public-question-side {
        position: sticky;
        top: 110px;
        overflow: hidden;
    }
    .public-question-side-head {
        padding: 26px;
        background: linear-gradient(135deg, rgba(10, 166, 215, .16), rgba(245, 158, 11, .16));
        border-bottom: 1px solid var(--seo-line);
    }
    .public-question-side-head h3 {
        margin: 0 0 8px;
        color: var(--seo-ink);
        font-size: 1.35rem;
        letter-spacing: 0;
    }
    .public-question-side-head p {
        margin: 0;
        color: var(--seo-muted);
        line-height: 1.6;
    }
    .public-question-side-body {
        padding: 26px;
    }
    .public-question-cta,
    .public-question-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        padding: 13px 16px;
        border-radius: 12px;
        font-weight: 900;
        text-decoration: none;
    }
    .public-question-cta {
        margin-bottom: 12px;
        background: var(--seo-blue);
        color: #fff;
    }
    .public-question-cta:hover {
        background: var(--seo-blue-dark);
        color: #fff;
    }
    .public-question-secondary {
        border: 1px solid var(--seo-line);
        color: var(--seo-blue-dark);
        background: #fff;
    }
    .public-question-secondary:hover {
        border-color: var(--seo-orange);
        color: var(--seo-ink);
    }
    .linked-tests {
        margin-top: 24px;
        padding-top: 20px;
        border-top: 1px solid #e5edf8;
    }
    .linked-tests h4 {
        margin-bottom: 12px;
        color: var(--seo-ink);
        font-size: 1rem;
        letter-spacing: 0;
    }
    .linked-tests ul {
        margin: 0;
        padding-left: 18px;
        color: var(--seo-muted);
        line-height: 1.7;
    }
    @media (max-width: 991px) {
        .public-question-layout { grid-template-columns: 1fr; }
        .public-question-side { position: static; }
    }
    @media (max-width: 640px) {
        .public-question-page { padding: 44px 0; }
        .public-question-card { padding: 24px; }
        .choice-item { grid-template-columns: 34px minmax(0, 1fr); }
        .choice-letter { width: 34px; height: 34px; }
    }
</style>

<main class="public-question-page">
    <div class="container">
        <div class="public-question-layout">
            <article class="public-question-card">
                <div class="question-label">
                    <i class="fas fa-question-circle"></i>
                    <span><?= (string)($question['type'] ?? 'mcq') === 'sata' ? 'Select all that apply' : 'Multiple choice' ?></span>
                </div>

                <div class="public-question-stem">
                    <?= $question['stem'] ?? '' ?>
                </div>

                <?php if (!empty($question['media_path'])): ?>
                    <figure class="public-question-media">
                        <img src="<?= base_url('questions/media/' . (int)($question['id'] ?? 0)) ?>" alt="Practice question media">
                    </figure>
                <?php endif; ?>

                <?php if (!empty($choices)): ?>
                    <ul class="choice-list">
                        <?php foreach ($choices as $choice): ?>
                            <li class="choice-item">
                                <span class="choice-letter"><?= esc($choice['label'] ?? '') ?></span>
                                <span class="choice-content"><?= esc($choice['content'] ?? '') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <a class="public-question-inline-cta" href="<?= base_url('register') ?>">
                    <span>Get Access</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </article>

            <aside class="public-question-side">
                <div class="public-question-side-head">
                    <h3>Continue practicing</h3>
                    <p>Use the full free test flow to answer questions, submit your work, and review your result.</p>
                </div>
                <div class="public-question-side-body">
                    <a class="public-question-cta" href="<?= base_url('register') ?>">
                        <span>Get Access</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a class="public-question-secondary" href="<?= esc($primaryTestUrl ?? base_url('/')) ?>">
                        <span>View Test Page</span>
                    </a>

                    <?php if (!empty($linkedTests)): ?>
                        <div class="linked-tests">
                            <h4>Appears in</h4>
                            <ul>
                                <?php foreach ($linkedTests as $test): ?>
                                    <li><?= esc($test['title'] ?? 'Practice test') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</main>
