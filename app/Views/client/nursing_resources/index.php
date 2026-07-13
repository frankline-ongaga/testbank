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

    <?php if (!empty($posts)): ?>
        <div class="resource-grid">
            <?php foreach ($posts as $post): ?>
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
    <?php elseif (empty($loadError)): ?>
        <div class="resource-empty">
            <h3>No resources found.</h3>
            <p>Published WordPress posts from this category will appear here.</p>
        </div>
    <?php endif; ?>
</div>
