<h2 class="mb-4">Product Management</h2>

<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-md-6">
        <a href="<?= base_url('admin/add_product') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="col-md-6 text-end">
        <div class="btn-group" role="group">
            <a href="<?= base_url('admin/export_products_pdf') ?>" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
            <a href="<?= base_url('admin/export_products_excel') ?>" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?= $product->id ?></td>
                                <td><?= htmlspecialchars($product->name) ?></td>
                                <td><?= htmlspecialchars($product->category_name) ?></td>
                                <td><?= format_price($product->price) ?></td>
                                <td>
                                    <?php if ($product->stock_quantity <= 10): ?>
                                        <span class="badge bg-warning"><?= $product->stock_quantity ?></span>
                                    <?php elseif ($product->stock_quantity == 0): ?>
                                        <span class="badge bg-danger">Out of Stock</span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $product->stock_quantity ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($product->status == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= base_url('admin/edit_product/' . $product->id) ?>" class="btn btn-info btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/delete_product/' . $product->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-box fa-3x mb-3"></i>
                                <p>No products found.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div> 