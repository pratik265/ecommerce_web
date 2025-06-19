<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - E-commerce Store</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        
        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .product-image {
            height: 200px;
            object-fit: cover;
        }
        
        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--primary-color);
        }
        
        .sale-price {
            color: var(--danger-color);
        }
        
        .original-price {
            text-decoration: line-through;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), #0056b3);
            border: none;
            border-radius: 25px;
            padding: 10px 25px;
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, var(--primary-color));
            transform: translateY(-2px);
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .footer {
            background: #343a40;
            color: white;
            padding: 40px 0 20px;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .form-control {
            border-radius: 10px;
            border: 1px solid #dee2e6;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .floating-chat-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }
        
        .floating-chat-btn .btn {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #25D366;
            border: none;
            transition: all 0.3s ease;
        }
        
        .floating-chat-btn .btn:hover {
            background: #128C7E;
            transform: scale(1.1);
        }
        
        .floating-chat-btn .badge {
            font-size: 10px;
            padding: 4px 6px;
        }
        
        @media (max-width: 768px) {
            .floating-chat-btn {
                bottom: 20px;
                right: 20px;
            }
            
            .floating-chat-btn .btn {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="fas fa-shopping-cart me-2"></i>E-Shop
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('products') ?>">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('blogs') ?>">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('chat') ?>">
                            <i class="fas fa-comments me-1"></i>Chat Support
                            <?php if (!empty($chat_unread_count)): ?>
                                <span class="badge bg-danger ms-1"><?= $chat_unread_count ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-3" action="<?= base_url('search') ?>" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Search products..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                
                <!-- Cart -->
                <div class="position-relative me-3">
                    <a href="<?= base_url('cart') ?>" class="btn btn-outline-light">
                        <i class="fas fa-shopping-cart"></i>
                        <?php if (get_cart_count() > 0): ?>
                            <span class="cart-badge"><?= get_cart_count() ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <!-- User Menu -->
                <ul class="navbar-nav">
                    <?php if (is_logged_in()): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i><?= $this->session->userdata('user_name') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">My Profile</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('chat') ?>">
                                    <i class="fas fa-comments me-2"></i>Chat with Support
                                    <?php if (!empty($chat_unread_count)): ?>
                                        <span class="badge bg-danger ms-2"><?= $chat_unread_count ?></span>
                                    <?php endif; ?>
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('logout') ?>">Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('register') ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <?php $flash_message = get_flash_message(); ?>
    <?php if ($flash_message): ?>
        <div class="container mt-3">
            <div class="alert alert-<?= $flash_message['type'] == 'error' ? 'danger' : $flash_message['type'] ?> alert-dismissible fade show">
                <?= $flash_message['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Floating Chat Button -->
    <div class="floating-chat-btn">
        <a href="<?= base_url('chat') ?>" class="btn btn-success btn-lg rounded-circle shadow-lg" title="Chat with Support">
            <i class="fas fa-comments fa-lg"></i>
            <?php if (is_logged_in()): ?>
                <?php if (!empty($chat_unread_count)): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?= $chat_unread_count ?>
                    </span>
                <?php endif; ?>
            <?php endif; ?>
        </a>
    </div>

    <!-- Main Content -->
    <main> 

    </main>

    <!-- Bootstrap JS and Popper.js (required for navbar toggling) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html> 