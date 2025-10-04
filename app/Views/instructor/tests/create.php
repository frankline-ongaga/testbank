<div class="admin-content">
    <div class="card">
        <div class="card-body">
            <form action="<?= base_url('instructor/tests/store') ?>" method="post">
                <?= csrf_field() ?>
                
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <div class="alert alert-info">
                    <i class="fa-solid fa-info-circle me-2"></i>
                    Tests created by instructors require admin approval before becoming active.
                </div>

                <div class="mb-4">
                    <label class="form-label">Test Title</label>
                    <input type="text" class="form-control" name="title" value="<?= old('title') ?>" required>
                    <div class="form-text">Enter a descriptive title for the test</div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Test Mode</label>
                        <select class="form-select" name="mode" required>
                            <option value="practice" <?= old('mode') === 'practice' ? 'selected' : '' ?>>Practice Mode</option>
                            <option value="evaluation" <?= old('mode') === 'evaluation' ? 'selected' : '' ?>>Evaluation Mode</option>
                        </select>
                        <div class="form-text">Practice mode shows answers, Evaluation mode is timed</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Time Limit (minutes)</label>
                        <input type="number" class="form-control" name="time_limit" value="<?= old('time_limit', '60') ?>" min="0">
                        <div class="form-text">Leave empty or 0 for no time limit</div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="is_adaptive" value="1" <?= old('is_adaptive') ? 'checked' : '' ?>>
                        <label class="form-check-label">Enable Adaptive Testing</label>
                        <div class="form-text">Questions will adjust based on student performance</div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Select Questions</label>
                    <div class="card">
                        <div class="card-body p-2">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <select class="form-select" id="categoryFilter">
                                        <option value="">All Categories</option>
                                        <?php foreach (($categories ?? []) as $cat): ?>
                                            <option value="<?= $cat['id'] ?>"><?= esc($cat['name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-select" id="difficultyFilter">
                                        <option value="">All Difficulties</option>
                                        <option value="easy">Easy</option>
                                        <option value="medium">Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="searchQuestions" placeholder="Search...">
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fa-solid fa-search"></i>
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
                                            <?= esc($q['content']) ?>
                                            <div class="mt-1">
                                                <span class="badge bg-primary"><?= esc($q['category'] ?? '') ?></span>
                                                <span class="badge bg-secondary"><?= esc($q['difficulty'] ?? '') ?></span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Submit for Approval</button>
                    <a href="<?= base_url('instructor/tests') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('categoryFilter');
    const difficultyFilter = document.getElementById('difficultyFilter');
    const searchInput = document.getElementById('searchQuestions');
    const questionList = document.querySelector('.question-list');

    function filterQuestions() {
        const category = categoryFilter.value;
        const difficulty = difficultyFilter.value;
        const search = searchInput.value.toLowerCase();

        const questions = questionList.querySelectorAll('.card');
        questions.forEach(q => {
            const content = q.textContent.toLowerCase();
            const categoryMatch = !category || q.querySelector('.badge.bg-primary').textContent === category;
            const difficultyMatch = !difficulty || q.querySelector('.badge.bg-secondary').textContent === difficulty;
            const searchMatch = !search || content.includes(search);

            q.style.display = categoryMatch && difficultyMatch && searchMatch ? '' : 'none';
        });
    }

    categoryFilter.addEventListener('change', filterQuestions);
    difficultyFilter.addEventListener('change', filterQuestions);
    searchInput.addEventListener('input', filterQuestions);
});
</script>

