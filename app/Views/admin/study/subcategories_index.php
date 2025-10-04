<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Subcategories - <?= esc($category['name']) ?></h5>
        <a href="<?= base_url('admin/study/'.$category['id'].'/subcategory/create') ?>" class="btn btn-primary btn-sm">Add Subcategory</a>
    </div>
    <div class="card-body">
        <div class="row">
            <?php foreach (($subcategories ?? []) as $sub): ?>
                <div class="col-md-12 mb-3">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-1"><?= esc($sub['name']) ?></h6>
                        <div class="text-muted small mb-2"><?= esc($sub['description'] ?? '') ?></div>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('admin/study/subcategory/'.$sub['id'].'/questions') ?>" class="btn btn-outline-secondary btn-sm">Manage Questions</a> &nbsp; &nbsp; 
                            <a href="<?= base_url('admin/study/subcategory/'.$sub['id'].'/qcategories') ?>" class="btn btn-outline-secondary btn-sm">Manage Topics</a> &nbsp; &nbsp; 
                            <a href="<?= base_url('admin/notes?subcategory_id='.$sub['id']) ?>" class="btn btn-outline-secondary btn-sm">Manage Notes</a> &nbsp; &nbsp; 
                            <a href="<?= base_url('admin/study/subcategory/'.$sub['id'].'/edit') ?>" class="btn btn-outline-primary btn-sm">Edit</a> &nbsp; &nbsp; 
                            <a href="<?= base_url('admin/study/subcategory/'.$sub['id'].'/delete') ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this subcategory and its questions?');">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


