<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets') ?>">Cheat Sheets</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($category['name']) ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><?= esc($category['name']) ?> - Cheat Sheets</h2>
            <p class="text-muted mb-0">Choose a subcategory</p>
        </div>
        <a href="<?= base_url('client/cheat-sheets') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (!empty($subcategories)): ?>
        <div class="row g-3">
            <?php foreach ($subcategories as $sub): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= esc($sub['name']) ?></h5>
                            <?php if (!empty($sub['description'])): ?>
                                <div class="text-muted small mb-3"><?= esc($sub['description']) ?></div>
                            <?php else: ?>
                                <div class="text-muted small mb-3">Cheat sheets for this topic.</div>
                            <?php endif; ?>
                            <a class="btn btn-primary" href="<?= base_url('client/cheat-sheets/subcategory/' . (int)$sub['id'] . '/docs') ?>">
                                View Cheat Sheets
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
                <h5 class="text-muted">No Subcategories</h5>
            </div>
        </div>
    <?php endif; ?>
</div>

