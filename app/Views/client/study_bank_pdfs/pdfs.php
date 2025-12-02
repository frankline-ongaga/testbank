<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('client/study-bank-pdfs') ?>">Study Bank Docs</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('client/study-bank-pdfs/'.$category['id'].'/subcategories') ?>"><?= esc($category['name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($subcategory['name']) ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><?= esc($subcategory['name']) ?> - Docs</h2>
            <p class="text-muted">Download study documents</p>
        </div>
        <a href="<?= base_url('client/study-bank-pdfs/'.$category['id'].'/subcategories') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (!empty($pdfs)): ?>
    <div class="row g-3">
        <?php foreach ($pdfs as $pdf): ?>
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center">
                            <i class="fas fa-file fa-3x text-muted"></i>
                        </div>
                        <div class="col-md-8">
                            <h5 class="card-title mb-1"><?= esc($pdf['title']) ?></h5>
                            <?php if (!empty($pdf['description'])): ?>
                            <p class="card-text text-muted mb-2"><?= esc($pdf['description']) ?></p>
                            <?php endif; ?>
                            <small class="text-muted">
                                <i class="fas fa-file"></i> <?= esc($pdf['file_name']) ?> 
                                <span class="mx-2">|</span>
                                <i class="fas fa-hdd"></i> <?= number_format($pdf['file_size'] / 1024, 2) ?> KB
                                <span class="mx-2">|</span>
                                <i class="fas fa-calendar"></i> <?= date('M d, Y', strtotime($pdf['created_at'])) ?>
                            </small>
                        </div>
                        <div class="col-md-3 text-end">
                            <a href="<?= base_url('client/study-bank-pdfs/pdf/'.$pdf['id'].'/download') ?>" 
                               class="btn btn-primary">
                                <i class="fas fa-download"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="fas fa-file fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">No Documents Available</h5>
            <p class="text-muted">There are no documents available in this subcategory yet. Check back soon!</p>
        </div>
    </div>
    <?php endif; ?>
</div>

