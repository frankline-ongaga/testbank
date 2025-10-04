<div class="admin-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Question Bank</h1>
        <a href="<?= base_url('admin/questions/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Question
        </a>
    </div>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <select class="form-select form-control" id="categoryFilter">
                        <option value="">All Categories</option>
                        <?php foreach (($categories ?? []) as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-control" id="difficultyFilter">
                        <option value="">All Difficulties</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select form-control" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="searchQuestions" placeholder="Search...">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Question</th>
                            <th>Category</th>
                            <th>Difficulty</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($questions ?? []) as $q): ?>
                            <tr>
                                <td>
                                    <div style="max-width: 400px;">
                                        <?= esc($q['content']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        <?= esc($q['category'] ?? '—') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $q['difficulty'] === 'hard' ? 'danger' : ($q['difficulty'] === 'medium' ? 'warning' : 'success') ?>">
                                        <?= ucfirst(esc($q['difficulty'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $q['status'] === 'active' ? 'success' : ($q['status'] === 'pending' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst(esc($q['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="<?= base_url('admin/questions/edit/' . $q['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/questions/preview/' . $q['id']) ?>" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete(<?= $q['id'] ?>)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($questions)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">No questions found</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(questionId) {
    if (confirm('Are you sure you want to delete this question?')) {
        window.location.href = `<?= base_url('admin/questions/delete/') ?>${questionId}`;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const difficultyFilter = document.getElementById('difficultyFilter');
    const statusFilter = document.getElementById('statusFilter');
    const searchInput = document.getElementById('searchQuestions');
    const table = document.querySelector('table');

    function filterQuestions() {
        const category = categoryFilter.value;
        const difficulty = difficultyFilter.value;
        const status = statusFilter.value;
        const search = searchInput.value.toLowerCase();

        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const content = row.textContent.toLowerCase();
            const categoryMatch = !category || row.querySelector('.badge.bg-primary').textContent.trim() === category;
            const difficultyMatch = !difficulty || row.querySelector('td:nth-child(3)').textContent.trim().toLowerCase() === difficulty;
            const statusMatch = !status || row.querySelector('td:nth-child(4)').textContent.trim().toLowerCase() === status;
            const searchMatch = !search || content.includes(search);

            row.style.display = categoryMatch && difficultyMatch && statusMatch && searchMatch ? '' : 'none';
        });
    }

    categoryFilter.addEventListener('change', filterQuestions);
    difficultyFilter.addEventListener('change', filterQuestions);
    statusFilter.addEventListener('change', filterQuestions);
    searchInput.addEventListener('input', filterQuestions);
});
</script>
