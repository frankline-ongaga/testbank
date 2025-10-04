<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Subcategory - <?= esc($category['name']) ?></h5>
    </div>
    <div class="card-body">
        <form method="post" action="<?= base_url('admin/study/'.$category['id'].'/subcategory/store') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Save</button>
            <a href="<?= base_url('admin/study/'.$category['id'].'/subcategories') ?>" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>


