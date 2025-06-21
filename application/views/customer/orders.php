<div class="container my-5">
    <h2 class="mb-4">My Orders</h2>
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!empty($orders)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?= htmlspecialchars($order->id) ?></td>
                                    <td><?= date('F j, Y, g:i a', strtotime($order->created_at)) ?></td>
                                    <td>$<?= number_format($order->total_amount, 2) ?></td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="<?= base_url('customer/order/' . $order->id) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center p-4">
                    <p class="text-muted">You have no orders yet.</p>
                    <a href="<?= base_url() ?>" class="btn btn-primary">Start Shopping</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 