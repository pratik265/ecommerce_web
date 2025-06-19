<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-credit-card me-2"></i>Checkout
            </h1>
        </div>
    </div>
    
    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <?= form_open('place_order', ['class' => 'needs-validation', 'novalidate' => '']) ?>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?= $user->name ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= $user->email ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" 
                                   value="<?= $user->phone ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address</label>
                            <textarea class="form-control" id="shipping_address" name="shipping_address" 
                                      rows="3" required><?= $user->address ?></textarea>
                            <?= form_error('shipping_address', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">Select payment method</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cash_on_delivery">Cash on Delivery</option>
                            </select>
                            <?= form_error('payment_method', '<small class="text-danger">', '</small>') ?>
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Order Notes (Optional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" 
                                      placeholder="Any special instructions for delivery..."></textarea>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and 
                                <a href="#" class="text-primary">Privacy Policy</a>
                            </label>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Place Order
                            </button>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php 
                    $subtotal = 0;
                    foreach ($cart_items as $item) {
                        $subtotal += $item['price'] * $item['quantity'];
                    }
                    $shipping = $subtotal > 50 ? 0 : 10;
                    $total = $subtotal + $shipping;
                    ?>
                    
                    <!-- Cart Items -->
                    <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <h6 class="mb-0"><?= $item['name'] ?></h6>
                                <small class="text-muted">Qty: <?= $item['quantity'] ?></small>
                            </div>
                            <span><?= format_price($item['price'] * $item['quantity']) ?></span>
                        </div>
                    <?php endforeach; ?>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span><?= format_price($subtotal) ?></span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span><?= $shipping > 0 ? format_price($shipping) : 'FREE' ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="fs-5"><?= format_price($total) ?></strong>
                    </div>
                    
                    <!-- Security Info -->
                    <div class="alert alert-info small">
                        <i class="fas fa-shield-alt me-2"></i>
                        Your payment information is secure and encrypted.
                    </div>
                </div>
            </div>
            
            <!-- Return Policy -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Return Policy</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-check text-success me-2"></i>30-day return policy</li>
                        <li><i class="fas fa-check text-success me-2"></i>Free returns on most items</li>
                        <li><i class="fas fa-check text-success me-2"></i>Full refund guarantee</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> 