<div class="container py-4">
    <?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Study Notes</h3>
        <a href="/notes/create" class="btn btn-primary">New Note</a>
    </div>

    <form method="get" class="row g-2 mb-3">
        <div class="col-md-6">
            <select name="category_id" class="form-select">
                <option value="">All Categories</option>
                <?php foreach (($categories ?? []) as $c): ?>
                    <option value="<?= (int)$c['id'] ?>" <?= ((int)$selected_cat === (int)$c['id'] ? 'selected' : '') ?>><?= esc($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-6">
            <button class="btn btn-outline-primary">Filter</button>
            <a href="/notes" class="btn btn-link">Reset</a>
        </div>
    </form>

    <div class="list-group">
        <?php foreach (($notes ?? []) as $n): ?>
            <a href="/notes/view/<?= (int)$n['id'] ?>" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?= esc($n['title']) ?></h5>
                    <small>v<?= (int)$n['version'] ?></small>
                </div>
                <p class="mb-1"><?= esc(substr(strip_tags($n['content']),0,120)) ?>...</p>
            </a>
        <?php endforeach; ?>
    </div>
</div>





