<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Documents - <?= esc($category['name']) ?></h5>
        <div class="d-flex gap-2">
            <a href="<?= base_url('admin/study-bank-pdfs') ?>" class="btn btn-secondary btn-sm">Back to Categories</a>
            <a href="<?= base_url('admin/study-bank-pdfs/category/'.$category['id'].'/upload') ?>" class="btn btn-primary btn-sm">Upload Document</a>
        </div>
    </div>
    <div class="card-body">
        <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if (!empty($pdfs)): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subcategory</th>
                        <th>File Name</th>
                        <th>Size</th>
                        <th>Uploaded</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pdfs as $pdf): ?>
                    <tr>
                        <td>
                            <strong><?= esc($pdf['title']) ?></strong>
                            <?php if (!empty($pdf['description'])): ?>
                                <br><small class="text-muted"><?= esc(substr($pdf['description'], 0, 80)) ?><?= strlen($pdf['description']) > 80 ? '...' : '' ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($subcategoryMap[(int)$pdf['subcategory_id']] ?? '—') ?></td>
                        <td><?= esc($pdf['file_name']) ?></td>
                        <td><?= number_format($pdf['file_size'] / 1024, 2) ?> KB</td>
                        <td><?= date('M d, Y', strtotime($pdf['created_at'])) ?></td>
                        <td class="text-end">
                            <a href="<?= base_url('admin/study-bank-pdfs/pdf/'.$pdf['id'].'/edit') ?>" 
                               class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                            <a href="<?= base_url('admin/study-bank-pdfs/pdf/'.$pdf['id'].'/delete') ?>" 
                               class="btn btn-sm btn-danger" onclick="return confirm('Delete this document?')" title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="text-center text-muted py-5">
            <i class="fas fa-file fa-3x mb-3"></i>
            <p>No documents uploaded in this category yet.</p>
            <a href="<?= base_url('admin/study-bank-pdfs/category/'.$category['id'].'/upload') ?>" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload First Document
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>


