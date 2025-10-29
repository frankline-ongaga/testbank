<div class="container py-3">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Study Library</h6>
                </div>
                <div class="list-group list-group-flush">
                    <?php foreach (($categories ?? []) as $cat): ?>
                        <a href="<?= base_url('client/study/'.$cat['id'].'/subcategories') ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <span><?= esc($cat['name']) ?></span>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body d-flex align-items-center justify-content-center text-center text-muted">
                    <div>
                        <div class="mb-2"><i class="far fa-folder-open fa-2xl"></i></div>
                        <div>Select a category on the left to view its subfolders.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


