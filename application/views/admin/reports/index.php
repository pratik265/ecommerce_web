<h2 class="mb-4">Sales Reports & Analytics</h2>

<!-- Export Buttons -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="btn-group" role="group">
            <a href="<?= base_url('admin/export_reports_pdf') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>&year=<?= $year ?>" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?= base_url('admin/export_reports_excel') ?>?start_date=<?= $start_date ?>&end_date=<?= $end_date ?>&year=<?= $year ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <span class="badge bg-primary">Report Period: <?= date('M d, Y', strtotime($start_date)) ?> - <?= date('M d, Y', strtotime($end_date)) ?></span>
    </div>
</div>

<!-- Date Range Filter -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Filter Reports</h5>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" name="start_date" value="<?= $start_date ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" name="end_date" value="<?= $end_date ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <select class="form-select" name="year">
                            <?php for($y = date('Y'); $y >= date('Y')-5; $y--): ?>
                                <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Summary Statistics -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Revenue</h6>
                        <h3 class="mb-0"><?= format_price($order_stats['total_revenue']) ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Total Orders</h6>
                        <h3 class="mb-0"><?= $order_stats['total_orders'] ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Monthly Revenue</h6>
                        <h3 class="mb-0"><?= format_price($order_stats['monthly_revenue']) ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title">Monthly Orders</h6>
                        <h3 class="mb-0"><?= $order_stats['monthly_orders'] ?></h3>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-calendar fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock Information -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-success">Total Stock</h6>
                        <h4 class="mb-0"><?= $stock_stats['total_stock'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-boxes fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-warning">Low Stock</h6>
                        <h4 class="mb-0"><?= $stock_stats['low_stock_products'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-danger">Out of Stock</h6>
                        <h4 class="mb-0"><?= $stock_stats['out_of_stock_products'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-info">In Stock</h6>
                        <h4 class="mb-0"><?= $stock_stats['in_stock_products'] ?></h4>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Selling Products -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Top Selling Products</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($top_products)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Quantity Sold</th>
                                    <th>Total Revenue</th>
                                    <th>Average Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->name) ?></td>
                                        <td><span class="badge bg-primary"><?= $product->total_sold ?></span></td>
                                        <td><?= format_price($product->total_revenue) ?></td>
                                        <td><?= format_price($product->total_revenue / $product->total_sold) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No sales data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Stock Alerts -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-warning">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">Low Stock Products</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($low_stock_products)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Stock</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($low_stock_products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->name) ?></td>
                                        <td><span class="badge bg-warning"><?= $product->stock_quantity ?></span></td>
                                        <td>
                                            <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Update
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No low stock products.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Out of Stock Products</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($out_of_stock_products)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($out_of_stock_products as $product): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($product->name) ?></td>
                                        <td><span class="badge bg-danger">Out of Stock</span></td>
                                        <td>
                                            <a href="<?= base_url('admin/products/edit/' . $product->id) ?>" class="btn btn-sm btn-danger">
                                                <i class="fas fa-edit"></i> Restock
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No out of stock products.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Sales Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Monthly Sales Trend (<?= $year ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($monthly_sales)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Month</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                    <th>Average Order Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $months = array(
                                    1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                    5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                    9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                );
                                foreach ($monthly_sales as $sale): 
                                ?>
                                    <tr>
                                        <td><?= $months[$sale->month] ?></td>
                                        <td><?= $sale->total_orders ?></td>
                                        <td><?= format_price($sale->total_revenue) ?></td>
                                        <td><?= $sale->total_orders > 0 ? format_price($sale->total_revenue / $sale->total_orders) : '$0.00' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No monthly sales data available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Daily Sales -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Daily Sales (<?= date('M Y', strtotime($start_date)) ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($daily_sales)): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Orders</th>
                                    <th>Revenue</th>
                                    <th>Average Order Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($daily_sales as $sale): ?>
                                    <tr>
                                        <td><?= date('M d, Y', strtotime($sale->date)) ?></td>
                                        <td><?= $sale->total_orders ?></td>
                                        <td><?= format_price($sale->total_revenue) ?></td>
                                        <td><?= $sale->total_orders > 0 ? format_price($sale->total_revenue / $sale->total_orders) : '$0.00' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">No daily sales data available for the selected period.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 