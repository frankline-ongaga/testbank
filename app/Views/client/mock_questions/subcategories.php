<?php
    $categories = $categories ?? [];
    $subcategories = $subcategories ?? [];
    $mockCounts = $mockCounts ?? [];
    $totalMockQuestions = array_sum(array_map('intval', $mockCounts));
?>

<div class="admin-content mock-library-page">
    <style>
        .mock-library-page {
            display: grid;
            gap: 22px;
        }

        .mock-header {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: end;
        }

        .mock-copy {
            color: #516074;
            line-height: 1.65;
            margin: 0;
            max-width: 760px;
        }

        .mock-header-action {
            align-items: center;
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 16px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .07);
            color: #087ea3 !important;
            display: inline-flex;
            gap: 10px;
            min-height: 48px;
            padding: 0 16px;
            white-space: nowrap;
            font-weight: 900;
        }

        .mock-layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .mock-rail,
        .mock-workspace,
        .mock-stat,
        .mock-topic-card,
        .mock-empty-card {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .mock-rail {
            overflow: hidden;
            position: sticky;
            top: 24px;
        }

        .mock-rail-head {
            background: linear-gradient(135deg, rgba(10, 166, 215, .1), rgba(255, 255, 255, .94));
            border-bottom: 1px solid rgba(8, 126, 163, .1);
            padding: 18px 18px 14px;
        }

        .mock-rail-head strong {
            color: #142033;
            display: block;
            font-size: 1rem;
            font-weight: 900;
        }

        .mock-rail-head span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 4px;
        }

        .mock-category-list {
            display: grid;
            gap: 6px;
            padding: 10px;
        }

        .mock-category-link {
            align-items: center;
            border: 1px solid transparent;
            border-radius: 14px;
            color: #516074 !important;
            display: grid;
            gap: 10px;
            grid-template-columns: 32px minmax(0, 1fr) auto;
            min-height: 50px;
            padding: 9px 10px;
        }

        .mock-category-link i:first-child {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border-radius: 10px;
            color: #087ea3;
            display: inline-flex;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .mock-category-link span {
            font-size: 14px;
            font-weight: 850;
            overflow-wrap: anywhere;
        }

        .mock-category-link.active,
        .mock-category-link:hover {
            background: rgba(10, 166, 215, .08);
            border-color: rgba(10, 166, 215, .18);
            color: #087ea3 !important;
        }

        .mock-category-link.active i:first-child {
            background: #0aa6d7;
            color: #fff;
        }

        .mock-workspace {
            padding: 18px;
        }

        .mock-stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin-bottom: 16px;
        }

        .mock-stat {
            box-shadow: none;
            padding: 18px 20px;
        }

        .mock-stat-value {
            color: #142033;
            font-size: 1.85rem;
            font-weight: 950;
            line-height: 1;
        }

        .mock-stat-label {
            color: #516074;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .mock-topic-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .mock-topic-card {
            border-radius: 16px;
            display: grid;
            gap: 16px;
            padding: 18px;
        }

        .mock-topic-title {
            color: #142033;
            font-size: 1.08rem;
            font-weight: 900;
            line-height: 1.25;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .mock-topic-description {
            color: #64748b;
            margin: 0;
        }

        .mock-topic-meta {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            font-size: 13px;
            font-weight: 800;
        }

        .mock-topic-meta span {
            align-items: center;
            display: inline-flex;
            gap: 7px;
        }

        .mock-topic-action {
            align-items: center;
            background: #0aa6d7;
            border-radius: 12px;
            color: #fff !important;
            display: inline-flex;
            gap: 9px;
            justify-content: center;
            min-height: 44px;
            padding: 0 14px;
            font-weight: 900;
            justify-self: start;
        }

        .mock-empty-card {
            padding: 32px;
            text-align: center;
        }

        @media (max-width: 991.98px) {
            .mock-layout {
                grid-template-columns: 1fr;
            }

            .mock-rail {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .mock-header,
            .mock-stats-grid,
            .mock-topic-grid {
                grid-template-columns: 1fr;
            }

            .mock-header-action,
            .mock-topic-action {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <div class="mock-header">
        <p class="mock-copy">Choose a subcategory and work through mock questions with answer choices, correct answers, explanations, and rationales.</p>
        <a class="mock-header-action" href="<?= base_url('client') ?>">
            <i class="fas fa-arrow-left"></i>
            Dashboard
        </a>
    </div>

    <div class="mock-layout">
        <aside class="mock-rail">
            <div class="mock-rail-head">
                <strong>Mock Library</strong>
                <span>Browse by category</span>
            </div>
            <nav class="mock-category-list" aria-label="Mock question categories">
                <?php foreach ($categories as $cat): ?>
                    <?php $isActive = !empty($category) && (int) $cat['id'] === (int) $category['id']; ?>
                    <a href="<?= base_url('client/mock-questions/' . (int) $cat['id'] . '/subcategories') ?>" class="mock-category-link <?= $isActive ? 'active' : '' ?>">
                        <i class="far fa-folder"></i>
                        <span><?= esc($cat['name']) ?></span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <main class="mock-workspace">
            <div class="mock-stats-grid">
                <div class="mock-stat">
                    <div class="mock-stat-value"><?= esc((string) count($subcategories)) ?></div>
                    <div class="mock-stat-label">Subcategories</div>
                </div>
                <div class="mock-stat">
                    <div class="mock-stat-value"><?= esc((string) $totalMockQuestions) ?></div>
                    <div class="mock-stat-label">Mock Questions</div>
                </div>
            </div>

            <?php if (!empty($subcategories)): ?>
                <div class="mock-topic-grid">
                    <?php foreach ($subcategories as $sub): ?>
                        <?php $mockCount = (int) ($mockCounts[(int) $sub['id']] ?? 0); ?>
                        <article class="mock-topic-card">
                            <div>
                                <h2 class="mock-topic-title"><?= esc($sub['name']) ?></h2>
                                <p class="mock-topic-description"><?= esc($sub['description'] ?: 'Mock question practice for this topic.') ?></p>
                            </div>
                            <div class="mock-topic-meta">
                                <span><i class="far fa-circle-question"></i><?= esc((string) $mockCount) ?> mock questions</span>
                            </div>
                            <a class="mock-topic-action" href="<?= base_url('client/mock-questions/subcategory/' . (int) $sub['id'] . '/questions') ?>">
                                <i class="fas fa-arrow-right"></i>
                                Practice Mock Questions
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="mock-empty-card">
                    <h3>No subcategories yet.</h3>
                    <p class="text-muted mb-0">Mock questions will appear here after subcategories are added.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
