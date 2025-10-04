<?php
$currentRole = session()->get('current_role');
if ($currentRole === 'client') {
    echo view('client/layout/header', ['title' => $title ?? 'Take Test']);
} elseif ($currentRole === 'instructor') {
    echo view('instructor/layout/header', ['title' => $title ?? 'Take Test']);
} else {
    echo view('admin/layout/header', ['title' => $title ?? 'Take Test']);
}
?>
    <div class="admin-page-header">
        <div class="admin-page-title">
            <h1><?= esc($title ?? 'Take Test') ?></h1>
            <p>Test #<?= (int)$attempt['test_id'] ?></p>
        </div>
    </div>
    <div class="admin-content" style="max-width:900px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="progress" style="width: 200px;">
                <div class="progress-bar" role="progressbar" id="progress-bar"></div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="fw-bold" id="timer">Time Remaining: --:--</div>
                <div class="badge bg-primary" id="question-counter">Question 1/<?= count($questions) ?></div>
            </div>
        </div>

        <form method="post" action="<?= base_url(($currentRole === 'client' ? 'client/tests' : 'tests') . '/submit/' . (int)$attempt['id']) ?>">
            <?php foreach ($questions as $idx => $q): ?>
                <div class="card mb-3 question-card" id="question-<?= $idx ?>" style="<?= $idx === 0 ? '' : 'display:none;' ?>">
                    <div class="card-body">
                        <h6>Q<?= $idx+1 ?>.</h6>
                        <div class="mb-2"><?= $q['stem'] ?></div>
                        <?php $choices = $choicesByQ[$q['id']] ?? []; ?>
                        <?php foreach ($choices as $choice): ?>
                            <?php if ($q['type'] === 'sata'): ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="answers[<?= (int)$q['id'] ?>][]" value="<?= (int)$choice['id'] ?>" id="c<?= (int)$choice['id'] ?>" />
                                    <label class="form-check-label" for="c<?= (int)$choice['id'] ?>">(<?= esc($choice['label']) ?>) <?= esc($choice['content']) ?></label>
                                </div>
                            <?php else: ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers[<?= (int)$q['id'] ?>][]" value="<?= (int)$choice['id'] ?>" id="c<?= (int)$choice['id'] ?>" />
                                    <label class="form-check-label" for="c<?= (int)$choice['id'] ?>">(<?= esc($choice['label']) ?>) <?= esc($choice['content']) ?></label>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="d-flex justify-content-between mt-4">
                            <?php if ($idx > 0): ?>
                                <button type="button" class="btn btn-outline-primary prev-btn" onclick="showQuestion(<?= $idx - 1 ?>)">Previous</button>
                            <?php else: ?>
                                <div></div>
                            <?php endif; ?>
                            <?php if ($idx < count($questions) - 1): ?>
                                <button type="button" class="btn btn-primary next-btn" onclick="showQuestion(<?= $idx + 1 ?>)">Next</button>
                            <?php else: ?>
                                <button type="submit" class="btn btn-success">Submit Test</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>

        <script>
            let currentQuestion = 0;
            const totalQuestions = <?= count($questions) ?>;
            let timeLeft = <?= ($attempt['time_limit_minutes'] ?? 60) * 60 ?>; // seconds

            function showQuestion(idx) {
                // Hide current question
                document.getElementById(`question-${currentQuestion}`).style.display = 'none';
                // Show new question
                document.getElementById(`question-${idx}`).style.display = 'block';
                // Update current question
                currentQuestion = idx;
                // Update counter and progress
                updateProgress();
            }

            function updateProgress() {
                // Update question counter
                document.getElementById('question-counter').textContent = `Question ${currentQuestion + 1}/${totalQuestions}`;
                // Update progress bar
                const progress = ((currentQuestion + 1) / totalQuestions) * 100;
                document.getElementById('progress-bar').style.width = `${progress}%`;
            }

            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                document.getElementById('timer').textContent = 
                    `Time Remaining: ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    document.querySelector('form').submit();
                } else {
                    timeLeft--;
                    setTimeout(updateTimer, 1000);
                }
            }

            // Initialize progress
            updateProgress();
            // Start timer
            updateTimer();

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight' && currentQuestion < totalQuestions - 1) {
                    showQuestion(currentQuestion + 1);
                } else if (e.key === 'ArrowLeft' && currentQuestion > 0) {
                    showQuestion(currentQuestion - 1);
                }
            });
        </script>
    </div>
<?php
if ($currentRole === 'client') {
    echo view('client/layout/footer');
} elseif ($currentRole === 'instructor') {
    echo view('instructor/layout/footer');
} else {
    echo view('admin/layout/footer');
}
?>