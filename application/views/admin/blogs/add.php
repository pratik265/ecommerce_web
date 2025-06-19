<h2 class="mb-4">Add Blog</h2>
<form action="<?= base_url('admin/add_blog') ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Blog Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title') ?>" required>
        <?= form_error('title', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="5" required><?= set_value('content') ?></textarea>
        <?= form_error('content', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Blog Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
            <option value="published" <?= set_select('status', 'published', TRUE) ?>>Published</option>
            <option value="draft" <?= set_select('status', 'draft') ?>>Draft</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Add Blog</button>
    <a href="<?= base_url('admin/blogs') ?>" class="btn btn-secondary ms-2">Cancel</a>
</form> 