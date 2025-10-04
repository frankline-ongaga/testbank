<div class="container py-4" style="max-width:900px;">
    <h3 class="mb-3">New Note</h3>
    <?php if (session()->getFlashdata('errors')): ?>
    <ul class="text-danger">
        <?php foreach (session()->getFlashdata('errors') as $e): ?>
            <li><?= esc($e) ?></li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <form method="post" action="/notes">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                <option value="">-- None --</option>
                <?php foreach (($categories ?? []) as $c): ?>
                    <option value="<?= (int)$c['id'] ?>"><?= esc($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="10" required></textarea>
        </div>
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="/notes" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>




