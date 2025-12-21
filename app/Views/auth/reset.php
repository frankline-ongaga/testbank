<section class="py-5" style="background:#f9fafb;">
    <div class="container d-flex justify-content-center" style="min-height:60vh;">
        <div class="card shadow-sm border-0" style="max-width:480px; width:100%; border-radius:16px;">
            <div class="card-body p-4 p-md-5">
                <h2 class="mb-3">Reset your password</h2>
                <p class="text-muted mb-4" style="font-size:0.95rem;">
                    Choose a new password for your NCLEX Prep Course account.
                </p>

                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                <li><?= esc($e) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('reset/' . esc($token)) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">New password</label>
                        <input type="password" name="password" class="form-control" required placeholder="Enter a new password" />
                    </div>
                    <div class="d-flex gap-2 align-items-center mt-3">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                        <a href="<?= base_url('login/student') ?>" class="btn btn-link">Back to login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>



