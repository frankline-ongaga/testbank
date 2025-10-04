<?= view('admin/partials/header', ['title' => $title]) ?>
    <?php
        $roles = session()->get('roles') ?? [];
        $isAdmin = in_array('admin', $roles);
        $isInstructor = in_array('instructor', $roles);
        $isStudent = (!$isAdmin && !$isInstructor) || in_array('student', $roles);
    ?>
    <div class="admin-page-header">
        <div class="admin-page-title">
            <h1><?= $title ?></h1>
            <?php if ($isAdmin || $isInstructor): ?>
                <p>Manage and organize tests in the system</p>
            <?php else: ?>
                <p>Available tests for you to take</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="admin-content">
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Tests</h3>
        <?php if ($isAdmin || $isInstructor): ?>
            <a href="/tests/create" class="btn btn-primary">Create Test</a>
        <?php endif; ?>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Mode</th>
                <th>Time Limit</th>
                <th>Adaptive</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($tests ?? []) as $t): ?>
                <tr>
                    <td><?= esc($t['id']) ?></td>
                    <td><?= esc($t['title']) ?></td>
                    <td><?= esc($t['mode']) ?></td>
                    <td><?= esc($t['time_limit_minutes'] ?? '-') ?></td>
                    <td>
                        <?= esc(($t['is_adaptive'] ?? 0) ? 'Yes' : 'No') ?>
                        <?php if ($isStudent): ?>
                            <a href="/start/<?= (int)$t['id'] ?>" class="btn btn-sm btn-primary float-end">Start Test</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<?= view('admin/partials/footer') ?>


