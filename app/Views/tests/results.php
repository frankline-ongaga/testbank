<?php
// Choose layout based on current portal
$currentRole = session()->get('current_role');
if ($currentRole === 'client') {
    echo view('client/layout/header', ['title' => $title ?? 'Results']);
} elseif ($currentRole === 'instructor') {
    echo view('instructor/layout/header', ['title' => $title ?? 'Results']);
} else {
    echo view('admin/layout/header', ['title' => $title ?? 'Results']);
}
?>
    <div class="admin-content" style="max-width:900px;">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Score</div>
                        <?php $scoreVal = is_numeric($attempt['score'] ?? null) ? (float)$attempt['score'] : 0; ?>
                        <div class="h3 mb-0"><?= number_format($scoreVal, 0) ?>%</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Time Taken</div>
                        <?php 
                            $startTs = !empty($attempt['started_at']) ? strtotime($attempt['started_at']) : null;
                            $endTs = !empty($attempt['completed_at']) ? strtotime($attempt['completed_at']) : null;
                            $minutes = 0;
                            if ($startTs && $endTs && $endTs >= $startTs) {
                                $minutes = max(0, round(($endTs - $startTs) / 60));
                            }
                        ?>
                        <div class="h3 mb-0"><?= (int)$minutes ?> min</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title">Questions</div>
                        <div class="h3 mb-0">
                        <?php
                            $correct = 0;
                            foreach ($userAnswers as $ans) {
                                if (!empty($ans['is_correct'])) $correct++;
                            }
                            echo $correct . '/' . count($questions);
                        ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <h4>Detailed Feedback</h4>
            <?php foreach ($questions as $idx => $q): ?>
                <?php 
                    $userAns = $userAnswers[$q['id']] ?? null;
                    $isCorrect = $userAns ? $userAns['is_correct'] : false;
                    $userChoices = $userAns ? $userAns['choices'] : [];
                ?>
                <div class="card mb-3 <?= $isCorrect ? 'border-success' : 'border-danger' ?>">
                    <div class="card-header <?= $isCorrect ? 'bg-success text-white' : 'bg-danger text-white' ?>">
                        Question <?= $idx + 1 ?> - <?= $isCorrect ? 'Correct' : 'Incorrect' ?>
                    </div>
                    <div class="card-body">
                        <div class="mb-3"><?= $q['stem'] ?></div>
                        
                        <?php $choices = $choicesByQ[$q['id']] ?? []; ?>
                        <?php foreach ($choices as $choice): ?>
                            <?php 
                                $isChosen = in_array($choice['id'], $userChoices);
                                $isActuallyCorrect = $choice['is_correct'];
                                
                                $class = '';
                                if ($isChosen && $isActuallyCorrect) $class = 'text-success fw-bold';
                                else if ($isChosen && !$isActuallyCorrect) $class = 'text-danger fw-bold';
                                else if (!$isChosen && $isActuallyCorrect) $class = 'text-success';
                            ?>
                            <div class="<?= $class ?>">
                                <?php if ($isChosen): ?>
                                    <i class="fa-solid <?= $isActuallyCorrect ? 'fa-check' : 'fa-times' ?>"></i>
                                <?php endif; ?>
                                (<?= esc($choice['label']) ?>) <?= esc($choice['content']) ?>
                            </div>
                        <?php endforeach; ?>

                        <?php if (!$isCorrect && $q['rationale']): ?>
                            <div class="alert alert-info mt-3">
                                <strong>Explanation:</strong><br>
                                <?= $q['rationale'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex gap-2">
            <?php if ($currentRole === 'client'): ?>
                <a href="<?= base_url('client/tests') ?>" class="btn btn-secondary">Back to Tests</a>
                <a href="<?= base_url('client/analytics') ?>" class="btn btn-primary">View Analytics</a>
            <?php elseif ($currentRole === 'instructor'): ?>
                <a href="<?= base_url('instructor/tests') ?>" class="btn btn-secondary">Back to Tests</a>
                <a href="<?= base_url('instructor/analytics') ?>" class="btn btn-primary">View Analytics</a>
            <?php else: ?>
                <a href="<?= base_url('admin/tests') ?>" class="btn btn-secondary">Back to Tests</a>
                <a href="<?= base_url('admin/analytics') ?>" class="btn btn-primary">View Analytics</a>
            <?php endif; ?>
        </div>
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