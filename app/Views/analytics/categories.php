<?= view('admin/partials/header', ['title' => $title]) ?>
    <div class="admin-page-header">
        <div class="admin-page-title">
            <h1><?= $title ?></h1>
            <p>Category-wise performance analysis</p>
        </div>
    </div>
    <div class="admin-content">
    <h3 class="mb-3">Category Analysis</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Category</th>
                <th>Correct</th>
                <th>Total</th>
                <th>Accuracy</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach (($rows ?? []) as $r): ?>
                <?php $acc = ($r['num_questions'] ?? 0) > 0 ? round(($r['num_correct'] / $r['num_questions']) * 100, 2) : 0; ?>
                <tr>
                    <td><?= esc($r['category']) ?></td>
                    <td><?= esc($r['num_correct']) ?></td>
                    <td><?= esc($r['num_questions']) ?></td>
                    <td><?= $acc ?>%</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/analytics" class="btn btn-secondary">Back</a>
    </div>
<?= view('admin/partials/footer') ?>


