<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="row mb-4">
    <div class="col">
        <h1 class="h3">Study Notes</h1>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="<?= base_url('client/notes') ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active">
                    All Notes
                    <span class="badge bg-secondary rounded-pill"><?= count($notes) ?></span>
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('client/notes?category=' . $category['id']) ?>" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <?= esc($category['name']) ?>
                        <span class="badge bg-secondary rounded-pill">
                            <?= count(array_filter($notes, fn($n) => $n['category_id'] == $category['id'])) ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <?php if ($notes): ?>
            <?php 
            // Group featured notes
            $featured = array_filter($notes, fn($n) => $n['is_featured']);
            $regular = array_filter($notes, fn($n) => !$n['is_featured']);
            ?>

            <?php if ($featured): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star text-warning me-2"></i>Featured Notes
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row row-cols-1 row-cols-md-2 g-4">
                            <?php foreach ($featured as $note): ?>
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="card-status-top bg-warning"></div>
                                        <div class="card-body">
                                            <span class="badge bg-primary mb-2"><?= esc($note['category_name']) ?></span>
                                            <h5 class="card-title"><?= esc($note['title']) ?></h5>
                                            <p class="card-text text-muted small">
                                                By <?= esc($note['author_name']) ?> • 
                                                <?= date('M j, Y', strtotime($note['created_at'])) ?>
                                            </p>
                                            <p class="card-text">
                                                <?= character_limiter(strip_tags($note['content']), 150) ?>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent">
                                            <a href="<?= base_url('client/notes/' . $note['id']) ?>" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-book-reader me-1"></i>Read More
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($regular as $note): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="badge bg-primary mb-2"><?= esc($note['category_name']) ?></span>
                                <h5 class="card-title"><?= esc($note['title']) ?></h5>
                                <p class="card-text text-muted small">
                                    By <?= esc($note['author_name']) ?> • 
                                    <?= date('M j, Y', strtotime($note['created_at'])) ?>
                                </p>
                                <p class="card-text">
                                    <?= character_limiter(strip_tags($note['content']), 150) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="<?= base_url('client/notes/' . $note['id']) ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-book-reader me-1"></i>Read More
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <h4 class="text-muted mb-3">No Study Notes Available</h4>
                    <p class="text-muted">Check back later for new study materials.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


