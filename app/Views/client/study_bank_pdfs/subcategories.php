<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('client/study-bank-pdfs') ?>">Study Bank Docs</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($category['name']) ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><?= esc($category['name']) ?></h2>
            <p class="text-muted">Select a subcategory to view available PDFs</p>
        </div>
        <a href="<?= base_url('client/study-bank-pdfs') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row g-3">
        <?php foreach (($subcategories ?? []) as $sub): ?>
        <div class="col-md-6">
            <a href="<?= base_url('client/study-bank-pdfs/subcategory/'.$sub['id'].'/pdfs') ?>" 
               class="card h-100 shadow-sm text-decoration-none">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5 class="card-title text-primary"><?= esc($sub['name']) ?></h5>
                            <?php if (!empty($sub['description'])): ?>
                            <p class="card-text text-muted small mb-0"><?= esc($sub['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
        <?php if (empty($subcategories)): ?>
        <div class="col-12">
            <div class="text-center text-muted py-5">
                <i class="fas fa-folder-open fa-3x mb-3"></i>
                <p>No subcategories available in this category.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

