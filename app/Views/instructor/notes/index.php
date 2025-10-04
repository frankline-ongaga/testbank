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
        <h1 class="h3">My Study Notes</h1>
    </div>
    <div class="col text-end">
        <a href="<?= base_url('instructor/notes/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create Note
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Categories</h5>
            </div>
            <div class="list-group list-group-flush">
                <a href="<?= base_url('instructor/notes') ?>" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active">
                    All Notes
                    <span class="badge bg-secondary rounded-pill"><?= count($notes) ?></span>
                </a>
                <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('instructor/notes?category=' . $category['id']) ?>" 
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
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php foreach ($notes as $note): ?>
                    <div class="col">
                        <div class="card h-100">
                            <?php if ($note['is_featured']): ?>
                                <div class="card-status-top bg-primary"></div>
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <span class="badge bg-primary mb-2"><?= esc($note['category_name']) ?></span>
                                    <span class="badge bg-<?= $note['status'] === 'published' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($note['status']) ?>
                                    </span>
                                </div>
                                <h5 class="card-title"><?= esc($note['title']) ?></h5>
                                <p class="card-text text-muted small">
                                    Created <?= date('M j, Y', strtotime($note['created_at'])) ?>
                                </p>
                                <p class="card-text">
                                    <?= character_limiter(strip_tags($note['content']), 150) ?>
                                </p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="d-flex gap-2">
                                    <a href="<?= base_url('instructor/notes/' . $note['id']) ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <a href="<?= base_url('instructor/notes/edit/' . $note['id']) ?>" 
                                       class="btn btn-secondary btn-sm">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete(<?= $note['id'] ?>)">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-body text-center py-5">
                    <h4 class="text-muted mb-3">No Study Notes Found</h4>
                    <p class="text-muted">Get started by creating your first study note.</p>
                    <a href="<?= base_url('instructor/notes/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Note
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<form id="deleteForm" action="" method="POST" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this note?')) {
        const form = document.getElementById('deleteForm');
        form.action = `<?= base_url('instructor/notes/delete/') ?>/${id}`;
        form.submit();
    }
}
</script>


