<?php
$exam = $exam ?? [];
$subjects = $exam['subjects'] ?? [];
$features = $exam['features'] ?? [];
$plan = $exam['plan'] ?? [];
$faqs = $exam['faqs'] ?? [];
?>

<!-- Page Title Banner Start -->
<section class="page_title_banner">
    <div class="container">
        <div class="content">
            <div class="title">
                <h1><?= esc($exam['name'] ?? '') ?> Preparation</h1>
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
<!-- Page Title Banner End -->

<style>
    .exam-prep-page {
        --exam-blue: #0aa6d7;
        --exam-blue-dark: #088fb8;
        --exam-orange: #f59e0b;
        --exam-ink: #1e293b;
        --exam-muted: #64748b;
        --exam-line: #e2e8f0;
    }
    .exam-prep-page h2,
    .exam-prep-page h3,
    .exam-prep-page h4 {
        color: var(--exam-ink);
        letter-spacing: 0;
    }
    .exam-intro-image {
        width: 100%;
        min-height: 420px;
        max-height: 500px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 8px 24px rgba(15, 23, 42, .12);
    }
    .exam-intro-copy h2 {
        margin-bottom: 1rem;
        font-size: 2.5rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .exam-intro-copy > p {
        margin-bottom: 1.25rem;
        color: var(--exam-muted);
        font-size: 1.1rem;
        line-height: 1.75;
    }
    .exam-kicker {
        display: block;
        margin-bottom: .75rem;
        color: var(--exam-blue-dark);
        font-size: .9rem;
        font-weight: 700;
        text-transform: uppercase;
    }
    .exam-benefits {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: .75rem 1rem;
        margin: 1.75rem 0 2rem;
        padding: 0;
        list-style: none;
    }
    .exam-benefits li {
        display: flex;
        align-items: flex-start;
        gap: .65rem;
        color: #475569;
        line-height: 1.5;
    }
    .exam-benefits i {
        margin-top: .2rem;
        color: var(--exam-blue);
        flex-shrink: 0;
    }
    .exam-section-heading {
        max-width: 760px;
        margin: 0 auto 3rem;
        text-align: center;
    }
    .exam-section-heading h2 {
        margin-bottom: 1rem;
        font-size: 2.5rem;
        font-weight: 700;
    }
    .exam-section-heading p {
        margin: 0;
        color: var(--exam-muted);
        font-size: 1.1rem;
        line-height: 1.7;
    }
    .exam-subject-card {
        height: 100%;
        padding: 2rem;
        border: 1px solid var(--exam-line);
        border-top: 4px solid var(--exam-blue);
        border-radius: 12px;
        background: #fff;
        transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
    }
    .exam-subject-card:hover {
        transform: translateY(-5px);
        border-color: var(--exam-orange);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .08);
    }
    .exam-subject-icon {
        display: inline-flex;
        width: 48px;
        height: 48px;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        border-radius: 50%;
        background: rgba(10, 166, 215, .12);
        color: var(--exam-blue);
        font-size: 1.15rem;
    }
    .exam-subject-card h3 {
        margin-bottom: .75rem;
        font-size: 1.25rem;
        font-weight: 700;
    }
    .exam-subject-card p {
        margin: 0;
        color: var(--exam-muted);
        line-height: 1.65;
    }
    .exam-feature-box {
        height: 100%;
        padding: 2rem;
        border-left: 4px solid var(--exam-blue);
        border-radius: 12px;
        background: #f8fafc;
    }
    .exam-feature-box h4 {
        margin-bottom: .75rem;
        font-size: 1.3rem;
        font-weight: 600;
    }
    .exam-feature-box h4 i {
        margin-right: .6rem;
        color: var(--exam-blue);
    }
    .exam-feature-box p {
        margin: 0;
        color: var(--exam-muted);
        line-height: 1.65;
    }
    .exam-roadmap {
        padding: 2.5rem;
        border-radius: 12px;
        background: #f8fafc;
    }
    .exam-roadmap-step {
        position: relative;
        height: 100%;
        padding: 1.5rem 1.25rem;
        border-radius: 10px;
        background: #fff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
    }
    .exam-roadmap-number {
        display: inline-flex;
        width: 38px;
        height: 38px;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        border-radius: 50%;
        background: var(--exam-orange);
        color: #fff;
        font-size: .8rem;
        font-weight: 800;
    }
    .exam-roadmap-step h4 {
        margin-bottom: .6rem;
        font-size: 1.1rem;
        font-weight: 700;
    }
    .exam-roadmap-step p {
        margin: 0;
        color: var(--exam-muted);
        line-height: 1.6;
    }
    .exam-faq {
        max-width: 900px;
        margin: 0 auto;
    }
    .exam-faq details {
        margin-bottom: 1rem;
        border: 1px solid var(--exam-line);
        border-radius: 10px;
        background: #fff;
    }
    .exam-faq summary {
        position: relative;
        padding: 1.25rem 3.5rem 1.25rem 1.5rem;
        color: var(--exam-ink);
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        list-style: none;
    }
    .exam-faq summary::-webkit-details-marker {
        display: none;
    }
    .exam-faq summary::after {
        content: "+";
        position: absolute;
        top: 1rem;
        right: 1.5rem;
        color: var(--exam-blue);
        font-size: 1.6rem;
        font-weight: 400;
    }
    .exam-faq details[open] summary::after {
        content: "-";
    }
    .exam-faq details p {
        margin: 0;
        padding: 0 1.5rem 1.25rem;
        color: var(--exam-muted);
        line-height: 1.7;
    }
    .exam-cta-box {
        padding: 3rem;
        border: 2px solid var(--exam-line);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        text-align: center;
    }
    .exam-cta-box h2 {
        margin-bottom: .75rem;
        font-size: 2rem;
        font-weight: 700;
    }
    .exam-cta-box p {
        max-width: 680px;
        margin: 0 auto 1.75rem;
        color: var(--exam-muted);
        font-size: 1.05rem;
        line-height: 1.7;
    }
    .exam-disclaimer {
        max-width: 900px;
        margin: 2rem auto 0;
        color: #94a3b8;
        font-size: .75rem;
        line-height: 1.6;
        text-align: center;
    }
    @media (max-width: 991px) {
        .exam-intro-image {
            min-height: 340px;
            margin-bottom: 2rem;
        }
    }
    @media (max-width: 767px) {
        .exam-intro-copy h2,
        .exam-section-heading h2 {
            font-size: 2rem;
        }
        .exam-benefits {
            grid-template-columns: 1fr;
        }
        .exam-roadmap,
        .exam-cta-box {
            padding: 2rem 1.25rem;
        }
    }
