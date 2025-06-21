<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); }
        .register-card { border-radius: 1rem; box-shadow: 0 4px 32px rgba(0,0,0,0.08); }
        .brand { font-size: 2rem; font-weight: bold; color: #4f46e5; }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-7 col-lg-6">
            <div class="card register-card p-4">
                <div class="text-center mb-4">
                    <span class="brand">E-Shop</span>
                    <h3 class="fw-bold mt-2">Customer Registration</h3>
                    <p class="text-muted">Create your account to start shopping</p>
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"> <?= $error ?> </div>
                <?php endif; ?>
                <?= form_open(current_url(), ['class' => 'needs-validation', 'novalidate' => '']) ?>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" required>
                            <?= form_error('name', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>" required>
                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <?= form_error('confirm_password', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= set_value('phone') ?>">
                            <?= form_error('phone', '<small class="text-danger">', '</small>') ?>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="1"><?= set_value('address') ?></textarea>
                            <?= form_error('address', '<small class="text-danger">', '</small>') ?>
                        </div>
                    </div>
                    <div class="d-grid mb-2">
                        <button type="submit" class="btn btn-primary btn-lg">Register</button>
                    </div>
                <?= form_close() ?>
                <div class="text-center mt-3">
                    <span>Already have an account? <a href="<?= base_url('customer/login') ?>" class="fw-bold text-primary">Login</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 