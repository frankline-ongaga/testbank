<?= view('admin/partials/header', ['title' => $title ?? 'Pending Questions']) ?>
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <h3 class="mb-3">Pending Questions</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>Stem</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $q): ?>
                <tr>
                    <td><?= esc($q['id']) ?></td>
                    <td><?= esc($q['type']) ?></td>
                    <td><?= esc(substr(strip_tags($q['stem']), 0, 80)) ?>...</td>
                    <td class="d-flex gap-2">
                        <a href="/admin/questions/approve/<?= (int)$q['id'] ?>" class="btn btn-sm btn-success">Approve</a>
                        <a href="/admin/questions/deactivate/<?= (int)$q['id'] ?>" class="btn btn-sm btn-outline-warning">Deactivate</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?= view('admin/partials/footer') ?>


