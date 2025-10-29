<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success mb-3"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger mb-3"><?= esc(session()->getFlashdata('error')) ?></div>
<?php endif; ?>

<div class="d-flex justify-content-end align-items-center mb-3">
    <div class="d-flex gap-2">
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
            <input type="text" id="searchCategory" class="form-control" placeholder="Search categories...">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fas fa-plus me-2"></i>Add Category
        </button>
    </div>
 </div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="categoryTable">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>Name</th>
                        <th style="width: 200px" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (($terms ?? []) as $idx => $t): ?>
                        <tr>
                            <td class="text-muted"><?= $idx + 1 ?></td>
                            <td class="category-name"><?= esc($t['name']) ?></td>
                            <td class="text-end">
                                <button type="button" 
                                        class="btn btn-sm btn-outline-primary me-2 js-edit-category"
                                        data-id="<?= (int)$t['id'] ?>"
                                        data-name="<?= esc($t['name']) ?>"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editCategoryModal">
                                    <i class="fas fa-pen me-1"></i>Edit
                                </button>
                                <a href="<?= base_url('admin/taxonomy/nclex/delete/' . (int)$t['id']) ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Delete this category?');">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($terms)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">No categories yet. Use the Add button to create one.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Question Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="<?= base_url('admin/taxonomy/nclex/store') ?>">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g., Pharmacology" required>
            <div class="form-text text-muted">Category students can filter by during study</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Question Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" id="editCategoryForm" action="#">
        <?= csrf_field() ?>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="editCategoryName" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchCategory');
    const table = document.getElementById('categoryTable');
    const rows = table ? table.querySelectorAll('tbody tr') : [];

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            rows.forEach(r => {
                const nameCell = r.querySelector('.category-name');
                const text = (nameCell ? nameCell.textContent : '').toLowerCase();
                r.style.display = !q || text.includes(q) ? '' : 'none';
            });
        });
    }

    // Edit modal wiring (single modal reused)
    document.querySelectorAll('.js-edit-category').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const form = document.getElementById('editCategoryForm');
            const input = document.getElementById('editCategoryName');
            if (form && input) {
                form.action = '<?= base_url('admin/taxonomy/nclex/update') ?>/' + id;
                input.value = name || '';
            }
        });
    });
});
</script>


