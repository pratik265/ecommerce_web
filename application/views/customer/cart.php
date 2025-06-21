<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); }
        .cart-card { border-radius: 1rem; box-shadow: 0 4px 32px rgba(0,0,0,0.08); }
        .brand { font-size: 2rem; font-weight: bold; color: #4f46e5; }
        .product-img { height: 80px; width: 80px; object-fit: cover; border-radius: 0.5rem; }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <span class="brand">E-Shop</span>
        <a href="<?= base_url('customer/dashboard') ?>" class="btn btn-outline-primary">Continue Shopping</a>
    </div>
    <div class="cart-card p-4 bg-white">
        <h2 class="fw-bold mb-4">My Cart</h2>
        <?php if (!empty($cart)): ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($cart as $item): ?>
                            <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                            <tr>
                                <td><img src="<?= base_url('uploads/products/' . $item['image']) ?>" class="product-img" alt="<?= htmlspecialchars($item['name']) ?>"></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td>₹<?= number_format($item['price'], 2) ?></td>
                                <td><?= $item['quantity'] ?></td>
                                <td>₹<?= number_format($subtotal, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>₹<?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <a href="<?= base_url('customer/checkout') ?>" class="btn btn-primary btn-lg">Checkout</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Your cart is empty.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html> 