<?php include(APPPATH.'views/customer/header.php'); ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm p-4 mb-4">
                <h2 class="fw-bold mb-4">Checkout</h2>
                <form method="post" action="<?= base_url('customer/place_order') ?>">
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="2" required><?= set_value('shipping_address') ?></textarea>
                        <?= form_error('shipping_address', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="cod">Cash on Delivery</option>
                            <option value="card">Credit/Debit Card</option>
                            <option value="upi">UPI</option>
                        </select>
                        <?= form_error('payment_method', '<small class="text-danger">', '</small>') ?>
                    </div>
                    <hr>
                    <h5 class="mb-3">Order Summary</h5>
                    <div class="table-responsive mb-3">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                <?php foreach ($cart as $item): ?>
                                    <?php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; ?>
                                    <tr>
                                        <td><img src="<?= base_url('uploads/products/' . $item['image']) ?>" style="height: 50px; width: 50px; object-fit: cover;" alt="<?= htmlspecialchars($item['name']) ?>"></td>
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
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Place Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include(APPPATH.'views/customer/footer.php'); ?> 