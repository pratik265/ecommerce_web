<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Order Details</h2>
        <a href="<?= base_url('customer/orders') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Back to Orders</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Order #<?= htmlspecialchars($order->id) ?></h5>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($order->created_at)) ?></p>
                    <p><strong>Total Amount:</strong> $<?= number_format($order->total_amount, 2) ?></p>
                    <p><strong>Status:</strong> 
                        <span class="badge 
                            <?php 
                                switch($order->status) {
                                    case 'pending': echo 'bg-warning text-dark'; break;
                                    case 'processing': echo 'bg-info text-dark'; break;
                                    case 'shipped': echo 'bg-primary'; break;
                                    case 'completed': echo 'bg-success'; break;
                                    case 'cancelled': echo 'bg-danger'; break;
                                    default: echo 'bg-secondary';
                                }
                            ?>">
                            <?= ucfirst(htmlspecialchars($order->status)) ?>
                        </span>
                    </p>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Items Ordered</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($order->items as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?= base_url('uploads/products/' . htmlspecialchars($item->image)) ?>" alt="<?= htmlspecialchars($item->name) ?>" class="img-fluid rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                            <span><?= htmlspecialchars($item->name) ?></span>
                                        </div>
                                    </td>
                                    <td>$<?= number_format($item->price, 2) ?></td>
                                    <td><?= htmlspecialchars($item->quantity) ?></td>
                                    <td>$<?= number_format($item->price * $item->quantity, 2) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Address:</strong><br><?= nl2br(htmlspecialchars($order->shipping_address)) ?></p>
                    <p><strong>Payment Method:</strong><br><?= ucfirst(str_replace('_', ' ', htmlspecialchars($order->payment_method))) ?></p>
                </div>
            </div>
        </div>
    </div>
</div> 