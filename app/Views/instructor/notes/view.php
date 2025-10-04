<div class="row mb-4">
    <div class="col">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('instructor/notes') ?>">Study Notes</a></li>
                <li class="breadcrumb-item active"><?= esc($note['title']) ?></li>
            </ol>
        </nav>
    </div>
    <div class="col text-end">
        <div class="btn-group">
            <a href="<?= base_url('instructor/notes/edit/' . $note['id']) ?>" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit Note
            </a>
            <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= $note['id'] ?>)">
                <i class="fas fa-trash me-2"></i>Delete
            </button>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2 mb-1"><?= esc($note['title']) ?></h1>
                <div class="text-muted">
                    <span class="badge bg-primary me-2"><?= esc($note['category_name']) ?></span>
                    <span class="badge bg-<?= $note['status'] === 'published' ? 'success' : 'warning' ?> me-2">
                        <?= ucfirst($note['status']) ?>
                    </span>
                    <span class="me-2">•</span>
                    Created <?= date('M j, Y', strtotime($note['created_at'])) ?>
                    <?php if ($note['updated_at'] !== $note['created_at']): ?>
                        <span class="me-2">•</span>
                        Updated <?= date('M j, Y', strtotime($note['updated_at'])) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="content">
            <?= $note['content'] ?>
        </div>
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


