<?php
    $freeTests = $freeTests ?? [];
    $paidTests = $paidTests ?? [];
    $products = $products ?? [];
    $activeProductSlugs = array_values(array_filter(array_map('strval', $activeProductSlugs ?? [])));
    $freeCount = count($freeTests);
    $paidCount = count($paidTests);
    $allCount = $freeCount + $paidCount;

    $productNames = static function (array $test): array {
        return array_values(array_filter(array_map('trim', explode(',', (string) ($test['product_names'] ?? '')))));
    };

    $productSlugs = static function (array $test): array {
        return array_values(array_filter(array_map('trim', explode(',', (string) ($test['product_slugs'] ?? '')))));
    };

    $productKey = static function (string $name): string {
        return strtolower(preg_replace('/[^a-z0-9]+/i', '-', trim($name)));
    };

    $testCard = static function (array $test, bool $isFree, array $activeProductSlugs) use ($productNames, $productSlugs, $productKey): void {
        $productsForTest = $productNames($test);
        $productSlugsForTest = $productSlugs($test);
        $productKeys = array_map($productKey, $productsForTest);
        $mode = (string) ($test['mode'] ?? 'practice');
        $questions = (int) ($test['question_count'] ?? 0);
        $minutes = (int) ($test['time_limit_minutes'] ?? 0);
        $hasTestAccess = $isFree || !empty(array_intersect($productSlugsForTest, $activeProductSlugs));
        $accessProductSlug = '';
        foreach ($productSlugsForTest as $slug) {
            if (!in_array($slug, $activeProductSlugs, true)) {
                $accessProductSlug = $slug;
                break;
            }
        }
        if ($accessProductSlug === '' && !empty($productSlugsForTest)) {
            $accessProductSlug = $productSlugsForTest[0];
        }
        $accessUrl = base_url('client/subscription') . ($accessProductSlug !== '' ? '?product=' . rawurlencode($accessProductSlug) : '');
        $startUrl = $isFree
            ? base_url('client/tests/start-free/' . $test['id'])
            : base_url('client/tests/start/' . $test['id']);
        ?>
        <article class="test-library-card <?= !$hasTestAccess ? 'is-locked' : '' ?>" data-test-card data-access="<?= $isFree ? 'free' : 'paid' ?>" data-products="<?= esc(implode(' ', $productKeys)) ?>">
            <div class="test-card-main">
                <div class="test-card-icon">
                    <i class="far fa-file-lines"></i>
                </div>
                <div class="test-card-copy">
                    <div class="test-card-topline">
                        <span class="test-type-pill <?= $isFree ? 'test-type-pill-free' : 'test-type-pill-paid' ?>">
                            <?= $isFree ? 'Free' : 'Premium' ?>
                        </span>
                        <span class="test-mode-pill"><?= esc(ucfirst($mode)) ?></span>
                    </div>
                    <h2 class="test-card-title"><?= esc($test['title']) ?></h2>
                    <div class="test-meta-row">
                        <span><i class="far fa-circle-question"></i><?= esc((string) $questions) ?> questions</span>
                        <?php if ($minutes > 0): ?>
                            <span><i class="far fa-clock"></i><?= esc((string) $minutes) ?> mins</span>
                        <?php else: ?>
                            <span><i class="far fa-clock"></i>Untimed</span>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($productsForTest)): ?>
                        <div class="test-product-row">
                            <?php foreach ($productsForTest as $productName): ?>
                                <span class="product-pill"><?= esc($productName) ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="test-card-action">
                <?php if ($hasTestAccess): ?>
                    <a href="<?= esc($startUrl) ?>" class="btn test-start-btn">
                        <i class="fas fa-play"></i>
                        <?= $isFree ? 'Start Free Test' : 'Start Test' ?>
                    </a>
                <?php else: ?>
                    <a href="<?= esc($accessUrl) ?>" class="btn test-lock-btn">
                        <i class="fas fa-lock"></i>
                        Get Access
                    </a>
                <?php endif; ?>
            </div>
        </article>
        <?php
    };
