<?php include(APPPATH.'views/customer/header.php'); ?>
<div class="container py-4">
    <h2 class="fw-bold mb-4 text-center"><i class="fas fa-blog text-info me-2"></i>Our Blogs</h2>
    <div class="row g-4">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <?php if ($blog->image): ?>
                            <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($blog->title) ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2"><?= htmlspecialchars($blog->title) ?></h5>
                            <p class="card-text text-muted small mb-2">
                                <?= substr(strip_tags($blog->content), 0, 100) ?>...
                            </p>
                            <div class="mb-2">
                                <small class="text-muted"><i class="fas fa-user me-1"></i><?= $blog->author_name ?? 'Admin' ?></small>
                                <small class="text-muted ms-3"><i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($blog->created_at)) ?></small>
                            </div>
                            <a href="<?= base_url('customer/blog/' . $blog->id) ?>" class="btn btn-outline-primary mt-auto">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">No blogs found.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php include(APPPATH.'views/customer/footer.php'); ?> 