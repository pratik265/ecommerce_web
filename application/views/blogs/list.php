<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
        </ol>
    </nav>
    <h1 class="mb-4"><i class="fas fa-blog me-2"></i>Our Blog</h1>
    <div class="row">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100">
                        <?php if ($blog->image): ?>
                            <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($blog->title) ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($blog->title) ?></h5>
                            <div class="mb-2 text-muted small">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($blog->author_name ?? '') ?>
                                <span class="mx-2">|</span>
                                <i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($blog->created_at)) ?>
                            </div>
                            <p class="card-text text-muted">
                                <?= substr(strip_tags($blog->content), 0, 100) ?>...
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="<?= base_url('blog/' . $blog->slug) ?>" class="btn btn-outline-primary btn-sm">
                                Read More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fas fa-blog fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">No Blog Posts Found</h3>
                <p class="text-muted">We couldn't find any blog posts at the moment.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($total_pages) && $total_pages > 1): ?>
        <nav aria-label="Blog pagination" class="mt-5">
            <ul class="pagination justify-content-center">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page - 1 ?>">
                            <i class="fas fa-chevron-left"></i> Previous
                        </a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $current_page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $current_page + 1 ?>">
                            Next <i class="fas fa-chevron-right"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div> 