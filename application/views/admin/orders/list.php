<h2 class="mb-4">Order Management</h2>

<!-- Export Buttons -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="btn-group" role="group">
            <a href="<?= base_url('admin/export_orders_pdf') ?>" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?= base_url('admin/export_orders_excel') ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <span class="badge bg-primary">Total Orders: <?= count($orders) ?></span>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <strong><?= htmlspecialchars($order->order_number) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($order->customer_name ?? 'Guest') ?></td>
                                <td><?= htmlspecialchars($order->customer_email ?? 'N/A') ?></td>
                                <td>
                                    <span class="fw-bold text-primary">
                                        <?= format_price($order->total_amount) ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="<?= base_url('admin/update_order_status/' . $order->id) ?>" class="d-inline">
                                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                            <option value="pending" <?= $order->status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="processing" <?= $order->status == 'processing' ? 'selected' : '' ?>>Processing</option>
                                            <option value="shipped" <?= $order->status == 'shipped' ? 'selected' : '' ?>>Shipped</option>
                                            <option value="delivered" <?= $order->status == 'delivered' ? 'selected' : '' ?>>Delivered</option>
                                            <option value="cancelled" <?= $order->status == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?= date('M d, Y H:i', strtotime($order->created_at)) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/orders/view/' . $order->id) ?>" class="btn btn-info btn-sm" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/export_order_pdf/' . $order->id) ?>" class="btn btn-danger btn-sm" title="Export PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                                <p>No orders found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Auto-submit form when status changes
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('select[name="status"]');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.form.submit();
        });
    });
});
</script> 