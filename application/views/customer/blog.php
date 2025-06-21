<?php include(APPPATH.'views/customer/header.php'); ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <?php if ($blog->image): ?>
                    <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" class="card-img-top" style="height: 300px; object-fit: cover;" alt="<?= htmlspecialchars($blog->title) ?>">
                <?php endif; ?>
                <div class="card-body">
                    <h2 class="fw-bold mb-2"><?= htmlspecialchars($blog->title) ?></h2>
                    <div class="mb-3 text-muted small">
                        <i class="fas fa-user me-1"></i><?= $blog->author_name ?? 'Admin' ?>
                        <span class="ms-3"><i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($blog->created_at)) ?></span>
                    </div>
                    <div class="blog-content mb-3">
                        <?= $blog->content ?>
                    </div>
                    <a href="<?= base_url('customer/blogs') ?>" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-1"></i>Back to Blogs</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include(APPPATH.'views/customer/footer.php'); ?> 