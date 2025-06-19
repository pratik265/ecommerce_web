<!-- Hero Section with Slider -->
<?php if (!empty($sliders)): ?>
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach ($sliders as $index => $slider): ?>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                    class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                    aria-label="Slide <?= $index + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <div class="carousel-inner">
        <?php foreach ($sliders as $index => $slider): ?>
            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                <div class="hero-section" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h1 class="display-4 fw-bold mb-4"><?= $slider->title ?></h1>
                                <p class="lead mb-4"><?= $slider->subtitle ?></p>
                                <a href="<?= base_url($slider->link) ?>" class="btn btn-light btn-lg">
                                    Shop Now <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                            <div class="col-lg-6">
                                <img src="<?= base_url('uploads/sliders/' . $slider->image) ?>" 
                                     alt="<?= $slider->title ?>" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<?php endif; ?>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-star text-warning me-2"></i>
                    Featured Products
                </h2>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($featured_products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                             class="card-img-top product-image" alt="<?= $product->name ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= $product->name ?></h5>
                            <p class="card-text text-muted small"><?= $product->category_name ?></p>
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
        
        <div class="text-center mt-4">
            <a href="<?= base_url('products') ?>" class="btn btn-primary btn-lg">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Sale Products Section -->
<?php if (!empty($sale_products)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-tags text-danger me-2"></i>
                    Special Offers
                </h2>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($sale_products as $product): ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="card product-card h-100">
                        <div class="position-relative">
                            <img src="<?= base_url('uploads/products/' . $product->image) ?>" 
                                 class="card-img-top product-image" alt="<?= $product->name ?>">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-2">SALE</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title"><?= $product->name ?></h6>
                            <div class="price mb-3">
                                <span class="sale-price"><?= format_price($product->sale_price) ?></span>
                                <span class="original-price ms-2"><?= format_price($product->price) ?></span>
                            </div>
                            <div class="mt-auto">
                                <button onclick="addToCart(<?= $product->id ?>)" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-cart-plus me-1"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Recent Blog Posts -->
<?php if (!empty($recent_blogs)): ?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="text-center mb-5">
                    <i class="fas fa-blog text-info me-2"></i>
                    Latest from Our Blog
                </h2>
            </div>
        </div>
        
        <div class="row">
            <?php foreach ($recent_blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if ($blog->image): ?>
                            <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" 
                                 class="card-img-top" style="height: 200px; object-fit: cover;" 
                                 alt="<?= $blog->title ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= $blog->title ?></h5>
                            <p class="card-text text-muted">
                                <?= substr(strip_tags($blog->content), 0, 100) ?>...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i><?= isset($blog->author_name) && $blog->author_name ? $blog->author_name : 'Admin' ?>
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= date('M d, Y', strtotime($blog->created_at)) ?>
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?= base_url('blog/' . $blog->slug) ?>" class="btn btn-outline-primary btn-sm">
                                Read More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= base_url('blogs') ?>" class="btn btn-outline-primary">
                View All Posts <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Features Section -->
<section class="py-5 bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h5>Free Shipping</h5>
                    <p class="text-muted">On orders over $50</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-undo fa-3x text-success mb-3"></i>
                    <h5>Easy Returns</h5>
                    <p class="text-muted">30 day return policy</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-shield-alt fa-3x text-warning mb-3"></i>
                    <h5>Secure Payment</h5>
                    <p class="text-muted">100% secure checkout</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <i class="fas fa-headset fa-3x text-info mb-3"></i>
                    <h5>24/7 Support</h5>
                    <p class="text-muted">Get help anytime</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chat Support Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4">
                    <i class="fas fa-comments text-success me-2"></i>
                    Need Help? Chat with Us!
                </h2>
                <p class="lead mb-4">
                    Have questions about our products or need assistance with your order? 
                    Our support team is here to help you 24/7 through our live chat system.
                </p>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock text-success me-3 fa-2x"></i>
                            <div>
                                <h6 class="mb-1">24/7 Availability</h6>
                                <small class="text-muted">Always here when you need us</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-bolt text-warning me-3 fa-2x"></i>
                            <div>
                                <h6 class="mb-1">Instant Response</h6>
                                <small class="text-muted">Get answers in real-time</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-tie text-primary me-3 fa-2x"></i>
                            <div>
                                <h6 class="mb-1">Expert Support</h6>
                                <small class="text-muted">Knowledgeable team members</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-mobile-alt text-info me-3 fa-2x"></i>
                            <div>
                                <h6 class="mb-1">Mobile Friendly</h6>
                                <small class="text-muted">Chat on any device</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="chat-preview-card">
                    <div class="chat-header-preview">
                        <div class="d-flex align-items-center justify-content-center">
                            <div class="chat-avatar me-3">
                                <i class="fas fa-headset"></i>
                            </div>
                            <div class="text-start">
                                <h5 class="mb-0 text-white">Admin Support</h5>
                                <small class="text-white-50">Online</small>
                            </div>
                        </div>
                    </div>
                    <div class="chat-body-preview">
                        <div class="message-preview received">
                            <div class="message-content-preview">
                                Hi! How can I help you today? 😊
                            </div>
                        </div>
                        <div class="message-preview sent">
                            <div class="message-content-preview">
                                I have a question about my order
                            </div>
                        </div>
                    </div>
                    <div class="chat-footer-preview">
                        <a href="<?= base_url('chat') ?>" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-comments me-2"></i>
                            Start Chat Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.chat-preview-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    overflow: hidden;
    max-width: 400px;
    margin: 0 auto;
}

.chat-header-preview {
    background: #25D366;
    padding: 20px;
}

.chat-avatar {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
}

.chat-body-preview {
    padding: 20px;
    background: #f0f0f0;
    min-height: 200px;
}

.message-preview {
    margin-bottom: 15px;
    display: flex;
    align-items: flex-end;
    gap: 8px;
}

.message-preview.sent {
    justify-content: flex-end;
}

.message-preview.received {
    justify-content: flex-start;
}

.message-content-preview {
    max-width: 70%;
    padding: 10px 14px;
    border-radius: 18px;
    font-size: 14px;
}

.message-preview.sent .message-content-preview {
    background: #007bff;
    color: white;
    border-bottom-right-radius: 5px;
}

.message-preview.received .message-content-preview {
    background: white;
    color: #000;
    border-bottom-left-radius: 5px;
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
}

.chat-footer-preview {
    padding: 20px;
    background: white;
}
</style> 