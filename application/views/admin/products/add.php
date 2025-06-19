<h2 class="mb-4">Add Product</h2>
<form action="<?= base_url('admin/add_product') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= set_value('name') ?>" required>
        <?= form_error('name', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required><?= set_value('description') ?></textarea>
        <?= form_error('description', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= set_value('price') ?>" required>
        <?= form_error('price', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="sale_price" class="form-label">Sale Price</label>
        <input type="number" step="0.01" class="form-control" id="sale_price" name="sale_price" value="<?= set_value('sale_price') ?>">
    </div>
    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select class="form-select" id="category_id" name="category_id" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat->id ?>" <?= set_select('category_id', $cat->id) ?>><?= htmlspecialchars($cat->name) ?></option>
            <?php endforeach; ?>
        </select>
        <?= form_error('category_id', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="stock_quantity" class="form-label">Stock Quantity</label>
        <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= set_value('stock_quantity') ?>" required>
        <?= form_error('stock_quantity', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Product Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
            <option value="active" <?= set_select('status', 'active', TRUE) ?>>Active</option>
            <option value="inactive" <?= set_select('status', 'inactive') ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Product</button>
    <a href="<?= base_url('admin/products') ?>" class="btn btn-secondary ms-2">Cancel</a>
</form> 