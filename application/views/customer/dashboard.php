<?php include(APPPATH.'views/customer/header.php'); ?>
<!-- Hero/Slider Section -->
<div class="container mb-4">
    <div class="row">
        <div class="col-12">
            <div id="customerHeroCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="p-5 text-center bg-primary text-white rounded shadow">
                            <h2 class="fw-bold mb-2">Welcome, <?= htmlspecialchars($this->session->userdata('customer_name')) ?>!</h2>
                            <p class="lead mb-0">Start shopping from our latest products below.</p>
                        </div>
                    </div>
                    <!-- You can add more slides here if you want dynamic slider images -->
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= base_url('customer/product/' . $product->id) ?>">
                            <img src="<?= base_url('uploads/products/' . $product->image) ?>" class="card-img-top product-img" alt="<?= htmlspecialchars($product->name) ?>">
                        </a>
                        <div class="card-body d-flex flex-column">
                            <a href="<?= base_url('customer/product/' . $product->id) ?>" style="text-decoration:none;color:inherit;">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($product->name) ?></h5>
                            </a>
                            <p class="card-text text-muted mb-2">Category: <?= htmlspecialchars($product->category_name) ?></p>
                            <div class="mb-2">
                                <span class="fw-bold text-success">₹<?= number_format($product->price, 2) ?></span>
                            </div>
                            <form method="post" action="<?= base_url('customer/add_to_cart/' . $product->id) ?>">
                                <button type="submit" class="btn btn-primary mt-auto">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">No products available.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include(APPPATH.'views/customer/footer.php'); ?> 