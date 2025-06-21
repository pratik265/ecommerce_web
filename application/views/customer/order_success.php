<?php include(APPPATH.'views/customer/header.php'); ?>
<div class="container py-5 text-center">
    <div class="card shadow-sm p-5 mx-auto" style="max-width: 500px;">
        <div class="mb-4">
            <i class="fas fa-check-circle fa-4x text-success"></i>
        </div>
        <h2 class="fw-bold mb-3">Order Placed Successfully!</h2>
        <p class="lead mb-4">Thank you for your purchase. Your order has been placed and will be processed soon.</p>
        <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-primary btn-lg">Go to Dashboard</a>
    </div>
</div>
<?php include(APPPATH.'views/customer/footer.php'); ?> 