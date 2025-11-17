<div class="admin-content">
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <p class="mb-2">Upload a CSV exported from Excel. The CSV must include a header row with the following columns:</p>
            <pre class="bg-light p-3 border rounded small">type, stem, rationale, choice_a, choice_b, choice_c, choice_d, correct</pre>
            <p class="text-muted small mb-3">
                - <strong>type</strong>: mcq or sata
                <br>- <strong>correct</strong>: For MCQ use a single letter (e.g., A). For SATA separate with comma or semicolon (e.g., A;C).
                <br>- <strong>Optional</strong>: You can add <code>choice_e</code> and <code>choice_f</code> columns.
            </p>
            <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions/import/sample') ?>" class="btn btn-outline-secondary btn-sm mb-3">
                <i class="fas fa-download me-1"></i>Download sample CSV
            </a>

            <form action="<?= base_url('admin/tests/' . $test['id'] . '/questions/import') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label">CSV File</label>
                    <input type="file" name="csv_file" accept=".csv" class="form-control" required>
                    <div class="form-text">Only .csv files are supported. In Excel, choose “Save As” → CSV (Comma delimited) (*.csv).</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Import
                    </button>
                    <a href="<?= base_url('admin/tests/' . $test['id'] . '/questions') ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


