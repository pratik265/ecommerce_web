<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); }
        .login-card { border-radius: 1rem; box-shadow: 0 4px 32px rgba(0,0,0,0.08); }
        .brand { font-size: 2rem; font-weight: bold; color: #4f46e5; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <span class="brand">E-Shop</span>
                    <h3 class="fw-bold mt-2">Customer Login</h3>
                    <p class="text-muted">Sign in to start shopping</p>
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                <?php endif; ?>
                <?= form_open('customer/login', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required autofocus>
                        <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-primary btn-lg">Login</button>
                    </div>
                <?= form_close() ?>
                <div class="text-center mt-3">
                    <span>Don't have an account? <a href="<?= base_url('customer/register') ?>" class="fw-bold text-primary">Register</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 