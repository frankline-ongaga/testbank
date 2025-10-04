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
        <h5 class="card-title mb-0">Create Study Note</h5>
    </div>
    <div class="card-body">
        <form action="<?= base_url('admin/notes/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <?php if (!empty($subcategory_id) && !empty($subcategory)): ?>
                <input type="hidden" name="subcategory_id" value="<?= (int)$subcategory_id ?>" />
                <div class="alert alert-secondary py-2">
                    <div class="small mb-0">Subcategory</div>
                    <div class="fw-semibold mb-0"><?= esc($subcategory['name']) ?></div>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <label class="form-label">Title</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= old('title') ?>" required>
                <div class="form-text">Enter a descriptive title for the study note</div>
            </div>

            

            <div class="mb-4">
                <label class="form-label">Content</label>
                <textarea id="content" name="content" class="form-control"><?= old('content') ?></textarea>
                <div class="form-text">Write the study note content. Use the editor toolbar for formatting.</div>
            </div>

            <div class="mb-4">
                <label class="form-label">Attachments</label>
                <input type="file" name="attachments[]" class="form-control" multiple 
                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip">
                <div class="form-text">
                    Upload supporting documents (PDF, Word, Excel, PowerPoint, ZIP). Max 10MB per file.
                </div>
            </div>

            <div class="mb-4">
                <div class="form-check form-switch">
                    <input type="checkbox" name="is_featured" class="form-check-input" 
                           value="1" <?= old('is_featured') ? 'checked' : '' ?>>
                    <label class="form-check-label">Feature this note</label>
                </div>
                <div class="form-text">Featured notes appear at the top of the list</div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Save Note
                </button>
                <a href="<?= base_url('admin/notes' . (!empty($subcategory_id) ? ('?subcategory_id='.$subcategory_id) : '')) ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>