?>

<div class="admin-content test-library-page">
    <style>
        .test-library-page {
            display: grid;
            gap: 22px;
        }

        .test-library-toolbar {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 18px;
            align-items: end;
        }

        .test-library-kicker {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .test-library-title {
            color: #142033;
            font-size: clamp(1.55rem, 2.2vw, 2.15rem);
            font-weight: 900;
            line-height: 1.16;
            margin: 0;
        }

        .test-library-copy {
            color: #516074;
            line-height: 1.65;
            margin: 8px 0 0;
            max-width: 720px;
        }

        .test-library-cta {
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

        .test-library-cta i {
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

        .test-library-cta strong {
            color: #142033;
            display: block;
            font-weight: 900;
            line-height: 1.2;
        }

        .test-library-cta span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 2px;
        }

        .test-stats-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .test-stat-card {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            padding: 18px 20px;
        }

        .test-stat-value {
            color: #142033;
            font-size: 2rem;
            font-weight: 950;
            line-height: 1;
        }

        .test-stat-label {
            color: #516074;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            margin-top: 8px;
            text-transform: uppercase;
        }

        .test-filter-panel {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            padding: 16px;
        }

        .test-filter-row {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .test-filter-label {
            color: #516074;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            margin-right: 4px;
            text-transform: uppercase;
        }

        .test-filter-btn {
            background: #f8fbff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 999px;
            color: #087ea3;
            font-size: 13px;
            font-weight: 850;
            min-height: 38px;
            padding: 0 14px;
            transition: .18s ease;
        }

        .test-filter-btn:hover,
        .test-filter-btn.is-active {
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            border-color: #087ea3;
            color: #fff;
            box-shadow: 0 10px 22px rgba(10, 166, 215, .18);
        }

        .test-section {
            display: grid;
            gap: 14px;
        }

        .test-section-head {
            align-items: end;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: space-between;
        }

        .test-section-title {
            color: #142033;
            font-size: 1.15rem;
            font-weight: 900;
            margin: 0;
        }

        .test-section-note {
            color: #64748b;
            font-size: 14px;
            margin: 2px 0 0;
        }

        .test-count-pill {
            background: rgba(10, 166, 215, .1);
            border: 1px solid rgba(10, 166, 215, .22);
            border-radius: 999px;
            color: #087ea3;
            font-size: 13px;
            font-weight: 850;
            padding: 7px 12px;
        }

        .test-library-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .test-library-card {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            display: grid;
            gap: 16px;
            grid-template-rows: 1fr auto;
            min-height: 258px;
            padding: 18px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .test-library-card::before {
            background: #0aa6d7;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .test-library-card:hover {
            border-color: rgba(10, 166, 215, .34);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .test-card-main {
            display: grid;
            gap: 14px;
            grid-template-columns: 46px minmax(0, 1fr);
        }

        .test-card-icon {
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

        .test-card-copy {
            min-width: 0;
        }

        .test-card-topline,
        .test-meta-row,
        .test-product-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .test-card-topline {
            margin-bottom: 10px;
        }

        .test-type-pill,
        .test-mode-pill,
        .product-pill {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: 12px;
            font-weight: 850;
            line-height: 1;
            min-height: 26px;
            padding: 0 9px;
        }

        .test-type-pill-free {
            background: rgba(34, 197, 94, .12);
            color: #15803d;
        }

        .test-type-pill-paid {
            background: rgba(245, 158, 11, .14);
            color: #b45309;
        }

        .test-mode-pill {
            background: rgba(10, 166, 215, .1);
            color: #087ea3;
        }

        .test-card-title {
            color: #142033;
            font-size: 1.04rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 12px;
            overflow-wrap: anywhere;
        }

        .test-meta-row {
            color: #64748b;
            font-size: 13px;
            font-weight: 750;
            margin-bottom: 12px;
        }

        .test-meta-row span {
            align-items: center;
            display: inline-flex;
            gap: 6px;
        }

        .test-product-row {
            margin-top: 2px;
        }

        .product-pill {
            background: #f8fbff;
            border: 1px solid rgba(8, 126, 163, .14);
            color: #087ea3;
        }

        .test-card-action {
            display: flex;
        }

        .test-start-btn,
        .test-lock-btn {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            gap: 8px;
            justify-content: center;
            min-height: 46px;
            width: 100%;
        }

        .test-start-btn {
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            color: #fff !important;
            font-weight: 900;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .18);
        }

        .test-start-btn:hover,
        .test-start-btn:focus {
            background: linear-gradient(135deg, #0995c2 0%, #076c8d 100%);
            color: #fff !important;
        }

        .test-lock-btn {
            background: rgba(245, 158, 11, .14);
            border: 1px solid rgba(245, 158, 11, .32);
            color: #b45309 !important;
            font-weight: 900;
        }

        .empty-tests-card {
            background:
                linear-gradient(135deg, rgba(10, 166, 215, .1), rgba(255, 255, 255, .94)),
                #fff;
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
            padding: 34px 24px;
            text-align: center;
        }

        .empty-tests-card h3 {
            color: #142033;
            font-size: 1.2rem;
            font-weight: 900;
            margin: 0 0 8px;
        }

        .empty-tests-card p {
            color: #64748b;
            margin: 0 auto 18px;
            max-width: 520px;
        }

        .test-library-card.is-hidden,
        .test-section.is-empty-filter {
            display: none;
        }

        .theme-dark .test-library-title,
        .theme-dark .test-section-title,
        .theme-dark .test-card-title,
        .theme-dark .test-stat-value,
        .theme-dark .test-library-cta strong,
        .theme-dark .empty-tests-card h3 {
            color: #f8fafc;
        }

        .theme-dark .test-library-copy,
        .theme-dark .test-section-note,
        .theme-dark .test-meta-row,
        .theme-dark .test-library-cta span,
        .theme-dark .empty-tests-card p {
            color: #cbd5e1;
        }

        .theme-dark .test-library-card,
        .theme-dark .test-stat-card,
        .theme-dark .test-filter-panel,
        .theme-dark .test-library-cta,
        .theme-dark .empty-tests-card {
            background: #111827;
            border-color: #374151;
        }

        @media (max-width: 991.98px) {
            .test-library-toolbar,
            .test-stats-grid {
                grid-template-columns: 1fr;
            }

            .test-library-cta {
                min-width: 0;
            }
        }

        @media (max-width: 575.98px) {
            .test-library-grid {
                grid-template-columns: 1fr;
            }

            .test-card-main {
                grid-template-columns: 1fr;
            }

            .test-card-icon {
                height: 42px;
                width: 42px;
            }
        }
    </style>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="test-library-toolbar">
        <div>
            <p class="test-library-copy">Browse every exam library, start tests covered by your active access, and unlock the products you still need from the same page.</p>
        </div>
        <a class="test-library-cta" href="<?= base_url('client/subscription') ?>">
            <i class="fas fa-key"></i>
            <span>
                <strong><?= !empty($hasSubscription) ? 'Manage Access' : 'Unlock Premium Tests' ?></strong>
                <span><?= !empty($hasSubscription) ? 'View your current product plans' : 'Choose NCLEX, ATI TEAS 7, or HESI' ?></span>
            </span>
        </a>
    </div>

    <div class="test-stats-grid">
        <div class="test-stat-card">
            <div class="test-stat-value"><?= esc((string) $allCount) ?></div>
            <div class="test-stat-label">Visible Tests</div>
        </div>
        <div class="test-stat-card">
            <div class="test-stat-value"><?= esc((string) $freeCount) ?></div>
            <div class="test-stat-label">Free Tests</div>
        </div>
        <div class="test-stat-card">
            <div class="test-stat-value"><?= esc((string) $paidCount) ?></div>
            <div class="test-stat-label">Premium Available</div>
        </div>
    </div>

    <div class="test-filter-panel">
        <div class="test-filter-row" data-test-filters>
            <span class="test-filter-label">Filter</span>
            <button type="button" class="test-filter-btn is-active" data-filter="all">All</button>
            <button type="button" class="test-filter-btn" data-filter="free">Free</button>
            <button type="button" class="test-filter-btn" data-filter="paid">Premium</button>
            <?php foreach ($products as $product): ?>
                <?php $key = $productKey((string) ($product['name'] ?? '')); ?>
                <?php if ($key !== ''): ?>
                    <button type="button" class="test-filter-btn" data-filter-product="<?= esc($key) ?>"><?= esc($product['name']) ?></button>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($freeTests)): ?>
        <section class="test-section" data-test-section>
            <div class="test-section-head">
                <div>
                    <h2 class="test-section-title">Free Tests</h2>
                    <p class="test-section-note">Quick-start practice available without a paid plan.</p>
                </div>
                <span class="test-count-pill"><?= esc((string) $freeCount) ?> tests</span>
            </div>
            <div class="test-library-grid">
                <?php foreach ($freeTests as $test): ?>
                    <?php $testCard($test, true, $activeProductSlugs); ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <section class="test-section" data-test-section>
        <div class="test-section-head">
            <div>
                <h2 class="test-section-title">Premium Tests</h2>
                <p class="test-section-note">Unlocked tests can be started immediately. Locked tests show a product checkout shortcut.</p>
            </div>
            <span class="test-count-pill"><?= esc((string) $paidCount) ?> tests</span>
        </div>

        <?php if (!empty($paidTests)): ?>
            <div class="test-library-grid">
                <?php foreach ($paidTests as $test): ?>
                    <?php $testCard($test, false, $activeProductSlugs); ?>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-tests-card">
                <?php if (empty($hasSubscription)): ?>
                    <h3>Premium tests unlock by product.</h3>
                    <p>NCLEX, ATI TEAS 7, and HESI each have their own access. Choose a product plan to start matching paid tests.</p>
                    <a href="<?= base_url('client/subscription') ?>" class="btn btn-primary">View Plans</a>
                <?php else: ?>
                    <h3>No premium tests are available for your active products yet.</h3>
                    <p>Free tests are still available above while premium product tests are being added.</p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </section>

    <div class="empty-tests-card d-none" data-empty-filter>
        <h3>No tests match this filter.</h3>
        <p>Try another product or access type.</p>
    </div>

    <script>
        (function () {
            const filterButtons = document.querySelectorAll('.test-filter-btn');
            const cards = document.querySelectorAll('[data-test-card]');
            const sections = document.querySelectorAll('[data-test-section]');
            const emptyFilter = document.querySelector('[data-empty-filter]');

            function applyFilter(button) {
                const accessFilter = button.dataset.filter || '';
                const productFilter = button.dataset.filterProduct || '';
                let visibleCards = 0;

                filterButtons.forEach(function (item) {
                    item.classList.toggle('is-active', item === button);
                });

                cards.forEach(function (card) {
                    const matchesAccess = !accessFilter || accessFilter === 'all' || card.dataset.access === accessFilter;
                    const matchesProduct = !productFilter || (card.dataset.products || '').split(' ').includes(productFilter);
                    const visible = matchesAccess && matchesProduct;
                    card.classList.toggle('is-hidden', !visible);
                    if (visible) {
                        visibleCards += 1;
                    }
                });

                sections.forEach(function (section) {
                    const hasVisible = Array.from(section.querySelectorAll('[data-test-card]')).some(function (card) {
                        return !card.classList.contains('is-hidden');
                    });
                    section.classList.toggle('is-empty-filter', !hasVisible && cards.length > 0);
                });

                if (emptyFilter) {
                    emptyFilter.classList.toggle('d-none', visibleCards > 0);
                }
            }

            filterButtons.forEach(function (button) {
                button.addEventListener('click', function () {
                    applyFilter(button);
                });
            });
        })();
    </script>
</div>
