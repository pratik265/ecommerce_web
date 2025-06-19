<h2 class="mb-4">Blog Management</h2>
<a href="<?= base_url('admin/add_blog') ?>" class="btn btn-primary mb-3">Add Blog</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>Status</th>
            <th>Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <td><?= $blog->id ?></td>
                    <td><?= htmlspecialchars($blog->title) ?></td>
                    <td><?= htmlspecialchars($blog->author_name) ?></td>
                    <td>
                        <?php if ($blog->status == 'published'): ?>
                            <span class="badge bg-success">Published</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Draft</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('Y-m-d', strtotime($blog->created_at)) ?></td>
                    <td>
                        <a href="<?= base_url('admin/edit_blog/' . $blog->id) ?>" class="btn btn-info btn-sm">Edit</a>
                        <a href="<?= base_url('admin/delete_blog/' . $blog->id) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No blogs found.</td></tr>
        <?php endif; ?>
    </tbody>
</table> 