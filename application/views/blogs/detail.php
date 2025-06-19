<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('blogs') ?>">Blogs</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($blog->title) ?></li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card mb-4">
                <?php if ($blog->image): ?>
                    <img src="<?= base_url('uploads/blogs/' . $blog->image) ?>" class="card-img-top" alt="<?= htmlspecialchars($blog->title) ?>" style="max-height:350px;object-fit:cover;">
                <?php endif; ?>
                <div class="card-body">
                    <h1 class="card-title mb-3"><?= htmlspecialchars($blog->title) ?></h1>
                    <div class="mb-3 text-muted small">
                        <i class="fas fa-user me-1"></i><?= htmlspecialchars($blog->author_name ?? '') ?>
                        <span class="mx-2">|</span>
                        <i class="fas fa-calendar me-1"></i><?= date('M d, Y', strtotime($blog->created_at)) ?>
                    </div>
                    <div class="card-text mb-4">
                        <?= nl2br($blog->content) ?>
                    </div>
                    <a href="<?= base_url('blogs') ?>" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-1"></i>Back to Blogs</a>
                </div>
            </div>
        </div>
    </div>
</div> 