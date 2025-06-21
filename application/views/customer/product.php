<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product->name) ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); }
        .brand { font-size: 2rem; font-weight: bold; color: #4f46e5; }
        .product-img-lg { width: 100%; max-width: 400px; height: 350px; object-fit: cover; border-radius: 1rem; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="brand">E-Shop</span>
        <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-primary">Back to Products</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 shadow-lg">
                <div class="row g-4 align-items-center">
                    <div class="col-md-5 text-center">
                        <img src="<?= base_url('uploads/products/' . $product->image) ?>" class="product-img-lg mb-3 mb-md-0" alt="<?= htmlspecialchars($product->name) ?>">
                    </div>
                    <div class="col-md-7">
                        <h2 class="fw-bold mb-2"><?= htmlspecialchars($product->name) ?></h2>
                        <p class="text-muted mb-1">Category: <?= htmlspecialchars($product->category_name) ?></p>
                        <h4 class="text-success mb-3">₹<?= number_format($product->price, 2) ?></h4>
                        <p><?= nl2br(htmlspecialchars($product->description)) ?></p>
                        <form method="post" action="<?= base_url('customer/add_to_cart/' . $product->id) ?>">
                            <button type="submit" class="btn btn-primary btn-lg mt-2">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html> 