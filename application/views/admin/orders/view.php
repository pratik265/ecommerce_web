<h2 class="mb-4">Order Details</h2>
<?php if (!empty($order)): ?>
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Order Info</h5>
                <p><strong>Order #:</strong> <?= htmlspecialchars($order->order_number) ?></p>
                <p><strong>Status:</strong> <span class="badge bg-info text-dark"><?= ucfirst($order->status) ?></span></p>
                <p><strong>Date:</strong> <?= date('Y-m-d', strtotime($order->created_at)) ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">User Info</h5>
                <p><strong>Name:</strong> <?= htmlspecialchars($order->user_name ?? 'Guest') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($order->user_email ?? '-') ?></p>
                <p><strong>Shipping Address:</strong> <?= nl2br(htmlspecialchars($order->shipping_address)) ?></p>
                <p><strong>Payment Method:</strong> <?= htmlspecialchars($order->payment_method) ?></p>
            </div>
        </div>
    </div>
</div>
<h4 class="mb-3">Order Items</h4>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($order_items)): ?>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item->product_name) ?></td>
                    <td><?= $item->quantity ?></td>
                    <td><?= format_price($item->price) ?></td>
                    <td><?= format_price($item->price * $item->quantity) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="4" class="text-center">No items found.</td></tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="text-end">
    <strong>Total: <?= format_price($order->total_amount) ?></strong>
</div>
<?php else: ?>
    <div class="alert alert-danger">Order not found.</div>
<?php endif; ?> 