<div class="container py-5" style="max-width:720px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Logo" style="width:40px; height:40px;" class="me-2">
                        <h3 class="mb-0"><?= esc($title ?? 'Login') ?></h3>
                    </div>
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('message')): ?>
                    <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= esc($loginAction ?? '/login/student') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="name@example.com" required />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="••••••••" required />
                        </div>
                        <div class="d-flex gap-2 align-items-center mb-2">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="/register" class="btn btn-link p-0">Create account</a>
                            <a href="/forgot" class="btn btn-link p-0">Forgot password?</a>
                        </div>
                        <?php if (($loginRole ?? 'student') === 'student'): ?>
                            <div class="mt-3">
                                <a href="/auth/google" class="btn btn-outline-danger w-100"><i class="fa-brands fa-google me-2"></i>Sign in with Google</a>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <ul class="text-danger mt-3">
                                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                    <li><?= esc($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="text-center mt-3 text-muted small">
                Secure student access to the NCLEX Test Bank
            </div>
        </div>
    </div>
</div>


