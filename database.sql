-- E-commerce Database Schema

CREATE DATABASE IF NOT EXISTS ecommerce_db;
USE ecommerce_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('user', 'admin') DEFAULT 'user',
    status ENUM('active', 'blocked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    image VARCHAR(255),
    category_id INT,
    stock_quantity INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Blogs table
CREATE TABLE blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    author_id INT,
    status ENUM('published', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Orders table
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT,
    payment_method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Order items table
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    product_name VARCHAR(200) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- Sliders table
CREATE TABLE sliders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200),
    subtitle VARCHAR(200),
    image VARCHAR(255) NOT NULL,
    link VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Chat Tables
CREATE TABLE `chat_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `room_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_type` enum('user','admin') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `room_id` (`room_id`),
  KEY `sender_id` (`sender_id`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user
INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample categories
INSERT INTO categories (name, slug, description) VALUES 
('Electronics', 'electronics', 'Electronic devices and gadgets'),
('Clothing', 'clothing', 'Fashion and apparel'),
('Books', 'books', 'Books and literature'),
('Home & Garden', 'home-garden', 'Home improvement and garden supplies');

-- Insert sample products
INSERT INTO products (name, slug, description, price, sale_price, category_id, stock_quantity, image) VALUES 
('iPhone 13 Pro', 'iphone-13-pro', 'Latest iPhone with advanced camera system', 999.99, 899.99, 1, 50, 'iphone13pro-modern.jpg'),
('Samsung Galaxy S21', 'samsung-galaxy-s21', 'Premium Android smartphone', 799.99, 699.99, 1, 30, 'galaxys21-modern.jpg'),
('Sony WH-1000XM4 Headphones', 'sony-wh-1000xm4', 'Industry-leading noise cancelling headphones', 349.99, 299.99, 1, 40, 'sony-headphones.jpg'),
('Nike Air Max', 'nike-air-max', 'Comfortable running shoes', 129.99, 99.99, 2, 100, 'nikeairmax-modern.jpg'),
('Adidas T-Shirt', 'adidas-t-shirt', 'Comfortable cotton t-shirt', 29.99, 24.99, 2, 200, 'adidas-tshirt-modern.jpg'),
('The Great Gatsby', 'the-great-gatsby', 'Classic American novel', 12.99, 9.99, 3, 75, 'greatgatsby-modern.jpg'),
('Garden Tool Set', 'garden-tool-set', 'Complete gardening tool kit', 89.99, 79.99, 4, 25, 'gardentools-modern.jpg');

-- Insert sample blogs
INSERT INTO blogs (title, slug, content, author_id, status, image) VALUES 
('Top 10 Smartphones of 2024', 'top-10-smartphones-2024', 'Discover the best smartphones available in 2024 with cutting-edge features and performance...', 1, 'published', 'blog-smartphones.jpg'),
('Fashion Trends for Summer', 'fashion-trends-summer', 'Stay ahead of the fashion curve with these summer trends that are dominating the runway...', 1, 'published', 'blog-fashion.jpg'),
('Must-Read Books This Year', 'must-read-books-2024', 'A curated list of the most compelling books that you should add to your reading list...', 1, 'published', 'blog-books.jpg'),
('Home Improvement Tips', 'home-improvement-tips', 'Transform your living space with these practical home improvement tips and tricks...', 1, 'published', 'blog-home.jpg'),
('Sustainable Living Guide', 'sustainable-living-guide', 'Learn how to live a more sustainable lifestyle with these eco-friendly practices...', 1, 'published', 'blog-sustainable.jpg');

-- Insert sample sliders
INSERT INTO sliders (title, subtitle, image, link, sort_order) VALUES 
('Welcome to Our Store', 'Discover amazing products at great prices', 'slider-modern-1.jpg', '/products', 1),
('New Arrivals', 'Check out our latest collection', 'slider-modern-2.jpg', '/products', 2),
('Special Offers', 'Limited time deals on selected items', 'slider-modern-3.jpg', '/products', 3);

-- Insert sample chat data
INSERT INTO `chat_rooms` (`user_id`, `admin_id`, `room_name`) VALUES
(2, 1, 'Chat with John Doe'),
(3, 1, 'Chat with Jane Smith'),
(4, 1, 'Chat with Mike Johnson');

INSERT INTO `chat_messages` (`room_id`, `sender_id`, `sender_type`, `message`, `is_read`) VALUES
(1, 2, 'user', 'Hello, I have a question about my order', 1),
(1, 1, 'admin', 'Hi! Sure, I\'d be happy to help. What\'s your order number?', 0),
(1, 2, 'user', 'My order number is #ORD001', 1),
(1, 1, 'admin', 'I can see your order. It\'s currently being processed and will be shipped tomorrow.', 0),
(2, 3, 'user', 'Hi admin, when will my product be back in stock?', 1),
(2, 1, 'admin', 'Hello! The product should be back in stock by next week. Would you like me to notify you when it\'s available?', 0),
(3, 4, 'user', 'I need help with my account', 1),
(3, 1, 'admin', 'Of course! What seems to be the issue with your account?', 0); 