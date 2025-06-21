<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' | ' : '' ?>E-Shop</title>
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%); }
        .brand { font-size: 2rem; font-weight: bold; color: #4f46e5; text-decoration: none; }
        .nav-link.active { font-weight: bold; color: #4f46e5 !important; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand brand" href="<?= base_url('customer/dashboard') ?>">E-Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link<?= uri_string() == 'customer/dashboard' ? ' active' : '' ?>" href="<?= base_url('customer/dashboard') ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= uri_string() == 'customer/blogs' ? ' active' : '' ?>" href="<?= base_url('customer/blogs') ?>">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link<?= uri_string() == 'customer/about' ? ' active' : '' ?>" href="<?= base_url('customer/about') ?>">About</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('customer/cart') ?>">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="badge bg-danger" id="cart-count"><?= count($this->session->userdata('cart') ?? []) ?></span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle"></i> <?= $this->session->userdata('customer_name') ?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?= base_url('customer/profile') ?>">Profile</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('customer/orders') ?>">Orders</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('customer/logout') ?>">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html> 