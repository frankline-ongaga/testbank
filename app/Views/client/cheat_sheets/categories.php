<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Cheat Sheets</h2>
            <p class="text-muted mb-0">Quick-reference PDFs and images</p>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (!empty($categories)): ?>
        <div class="row g-3">
            <?php foreach ($categories as $cat): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= esc($cat['name']) ?></h5>
                            <?php if (!empty($cat['description'])): ?>
                                <div class="text-muted small mb-3"><?= esc($cat['description']) ?></div>
                            <?php else: ?>
                                <div class="text-muted small mb-3">Browse cheat sheets by subcategory.</div>
                            <?php endif; ?>
                            <a class="btn btn-primary" href="<?= base_url('client/cheat-sheets/' . (int)$cat['id'] . '/subcategories') ?>">
                                View Subcategories
                            </a>
                            <a class="btn btn-outline-secondary ms-2" href="<?= base_url('client/cheat-sheets/category/' . (int)$cat['id'] . '/docs') ?>">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-file-image fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Categories</h5>
            </div>
        </div>
    <?php endif; ?>
</div>

