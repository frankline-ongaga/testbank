<style>
    .study-docs-hero {
        background: #f8f9fa;
        padding: 2rem 0;
        margin-bottom: 2rem;
        border-radius: 10px;
        border: 1px solid #e9ecef;
    }
    .study-docs-hero h2 {
        font-size: 1.75rem;
        font-weight: 600;
        margin-bottom: 0;
        color: #2d3748;
    }
    .category-card {
        border: 1px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        overflow: hidden;
        background: white;
    }
    .category-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #dee2e6;
    }
    .category-icon-wrapper {
        background: #f8f9fa;
        width: 50px;
        height: 50px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #6c757d;
        flex-shrink: 0;
    }
    .category-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .category-card .card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0;
    }
    .category-card .card-text {
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }
    .category-card .btn-view-docs {
        background: white;
        border: 2px solid #000;
        color: #000;
        padding: 0.6rem 1.25rem;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }
    .category-card .btn-view-docs:hover {
        background: #000;
        color: white;
    }
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }
    .empty-state i {
        font-size: 4rem;
        color: #cbd5e0;
        margin-bottom: 1.5rem;
    }
</style>

<div class="container py-4">
    <div class="study-docs-hero text-center">
        <div class="container">
            <h2>Download premium study material</h2>
        </div>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i><?= esc(session()->getFlashdata('message')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i><?= esc(session()->getFlashdata('error')) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php foreach (($categories ?? []) as $cat): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card category-card h-100">
                <div class="card-body p-4">
                    <div class="category-header">
                        <div class="category-icon-wrapper">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5 class="card-title"><?= esc($cat['name']) ?></h5>
                    </div>
                    <?php if (!empty($cat['description'])): ?>
                    <p class="card-text"><?= esc($cat['description']) ?></p>
                    <?php else: ?>
                    <p class="card-text">Access documents and study materials for <?= esc($cat['name']) ?></p>
                    <?php endif; ?>
                    <a href="<?= base_url('client/study-bank-pdfs/category/'.$cat['id'].'/docs') ?>" 
                       class="btn-view-docs">
                        View Documents <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php if (empty($categories)): ?>
        <div class="col-12">
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <h4 class="text-muted">No Categories Available</h4>
                <p class="text-muted">Check back soon for study materials.</p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

