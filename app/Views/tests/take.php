<?php
$currentRole = session()->get('current_role');
if (empty($renderInHomepage)) {
    if ($currentRole === 'client') {
        echo view('client/layout/header', ['title' => $title ?? 'Take Test']);
    } elseif ($currentRole === 'instructor') {
        echo view('instructor/layout/header', ['title' => $title ?? 'Take Test']);
    } else {
        echo view('admin/layout/header', ['title' => $title ?? 'Take Test']);
    }
}
?>
    <style>
        .test-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            border-bottom: 2px solid #e5e7eb;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        .test-content {
            max-width: 900px;
            margin: 0 auto 2rem auto;
            padding: 0 1rem;
        }
        .question-stem {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }
        .timer-display {
            font-size: 1.5rem;
            font-weight: 700;
            color: #6366f1;
        }
        .timer-display.warning {
            color: #ef4444;
        }
        .theme-dark .test-header {
            background: #1e293b;
            border-color: #334155;
        }
    </style>

    <div class="test-header">
        <div class="container" style="max-width: 900px;">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="mb-1"><?= esc($test['title'] ?? 'Take Test') ?></h5>
                    <div class="text-muted small" id="question-counter">Question 1 of <?= count($questions) ?></div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <div class="text-muted small">Time Remaining</div>
                        <div class="timer-display" id="timer">--:--</div>
                    </div>
                </div>
            </div>
            <div class="progress mt-3" style="height: 6px;">
                <div class="progress-bar" role="progressbar" id="progress-bar" style="width: 0%"></div>
            </div>
        </div>
    </div>

    <div class="test-content">
        <form method="post" action="<?= isset($freeSubmitAction) ? $freeSubmitAction : base_url(($currentRole === 'client' ? 'client/tests' : 'tests') . '/submit/' . (int)$attempt['id']) ?>">
            <?php foreach ($questions as $idx => $q): ?>
                <div class="question-card" id="question-<?= $idx ?>" style="<?= $idx === 0 ? '' : 'display:none;' ?>">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="question-stem"><?= $q['stem'] ?></div>
                            <?php if (!empty($q['media_path'])): ?>
                                <div class="mb-3">
                                    <img src="<?= base_url('questions/media/' . (int)$q['id']) ?>" alt="Question image" class="img-fluid border rounded" style="max-height: 420px;">
                                </div>
                            <?php endif; ?>
                            <?php $choices = $choicesByQ[$q['id']] ?? []; ?>
                            <?php foreach ($choices as $choice): ?>
                                <?php if ($q['type'] === 'sata'): ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" name="answers[<?= (int)$q['id'] ?>][]" value="<?= (int)$choice['id'] ?>" id="c<?= (int)$choice['id'] ?>" />
                                        <label class="form-check-label" for="c<?= (int)$choice['id'] ?>">
                                            <strong>(<?= esc($choice['label']) ?>)</strong> <?= esc($choice['content']) ?>
                                        </label>
                                    </div>
                                <?php else: ?>
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="radio" name="answers[<?= (int)$q['id'] ?>][]" value="<?= (int)$choice['id'] ?>" id="c<?= (int)$choice['id'] ?>" />
                                        <label class="form-check-label" for="c<?= (int)$choice['id'] ?>">
                                            <strong>(<?= esc($choice['label']) ?>)</strong> <?= esc($choice['content']) ?>
                                        </label>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            
                            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                                <?php if ($idx > 0): ?>
                                    <button type="button" class="btn btn-outline-secondary" onclick="prevQuestion()">
                                        <i class="fas fa-arrow-left me-2"></i>Previous
                                    </button>
                                <?php else: ?>
                                    <div></div>
                                <?php endif; ?>
                                <?php if ($idx < count($questions) - 1): ?>
                                    <button type="button" class="btn btn-primary" onclick="nextQuestion()">
                                        Next<i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Submit your test? You cannot change answers after submission.')">
                                        <i class="fas fa-check me-2"></i>Submit Test
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </form>
    </div>

        <script>
            let currentQuestion = 0;
            const totalQuestions = <?= count($questions) ?>;
            const minutesLimit = <?= (int)($test['time_limit_minutes'] ?? 60) ?>;
            const hasTimeLimit = minutesLimit > 0;
            let timeLeft = hasTimeLimit ? (minutesLimit * 60) : 0; // seconds

            function showQuestion(idx) {
                document.getElementById(`question-${currentQuestion}`).style.display = 'none';
                document.getElementById(`question-${idx}`).style.display = 'block';
                currentQuestion = idx;
                updateProgress();
            }

            function prevQuestion() {
                if (currentQuestion > 0) showQuestion(currentQuestion - 1);
            }

            function nextQuestion() {
                if (currentQuestion < totalQuestions - 1) showQuestion(currentQuestion + 1);
            }

            function updateProgress() {
                document.getElementById('question-counter').textContent = `Question ${currentQuestion + 1} of ${totalQuestions}`;
                const progress = ((currentQuestion + 1) / totalQuestions) * 100;
                document.getElementById('progress-bar').style.width = `${progress}%`;
            }

            function updateTimer() {
                const timerEl = document.getElementById('timer');
                if (!hasTimeLimit) {
                    timerEl.textContent = 'Unlimited';
                    timerEl.classList.remove('warning');
                    return; // no countdown
                }
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (timeLeft <= 300) {
                    timerEl.classList.add('warning');
                }
                if (timeLeft <= 0) {
                    document.querySelector('form').submit();
                } else {
                    timeLeft--;
                    setTimeout(updateTimer, 1000);
                }
            }

            updateProgress();
            updateTimer();

            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowRight') nextQuestion();
                else if (e.key === 'ArrowLeft') prevQuestion();
            });
        </script>
<?php
if (empty($renderInHomepage)) {
    if ($currentRole === 'client') {
        echo view('client/layout/footer');
    } elseif ($currentRole === 'instructor') {
        echo view('instructor/layout/footer');
    } else {
        echo view('admin/layout/footer');
    }
}
?>
