<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
            </h1>
        </div>
    </div>
    
    <?php if (!empty($cart_items)): ?>
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Cart Items (<?= count($cart_items) ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="row align-items-center mb-3 pb-3 border-bottom" data-product-id="<?= $item['id'] ?>">
                                <div class="col-md-2">
                                    <img src="<?= base_url('uploads/products/' . $item['image']) ?>" 
                                         class="img-fluid rounded" alt="<?= $item['name'] ?>">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1"><?= $item['name'] ?></h6>
                                    <p class="text-muted mb-0">Price: <?= format_price($item['price']) ?></p>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                onclick="updateCartQuantity(<?= $item['id'] ?>, <?= $item['quantity'] - 1 ?>)">-</button>
                                        <input type="number" class="form-control text-center" value="<?= $item['quantity'] ?>" 
                                               min="1" onchange="updateCartQuantity(<?= $item['id'] ?>, this.value)">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" 
                                                onclick="updateCartQuantity(<?= $item['id'] ?>, <?= $item['quantity'] + 1 ?>)">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <strong class="item-total"><?= format_price($item['price'] * $item['quantity']) ?></strong>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-outline-danger btn-sm" 
                                            onclick="if(confirmDelete()) window.location.href='<?= base_url('remove_from_cart/' . $item['id']) ?>'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <!-- Cart Summary -->
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
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="subtotal-amount"><?= format_price($subtotal) ?></span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span class="shipping-amount"><?= $shipping > 0 ? format_price($shipping) : 'FREE' ?></span>
                        </div>
                        
                        <?php if ($shipping > 0): ?>
                            <div class="alert alert-info small free-shipping-alert">
                                <i class="fas fa-info-circle me-1"></i>
                                Add <?= format_price(50 - $subtotal) ?> more for free shipping!
                            </div>
                        <?php endif; ?>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="fs-5 total-amount"><?= format_price($total) ?></strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('checkout') ?>" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Proceed to Checkout
                            </a>
                            <a href="<?= base_url('products') ?>" class="btn btn-outline-primary">
                                <i class="fas fa-shopping-bag me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Methods -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">Accepted Payment Methods</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-3">
                                <i class="fab fa-cc-visa fa-2x text-primary"></i>
                            </div>
                            <div class="col-3">
                                <i class="fab fa-cc-mastercard fa-2x text-warning"></i>
                            </div>
                            <div class="col-3">
                                <i class="fab fa-cc-paypal fa-2x text-info"></i>
                            </div>
                            <div class="col-3">
                                <i class="fab fa-cc-apple-pay fa-2x text-dark"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">Your Cart is Empty</h3>
            <p class="text-muted">Looks like you haven't added any products to your cart yet.</p>
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for AJAX Cart Updates -->
<script>
function updateCartQuantity(productId, quantity) {
    // Prevent negative quantities
    if (quantity < 1) {
        quantity = 1;
    }
    
    // Show loading state
    const productRow = document.querySelector(`[data-product-id="${productId}"]`);
    const quantityInput = productRow.querySelector('input[type="number"]');
    const originalValue = quantityInput.value;
    quantityInput.disabled = true;
    
    // Make AJAX request
    fetch('<?= base_url("update_cart") ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: `product_id=${productId}&quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count in header
            const cartBadge = document.querySelector('.cart-badge');
            if (cartBadge) {
                cartBadge.textContent = data.cart_count;
            }
            
            // Update item total
            const itemTotalElement = productRow.querySelector('.item-total');
            if (itemTotalElement) {
                itemTotalElement.textContent = data.item_total;
            }
            
            // Update cart summary
            updateCartSummary();
            
            // Show success message
            showMessage(data.message, 'success');
        } else {
            // Show error message
            showMessage(data.message, 'error');
            // Revert quantity input
            quantityInput.value = originalValue;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Failed to update cart. Please try again.', 'error');
        // Revert quantity input
        quantityInput.value = originalValue;
    })
    .finally(() => {
        // Re-enable quantity input
        quantityInput.disabled = false;
    });
}

function updateCartSummary() {
    // Recalculate cart summary
    let subtotal = 0;
    const itemTotals = document.querySelectorAll('.item-total');
    
    itemTotals.forEach(element => {
        const priceText = element.textContent.replace(/[^0-9.]/g, '');
        subtotal += parseFloat(priceText) || 0;
    });
    
    // Update subtotal
    const subtotalElement = document.querySelector('.subtotal-amount');
    if (subtotalElement) {
        subtotalElement.textContent = '$' + subtotal.toFixed(2);
    }
    
    // Update shipping
    const shipping = subtotal > 50 ? 0 : 10;
    const shippingElement = document.querySelector('.shipping-amount');
    if (shippingElement) {
        shippingElement.textContent = shipping > 0 ? '$' + shipping.toFixed(2) : 'FREE';
    }
    
    // Update total
    const total = subtotal + shipping;
    const totalElement = document.querySelector('.total-amount');
    if (totalElement) {
        totalElement.textContent = '$' + total.toFixed(2);
    }
    
    // Update free shipping message
    const freeShippingAlert = document.querySelector('.free-shipping-alert');
    if (freeShippingAlert) {
        if (shipping > 0) {
            const remaining = 50 - subtotal;
            freeShippingAlert.innerHTML = `<i class="fas fa-info-circle me-1"></i>Add $${remaining.toFixed(2)} more for free shipping!`;
            freeShippingAlert.style.display = 'block';
        } else {
            freeShippingAlert.style.display = 'none';
        }
    }
}

function showMessage(message, type) {
    // Create message element
    const messageDiv = document.createElement('div');
    messageDiv.className = `alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show position-fixed`;
    messageDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    messageDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(messageDiv);
    
    // Remove after 3 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 3000);
}

function confirmDelete() {
    return confirm('Are you sure you want to remove this item from your cart?');
}
</script> 