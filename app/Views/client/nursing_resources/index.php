<div class="nursing-resource-page">
    <style>
        .nursing-resource-page {
            display: grid;
            gap: 22px;
        }

        .resource-hero,
        .resource-card,
        .resource-empty {
            background: rgba(255, 255, 255, .94);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, .07);
        }

        .resource-hero {
            display: grid;
            gap: 16px;
            grid-template-columns: minmax(0, 1fr) auto;
            padding: 24px;
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

        .resource-title {
            color: #142033;
            font-size: clamp(1.55rem, 2.4vw, 2.2rem);
            font-weight: 950;
            line-height: 1.16;
            margin: 0;
        }

        .resource-copy {
            color: #516074;
            line-height: 1.65;
            margin: 10px 0 0;
            max-width: 820px;
        }

        .resource-count {
            align-items: center;
            background: rgba(245, 158, 11, .14);
            border: 1px solid rgba(245, 158, 11, .25);
            border-radius: 16px;
            color: #b45309;
            display: inline-flex;
            font-weight: 900;
            gap: 10px;
            min-height: 54px;
            padding: 0 18px;
            white-space: nowrap;
        }

        .resource-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        }

        .resource-sections {
            display: grid;
            gap: 20px;
        }

        .resource-section,
        .resource-subsection {
            background: rgba(255, 255, 255, .82);
            border: 1px solid rgba(10, 166, 215, .13);
            border-radius: 18px;
            box-shadow: 0 18px 34px rgba(15, 23, 42, .055);
            display: grid;
            gap: 18px;
            padding: clamp(16px, 2vw, 22px);
        }

        .resource-subsection {
            background: rgba(248, 251, 253, .9);
            border-color: rgba(245, 158, 11, .18);
            box-shadow: none;
        }

        .resource-section-header {
            align-items: start;
            display: flex;
            gap: 14px;
            justify-content: space-between;
        }

        .resource-section-title {
            color: #142033;
            font-size: clamp(1.15rem, 1.8vw, 1.55rem);
            font-weight: 950;
            line-height: 1.2;
            margin: 0;
            overflow-wrap: anywhere;
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

        .resource-subsections {
            display: grid;
            gap: 16px;
        }

        .resource-card {
            display: grid;
            gap: 18px;
            grid-template-rows: 1fr auto;
            min-height: 240px;
            padding: 20px;
            position: relative;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .resource-card::before {
            background: #f59e0b;
            border-radius: 999px;
            content: "";
            height: calc(100% - 40px);
            left: 0;
            position: absolute;
            top: 20px;
            width: 4px;
        }

        .resource-card:hover {
            border-color: rgba(245, 158, 11, .38);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .1);
            transform: translateY(-2px);
        }

        .resource-subsection .resource-card {
            min-height: 210px;
        }

        .resource-card h2 {
            color: #142033;
            font-size: 1.1rem;
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

        .resource-date {
            color: #087ea3;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .05em;
            margin-bottom: 10px;
            text-transform: uppercase;
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
            min-height: 46px;
            padding: 0 16px;
            text-decoration: none;
        }

        .resource-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .resource-empty h3 {
            color: #142033;
            font-size: 1.15rem;
            font-weight: 900;
            margin: 0 0 8px;
        }

        .resource-empty p {
            color: #64748b;
            margin: 0;
        }

        @media (max-width: 767.98px) {
            .resource-hero {
                grid-template-columns: 1fr;
            }

            .resource-count {
                justify-content: center;
                white-space: normal;
            }

            .resource-section-header {
                display: grid;
            }

            .resource-section-count {
                width: fit-content;
            }
        }
    </style>

    <section class="resource-hero">
        <div>
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
                        <h2><?= esc($post['post_title']) ?></h2>
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

    $renderResourceGroup = static function (array $group, int $level = 0) use (&$renderResourceGroup, $renderResourceCards): void {
        $isSubcategory = $level > 0;
        ?>
        <section class="<?= $isSubcategory ? 'resource-subsection' : 'resource-section' ?>">
            <header class="resource-section-header">
                <div>
                    <span class="resource-section-label"><?= $isSubcategory ? 'Subcategory' : 'Category' ?></span>
                    <h2 class="resource-section-title"><?= esc($group['name'] ?? 'Resources') ?></h2>
                </div>
                <span class="resource-section-count"><?= esc((string) ($group['total'] ?? count($group['posts'] ?? []))) ?> resources</span>
            </header>

            <?php $renderResourceCards($group['posts'] ?? []); ?>

            <?php if (!empty($group['children'])): ?>
                <div class="resource-subsections">
                    <?php foreach ($group['children'] as $childGroup): ?>
                        <?php $renderResourceGroup($childGroup, $level + 1); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    };
    ?>

    <?php if (!empty($categoryGroups)): ?>
        <div class="resource-sections">
            <?php foreach ($categoryGroups as $group): ?>
                <?php $renderResourceGroup($group); ?>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($posts)): ?>
        <?php $renderResourceCards($posts); ?>
    <?php elseif (empty($loadError)): ?>
        <div class="resource-empty">
            <h3>No resources found.</h3>
            <p>Published WordPress posts from this category will appear here.</p>
        </div>
    <?php endif; ?>
</div>
