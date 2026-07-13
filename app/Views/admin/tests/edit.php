<div class="admin-content" style="max-width:920px;">
    <style>
        .product-picker-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
        }
        .product-picker-card {
            position: relative;
            display: block;
            height: 100%;
            padding: 1.1rem 1.15rem;
            border: 1px solid #d7dfeb;
            border-radius: 14px;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            cursor: pointer;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
        }
        .product-picker-card:hover {
            border-color: #0aa6d7;
            box-shadow: 0 12px 24px rgba(10, 166, 215, .10);
            transform: translateY(-2px);
        }
        .product-picker-input {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 1.15rem;
            height: 1.15rem;
        }
        .product-picker-card:has(.product-picker-input:checked) {
            border-color: #0aa6d7;
            box-shadow: 0 14px 28px rgba(10, 166, 215, .14);
            background: linear-gradient(180deg, #ffffff 0%, #effaff 100%);
        }
        .product-picker-name {
            margin: 0 2rem .35rem 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #152033;
        }
        .product-picker-note {
            margin: 0;
            color: #667085;
            font-size: .95rem;
            line-height: 1.45;
        }
    </style>
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Test & Products</h5>
        </div>
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/tests/update/' . $test['id']) ?>">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="<?= esc($test['title']) ?>" required />
                </div>
                <div class="mb-3">
                    <label class="form-label">Mode</label>
                    <select name="mode" class="form-control" required>
                        <option value="practice" <?= $test['mode']==='practice'?'selected':'' ?>>Practice</option>
                        <option value="evaluation" <?= $test['mode']==='evaluation'?'selected':'' ?>>Evaluation</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Time Limit (minutes)</label>
                    <input type="number" name="time_limit_minutes" class="form-control" value="<?= (int)($test['time_limit_minutes'] ?? 0) ?>" />
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_adaptive" value="1" <?= !empty($test['is_adaptive']) ? 'checked' : '' ?> />
                    <label class="form-check-label">Adaptive</label>
                </div>
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="draft" <?= $test['status']==='draft'?'selected':'' ?>>Draft</option>
                        <option value="pending" <?= $test['status']==='pending'?'selected':'' ?>>Pending</option>
                        <option value="active" <?= $test['status']==='active'?'selected':'' ?>>Active</option>
                        <option value="inactive" <?= $test['status']==='inactive'?'selected':'' ?>>Inactive</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="form-label">Products</label>
                    <div class="product-picker-grid">
                        <?php $selectedIds = array_map('intval', old('product_ids', $selectedProductIds ?? [])); ?>
                        <?php foreach (($products ?? []) as $product): ?>
                            <?php
                                $productId = (int) $product['id'];
                                $productSlug = (string) ($product['slug'] ?? '');
                                $productNote = match ($productSlug) {
                                    'nclex' => 'Licensure practice tests and review content for NCLEX learners.',
                                    'ati-teas-7' => 'Entrance exam practice sets for ATI TEAS 7 preparation.',
                                    'hesi' => 'Entrance exam practice content for HESI learners.',
                                    default => 'Assign this test to the selected product.',
                                };
                            ?>
                            <label class="product-picker-card">
                                <input class="form-check-input product-picker-input" type="checkbox" name="product_ids[]" value="<?= $productId ?>" <?= in_array($productId, $selectedIds, true) ? 'checked' : '' ?>>
                                <h6 class="product-picker-name"><?= esc($product['name']) ?></h6>
                                <p class="product-picker-note"><?= esc($productNote) ?></p>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-text text-muted">A test can appear under one or more exam products.</div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button> &nbsp; &nbsp;
                    <a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
