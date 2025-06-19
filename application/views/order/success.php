<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Success Message -->
            <div class="text-center mb-5">
                <div class="success-icon mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="text-success mb-3">Order Placed Successfully!</h1>
                <p class="lead text-muted">Thank you for your order. We'll process it right away.</p>
            </div>
            
            <!-- Order Details Card -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-receipt me-2"></i>Order Details
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Order Number:</strong> <?= $order->order_number ?></p>
                            <p><strong>Order Date:</strong> <?= date('F j, Y', strtotime($order->created_at)) ?></p>
                            <p><strong>Order Status:</strong> 
                                <span class="badge bg-<?= $order->status == 'pending' ? 'warning' : ($order->status == 'delivered' ? 'success' : 'info') ?>">
                                    <?= ucfirst($order->status) ?>
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Amount:</strong> <span class="fs-5 fw-bold text-primary"><?= format_price($order->total_amount) ?></span></p>
                            <p><strong>Payment Method:</strong> <?= ucfirst($order->payment_method) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-shipping-fast me-2"></i>Shipping Address
                    </h6>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br($order->shipping_address) ?></p>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-box me-2"></i>Order Items
                    </h6>
                </div>
                <div class="card-body">
                    <?php foreach ($order_items as $item): ?>
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-8">
                                <h6 class="mb-1"><?= $item->product_name ?></h6>
                                <p class="text-muted mb-0">Quantity: <?= $item->quantity ?></p>
                            </div>
                            <div class="col-md-4 text-end">
                                <strong><?= format_price($item->price * $item->quantity) ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="row mt-3">
                        <div class="col-md-8 text-end">
                            <strong>Total:</strong>
                        </div>
                        <div class="col-md-4 text-end">
                            <strong class="fs-5 text-primary"><?= format_price($order->total_amount) ?></strong>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Next Steps -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>What's Next?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-icon mb-2">
                                <i class="fas fa-envelope text-primary" style="font-size: 2rem;"></i>
                            </div>
                            <h6>Order Confirmation</h6>
                            <p class="small text-muted">You'll receive an email confirmation shortly.</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-icon mb-2">
                                <i class="fas fa-cog text-warning" style="font-size: 2rem;"></i>
                            </div>
                            <h6>Processing</h6>
                            <p class="small text-muted">We'll process your order within 24 hours.</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="step-icon mb-2">
                                <i class="fas fa-truck text-success" style="font-size: 2rem;"></i>
                            </div>
                            <h6>Shipping</h6>
                            <p class="small text-muted">Your order will be shipped within 2-3 business days.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="text-center">
                <div class="d-grid gap-2 d-md-block">
                    <a href="<?= base_url() ?>" class="btn btn-primary btn-lg me-md-2">
                        <i class="fas fa-home me-2"></i>Continue Shopping
                    </a>
                    <a href="<?= base_url('profile') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user me-2"></i>My Account
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.success-icon {
    animation: bounce 1s ease-in-out;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    60% {
        transform: translateY(-5px);
    }
}

.step-icon {
    transition: transform 0.3s ease;
}

.step-icon:hover {
    transform: scale(1.1);
}
</style> 