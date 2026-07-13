<?php
    $subcategories = $subcategories ?? [];
    $categories = $categories ?? [];
    $cheatSheetCounts = $cheatSheetCounts ?? [];
    $totalSubcategories = count($subcategories);
    $totalDocs = array_sum(array_map('intval', $cheatSheetCounts));
?>

<div class="admin-content cheat-subcategory-page">
    <style>
        .cheat-subcategory-page {
            display: grid;
            gap: 22px;
        }

        .cheat-sub-header {
            align-items: end;
            display: grid;
            gap: 18px;
            grid-template-columns: minmax(0, 1fr) auto;
        }

        .cheat-kicker {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .cheat-title {
            color: #142033;
            font-size: clamp(1.55rem, 2.2vw, 2.15rem);
            font-weight: 900;
            line-height: 1.16;
            margin: 0;
        }

        .cheat-copy {
            color: #516074;
            line-height: 1.65;
            margin: 8px 0 0;
            max-width: 740px;
        }

        .cheat-back {
            align-items: center;
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 999px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .07);
            color: #087ea3 !important;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            min-height: 46px;
            padding: 0 16px;
            white-space: nowrap;
        }

        .cheat-layout {
            align-items: start;
            display: grid;
            gap: 18px;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .cheat-rail,
        .cheat-workspace,
        .cheat-stat,
        .cheat-topic-card,
        .cheat-empty {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .cheat-rail {
            overflow: hidden;
            position: sticky;
            top: 24px;
        }

        .cheat-rail-head {
            background: linear-gradient(135deg, rgba(10, 166, 215, .1), rgba(255, 255, 255, .94));
            border-bottom: 1px solid rgba(8, 126, 163, .1);
            padding: 18px 18px 14px;
        }

        .cheat-rail-head strong {
            color: #142033;
            display: block;
            font-size: 1rem;
            font-weight: 900;
        }

        .cheat-rail-head span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 4px;
        }

        .cheat-category-list {
            display: grid;
            gap: 6px;
            padding: 10px;
        }

        .cheat-category-link {
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

        .cheat-category-link i:first-child {
            align-items: center;
            background: rgba(245, 158, 11, .14);
            border-radius: 10px;
            color: #b45309;
            display: inline-flex;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .cheat-category-link span {
            font-size: 14px;
            font-weight: 850;
            overflow-wrap: anywhere;
        }

        .cheat-category-link.active,
        .cheat-category-link:hover {
            background: rgba(10, 166, 215, .08);
            border-color: rgba(10, 166, 215, .18);
            color: #087ea3 !important;
        }

        .cheat-workspace {
            display: grid;
            gap: 16px;
            padding: 18px;
        }

        .cheat-stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cheat-stat {
            box-shadow: none;
            padding: 18px 20px;
        }

        .cheat-stat-value {
            color: #142033;
            font-size: 1.9rem;
            font-weight: 950;
            line-height: 1;
        }

        .cheat-stat-label {
            color: #516074;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .cheat-tools {
            align-items: center;
            display: grid;
            gap: 12px;
            grid-template-columns: minmax(0, 1fr) auto;
        }

        .cheat-search {
            position: relative;
        }

        .cheat-search i {
            color: #94a3b8;
            left: 16px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .cheat-search input {
            background: #f8fbff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 999px;
            color: #142033;
            min-height: 46px;
            padding: 0 16px 0 42px;
            width: 100%;
        }

        .cheat-all-link {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border: 1px solid rgba(10, 166, 215, .22);
            border-radius: 999px;
            color: #087ea3 !important;
            display: inline-flex;
            font-size: 13px;
            font-weight: 900;
            gap: 8px;
            min-height: 42px;
            padding: 0 14px;
            white-space: nowrap;
        }

        .cheat-topic-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .cheat-topic-card {
            display: grid;
            gap: 16px;
            grid-template-rows: 1fr auto;
            min-height: 230px;
            padding: 18px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .cheat-topic-card::before {
            background: #f59e0b;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .cheat-topic-card:hover {
            border-color: rgba(10, 166, 215, .34);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .cheat-topic-main {
            display: grid;
            gap: 14px;
            grid-template-columns: 46px minmax(0, 1fr);
        }

        .cheat-topic-icon {
            align-items: center;
            background: rgba(245, 158, 11, .14);
            border: 1px solid rgba(245, 158, 11, .24);
            border-radius: 14px;
            color: #b45309;
            display: inline-flex;
            font-size: 18px;
            height: 46px;
            justify-content: center;
            width: 46px;
        }

        .cheat-topic-title {
            color: #142033;
            font-size: 1.05rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .cheat-topic-copy {
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
            margin: 0;
        }

        .cheat-topic-meta {
            border-top: 1px solid rgba(8, 126, 163, .1);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 14px;
            padding-top: 14px;
        }

        .cheat-topic-meta span {
            align-items: center;
            color: #64748b;
            display: inline-flex;
            font-size: 13px;
            font-weight: 750;
            gap: 6px;
        }

        .cheat-topic-action {
            align-items: center;
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            border-radius: 999px;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .18);
            color: #fff !important;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 46px;
            padding: 0 16px;
            width: 100%;
        }

        .cheat-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .cheat-empty h3 {
            color: #142033;
            font-size: 1.2rem;
            font-weight: 900;
            margin: 12px 0 8px;
        }

        .cheat-empty p {
            color: #64748b;
            margin: 0;
        }

        .cheat-topic-card.is-hidden {
            display: none;
        }

        .theme-dark .cheat-title,
        .theme-dark .cheat-rail-head strong,
        .theme-dark .cheat-stat-value,
        .theme-dark .cheat-topic-title,
        .theme-dark .cheat-empty h3 {
            color: #f8fafc;
        }

        .theme-dark .cheat-copy,
        .theme-dark .cheat-rail-head span,
        .theme-dark .cheat-stat-label,
        .theme-dark .cheat-topic-copy,
        .theme-dark .cheat-topic-meta span,
        .theme-dark .cheat-empty p {
            color: #cbd5e1;
        }

        .theme-dark .cheat-back,
        .theme-dark .cheat-rail,
        .theme-dark .cheat-workspace,
        .theme-dark .cheat-stat,
        .theme-dark .cheat-topic-card,
        .theme-dark .cheat-empty {
            background: #111827;
            border-color: #374151;
        }

        .theme-dark .cheat-rail-head {
            background: #172033;
            border-color: #374151;
        }

        @media (max-width: 1100px) {
            .cheat-layout {
                grid-template-columns: 1fr;
            }

            .cheat-rail {
                position: static;
            }
        }

        @media (max-width: 767.98px) {
            .cheat-sub-header,
            .cheat-stats-grid,
            .cheat-tools {
                grid-template-columns: 1fr;
            }

            .cheat-topic-grid {
                grid-template-columns: 1fr;
            }

            .cheat-back,
            .cheat-all-link {
                justify-content: center;
                width: 100%;
            }
        }
    </style>

    <div class="cheat-sub-header">
        <div>
            <span class="cheat-kicker">Cheat Sheet Topics</span>
            <h1 class="cheat-title"><?= esc($category['name']) ?></h1>
            <p class="cheat-copy">Choose a focused topic to open its quick-reference PDFs and images.</p>
        </div>
        <a class="cheat-back" href="<?= base_url('client/cheat-sheets') ?>">
            <i class="fas fa-arrow-left"></i>
            All Categories
        </a>
    </div>

    <div class="cheat-layout">
        <aside class="cheat-rail">
            <div class="cheat-rail-head">
                <strong>Cheat Sheets</strong>
                <span>Browse by category</span>
            </div>
            <nav class="cheat-category-list" aria-label="Cheat sheet categories">
                <?php foreach ($categories as $cat): ?>
                    <?php $isActive = (int) $cat['id'] === (int) $category['id']; ?>
                    <a href="<?= base_url('client/cheat-sheets/' . (int) $cat['id'] . '/subcategories') ?>" class="cheat-category-link <?= $isActive ? 'active' : '' ?>">
                        <i class="far fa-file-image"></i>
                        <span><?= esc($cat['name']) ?></span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <main class="cheat-workspace">
            <div class="cheat-stats-grid">
                <div class="cheat-stat">
                    <div class="cheat-stat-value"><?= esc((string) $totalSubcategories) ?></div>
                    <div class="cheat-stat-label">Subcategories</div>
                </div>
                <div class="cheat-stat">
                    <div class="cheat-stat-value"><?= esc((string) $totalDocs) ?></div>
                    <div class="cheat-stat-label">Cheat Sheets</div>
                </div>
            </div>

            <div class="cheat-tools">
                <label class="cheat-search">
                    <i class="fas fa-search"></i>
                    <input type="search" data-cheat-sub-search placeholder="Search <?= esc($category['name']) ?> topics">
                </label>
                <a class="cheat-all-link" href="<?= base_url('client/cheat-sheets/category/' . (int) $category['id'] . '/docs') ?>">
                    <i class="fas fa-list"></i>
                    View All Sheets
                </a>
            </div>

            <?php if (!empty($subcategories)): ?>
                <div class="cheat-topic-grid">
                    <?php foreach ($subcategories as $sub): ?>
                        <?php
                            $docCount = (int) ($cheatSheetCounts[(int) $sub['id']] ?? 0);
                            $description = trim((string) ($sub['description'] ?? ''));
                            $searchText = strtolower(trim(($sub['name'] ?? '') . ' ' . $description));
                        ?>
                        <article class="cheat-topic-card" data-cheat-sub-card data-search="<?= esc($searchText) ?>">
                            <div>
                                <div class="cheat-topic-main">
                                    <div class="cheat-topic-icon">
                                        <i class="far fa-file-lines"></i>
                                    </div>
                                    <div>
                                        <h2 class="cheat-topic-title"><?= esc($sub['name']) ?></h2>
                                        <p class="cheat-topic-copy">
                                            <?= esc($description !== '' ? $description : 'Quick-reference sheets for this topic.') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="cheat-topic-meta">
                                    <span><i class="far fa-file-image"></i><?= esc((string) $docCount) ?> sheets</span>
                                </div>
                            </div>
                            <a class="cheat-topic-action" href="<?= base_url('client/cheat-sheets/subcategory/' . (int) $sub['id'] . '/docs') ?>">
                                View Cheat Sheets
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="cheat-empty d-none" data-cheat-sub-empty>
                    <i class="fas fa-search fa-2x text-muted"></i>
                    <h3>No topics match your search.</h3>
                    <p>Try another keyword or clear the search field.</p>
                </div>
            <?php else: ?>
                <div class="cheat-empty">
                    <i class="fas fa-file-image fa-2x text-muted"></i>
                    <h3>No subcategories yet.</h3>
                    <p>This category does not have cheat sheet topics at the moment.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <script>
        (function () {
            const searchInput = document.querySelector('[data-cheat-sub-search]');
            const cards = document.querySelectorAll('[data-cheat-sub-card]');
            const empty = document.querySelector('[data-cheat-sub-empty]');

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
