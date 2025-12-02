<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Document - <?= esc($subcategory['name']) ?></h5>
        <a href="<?= base_url('admin/study-bank-pdfs/subcategory/'.$subcategory['id'].'/pdfs') ?>" class="btn btn-secondary btn-sm">Back</a>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <form action="<?= base_url('admin/study-bank-pdfs/pdf/'.$pdf['id'].'/update') ?>" 
              method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="title" name="title" 
                       value="<?= esc($pdf['title']) ?>" required>
                <small class="form-text text-muted">Give this PDF a descriptive title</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"><?= esc($pdf['description'] ?? '') ?></textarea>
                <small class="form-text text-muted">Optional: Add a description or summary of the PDF content</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Current File</label>
                <div class="card bg-light">
                    <div class="card-body">
                        <i class="fas fa-file text-muted"></i> 
                        <?= esc($pdf['file_name']) ?> 
                        <span class="text-muted">(<?= number_format($pdf['file_size'] / 1024, 2) ?> KB)</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="pdf_file" class="form-label">Replace Document File (Optional)</label>
                <input type="file" class="form-control" id="pdf_file" name="pdf_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt">
                <small class="form-text text-muted">Leave empty to keep the current file. Allowed: PDF, DOC/DOCX, XLS/XLSX, TXT. Max size: 10MB</small>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('admin/study-bank-pdfs/subcategory/'.$subcategory['id'].'/pdfs') ?>" 
                   class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Document
                </button>
            </div>
        </form>
    </div>
</div>

