<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <div class="row g-3 align-items-center">
            <div class="col">
                <h5 class="card-title mb-0">Question Bank</h5>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('admin/questions/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add Question
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-3">
        <!-- Filters -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <select class="form-control" id="categoryFilter">
                    <option value="">All Categories</option>
                    <?php foreach ($nclex_terms as $term): ?>
                        <option value="<?= $term['id'] ?>"><?= esc($term['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="difficultyFilter">
                    <option value="">All Difficulties</option>
                    <?php foreach ($difficulty_terms as $term): ?>
                        <option value="<?= $term['id'] ?>"><?= esc($term['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-control" id="typeFilter">
                    <option value="">All Types</option>
                    <option value="mcq" <?= $filter_type === 'mcq' ? 'selected' : '' ?>>Multiple Choice</option>
                    <option value="sata" <?= $filter_type === 'sata' ? 'selected' : '' ?>>Select All That Apply</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchQuestions" 
                           placeholder="Search questions..." value="<?= esc($filter_q ?? '') ?>">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Questions Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 50%">Question</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Difficulty</th>
                        <th style="width: 120px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($questions as $q): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="question-content">
                                        <div class="fw-medium text-wrap" style="max-width: 500px;">
                                            <?= esc($q['stem']) ?>
                                        </div>
                                        <?php if (!empty($q['rationale'])): ?>
                                            <div class="text-muted small mt-1">
                                                Has rationale <i class="fas fa-circle-check text-success"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">
                                    <?= strtoupper(esc($q['type'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (!empty($q['terms'])): ?>
                                    <?php foreach ($q['terms'] as $term): ?>
                                        <span class="badge bg-primary"><?= esc($term) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Uncategorized</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $difficultyClass = [
                                        'easy' => 'success',
                                        'medium' => 'warning',
                                        'hard' => 'danger'
                                    ][$q['difficulty'] ?? 'medium'] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $difficultyClass ?>">
                                    <?= ucfirst(esc($q['difficulty'] ?? 'Medium')) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="<?= base_url('admin/questions/edit/' . $q['id']) ?>" 
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/questions/preview/' . $q['id']) ?>" 
                                       class="btn btn-sm btn-outline-info" title="Preview">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmDelete(<?= $q['id'] ?>)" title="Delete">
                                        <i class="fas fa-trash"></i>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const difficultyFilter = document.getElementById('difficultyFilter');
    const typeFilter = document.getElementById('typeFilter');
    const searchInput = document.getElementById('searchQuestions');
    const table = document.querySelector('table');

    function filterQuestions() {
        const category = categoryFilter.value.toLowerCase();
        const difficulty = difficultyFilter.value.toLowerCase();
        const type = typeFilter.value.toLowerCase();
        const search = searchInput.value.toLowerCase();

        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const content = row.textContent.toLowerCase();
            const categoryMatch = !category || row.querySelector('td:nth-child(3)').textContent.toLowerCase().includes(category);
            const difficultyMatch = !difficulty || row.querySelector('td:nth-child(4)').textContent.toLowerCase().includes(difficulty);
            const typeMatch = !type || row.querySelector('td:nth-child(2)').textContent.toLowerCase().includes(type);
            const searchMatch = !search || content.includes(search);

            row.style.display = categoryMatch && difficultyMatch && typeMatch && searchMatch ? '' : 'none';
        });
    }

    categoryFilter.addEventListener('change', filterQuestions);
    difficultyFilter.addEventListener('change', filterQuestions);
    typeFilter.addEventListener('change', filterQuestions);
    searchInput.addEventListener('input', filterQuestions);
});

function confirmDelete(questionId) {
    if (confirm('Are you sure you want to delete this question?')) {
        window.location.href = `<?= base_url('admin/questions/delete/') ?>${questionId}`;
    }
}
</script>