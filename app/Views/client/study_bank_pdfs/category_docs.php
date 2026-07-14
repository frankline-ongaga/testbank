<div class="study-docs-page">
    <style>
        .study-docs-page {
            display: grid;
            gap: 18px;
        }

        .study-docs-toolbar,
        .study-doc-card,
        .study-doc-empty {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, .07);
        }

        .study-docs-toolbar {
            align-items: center;
            display: flex;
            gap: 14px;
            justify-content: space-between;
            padding: 18px;
        }

        .study-docs-crumbs {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 800;
            gap: 8px;
        }

        .study-docs-crumbs a {
            color: #087ea3;
            text-decoration: none;
        }

        .study-docs-count {
            background: #fff7ed;
            border: 1px solid rgba(245, 158, 11, .24);
            border-radius: 999px;
            color: #b45309;
            display: inline-flex;
            font-size: 12px;
            font-weight: 950;
            min-height: 34px;
            padding: 0 12px;
            white-space: nowrap;
        }

        .study-docs-list {
            display: grid;
            gap: 14px;
        }

        .study-doc-card {
            align-items: center;
            display: grid;
            gap: 16px;
            grid-template-columns: auto minmax(0, 1fr) auto;
            padding: 18px;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .study-doc-card:hover {
            border-color: rgba(245, 158, 11, .34);
            box-shadow: 0 22px 42px rgba(15, 23, 42, .09);
            transform: translateY(-1px);
        }

        .study-doc-icon {
            align-items: center;
            background: rgba(10, 166, 215, .1);
            border-radius: 16px;
            color: #087ea3;
            display: inline-flex;
            font-size: 22px;
            height: 56px;
            justify-content: center;
            width: 56px;
        }

        .study-doc-title {
            color: #142033;
            font-size: 1.02rem;
            font-weight: 950;
            line-height: 1.32;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .study-doc-meta {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 12px;
            font-weight: 800;
            gap: 10px;
        }

        .study-doc-download {
            align-items: center;
            background: #f59e0b;
            border: 0;
            border-radius: 999px;
            color: #fff !important;
            display: inline-flex;
            font-weight: 950;
            gap: 8px;
            justify-content: center;
            min-height: 44px;
            padding: 0 16px;
            text-decoration: none;
            white-space: nowrap;
        }

        .study-doc-back {
            align-items: center;
            border: 1px solid rgba(10, 166, 215, .22);
            border-radius: 999px;
            color: #087ea3 !important;
            display: inline-flex;
            font-weight: 900;
            gap: 8px;
            min-height: 40px;
            padding: 0 14px;
            text-decoration: none;
        }

        .study-doc-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .study-doc-empty i {
            color: #94a3b8;
            font-size: 34px;
            margin-bottom: 12px;
        }

        .study-doc-empty h2 {
            color: #142033;
            font-size: 1.12rem;
            font-weight: 950;
            margin: 0 0 6px;
        }

        .study-doc-empty p {
            color: #64748b;
            margin: 0;
        }

        @media (max-width: 767.98px) {
            .study-docs-toolbar,
            .study-doc-card {
                align-items: stretch;
                grid-template-columns: 1fr;
            }

            .study-docs-toolbar {
                display: grid;
            }

            .study-doc-download,
            .study-doc-back {
                width: 100%;
            }
        }
    </style>

    <section class="study-docs-toolbar">
        <div class="study-docs-crumbs">
            <a href="<?= base_url('client/study-bank-pdfs') ?>">Study Bank Docs</a>
            <span>/</span>
            <span><?= esc($category['name']) ?></span>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="study-docs-count"><?= esc((string) count($pdfs)) ?> files</span>
            <a href="<?= base_url('client/study-bank-pdfs') ?>" class="study-doc-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>
    </section>

    <?php if (!empty($pdfs)): ?>
        <div class="study-docs-list">
            <?php foreach ($pdfs as $pdf): ?>
                <article class="study-doc-card">
                    <span class="study-doc-icon"><i class="fas fa-file-arrow-down"></i></span>
                    <div>
                        <h2 class="study-doc-title"><?= esc($pdf['title']) ?></h2>
                        <div class="study-doc-meta">
                            <span><i class="fas fa-tag"></i> <?= esc($subcategoryMap[(int) $pdf['subcategory_id']] ?? 'General') ?></span>
                            <span><i class="fas fa-file"></i> <?= esc($pdf['file_name']) ?></span>
                            <span><i class="fas fa-hdd"></i> <?= number_format(((int) $pdf['file_size']) / 1024, 2) ?> KB</span>
                        </div>
                    </div>
                    <a href="<?= base_url('client/study-bank-pdfs/pdf/' . (int) $pdf['id'] . '/download') ?>" class="study-doc-download">
                        Download
                        <i class="fas fa-download"></i>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="study-doc-empty">
            <i class="fas fa-file"></i>
            <h2>No Documents Available</h2>
            <p>Documents uploaded for this category will appear here.</p>
        </div>
    <?php endif; ?>
</div>
