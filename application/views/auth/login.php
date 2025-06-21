<?php
$customer_login = (uri_string() === 'customer/login');
$form_action = $customer_login ? 'customer/login' : 'login';
$title = $customer_login ? 'Customer Login' : 'Welcome Back';
$register_url = $customer_login ? base_url('customer/register') : base_url('register');
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-user-circle fa-3x text-primary mb-3"></i>
                        <h3 class="fw-bold"><?= $title ?></h3>
                        <p class="text-muted">Sign in to your account</p>
                    </div>
                    
                    <?= form_open($form_action, ['class' => 'needs-validation', 'novalidate' => '']) ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= set_value('email') ?>" required>
                            </div>
                            <?= form_error('email', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <?= form_error('password', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </div>
                    <?= form_close() ?>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="mb-0">Don't have an account? 
                            <a href="<?= $register_url ?>" class="text-primary fw-bold">Sign up here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 