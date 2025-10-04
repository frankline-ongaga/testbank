<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Topic - <?= esc($subcategory['name']) ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/study/qcategories/'.$qcategory['id'].'/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="<?= esc($qcategory['name']) ?>" required />
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Update</button>
                <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/qcategories') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>


