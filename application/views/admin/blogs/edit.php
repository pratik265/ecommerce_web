<h2 class="mb-4">Edit Blog</h2>
<form action="<?= base_url('admin/edit_blog/' . $blog->id) ?>" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">Blog Title</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= set_value('title', $blog->title) ?>" required>
        <?= form_error('title', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="5" required><?= set_value('content', $blog->content) ?></textarea>
        <?= form_error('content', '<div class="text-danger small">', '</div>') ?>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Blog Image</label>
        <?php if ($blog->image): ?>
            <div class="mb-2">
                <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" alt="Current Image" style="max-width:120px;max-height:120px;">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
            <option value="published" <?= set_select('status', 'published', $blog->status == 'published') ?>>Published</option>
            <option value="draft" <?= set_select('status', 'draft', $blog->status == 'draft') ?>>Draft</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update Blog</button>
    <a href="<?= base_url('admin/blogs') ?>" class="btn btn-secondary ms-2">Cancel</a>
</form> 