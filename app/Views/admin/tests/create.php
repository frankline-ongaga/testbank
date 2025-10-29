<div class="admin-content">
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('admin/tests/store') ?>" method="post">
                <?= csrf_field() ?>
                <?php if (!empty($is_free)): ?>
                    <input type="hidden" name="is_free" value="1">
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Test Title</label>
                    <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                    <div class="form-text text-muted">Enter a descriptive title for the test</div>
                </div>

                <input type="hidden" name="mode" value="practice">
                <?php if (empty($is_free)): ?>
                <div class="mb-4">
                    <label class="form-label">Time Limit (minutes)</label>
                    <input type="number" class="form-control" name="time_limit" value="<?= old('time_limit', '60') ?>" min="0">
                    <div class="form-text text-muted">Leave empty or 0 for no time limit</div>
                </div>
                <?php else: ?>
                    <input type="hidden" name="time_limit" value="0">
                <?php endif; ?>

                <input type="hidden" name="is_adaptive" value="1">

                <div class="mb-4">
                    <?php if (!empty($is_free)): ?>
                        <input type="hidden" name="is_free" value="1">
                    <?php endif; ?>
                    <label class="form-label">Select Questions</label>
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchQuestions" placeholder="Search questions...">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="question-list mt-3" style="max-height: 400px; overflow-y: auto;">
                        <?php foreach (($questions ?? []) as $q): ?>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="question_ids[]" 
                               value="<?= $q['id'] ?>" <?= in_array($q['id'], old('question_ids', [])) ? 'checked' : '' ?>>
                                        <label class="form-check-label">
                                            <?= esc($q['stem'] ?? $q['content'] ?? ('Question #' . $q['id'])) ?>
                                            <div class="mt-1">
                                                <?php if (!empty($q['type'])): ?>
                                                    <span class="badge bg-info"><?= esc(strtoupper($q['type'])) ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($questions)): ?>
                            <div class="text-muted small px-2 py-3">No questions found. Create questions first to add them to a test.</div>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Create Test</button>&nbsp;&nbsp;&nbsp;<a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const isFreeToggle = document.getElementById('isFreeToggle');
    const form = document.querySelector('form');
    const categoryFilter = document.getElementById('categoryFilter');
    const difficultyFilter = document.getElementById('difficultyFilter');
    const searchInput = document.getElementById('searchQuestions');
    const questionList = document.querySelector('.question-list');

    // When toggling free test, reload with flag to include reused questions
    if (isFreeToggle) {
        isFreeToggle.addEventListener('change', function() {
            const url = new URL(window.location.href);
            if (this.checked) { url.searchParams.set('is_free', '1'); }
            else { url.searchParams.delete('is_free'); }
            window.location.href = url.toString();
        });
    }

    function filterQuestions() {
        const category = categoryFilter ? categoryFilter.value : '';
        const difficulty = difficultyFilter ? difficultyFilter.value : '';
        const search = searchInput.value.toLowerCase();

        const questions = questionList.querySelectorAll('.card');
        questions.forEach(q => {
            const content = q.textContent.toLowerCase();
            const categoryMatch = !category || (q.querySelector('.badge.bg-primary') && q.querySelector('.badge.bg-primary').textContent === category);
            const difficultyMatch = !difficulty || (q.querySelector('.badge.bg-secondary') && q.querySelector('.badge.bg-secondary').textContent === difficulty);
            const searchMatch = !search || content.includes(search);

            q.style.display = categoryMatch && difficultyMatch && searchMatch ? '' : 'none';
        });
    }

    if (categoryFilter) categoryFilter.addEventListener('change', filterQuestions);
    if (difficultyFilter) difficultyFilter.addEventListener('change', filterQuestions);
    searchInput.addEventListener('input', filterQuestions);
});
</script>

