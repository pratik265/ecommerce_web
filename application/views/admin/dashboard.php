<h1 class="mb-4">Welcome to the Admin Dashboard</h1>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Users</h6>
                        <h3 class="mb-0"><?= $total_users ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Products</h6>
                        <h3 class="mb-0"><?= $total_products ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Orders</h6>
                        <h3 class="mb-0"><?= $stats['total_orders'] ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Revenue</h6>
                        <h3 class="mb-0"><?= format_price($stats['total_revenue']) ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Status Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-warning">Pending Orders</h6>
                        <h4 class="mb-0"><?= $stats['pending_orders'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-success">Completed Orders</h6>
                        <h4 class="mb-0"><?= $stats['completed_orders'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-info">Total Stock</h6>
                        <h4 class="mb-0"><?= $stock_stats['total_stock'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-danger shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-danger">Low Stock Alert</h6>
                        <h4 class="mb-0"><?= $stock_stats['low_stock_products'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chat Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-primary shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-primary">Chat Messages</h6>
                        <h4 class="mb-0">
                            <?php 
                            $this->load->model('Chat_model');
                            $chat_stats = $this->Chat_model->get_chat_stats();
                            echo $chat_stats['unread_messages'];
                            ?>
                        </h4>
                        <small class="text-muted">Unread</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-comments fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-info shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-info">Chat Rooms</h6>
                        <h4 class="mb-0"><?= $chat_stats['total_rooms'] ?></h4>
                        <small class="text-muted">Active</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-success shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-success">Today's Messages</h6>
                        <h4 class="mb-0"><?= $chat_stats['today_messages'] ?></h4>
                        <small class="text-muted">New</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar-day fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-warning shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-warning">Total Messages</h6>
                        <h4 class="mb-0"><?= $chat_stats['total_messages'] ?></h4>
                        <small class="text-muted">All Time</small>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-comment-dots fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Recent Orders</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($recent_orders)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_orders as $order): ?>
                                    <tr>
                                        <td><?= $order->order_number ?></td>
                                        <td><?= $order->customer_name ?></td>
                                        <td><?= format_price($order->total_amount) ?></td>
                                        <td>
                                            <span class="badge bg-<?= $order->status == 'delivered' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') ?>">
                                                <?= ucfirst($order->status) ?>
                                            </span>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($order->created_at)) ?></td>
                                        <td>
                                            <a href="<?= base_url('admin/orders/view/' . $order->id) ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No recent orders found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/products/add') ?>" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Add Product
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/orders') ?>" class="btn btn-info w-100">
                            <i class="fas fa-list"></i> View Orders
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/reports') ?>" class="btn btn-success w-100">
                            <i class="fas fa-chart-bar"></i> View Reports
                        </a>
                    </div>
                    <div class="col-md-3 mb-2">
                        <a href="<?= base_url('admin/users') ?>" class="btn btn-warning w-100">
                            <i class="fas fa-users"></i> Manage Users
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<p class="mt-4">Use the sidebar to manage users, products, blogs, orders, and view reports.</p> 