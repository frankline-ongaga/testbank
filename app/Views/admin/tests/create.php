<div class="admin-content">
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
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/tests/store') ?>" method="post">
                <?= csrf_field() ?>
                <?php if (!empty($is_free)): ?>
                    <input type="hidden" name="is_free" value="1">
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Test Title</label>
                    <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                    <div class="form-text text-muted">Enter a descriptive title for the test</div>
                </div>

                <input type="hidden" name="mode" value="practice">
                <?php if (empty($is_free)): ?>
                <div class="mb-4">
                    <label class="form-label">Time Limit (minutes)</label>
                    <input type="number" class="form-control" name="time_limit" value="<?= old('time_limit', '60') ?>" min="0">
                    <div class="form-text text-muted">Leave empty or 0 for no time limit</div>
                </div>
                <?php else: ?>
                    <input type="hidden" name="time_limit" value="0">
                <?php endif; ?>

                <input type="hidden" name="is_adaptive" value="1">
                <?php if (!empty($is_free)): ?>
                    <input type="hidden" name="is_free" value="1">
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Products</label>
                    <div class="product-picker-grid">
                        <?php $selectedIds = array_map('intval', old('product_ids', $defaultProductIds ?? [])); ?>
                        <?php foreach (($products ?? []) as $product): ?>
                            <?php
                                $productId = (int) $product['id'];
                                $selected = in_array($productId, $selectedIds, true);
                                $productSlug = (string) ($product['slug'] ?? '');
                                $productNote = match ($productSlug) {
                                    'nclex' => 'Licensure practice tests and review content for NCLEX learners.',
                                    'ati-teas-7' => 'Entrance exam practice sets for ATI TEAS 7 preparation.',
                                    'hesi' => 'Entrance exam practice content for HESI learners.',
                                    default => 'Assign this test to the selected product.',
                                };
                            ?>
                            <label class="product-picker-card">
                                <input class="form-check-input product-picker-input" type="checkbox" name="product_ids[]" value="<?= $productId ?>" <?= $selected ? 'checked' : '' ?>>
                                <h6 class="product-picker-name"><?= esc($product['name']) ?></h6>
                                <p class="product-picker-note"><?= esc($productNote) ?></p>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-text text-muted">A test can belong to one product or multiple products.</div>
                </div>
                
                <div class="alert alert-info">
                    After creating the test, you'll be redirected to manage its questions (add, link, or remove).
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Create Test</button>&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
