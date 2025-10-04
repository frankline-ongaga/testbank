<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('client/notes') ?>">Study Notes</a></li>
                <li class="breadcrumb-item active"><?= esc($note['title']) ?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1"><?= esc($note['title']) ?></h1>
                <div class="text-muted">
                    <span class="badge bg-primary me-2"><?= esc($note['category_name']) ?></span>
                    <?php if ($note['is_featured']): ?>
                        <span class="badge bg-warning me-2">Featured</span>
                    <?php endif; ?>
                    <span class="me-2">•</span>
                    By <?= esc($note['author_name']) ?>
                    <span class="me-2">•</span>
                    <?= date('M j, Y', strtotime($note['created_at'])) ?>
                </div>
            </div>
        </div>

        <div class="content">
            <?= $note['content'] ?>
        </div>
    </div>
</div>

<div class="text-center mt-4">
    <a href="<?= base_url('client/notes') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Notes
    </a>
</div>

