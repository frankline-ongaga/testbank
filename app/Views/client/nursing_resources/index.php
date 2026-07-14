<?php
    $posts = $posts ?? [];
    $categoryGroups = $categoryGroups ?? [];
?>

<div class="nursing-resource-page">
    <style>
        .nursing-resource-page {
            display: grid;
            gap: 22px;
        }

        .resource-header {
            display: grid;
            gap: 18px;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: end;
        }

        .resource-kicker {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .resource-copy {
            color: #516074;
            line-height: 1.65;
            margin: 0;
            max-width: 780px;
        }

        .resource-count {
            align-items: center;
            background: rgba(245, 158, 11, .14);
            border: 1px solid rgba(245, 158, 11, .28);
            border-radius: 999px;
            color: #b45309;
            display: inline-flex;
            font-size: 13px;
            font-weight: 950;
            gap: 8px;
            min-height: 42px;
            padding: 0 14px;
            white-space: nowrap;
        }

        .resource-layout {
            align-items: start;
            display: grid;
            gap: 18px;
            grid-template-columns: 300px minmax(0, 1fr);
        }

        .resource-rail,
        .resource-workspace,
        .resource-card,
        .resource-empty {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .resource-rail {
            overflow: hidden;
            position: sticky;
            top: 24px;
        }

        .resource-rail-head {
            background: linear-gradient(135deg, rgba(10, 166, 215, .1), rgba(255, 255, 255, .94));
            border-bottom: 1px solid rgba(8, 126, 163, .1);
            padding: 18px 18px 14px;
        }

        .resource-rail-head strong {
            color: #142033;
            display: block;
            font-size: 1rem;
            font-weight: 900;
        }

        .resource-rail-head span {
            color: #64748b;
            display: block;
            font-size: 13px;
            margin-top: 4px;
        }

        .resource-rail-list {
            display: grid;
            gap: 6px;
            max-height: calc(100vh - 220px);
            overflow: auto;
            padding: 10px;
        }

        .resource-rail-link {
            align-items: center;
            border: 1px solid transparent;
            border-radius: 14px;
            color: #516074 !important;
            display: grid;
            gap: 10px;
            grid-template-columns: 32px minmax(0, 1fr) auto;
            min-height: 50px;
            padding: 9px 10px;
            text-decoration: none;
            transition: background .18s ease, border-color .18s ease, color .18s ease;
        }

        .resource-rail-link.is-child {
            margin-left: 18px;
        }

        .resource-rail-link i:first-child {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border-radius: 10px;
            color: #087ea3;
            display: inline-flex;
            height: 32px;
            justify-content: center;
            width: 32px;
        }

        .resource-rail-link span {
            font-size: 14px;
            font-weight: 850;
            overflow-wrap: anywhere;
        }

        .resource-rail-link small {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 900;
        }

        .resource-rail-link:hover,
        .resource-rail-link.active {
            background: rgba(10, 166, 215, .08);
            border-color: rgba(10, 166, 215, .18);
            color: #087ea3 !important;
        }

        .resource-rail-link.active i:first-child {
            background: #0aa6d7;
            color: #fff;
        }

        .resource-workspace {
            display: grid;
            gap: 18px;
            padding: 18px;
        }

        .resource-section {
            scroll-margin-top: 24px;
        }

        .resource-section + .resource-section {
            border-top: 1px solid rgba(8, 126, 163, .1);
            padding-top: 18px;
        }

        .resource-section-head {
            align-items: start;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .resource-section-label {
            color: #087ea3;
            display: inline-flex;
            font-size: 11px;
            font-weight: 950;
            letter-spacing: .08em;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .resource-section-title {
            color: #142033;
            font-size: clamp(1.15rem, 1.8vw, 1.55rem);
            font-weight: 950;
            line-height: 1.2;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .resource-section-count {
            align-items: center;
            background: #fff7ed;
            border: 1px solid rgba(245, 158, 11, .24);
            border-radius: 999px;
            color: #b45309;
            display: inline-flex;
            flex: 0 0 auto;
            font-size: 12px;
            font-weight: 950;
            min-height: 34px;
            padding: 0 12px;
            white-space: nowrap;
        }

        .resource-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }

        .resource-card {
            display: grid;
            gap: 18px;
            grid-template-rows: 1fr auto;
            min-height: 220px;
            padding: 18px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .resource-card::before {
            background: #f59e0b;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .resource-card:hover {
            border-color: rgba(245, 158, 11, .38);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .resource-date {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .05em;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .resource-card h3 {
            color: #142033;
            font-size: 1.05rem;
            font-weight: 900;
            line-height: 1.35;
            margin: 0 0 10px;
            overflow-wrap: anywhere;
        }

        .resource-card p {
            color: #64748b;
            line-height: 1.55;
            margin: 0;
        }

        .resource-action {
            align-items: center;
            background: linear-gradient(135deg, #0aa6d7 0%, #087ea3 100%);
            border-radius: 999px;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .18);
            color: #fff !important;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 44px;
            padding: 0 16px;
            text-decoration: none;
            width: fit-content;
        }

        .resource-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .resource-empty h2 {
            color: #142033;
            font-size: 1.15rem;
            font-weight: 900;
            margin: 0 0 8px;
        }

        .resource-empty p {
            color: #64748b;
            margin: 0;
        }

        @media (max-width: 991.98px) {
            .resource-layout {
                grid-template-columns: 1fr;
            }

            .resource-rail {
                position: static;
            }

            .resource-rail-list {
                display: flex;
                max-height: none;
                overflow-x: auto;
            }

            .resource-rail-link {
                min-width: 240px;
            }

            .resource-rail-link.is-child {
                margin-left: 0;
            }
        }

        @media (max-width: 767.98px) {
            .resource-header,
            .resource-section-head {
                display: grid;
                grid-template-columns: 1fr;
            }

            .resource-count,
            .resource-section-count {
                width: fit-content;
            }
        }
    </style>

    <section class="resource-header">
        <div>
            <span class="resource-kicker">NCLEX Study Library</span>
            <p class="resource-copy"><?= esc($resource['intro']) ?></p>
        </div>
        <div class="resource-count">
            <i class="fas fa-file-lines"></i>
            <?= esc((string) count($posts)) ?> resources
        </div>
    </section>

    <?php if (!empty($loadError)): ?>
        <div class="ielts-alert ielts-alert-error"><?= esc($loadError) ?></div>
    <?php endif; ?>

    <?php
    $renderResourceCards = static function (array $items): void {
        if (empty($items)) {
            return;
        }
        ?>
        <div class="resource-grid">
            <?php foreach ($items as $post): ?>
                <article class="resource-card">
                    <div>
                        <?php if (!empty($post['post_date'])): ?>
                            <span class="resource-date"><?= esc(date('M j, Y', strtotime($post['post_date']))) ?></span>
                        <?php endif; ?>
                        <h3><?= esc($post['post_title']) ?></h3>
                        <?php if (!empty($post['excerpt'])): ?>
                            <p><?= esc($post['excerpt']) ?></p>
                        <?php endif; ?>
                    </div>
                    <a class="resource-action" href="<?= esc($post['url']) ?>">
                        Read Resource
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
        <?php
    };

    $renderResourceSection = static function (array $group, int $level = 0) use (&$renderResourceSection, $renderResourceCards): void {
        $termId = (int) ($group['term_id'] ?? 0);
        $sectionId = 'resource-section-' . ($termId ?: md5((string) ($group['name'] ?? 'resources')));
        ?>
        <section class="resource-section" id="<?= esc($sectionId) ?>">
            <header class="resource-section-head">
                <div>
                    <span class="resource-section-label"><?= $level > 0 ? 'Nested subcategory' : 'Subcategory' ?></span>
                    <h2 class="resource-section-title"><?= esc($group['name'] ?? 'Resources') ?></h2>
                </div>
                <span class="resource-section-count"><?= esc((string) ($group['total'] ?? count($group['posts'] ?? []))) ?> resources</span>
            </header>

            <?php $renderResourceCards($group['posts'] ?? []); ?>

            <?php if (!empty($group['children'])): ?>
                <?php foreach ($group['children'] as $childGroup): ?>
                    <?php $renderResourceSection($childGroup, $level + 1); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
        <?php
    };

    $firstRailItem = true;
    $renderResourceRail = static function (array $groups, int $level = 0) use (&$renderResourceRail, &$firstRailItem): void {
        foreach ($groups as $group) {
            $termId = (int) ($group['term_id'] ?? 0);
            $sectionId = 'resource-section-' . ($termId ?: md5((string) ($group['name'] ?? 'resources')));
            $isActive = $firstRailItem;
            $firstRailItem = false;
            ?>
            <a class="resource-rail-link <?= $level > 0 ? 'is-child' : '' ?> <?= $isActive ? 'active' : '' ?>" href="#<?= esc($sectionId) ?>" style="<?= $level > 1 ? 'margin-left:' . min($level, 3) * 18 . 'px;' : '' ?>">
                <i class="<?= $level > 0 ? 'fas fa-angle-right' : 'fas fa-folder' ?>"></i>
                <span><?= esc($group['name'] ?? 'Resources') ?></span>
                <small><?= esc((string) ($group['total'] ?? 0)) ?></small>
            </a>
            <?php
            if (!empty($group['children'])) {
                $renderResourceRail($group['children'], $level + 1);
            }
        }
    };
    ?>

    <?php if (!empty($categoryGroups)): ?>
        <div class="resource-layout">
            <aside class="resource-rail">
                <div class="resource-rail-head">
                    <strong>Subcategories</strong>
                    <span>Jump to a resource group</span>
                </div>
                <nav class="resource-rail-list" aria-label="<?= esc($resource['title']) ?> subcategories">
                    <?php $renderResourceRail($categoryGroups); ?>
                </nav>
            </aside>

            <main class="resource-workspace">
                <?php foreach ($categoryGroups as $group): ?>
                    <?php $renderResourceSection($group); ?>
                <?php endforeach; ?>
            </main>
        </div>
    <?php elseif (!empty($posts)): ?>
        <main class="resource-workspace">
            <?php $renderResourceCards($posts); ?>
        </main>
    <?php elseif (empty($loadError)): ?>
        <div class="resource-empty">
            <h2>No resources found.</h2>
            <p>Published WordPress posts from this category will appear here.</p>
        </div>
    <?php endif; ?>
</div>
