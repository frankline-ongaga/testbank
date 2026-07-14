<?php
    $subcategories = $subcategories ?? [];
    $categories = $categories ?? [];
    $questionCounts = $questionCounts ?? [];
    $mockCounts = $mockCounts ?? [];
    $hasStudyAccess = !empty($hasStudyAccess);
    $totalQuestions = array_sum(array_map('intval', $questionCounts));
    $totalMockQuestions = array_sum(array_map('intval', $mockCounts));
?>

<div class="admin-content study-subcategory-page">
    <style>
        .study-subcategory-page {
            display: grid;
            gap: 22px;
        }

        .study-header {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: end;
        }

        .study-kicker {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .study-title {
            color: #142033;
            font-size: clamp(1.55rem, 2.2vw, 2.15rem);
            font-weight: 900;
            line-height: 1.16;
            margin: 0;
        }

        .study-copy {
            color: #516074;
            line-height: 1.65;
            margin: 0;
            max-width: 740px;
        }

        .study-header-action {
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

        .study-layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 18px;
            align-items: start;
        }

        .study-rail,
        .study-workspace,
        .study-stat,
        .study-topic-card,
        .study-empty-card {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .study-rail {
            overflow: hidden;
            position: sticky;
            top: 24px;
        }

        .study-rail-head {
            background: linear-gradient(135deg, rgba(10, 166, 215, .1), rgba(255, 255, 255, .94));
            border-bottom: 1px solid rgba(8, 126, 163, .1);
            padding: 18px 18px 14px;
        }

        .study-rail-head strong {
            color: #142033;
            display: block;
            font-size: 1rem;
            font-weight: 900;
        }

        .study-rail-head span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 4px;
        }

        .study-category-list {
            display: grid;
            gap: 6px;
            padding: 10px;
        }

        .study-category-link {
            align-items: center;
            border: 1px solid transparent;
            border-radius: 14px;
            color: #516074 !important;
            display: grid;
            gap: 10px;
            grid-template-columns: 32px minmax(0, 1fr) auto;
            min-height: 50px;
            padding: 9px 10px;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .study-category-link i:first-child {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border-radius: 10px;
            color: #087ea3;
            display: inline-flex;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .study-category-link span {
            font-size: 14px;
            font-weight: 850;
            overflow-wrap: anywhere;
        }

        .study-category-link.active,
        .study-category-link:hover {
            background: rgba(10, 166, 215, .08);
            border-color: rgba(10, 166, 215, .18);
            color: #087ea3 !important;
        }

        .study-category-link.active i:first-child {
            background: #0aa6d7;
            color: #fff;
        }

        .study-workspace {
            padding: 18px;
        }

        .study-stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            margin-bottom: 16px;
        }

        .study-stat {
            box-shadow: none;
            padding: 18px 20px;
        }

        .study-stat-value {
            color: #142033;
            font-size: 1.85rem;
            font-weight: 950;
            line-height: 1;
        }

        .study-stat-label {
            color: #516074;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .study-tools {
            align-items: center;
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 12px;
            margin-bottom: 16px;
        }

        .study-search {
            position: relative;
        }

        .study-search i {
            color: #94a3b8;
            left: 16px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .study-search input {
            background: #f8fbff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 999px;
            color: #142033;
            min-height: 46px;
            padding: 0 16px 0 42px;
            width: 100%;
        }

        .study-access-pill {
            align-items: center;
            background: <?= $hasStudyAccess ? '#dcfce7' : 'rgba(245, 158, 11, .14)' ?>;
            border: 1px solid <?= $hasStudyAccess ? '#bbf7d0' : 'rgba(245, 158, 11, .32)' ?>;
            border-radius: 999px;
            color: <?= $hasStudyAccess ? '#166534' : '#b45309' ?>;
            display: inline-flex;
            font-size: 13px;
            font-weight: 900;
            gap: 8px;
            min-height: 42px;
            padding: 0 14px;
            white-space: nowrap;
        }

        .study-topic-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .study-topic-card {
            display: grid;
            gap: 16px;
            min-height: 230px;
            padding: 18px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .study-topic-card::before {
            background: #0aa6d7;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .study-topic-card.premium-topic::before {
            background: #f59e0b;
        }

        .study-topic-card:hover {
            border-color: rgba(10, 166, 215, .34);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .study-topic-top {
            display: grid;
            gap: 12px;
            grid-template-columns: 46px minmax(0, 1fr);
        }

        .study-topic-icon {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border: 1px solid rgba(10, 166, 215, .16);
            border-radius: 14px;
            color: #087ea3;
            display: inline-flex;
            font-size: 18px;
            height: 46px;
            justify-content: center;
            width: 46px;
        }

        .premium-topic .study-topic-icon {
            background: rgba(245, 158, 11, .14);
            border-color: rgba(245, 158, 11, .24);
            color: #b45309;
        }

        .study-topic-labels {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 10px;
        }

        .study-topic-badge,
        .study-topic-mode {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: 12px;
            font-weight: 850;
            line-height: 1;
            min-height: 26px;
            padding: 0 9px;
        }

        .study-topic-badge.free {
            background: rgba(34, 197, 94, .12);
            color: #15803d;
        }

        .study-topic-badge.premium {
            background: rgba(245, 158, 11, .14);
            color: #b45309;
        }

        .study-topic-mode {
            background: rgba(10, 166, 215, .1);
            color: #087ea3;
        }

        .study-topic-title {
            color: #142033;
            font-size: 1.05rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .study-topic-description {
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
            margin: 0;
        }

        .study-topic-meta {
            border-top: 1px solid rgba(8, 126, 163, .1);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 14px;
        }

        .study-topic-meta span {
            align-items: center;
            color: #64748b;
            display: inline-flex;
            font-size: 13px;
            font-weight: 750;
            gap: 6px;
        }

        .study-topic-action {
            align-self: end;
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 46px;
            width: 100%;
        }

        .study-topic-action.primary {
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            color: #fff !important;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .18);
        }

        .study-topic-action.locked {
            background: rgba(245, 158, 11, .14);
            border: 1px solid rgba(245, 158, 11, .32);
            color: #b45309 !important;
        }

        .study-empty-card {
            padding: 38px 24px;
            text-align: center;
        }

        .study-empty-card h3 {
            color: #142033;
            font-size: 1.2rem;
            font-weight: 900;
            margin: 12px 0 8px;
        }

        .study-empty-card p {
            color: #64748b;
            margin: 0;
        }

        .study-topic-card.is-hidden {
            display: none;
        }

        .theme-dark .study-title,
        .theme-dark .study-rail-head strong,
        .theme-dark .study-topic-title,
        .theme-dark .study-stat-value,
        .theme-dark .study-empty-card h3 {
            color: #f8fafc;
        }

        .theme-dark .study-copy,
        .theme-dark .study-rail-head span,
        .theme-dark .study-topic-description,
        .theme-dark .study-topic-meta span,
        .theme-dark .study-stat-label,
        .theme-dark .study-empty-card p {
            color: #cbd5e1;
        }

        .theme-dark .study-rail,
        .theme-dark .study-workspace,
        .theme-dark .study-stat,
        .theme-dark .study-topic-card,
        .theme-dark .study-empty-card,
        .theme-dark .study-header-action {
            background: #111827;
            border-color: #374151;
        }

        .theme-dark .study-rail-head {
            background: #172033;
            border-color: #374151;
        }

        @media (max-width: 1100px) {
            .study-layout {
                grid-template-columns: 1fr;
            }

            .study-rail {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .study-header,
            .study-tools,
            .study-stats-grid {
                grid-template-columns: 1fr;
            }

            .study-topic-grid {
                grid-template-columns: 1fr;
            }

            .study-header-action,
            .study-access-pill {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <div class="study-header">
        <div>
            <p class="study-copy">Choose a topic to practice focused questions and review supporting notes included with your NCLEX access.</p>
        </div>
        <a class="study-header-action" href="<?= base_url('client/study') ?>">
            <i class="fas fa-arrow-left"></i>
            All Categories
        </a>
    </div>

    <div class="study-layout">
        <aside class="study-rail">
            <div class="study-rail-head">
                <strong>Study Library</strong>
                <span>Browse by category</span>
            </div>
            <nav class="study-category-list" aria-label="Study categories">
                <?php foreach ($categories as $cat): ?>
                    <?php $isActive = (int) $cat['id'] === (int) $category['id']; ?>
                    <a href="<?= base_url('client/study/'.$cat['id'].'/subcategories') ?>" class="study-category-link <?= $isActive ? 'active' : '' ?>">
                        <i class="far fa-folder"></i>
                        <span><?= esc($cat['name']) ?></span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <main class="study-workspace">
            <div class="study-stats-grid">
                <div class="study-stat">
                    <div class="study-stat-value"><?= esc((string) count($subcategories)) ?></div>
                    <div class="study-stat-label">Topics</div>
                </div>
                <div class="study-stat">
                    <div class="study-stat-value"><?= esc((string) $totalQuestions) ?></div>
                    <div class="study-stat-label">Questions</div>
                </div>
                <div class="study-stat">
                    <div class="study-stat-value"><?= esc((string) $totalMockQuestions) ?></div>
                    <div class="study-stat-label">Mock Questions</div>
                </div>
            </div>

            <div class="study-tools">
                <label class="study-search">
                    <i class="fas fa-search"></i>
                    <input type="search" data-study-search placeholder="Search topics in <?= esc($category['name']) ?>">
                </label>
                <span class="study-access-pill">
                    <i class="fas fa-circle-check"></i>
                    NCLEX access active
                </span>
            </div>

            <?php if (!empty($subcategories)): ?>
                <div class="study-topic-grid">
                    <?php foreach ($subcategories as $sub): ?>
                        <?php
                            $questionCount = (int) ($questionCounts[(int) $sub['id']] ?? 0);
                            $mockCount = (int) ($mockCounts[(int) $sub['id']] ?? 0);
                            $href = base_url('client/study/subcategory/'.$sub['id'].'/questions');
                            $searchText = strtolower(trim(($sub['name'] ?? '') . ' ' . ($sub['description'] ?? '')));
                        ?>
                        <article class="study-topic-card premium-topic" data-study-topic data-search="<?= esc($searchText) ?>">
                            <div class="study-topic-top">
                                <div class="study-topic-icon">
                                    <i class="far fa-folder-open"></i>
                                </div>
                                <div>
                                    <div class="study-topic-labels">
                                        <span class="study-topic-badge premium">NCLEX</span>
                                        <span class="study-topic-mode">Practice</span>
                                    </div>
                                    <h2 class="study-topic-title"><?= esc($sub['name']) ?></h2>
                                    <p class="study-topic-description">
                                        <?= esc($sub['description'] ?: 'Focused practice questions and mock questions for this topic.') ?>
                                    </p>
                                </div>
                            </div>

                            <div class="study-topic-meta">
                                <span><i class="far fa-circle-question"></i><?= esc((string) $questionCount) ?> questions</span>
                                <span><i class="far fa-clipboard"></i><?= esc((string) $mockCount) ?> mock questions</span>
                            </div>

                            <a class="study-topic-action primary" href="<?= $href ?>">
                                <i class="fas fa-arrow-right"></i>
                                Start Studying
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="study-empty-card d-none" data-study-empty>
                    <i class="fas fa-search fa-2x text-muted"></i>
                    <h3>No topics match your search.</h3>
                    <p>Try a shorter keyword or choose another category.</p>
                </div>
            <?php else: ?>
                <div class="study-empty-card">
                    <i class="far fa-folder-open fa-2x text-muted"></i>
                    <h3>No topics available yet.</h3>
                    <p>This category does not have study topics at the moment.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        (function () {
            const searchInput = document.querySelector('[data-study-search]');
            const cards = document.querySelectorAll('[data-study-topic]');
            const empty = document.querySelector('[data-study-empty]');

            if (!searchInput || !cards.length) {
                return;
            }

            searchInput.addEventListener('input', function () {
                const query = searchInput.value.trim().toLowerCase();
                let visible = 0;

                cards.forEach(function (card) {
                    const matches = !query || (card.dataset.search || '').includes(query);
                    card.classList.toggle('is-hidden', !matches);
                    if (matches) {
                        visible += 1;
                    }
                });

                if (empty) {
                    empty.classList.toggle('d-none', visible > 0);
                }
            });
        })();
    </script>
</div>
