<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - <?= isset($title) ? $title : 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f4f6f9; }
        .admin-navbar { background: #212529; }
        .admin-navbar .navbar-brand { font-weight: bold; }
        .sidebar { min-height: 100vh; background: #343a40; color: #fff; }
        .sidebar a { color: #fff; display: block; padding: 10px 20px; text-decoration: none; }
        .sidebar a.active, .sidebar a:hover { background: #495057; color: #ffc107; }
        .content { padding: 30px 20px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg admin-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url('admin/dashboard') ?>">Admin Panel</a>
        <div class="d-flex align-items-center">
            <span class="text-light me-3">
                <i class="fas fa-user me-1"></i><?= $this->session->userdata('admin_name') ?>
            </span>
            <a href="<?= base_url() ?>" class="btn btn-outline-light me-2">View Site</a>
            <a href="<?= base_url('admin/logout') ?>" class="btn btn-warning">Logout</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h5 class="mt-4 mb-3 ms-3">Menu</h5>
            <a href="<?= base_url('admin/dashboard') ?>" class="<?= uri_string() == 'admin/dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="<?= base_url('admin/users') ?>" class="<?= uri_string() == 'admin/users' ? 'active' : '' ?>">
                <i class="fas fa-users me-2"></i>Users
            </a>
            <a href="<?= base_url('admin/products') ?>" class="<?= uri_string() == 'admin/products' ? 'active' : '' ?>">
                <i class="fas fa-box me-2"></i>Products
            </a>
            <a href="<?= base_url('admin/blogs') ?>" class="<?= uri_string() == 'admin/blogs' ? 'active' : '' ?>">
                <i class="fas fa-blog me-2"></i>Blogs
            </a>
            <a href="<?= base_url('admin/orders') ?>" class="<?= uri_string() == 'admin/orders' ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart me-2"></i>Orders
            </a>
            <a href="<?= base_url('admin/reports') ?>" class="<?= uri_string() == 'admin/reports' ? 'active' : '' ?>">
                <i class="fas fa-chart-bar me-2"></i>Reports
            </a>
            <a href="<?= base_url('admin/chat') ?>" class="<?= strpos(uri_string(), 'admin/chat') === 0 ? 'active' : '' ?>">
                <i class="fas fa-comments me-2"></i>Chat
                <?php 
                $this->load->model('Chat_model');
                $unread_count = $this->Chat_model->get_admin_unread_count();
                if ($unread_count > 0): 
                ?>
                    <span class="badge bg-danger ms-2"><?= $unread_count ?></span>
                <?php endif; ?>
            </a>
        </div>
        <div class="col-md-10 content"> 