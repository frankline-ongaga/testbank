<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Subcategory - <?= esc($category['name']) ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" value="<?= esc($subcategory['name']) ?>" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= esc($subcategory['description'] ?? '') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Update</button>
                <a href="<?= base_url('admin/study/'.$category['id'].'/subcategories') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>



