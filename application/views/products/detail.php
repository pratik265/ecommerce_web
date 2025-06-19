<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('products') ?>">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $product->name ?></li>
        </ol>
    </nav>
    
    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="card border-0">
                <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                     class="img-fluid rounded" alt="<?= $product->name ?>">
            </div>
        </div>
        
        <!-- Product Details -->
        <div class="col-lg-6">
            <h1 class="mb-3"><?= $product->name ?></h1>
            
            <div class="mb-3">
                <span class="badge bg-secondary me-2"><?= $product->category_name ?></span>
                <?php if ($product->sale_price): ?>
                    <span class="badge bg-danger">SALE</span>
                <?php endif; ?>
            </div>
            
            <div class="price mb-4">
                <?php if ($product->sale_price): ?>
                    <span class="sale-price fs-2"><?= format_price($product->sale_price) ?></span>
                    <span class="original-price fs-5 ms-3"><?= format_price($product->price) ?></span>
                    <div class="mt-2">
                        <span class="badge bg-success">
                            Save <?= format_price($product->price - $product->sale_price) ?>
                        </span>
                    </div>
                <?php else: ?>
                    <span class="price fs-2"><?= format_price($product->price) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="mb-4">
                <h5>Description</h5>
                <p class="text-muted"><?= nl2br($product->description) ?></p>
            </div>
            
            <div class="mb-4">
                <h5>Stock Status</h5>
                <?php if ($product->stock_quantity > 0): ?>
                    <span class="badge bg-success">In Stock (<?= $product->stock_quantity ?> available)</span>
                <?php else: ?>
                    <span class="badge bg-danger">Out of Stock</span>
                <?php endif; ?>
            </div>
            
            <?php if ($product->stock_quantity > 0): ?>
                <div class="mb-4">
                    <h5>Quantity</h5>
                    <div class="input-group" style="width: 150px;">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(-1)">-</button>
                        <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="<?= $product->stock_quantity ?>">
                        <button class="btn btn-outline-secondary" type="button" onclick="updateQuantity(1)">+</button>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button onclick="addToCartWithQuantity()" class="btn btn-primary btn-lg">
                        <i class="fas fa-cart-plus me-2"></i>Add to Cart
                    </button>
                    <a href="<?= base_url('cart') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-cart me-2"></i>View Cart
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    This product is currently out of stock. Please check back later.
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Related Products -->
    <?php if (!empty($related_products)): ?>
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">
                    <i class="fas fa-star text-warning me-2"></i>Related Products
                </h3>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($related_products as $related): ?>
                <?php if ($related->id != $product->id): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card product-card h-100">
                            <img src="<?= base_url('uploads/products/' . $related->image) ?>" 
                                 class="card-img-top product-image" alt="<?= $related->name ?>">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?= $related->name ?></h6>
                                <div class="price mb-3">
                                    <?php if ($related->sale_price): ?>
                                        <span class="sale-price"><?= format_price($related->sale_price) ?></span>
                                        <span class="original-price ms-2"><?= format_price($related->price) ?></span>
                                    <?php else: ?>
                                        <span class="price"><?= format_price($related->price) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-auto">
                                    <a href="<?= base_url('product/' . $related->slug) ?>" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <button onclick="addToCart(<?= $related->id ?>)" class="btn btn-primary btn-sm">
                                        <i class="fas fa-cart-plus me-1"></i>Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script>
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + change;
    const maxValue = parseInt(quantityInput.max);
    
    if (newValue >= 1 && newValue <= maxValue) {
        quantityInput.value = newValue;
    }
}

function addToCartWithQuantity() {
    const quantity = document.getElementById('quantity').value;
    addToCart(<?= $product->id ?>, quantity);
}
</script> 