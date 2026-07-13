<?php
    $testsList = $tests ?? [];
    $totalTests = count($testsList);
    $activeTests = 0;
    $freeTests = 0;
    $paidTests = 0;
    $unassignedTests = 0;

    foreach ($testsList as $row) {
        if (($row['status'] ?? '') === 'active') {
            $activeTests++;
        }
        if (!empty($row['is_free'])) {
            $freeTests++;
        } else {
            $paidTests++;
        }
        if (trim((string)($row['product_names'] ?? '')) === '') {
            $unassignedTests++;
        }
    }
?>

<div class="admin-content admin-tests-page">
    <style>
        .admin-tests-page {
            display: grid;
            gap: 22px;
        }
        .tests-hero {
            align-items: center;
            background:
                linear-gradient(135deg, rgba(10, 166, 215, .13), rgba(255, 196, 79, .18)),
                #fff;
            border: 1px solid rgba(8, 126, 163, .14);
            border-radius: 22px;
            box-shadow: 0 24px 48px rgba(15, 23, 42, .08);
            display: flex;
            gap: 18px;
            justify-content: space-between;
            padding: 24px;
        }
        .tests-eyebrow {
            color: #087ea3;
            display: block;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .08em;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        .tests-hero h2 {
            color: #142033;
            font-size: clamp(1.45rem, 2vw, 2rem);
            font-weight: 900;
            margin: 0 0 6px;
        }
        .tests-hero p {
            color: #59677d;
            margin: 0;
            max-width: 680px;
        }
        .tests-hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
        }
        .tests-metrics {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(5, minmax(0, 1fr));
        }
        .tests-metric {
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 18px;
            box-shadow: 0 18px 36px rgba(15, 23, 42, .07);
            padding: 18px;
        }
        .tests-metric span {
            color: #667085;
            display: block;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .tests-metric strong {
            color: #142033;
            display: block;
            font-size: 1.75rem;
            font-weight: 950;
            line-height: 1;
            margin-top: 8px;
        }
        .tests-table-card {
            border-radius: 22px;
        }
        .tests-table-head {
            align-items: center;
            border-bottom: 1px solid rgba(8, 126, 163, .1);
            display: flex;
            gap: 14px;
            justify-content: space-between;
            padding: 20px 24px;
        }
        .tests-table-head h3 {
            color: #142033;
            font-size: 1.05rem;
            font-weight: 900;
            margin: 0;
        }
        .tests-table-head span {
            color: #667085;
            font-size: .92rem;
            font-weight: 700;
        }
        .tests-table {
            min-width: 980px;
        }
        .tests-table td:first-child {
            min-width: 300px;
        }
        .test-title {
            color: #142033;
            display: block;
            font-weight: 900;
            line-height: 1.3;
            margin-bottom: 8px;
        }
        .test-meta-pills,
        .product-pills,
        .test-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }
        .product-pill {
            background: rgba(10, 166, 215, .12);
            border: 1px solid rgba(10, 166, 215, .26);
            color: #087ea3;
        }
        .status-pill {
            min-width: 76px;
            text-align: center;
        }
        .question-count {
            align-items: center;
            background: #f4f8fb;
            border: 1px solid rgba(8, 126, 163, .12);
            border-radius: 999px;
            color: #142033;
            display: inline-flex;
            font-weight: 900;
            justify-content: center;
            min-width: 48px;
            padding: 7px 12px;
        }
        .test-actions .btn {
            white-space: nowrap;
        }
        .tests-mobile-list {
            display: none;
        }
        .test-mobile-card {
            background: #fff;
            border: 1px solid rgba(8, 126, 163, .13);
            border-radius: 18px;
            box-shadow: 0 16px 32px rgba(15, 23, 42, .07);
            padding: 18px;
        }
        .test-mobile-top {
            display: grid;
            gap: 10px;
        }
        .test-mobile-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            margin: 14px 0;
        }
        .test-mobile-grid div {
            background: #f6fafc;
            border: 1px solid rgba(8, 126, 163, .1);
            border-radius: 14px;
            padding: 11px 12px;
        }
        .test-mobile-grid span {
            color: #667085;
            display: block;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .test-mobile-grid strong {
            color: #142033;
            display: block;
            font-weight: 900;
            margin-top: 4px;
        }
        .empty-tests {
            padding: 46px 24px;
            text-align: center;
        }
        .empty-tests i {
            color: #0aa6d7;
            font-size: 2rem;
            margin-bottom: 12px;
        }
        .empty-tests h3 {
            color: #142033;
            font-weight: 900;
            margin-bottom: 8px;
        }
        .empty-tests p {
            color: #667085;
            margin-bottom: 18px;
        }
        @media (max-width: 1180px) {
            .tests-metrics {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
        @media (max-width: 767px) {
            .tests-hero {
                align-items: stretch;
                display: grid;
                padding: 20px;
            }
            .tests-hero-actions {
                justify-content: stretch;
            }
            .tests-hero-actions .btn {
                width: 100%;
            }
            .tests-metrics {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .tests-table-head {
                display: grid;
                padding: 18px;
            }
            .tests-table-desktop {
                display: none;
            }
            .tests-mobile-list {
                display: grid;
                gap: 14px;
                padding: 18px;
            }
            .test-actions .btn {
                flex: 1 1 120px;
            }
        }
        @media (max-width: 480px) {
            .tests-metrics,
            .test-mobile-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="tests-hero">
        <div>
            <span class="tests-eyebrow">Test library</span>
            <h2>Manage practice tests</h2>
            <p>Assign products, manage questions, and publish the tests learners see in their NCLEX, ATI TEAS 7, or HESI access.</p>
        </div>
        <div class="tests-hero-actions">
            <a href="<?= base_url('admin/tests/create-free') ?>" class="btn btn-outline-primary">
                <i class="fas fa-gift me-2"></i>Create Free Test
            </a>
            <a href="<?= base_url('admin/tests/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Create Test
            </a>
        </div>
    </section>

    <section class="tests-metrics" aria-label="Test summary">
        <div class="tests-metric"><span>Total</span><strong><?= esc(number_format($totalTests)) ?></strong></div>
        <div class="tests-metric"><span>Active</span><strong><?= esc(number_format($activeTests)) ?></strong></div>
        <div class="tests-metric"><span>Paid</span><strong><?= esc(number_format($paidTests)) ?></strong></div>
        <div class="tests-metric"><span>Free</span><strong><?= esc(number_format($freeTests)) ?></strong></div>
        <div class="tests-metric"><span>Unassigned</span><strong><?= esc(number_format($unassignedTests)) ?></strong></div>
    </section>

    <section class="card tests-table-card">
        <div class="tests-table-head">
            <div>
                <h3>Practice test inventory</h3>
                <span><?= esc(number_format($totalTests)) ?> tests currently in the library</span>
            </div>
        </div>

        <?php if (!empty($testsList)): ?>
            <div class="table-responsive tests-table-desktop">
                <table class="table table-hover tests-table">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Products</th>
                            <th>Questions</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($testsList as $test): ?>
                            <?php
                                $productNames = array_filter(array_map('trim', explode(',', (string)($test['product_names'] ?? ''))));
                                $isFree = !empty($test['is_free']);
                                $mode = (string)($test['mode'] ?? 'practice');
                                $status = (string)($test['status'] ?? 'draft');
                            ?>
                            <tr>
                                <td>
                                    <span class="test-title"><?= esc($test['title']) ?></span>
                                    <div class="test-meta-pills">
                                        <span class="badge bg-<?= $mode === 'practice' ? 'info' : 'warning' ?>"><?= esc(ucfirst($mode)) ?></span>
                                        <span class="badge bg-<?= $isFree ? 'success' : 'secondary' ?>"><?= $isFree ? 'Free' : 'Paid' ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="product-pills">
                                        <?php if (!empty($productNames)): ?>
                                            <?php foreach ($productNames as $productName): ?>
                                                <span class="badge product-pill"><?= esc($productName) ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">Unassigned</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><span class="question-count"><?= esc((int)($test['question_count'] ?? 0)) ?></span></td>
                                <td>
                                    <span class="badge status-pill bg-<?= $status === 'active' ? 'success' : 'secondary' ?>">
                                        <?= esc(ucfirst($status)) ?>
                                    </span>
                                </td>
                                <td><?= !empty($test['created_at']) ? esc(date('M j, Y', strtotime($test['created_at']))) : '-' ?></td>
                                <td>
                                    <div class="test-actions">
                                        <a href="<?= base_url('admin/tests/edit/' . $test['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit me-1"></i>Edit</a>
                                        <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-list-ul me-1"></i>Questions</a>
                                        <?php if ($status !== 'active'): ?>
                                            <a href="<?= base_url('admin/tests/activate/' . $test['id']) ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-toggle-on me-1"></i>Activate</a>
                                        <?php endif; ?>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('Delete this test?')) window.location.href='<?= base_url('admin/tests/delete/' . $test['id']) ?>'">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tests-mobile-list">
                <?php foreach ($testsList as $test): ?>
                    <?php
                        $productNames = array_filter(array_map('trim', explode(',', (string)($test['product_names'] ?? ''))));
                        $isFree = !empty($test['is_free']);
                        $mode = (string)($test['mode'] ?? 'practice');
                        $status = (string)($test['status'] ?? 'draft');
                    ?>
                    <article class="test-mobile-card">
                        <div class="test-mobile-top">
                            <span class="test-title"><?= esc($test['title']) ?></span>
                            <div class="test-meta-pills">
                                <span class="badge bg-<?= $mode === 'practice' ? 'info' : 'warning' ?>"><?= esc(ucfirst($mode)) ?></span>
                                <span class="badge bg-<?= $isFree ? 'success' : 'secondary' ?>"><?= $isFree ? 'Free' : 'Paid' ?></span>
                                <span class="badge bg-<?= $status === 'active' ? 'success' : 'secondary' ?>"><?= esc(ucfirst($status)) ?></span>
                            </div>
                            <div class="product-pills">
                                <?php if (!empty($productNames)): ?>
                                    <?php foreach ($productNames as $productName): ?>
                                        <span class="badge product-pill"><?= esc($productName) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge bg-light text-dark">Unassigned</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="test-mobile-grid">
                            <div><span>Questions</span><strong><?= esc((int)($test['question_count'] ?? 0)) ?></strong></div>
                            <div><span>Created</span><strong><?= !empty($test['created_at']) ? esc(date('M j, Y', strtotime($test['created_at']))) : '-' ?></strong></div>
                        </div>
                        <div class="test-actions">
                            <a href="<?= base_url('admin/tests/edit/' . $test['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit me-1"></i>Edit</a>
                            <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions') ?>" class="btn btn-sm btn-outline-secondary"><i class="fas fa-list-ul me-1"></i>Questions</a>
                            <?php if ($status !== 'active'): ?>
                                <a href="<?= base_url('admin/tests/activate/' . $test['id']) ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-toggle-on me-1"></i>Activate</a>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('Delete this test?')) window.location.href='<?= base_url('admin/tests/delete/' . $test['id']) ?>'">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="empty-tests">
                <i class="fas fa-file-circle-plus"></i>
                <h3>No tests found</h3>
                <p>Create your first practice test and assign it to NCLEX, ATI TEAS 7, or HESI.</p>
                <a href="<?= base_url('admin/tests/create') ?>" class="btn btn-primary">Create Test</a>
            </div>
        <?php endif; ?>
    </section>
</div>
