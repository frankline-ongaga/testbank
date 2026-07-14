<div class="study-admin-subcategories">
    <style>
        .study-admin-subcategories {
            display: grid;
            gap: 18px;
        }

        .study-admin-toolbar,
        .study-admin-subcategory-card,
        .study-admin-empty {
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, .07);
        }

        .study-admin-toolbar {
            align-items: center;
            display: flex;
            gap: 16px;
            justify-content: space-between;
            padding: 18px;
        }

        .study-admin-breadcrumb {
            color: #64748b;
            display: flex;
            flex-wrap: wrap;
            font-size: 13px;
            font-weight: 800;
            gap: 8px;
        }

        .study-admin-breadcrumb a {
            color: #087ea3;
            text-decoration: none;
        }

        .study-admin-toolbar-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
        }

        .study-admin-btn {
            align-items: center;
            border-radius: 999px;
            display: inline-flex;
            font-size: 13px;
            font-weight: 900;
            gap: 8px;
            justify-content: center;
            min-height: 40px;
            padding: 0 14px;
            text-decoration: none !important;
            white-space: nowrap;
        }

        .study-admin-btn-primary {
            background: #f59e0b;
            border: 1px solid #f59e0b;
            color: #fff !important;
            box-shadow: 0 12px 22px rgba(245, 158, 11, .18);
        }

        .study-admin-btn-secondary {
            background: #fff;
            border: 1px solid rgba(10, 166, 215, .22);
            color: #087ea3 !important;
        }

        .study-admin-grid {
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .study-admin-subcategory-card {
            display: grid;
            gap: 18px;
            padding: 18px;
            position: relative;
        }

        .study-admin-subcategory-card::before {
            background: #0aa6d7;
            border-radius: 999px;
            content: "";
            height: calc(100% - 36px);
            left: 0;
            position: absolute;
            top: 18px;
            width: 4px;
        }

        .study-admin-card-head {
            display: grid;
            gap: 8px;
            padding-left: 8px;
        }

        .study-admin-card-title {
            color: #142033;
            font-size: 1.04rem;
            font-weight: 950;
            line-height: 1.25;
            margin: 0;
            overflow-wrap: anywhere;
        }

        .study-admin-card-copy {
            color: #64748b;
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
        }

        .study-admin-actions {
            display: grid;
            gap: 10px;
        }

        .study-admin-action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .study-admin-action {
            align-items: center;
            background: #f8fafc;
            border: 1px solid rgba(10, 166, 215, .14);
            border-radius: 999px;
            color: #263241 !important;
            display: inline-flex;
            font-size: 12px;
            font-weight: 900;
            gap: 7px;
            min-height: 36px;
            padding: 0 12px;
            text-decoration: none !important;
            transition: border-color .18s ease, color .18s ease, transform .18s ease;
        }

        .study-admin-action:hover {
            border-color: rgba(245, 158, 11, .45);
            color: #b45309 !important;
            transform: translateY(-1px);
        }

        .study-admin-action-muted {
            color: #087ea3 !important;
        }

        .study-admin-action-danger {
            background: #fff7f7;
            border-color: rgba(220, 38, 38, .16);
            color: #b91c1c !important;
        }

        .study-admin-empty {
            padding: 42px 24px;
            text-align: center;
        }

        .study-admin-empty i {
            color: #94a3b8;
            font-size: 36px;
            margin-bottom: 12px;
        }

        .study-admin-empty h2 {
            color: #142033;
            font-size: 1.14rem;
            font-weight: 950;
            margin: 0 0 8px;
        }

        .study-admin-empty p {
            color: #64748b;
            margin: 0 0 18px;
        }

        @media (max-width: 767.98px) {
            .study-admin-toolbar {
                align-items: stretch;
                display: grid;
            }

            .study-admin-toolbar-actions,
            .study-admin-btn,
            .study-admin-action {
                width: 100%;
            }

            .study-admin-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="study-admin-toolbar">
        <div class="study-admin-breadcrumb">
            <a href="<?= base_url('admin/study') ?>">Study Categories</a>
            <span>/</span>
            <span><?= esc($category['name']) ?></span>
        </div>
        <div class="study-admin-toolbar-actions">
            <a href="<?= base_url('admin/study') ?>" class="study-admin-btn study-admin-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>
            <a href="<?= base_url('admin/study/' . (int) $category['id'] . '/subcategory/create') ?>" class="study-admin-btn study-admin-btn-primary">
                <i class="fas fa-plus"></i>
                Add Subcategory
            </a>
        </div>
    </section>

    <?php if (!empty($subcategories)): ?>
        <div class="study-admin-grid">
            <?php foreach ($subcategories as $sub): ?>
                <article class="study-admin-subcategory-card">
                    <header class="study-admin-card-head">
                        <h2 class="study-admin-card-title"><?= esc($sub['name']) ?></h2>
                        <?php if (!empty($sub['description'])): ?>
                            <p class="study-admin-card-copy"><?= esc($sub['description']) ?></p>
                        <?php else: ?>
                            <p class="study-admin-card-copy">Manage the learning content attached to this subcategory.</p>
                        <?php endif; ?>
                    </header>

                    <div class="study-admin-actions">
                        <div class="study-admin-action-group">
                            <a href="<?= base_url('admin/study/subcategory/' . (int) $sub['id'] . '/questions') ?>" class="study-admin-action">
                                <i class="fas fa-list-check"></i>
                                Questions
                            </a>
                            <a href="<?= base_url('admin/mock-questions/subcategory/' . (int) $sub['id'] . '/questions') ?>" class="study-admin-action">
                                <i class="fas fa-comments"></i>
                                Mock Questions
                            </a>
                            <a href="<?= base_url('admin/study/subcategory/' . (int) $sub['id'] . '/qcategories') ?>" class="study-admin-action">
                                <i class="fas fa-tags"></i>
                                Topics
                            </a>
                            <a href="<?= base_url('admin/notes?subcategory_id=' . (int) $sub['id']) ?>" class="study-admin-action">
                                <i class="fas fa-note-sticky"></i>
                                Notes
                            </a>
                            <a href="<?= base_url('admin/study-bank-pdfs/subcategory/' . (int) $sub['id'] . '/pdfs') ?>" class="study-admin-action">
                                <i class="fas fa-file-lines"></i>
                                Docs
                            </a>
                        </div>

                        <div class="study-admin-action-group">
                            <a href="<?= base_url('admin/study/subcategory/' . (int) $sub['id'] . '/edit') ?>" class="study-admin-action study-admin-action-muted">
                                <i class="fas fa-pen"></i>
                                Edit
                            </a>
                            <a href="<?= base_url('admin/study/subcategory/' . (int) $sub['id'] . '/delete') ?>" class="study-admin-action study-admin-action-danger" onclick="return confirm('Delete this subcategory and its questions?');">
                                <i class="fas fa-trash"></i>
                                Delete
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="study-admin-empty">
            <i class="fas fa-folder-open"></i>
            <h2>No subcategories yet</h2>
            <p>Create the first subcategory for <?= esc($category['name']) ?>.</p>
            <a href="<?= base_url('admin/study/' . (int) $category['id'] . '/subcategory/create') ?>" class="study-admin-btn study-admin-btn-primary">
                <i class="fas fa-plus"></i>
                Add Subcategory
            </a>
        </div>
    <?php endif; ?>
</div>
