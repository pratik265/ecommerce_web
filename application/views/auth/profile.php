<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">My Profile</li>
        </ol>
    </nav>
    <h1 class="mb-4"><i class="fas fa-user me-2"></i>My Profile</h1>
    <?php if (!empty($user)): ?>
        <div class="card mx-auto" style="max-width: 500px;">
            <div class="card-body">
                <h4 class="card-title mb-3">Welcome, <?= htmlspecialchars($user->name) ?></h4>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($user->email) ?></li>
                    <li class="list-group-item"><strong>Phone:</strong> <?= htmlspecialchars($user->phone) ?></li>
                    <li class="list-group-item"><strong>Address:</strong> <?= nl2br(htmlspecialchars($user->address)) ?></li>
                </ul>
                <a href="#" class="btn btn-primary">Edit Profile</a>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">User information not found.</div>
    <?php endif; ?>
</div> 