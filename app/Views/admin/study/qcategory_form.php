<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Topic - <?= esc($subcategory['name']) ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/qcategories/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary">Save</button>
                <a href="<?= base_url('admin/study/subcategory/'.$subcategory['id'].'/qcategories') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>


