<?php
    $categories = $categories ?? [];
    $cheatSheetCounts = $cheatSheetCounts ?? [];
    $totalCategories = count($categories);
    $totalDocs = array_sum(array_map('intval', $cheatSheetCounts));
?>

<div class="admin-content cheat-library-page">
    <style>
        .cheat-library-page {
            display: grid;
            gap: 22px;
        }

        .cheat-library-header {
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
            max-width: 720px;
        }

        .cheat-access-card {
            align-items: center;
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 16px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .07);
            display: flex;
            gap: 12px;
            min-width: 250px;
            padding: 14px 16px;
        }

        .cheat-access-card i {
            align-items: center;
            background: rgba(245, 158, 11, .16);
            border-radius: 12px;
            color: #d97706;
            display: inline-flex;
            flex: 0 0 42px;
            height: 42px;
            justify-content: center;
            width: 42px;
        }

        .cheat-access-card strong {
            color: #142033;
            display: block;
            font-weight: 900;
            line-height: 1.2;
        }

        .cheat-access-card span span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 2px;
        }

        .cheat-stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cheat-stat,
        .cheat-tools,
        .cheat-card,
        .cheat-empty {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .cheat-stat {
            padding: 18px 20px;
        }

        .cheat-stat-value {
            color: #142033;
            font-size: 2rem;
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
            padding: 16px;
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

        .cheat-filter-note {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border: 1px solid rgba(10, 166, 215, .22);
            border-radius: 999px;
            color: #087ea3;
            display: inline-flex;
            font-size: 13px;
            font-weight: 900;
            gap: 8px;
            min-height: 42px;
            padding: 0 14px;
            white-space: nowrap;
        }

        .cheat-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .cheat-card {
            display: grid;
            gap: 16px;
            grid-template-rows: 1fr auto;
            min-height: 258px;
            padding: 18px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .cheat-card::before {
            background: #f59e0b;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .cheat-card:hover {
            border-color: rgba(10, 166, 215, .34);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .cheat-card-main {
            display: grid;
            gap: 14px;
            grid-template-columns: 46px minmax(0, 1fr);
        }

        .cheat-card-icon {
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

        .cheat-card-title {
            color: #142033;
            font-size: 1.08rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .cheat-card-copy {
            color: #64748b;
            font-size: 14px;
            line-height: 1.55;
            margin: 0;
        }

        .cheat-meta-row {
            border-top: 1px solid rgba(8, 126, 163, .1);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 14px;
        }

        .cheat-meta-row span {
            align-items: center;
            color: #64748b;
            display: inline-flex;
            font-size: 13px;
            font-weight: 750;
            gap: 6px;
        }

        .cheat-actions {
            display: grid;
            gap: 10px;
            grid-template-columns: minmax(0, 1fr);
        }

        .cheat-action-primary {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 46px;
            padding: 0 16px;
        }

        .cheat-action-primary {
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            color: #fff !important;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .18);
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

        .cheat-card.is-hidden {
            display: none;
        }

        .theme-dark .cheat-title,
        .theme-dark .cheat-access-card strong,
        .theme-dark .cheat-stat-value,
        .theme-dark .cheat-card-title,
        .theme-dark .cheat-empty h3 {
            color: #f8fafc;
        }

        .theme-dark .cheat-copy,
        .theme-dark .cheat-access-card span span,
        .theme-dark .cheat-stat-label,
        .theme-dark .cheat-card-copy,
        .theme-dark .cheat-meta-row span,
        .theme-dark .cheat-empty p {
            color: #cbd5e1;
        }

        .theme-dark .cheat-access-card,
        .theme-dark .cheat-stat,
        .theme-dark .cheat-tools,
        .theme-dark .cheat-card,
        .theme-dark .cheat-empty {
            background: #111827;
            border-color: #374151;
        }

        @media (max-width: 991.98px) {
            .cheat-library-header,
            .cheat-stats-grid,
            .cheat-tools {
                grid-template-columns: 1fr;
            }

            .cheat-access-card {
                min-width: 0;
            }
        }

        @media (max-width: 575.98px) {
            .cheat-grid {
                grid-template-columns: 1fr;
            }

            .cheat-card-main,
            .cheat-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="cheat-library-header">
        <div>
            <span class="cheat-kicker">Quick Reference Library</span>
            <h1 class="cheat-title">Cheat Sheets</h1>
            <p class="cheat-copy">Browse high-yield reference sheets by category and open every sheet for the topic you want to review.</p>
        </div>
        <div class="cheat-access-card">
            <i class="fas fa-bolt"></i>
            <span>
                <strong>Premium resource</strong>
                <span>PDFs and images for fast review</span>
            </span>
        </div>
    </div>

    <div class="cheat-stats-grid">
        <div class="cheat-stat">
            <div class="cheat-stat-value"><?= esc((string) $totalCategories) ?></div>
            <div class="cheat-stat-label">Categories</div>
        </div>
        <div class="cheat-stat">
            <div class="cheat-stat-value"><?= esc((string) $totalDocs) ?></div>
            <div class="cheat-stat-label">Cheat Sheets</div>
        </div>
    </div>

    <div class="cheat-tools">
        <label class="cheat-search">
            <i class="fas fa-search"></i>
            <input type="search" data-cheat-search placeholder="Search cheat sheet categories">
        </label>
        <span class="cheat-filter-note">
            <i class="fas fa-layer-group"></i>
            Organized by nursing topic
        </span>
    </div>

    <?php if (!empty($categories)): ?>
        <div class="cheat-grid">
            <?php foreach ($categories as $cat): ?>
                <?php
                    $categoryId = (int) $cat['id'];
                    $docCount = (int) ($cheatSheetCounts[$categoryId] ?? 0);
                    $description = trim((string) ($cat['description'] ?? ''));
                    $searchText = strtolower(trim(($cat['name'] ?? '') . ' ' . $description));
                ?>
                <article class="cheat-card" data-cheat-card data-search="<?= esc($searchText) ?>">
                    <div>
                        <div class="cheat-card-main">
                            <div class="cheat-card-icon">
                                <i class="far fa-file-image"></i>
                            </div>
                            <div>
                                <h2 class="cheat-card-title"><?= esc($cat['name']) ?></h2>
                                <p class="cheat-card-copy">
                                    <?= esc($description !== '' ? $description : 'Quick-reference sheets for focused review in this category.') ?>
                                </p>
                            </div>
                        </div>
                        <div class="cheat-meta-row">
                            <span><i class="far fa-file-lines"></i><?= esc((string) $docCount) ?> sheets</span>
                        </div>
                    </div>
                    <div class="cheat-actions">
                        <a class="cheat-action-primary" href="<?= base_url('client/cheat-sheets/category/' . $categoryId . '/docs') ?>">
                            View Cheat Sheets
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="cheat-empty d-none" data-cheat-empty>
            <i class="fas fa-search fa-2x text-muted"></i>
            <h3>No categories match your search.</h3>
            <p>Try a shorter keyword or clear the search field.</p>
        </div>
    <?php else: ?>
        <div class="cheat-empty">
            <i class="fas fa-file-image fa-2x text-muted"></i>
            <h3>No cheat sheet categories yet.</h3>
            <p>Check back soon for quick-reference sheets.</p>
        </div>
    <?php endif; ?>

    <script>
        (function () {
            const searchInput = document.querySelector('[data-cheat-search]');
            const cards = document.querySelectorAll('[data-cheat-card]');
            const empty = document.querySelector('[data-cheat-empty]');

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
