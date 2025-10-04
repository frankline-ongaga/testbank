<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Study Note</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('instructor/notes/update/' . $note['id']) ?>" method="POST">
            <?= csrf_field() ?>

            <div class="mb-4">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= old('title', $note['title']) ?>" required>
                <div class="form-text">Enter a descriptive title for the study note</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Category</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" 
                                <?= old('category_id', $note['category_id']) == $category['id'] ? 'selected' : '' ?>>
                            <?= esc($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="form-label">Content</label>
                <textarea name="content" class="form-control" rows="10" required><?= old('content', $note['content']) ?></textarea>
                <div class="form-text">Write the study note content. You can use markdown for formatting.</div>
            </div>

            <div class="mb-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Your changes will be submitted for review. The note will remain in its current status until approved by an admin.
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Submit Changes
                </button>
                <a href="<?= base_url('instructor/notes') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

