<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/f9ll5ybcbrw6k9c0mz3t0s8yvymj71b775qwmexemizlmhmz/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        images_upload_url: '<?= base_url('admin/notes/upload-image') ?>',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr, formData;
            xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '<?= base_url('admin/notes/upload-image') ?>');
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
            xhr.send(formData);
        },
        height: 500,
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
    });
</script>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Edit Study Note</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/notes/update/' . $note['id']) ?>" method="POST">
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
                <textarea id="content" name="content" class="form-control" rows="10" required><?= old('content', $note['content']) ?></textarea>
                <div class="form-text">Write the study note content. You can use markdown for formatting.</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="draft" <?= old('status', $note['status']) === 'draft' ? 'selected' : '' ?>>
                        Draft
                    </option>
                    <option value="published" <?= old('status', $note['status']) === 'published' ? 'selected' : '' ?>>
                        Published
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_featured" class="form-check-input" 
                           value="1" <?= old('is_featured', $note['is_featured']) ? 'checked' : '' ?>>
                    <label class="form-check-label">Feature this note</label>
                </div>
                <div class="form-text">Featured notes appear at the top of the list</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Update Note
                </button>
                
                  &nbsp;  &nbsp;  &nbsp; 

                <a href="<?= base_url('admin/notes') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

