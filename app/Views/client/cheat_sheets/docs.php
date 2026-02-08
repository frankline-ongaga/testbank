<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets') ?>">Cheat Sheets</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('client/cheat-sheets/' . (int)$category['id'] . '/subcategories') ?>"><?= esc($category['name']) ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= esc($subcategory['name']) ?></li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><?= esc($subcategory['name']) ?> - Cheat Sheets</h2>
            <p class="text-muted mb-0">View online or download</p>
        </div>
        <a href="<?= base_url('client/cheat-sheets/' . (int)$category['id'] . '/subcategories') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <?php if (!empty($cheatSheets)): ?>
        <div class="row g-3">
            <?php foreach ($cheatSheets as $doc): ?>
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-1 text-center">
                                    <?php
                                        $ext = strtolower((string)pathinfo((string)($doc['file_name'] ?? ''), PATHINFO_EXTENSION));
                                        $isPdf = $ext === 'pdf';
                                        $fileUrl = base_url('client/cheat-sheets/doc/' . (int)$doc['id'] . '/file');
                                        $viewUrl = base_url('client/cheat-sheets/doc/' . (int)$doc['id']);
                                    ?>
                                    <a href="<?= $viewUrl ?>" class="d-inline-block text-decoration-none" aria-label="View cheat sheet">
                                        <?php if ($isPdf): ?>
                                            <div class="border rounded bg-light" style="width:72px;height:72px;overflow:hidden;">
                                                <iframe src="<?= $fileUrl ?>" style="width:72px;height:72px;border:0;pointer-events:none;"></iframe>
                                            </div>
                                        <?php else: ?>
                                            <img src="<?= $fileUrl ?>" alt="Preview" class="img-fluid border rounded" style="width:72px;height:72px;object-fit:cover;" loading="lazy">
                                        <?php endif; ?>
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="card-title mb-1"><?= esc($doc['title']) ?></h5>
                                    <?php if (!empty($doc['description'])): ?>
                                        <p class="card-text text-muted mb-2"><?= esc($doc['description']) ?></p>
                                    <?php endif; ?>
                                    <small class="text-muted">
                                        <i class="fas fa-file"></i> <?= esc($doc['file_name']) ?>
                                        <span class="mx-2">|</span>
                                        <i class="fas fa-hdd"></i> <?= number_format(((int)$doc['file_size']) / 1024, 2) ?> KB
                                    </small>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="<?= base_url('client/cheat-sheets/doc/' . (int)$doc['id']) ?>" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="<?= base_url('client/cheat-sheets/doc/' . (int)$doc['id'] . '/download') ?>" class="btn btn-primary ms-2">
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
                <i class="fas fa-file-image fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Cheat Sheets Available</h5>
                <p class="text-muted mb-0">Check back soon!</p>
            </div>
        </div>
    <?php endif; ?>
</div>
