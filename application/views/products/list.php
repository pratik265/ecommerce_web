<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="fas fa-shopping-bag me-2"></i>All Products
            </h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card product-card h-100">
                                <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                                     class="card-img-top product-image" alt="<?= $product->name ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= $product->name ?></h5>
                                    <p class="card-text text-muted small"><?= $product->category_name ?></p>
                                    <p class="card-text small"><?= substr($product->description, 0, 80) ?>...</p>
                                    <div class="price mb-3">
                                        <?php if ($product->sale_price): ?>
                                            <span class="sale-price"><?= format_price($product->sale_price) ?></span>
                                            <span class="original-price ms-2"><?= format_price($product->price) ?></span>
                                        <?php else: ?>
                                            <span class="price"><?= format_price($product->price) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-auto">
                                        <a href="<?= base_url('product/' . $product->slug) ?>" class="btn btn-outline-primary btn-sm me-2">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                        <button onclick="addToCart(<?= $product->id ?>)" class="btn btn-primary btn-sm">
                                            <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                    <nav aria-label="Product pagination" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page - 1 ?>">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($current_page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $current_page + 1 ?>">
                                        Next <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h3 class="text-muted">No Products Found</h3>
                    <p class="text-muted">We couldn't find any products matching your criteria.</p>
                    <a href="<?= base_url('products') ?>" class="btn btn-primary">
                        <i class="fas fa-refresh me-2"></i>View All Products
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 