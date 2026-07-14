<div class="cheat-docs-page">
    <style>
        .cheat-docs-page {
            display: grid;
            gap: 18px;
        }

        .cheat-docs-toolbar,
        .cheat-doc-card,
        .cheat-doc-empty {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, .07);
        }

        .cheat-docs-toolbar {
            align-items: center;
            display: flex;
            gap: 14px;
            justify-content: space-between;
            padding: 18px;
        }

        .cheat-docs-crumbs {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 800;
            gap: 8px;
        }

        .cheat-docs-crumbs a {
            color: #087ea3;
            text-decoration: none;
        }

        .cheat-docs-count {
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

        .cheat-docs-list {
            display: grid;
            gap: 14px;
        }

        .cheat-doc-card {
            align-items: center;
            display: grid;
            gap: 16px;
            grid-template-columns: auto minmax(0, 1fr) auto;
            padding: 18px;
            transition: border-color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .cheat-doc-card:hover {
            border-color: rgba(245, 158, 11, .34);
            box-shadow: 0 22px 42px rgba(15, 23, 42, .09);
            transform: translateY(-1px);
        }

        .cheat-doc-preview {
            height: 64px;
            width: 64px;
        }

        .cheat-doc-preview img,
        .cheat-doc-preview iframe {
            background: #f8fafc;
            border: 1px solid rgba(10, 166, 215, .16);
            border-radius: 14px;
            height: 64px;
            object-fit: cover;
            overflow: hidden;
            width: 64px;
        }

        .cheat-doc-title {
            color: #142033;
            font-size: 1.02rem;
            font-weight: 950;
            line-height: 1.32;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .cheat-doc-meta {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 12px;
            font-weight: 800;
            gap: 10px;
        }

        .cheat-doc-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
        }

        .cheat-doc-view,
        .cheat-doc-download,
        .cheat-doc-back {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-weight: 950;
            gap: 8px;
            justify-content: center;
            min-height: 42px;
            padding: 0 14px;
            text-decoration: none;
            white-space: nowrap;
        }

        .cheat-doc-view,
        .cheat-doc-back {
            border: 1px solid rgba(10, 166, 215, .22);
            color: #087ea3 !important;
        }

        .cheat-doc-download {
            background: #f59e0b;
            color: #fff !important;
        }

        .cheat-doc-empty {
            padding: 40px 24px;
            text-align: center;
        }

        .cheat-doc-empty i {
            color: #94a3b8;
            font-size: 34px;
            margin-bottom: 12px;
        }

        .cheat-doc-empty h2 {
            color: #142033;
            font-size: 1.12rem;
            font-weight: 950;
            margin: 0 0 6px;
        }

        .cheat-doc-empty p {
            color: #64748b;
            margin: 0;
        }

        @media (max-width: 767.98px) {
            .cheat-docs-toolbar,
            .cheat-doc-card {
                align-items: stretch;
                grid-template-columns: 1fr;
            }

            .cheat-docs-toolbar {
                display: grid;
            }

            .cheat-doc-preview {
                height: 72px;
                width: 72px;
            }

            .cheat-doc-preview img,
            .cheat-doc-preview iframe {
                height: 72px;
                width: 72px;
            }

            .cheat-doc-actions,
            .cheat-doc-view,
            .cheat-doc-download,
            .cheat-doc-back {
                width: 100%;
            }
        }
    </style>

    <section class="cheat-docs-toolbar">
        <div class="cheat-docs-crumbs">
            <a href="<?= base_url('client/cheat-sheets') ?>">Cheat Sheets</a>
            <span>/</span>
            <span><?= esc($category['name']) ?></span>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="cheat-docs-count"><?= esc((string) count($cheatSheets)) ?> files</span>
            <a href="<?= base_url('client/cheat-sheets') ?>" class="cheat-doc-back">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
        </div>
    </section>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (!empty($cheatSheets)): ?>
        <div class="cheat-docs-list">
            <?php foreach ($cheatSheets as $doc): ?>
                <?php
                    $ext = strtolower((string) pathinfo((string) ($doc['file_name'] ?? ''), PATHINFO_EXTENSION));
                    $isPdf = $ext === 'pdf';
                    $fileUrl = base_url('client/cheat-sheets/doc/' . (int) $doc['id'] . '/file');
                    $viewUrl = base_url('client/cheat-sheets/doc/' . (int) $doc['id']);
                ?>
                <article class="cheat-doc-card">
                    <a href="<?= $viewUrl ?>" class="cheat-doc-preview" aria-label="View cheat sheet">
                        <?php if ($isPdf): ?>
                            <iframe src="<?= $fileUrl ?>" style="border:0;pointer-events:none;"></iframe>
                        <?php else: ?>
                            <img src="<?= $fileUrl ?>" alt="Preview" loading="lazy">
                        <?php endif; ?>
                    </a>
                    <div>
                        <h2 class="cheat-doc-title"><?= esc($doc['title']) ?></h2>
                        <div class="cheat-doc-meta">
                            <span><i class="fas fa-file"></i> <?= esc($doc['file_name']) ?></span>
                        </div>
                    </div>
                    <div class="cheat-doc-actions">
                        <a href="<?= $viewUrl ?>" class="cheat-doc-view">
                            View
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="<?= base_url('client/cheat-sheets/doc/' . (int) $doc['id'] . '/download') ?>" class="cheat-doc-download">
                            Download
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="cheat-doc-empty">
            <i class="fas fa-file-image"></i>
            <h2>No Cheat Sheets Available</h2>
            <p>Check back soon.</p>
        </div>
    <?php endif; ?>
</div>