</style>

<main class="exam-prep-page">
    <section class="py-60">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5">
                    <img
                        src="<?= base_url($exam['image'] ?? '') ?>"
                        alt="<?= esc($exam['imageAlt'] ?? '') ?>"
                        class="exam-intro-image">
                </div>
                <div class="col-lg-7 exam-intro-copy">
                    <span class="exam-kicker"><?= esc($exam['eyebrow'] ?? '') ?></span>
                    <h2><?= esc($exam['overviewTitle'] ?? '') ?></h2>
                    <p><?= esc($exam['intro'] ?? '') ?></p>
                    <p><?= esc($exam['overview'] ?? '') ?></p>
                    <ul class="exam-benefits">
                        <li><i class="fas fa-check-circle"></i><span>Focused content review</span></li>
                        <li><i class="fas fa-check-circle"></i><span>Practice with clear rationales</span></li>
                        <li><i class="fas fa-check-circle"></i><span>Flexible, self-paced study</span></li>
                        <li><i class="fas fa-check-circle"></i><span>Test-day strategy and pacing</span></li>
                    </ul>
                    <a href="<?= base_url('register') ?>" class="educate-btn">
                        <span class="educate-btn__curve"></span>Start Preparing
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="py-60" style="background:#f8fafc;">
        <div class="container">
            <div class="exam-section-heading">
                <span class="exam-kicker">What You Will Study</span>
                <h2><?= esc($exam['subjectsTitle'] ?? '') ?></h2>
                <p><?= esc($exam['subjectsIntro'] ?? '') ?></p>
            </div>
            <div class="row g-4">
                <?php foreach ($subjects as $subject): ?>
                    <div class="<?= count($subjects) > 4 ? 'col-lg-4 col-md-6' : 'col-lg-3 col-md-6' ?>">
                        <article class="exam-subject-card">
                            <span class="exam-subject-icon">
                                <i class="fas <?= esc($subject['icon']) ?>" aria-hidden="true"></i>
                            </span>
                            <h3><?= esc($subject['title']) ?></h3>
                            <p><?= esc($subject['text']) ?></p>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-60">
        <div class="container">
            <div class="exam-section-heading">
                <span class="exam-kicker">A Smarter Way to Prepare</span>
                <h2>Practice that teaches while you test</h2>
                <p>Build knowledge, apply it, and use your results to decide exactly what to study next.</p>
            </div>
            <div class="row g-4">
                <?php foreach ($features as $feature): ?>
                    <div class="col-lg-6">
                        <article class="exam-feature-box">
                            <h4><i class="fas fa-check-circle"></i><?= esc($feature['title']) ?></h4>
                            <p><?= esc($feature['text']) ?></p>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-60">
        <div class="container">
            <div class="exam-roadmap">
                <div class="exam-section-heading">
                    <span class="exam-kicker">Your Study Roadmap</span>
                    <h2>From first assessment to test day</h2>
                    <p>A clear sequence makes preparation manageable and keeps your progress visible.</p>
                </div>
                <div class="row g-4">
                    <?php foreach ($plan as $step): ?>
                        <div class="col-lg-3 col-md-6">
                            <article class="exam-roadmap-step">
                                <span class="exam-roadmap-number"><?= esc($step['number']) ?></span>
                                <h4><?= esc($step['title']) ?></h4>
                                <p><?= esc($step['text']) ?></p>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="py-60" style="background:#f8fafc;">
        <div class="container">
            <div class="exam-section-heading">
                <span class="exam-kicker">Common Questions</span>
                <h2><?= esc($exam['name'] ?? '') ?> Prep FAQ</h2>
            </div>
            <div class="exam-faq">
                <?php foreach ($faqs as $index => $faq): ?>
                    <details<?= $index === 0 ? ' open' : '' ?>>
                        <summary><?= esc($faq['question']) ?></summary>
                        <p><?= esc($faq['answer']) ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-60">
        <div class="container">
            <div class="exam-cta-box">
                <h2><?= esc($exam['ctaTitle'] ?? '') ?></h2>
                <p><?= esc($exam['ctaText'] ?? '') ?></p>
                <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg" style="padding:12px 28px; font-weight:600;">
                    Get Started
                </a>
            </div>
            <p class="exam-disclaimer"><?= esc($exam['disclaimer'] ?? '') ?></p>
        </div>
    </section>
</main>
