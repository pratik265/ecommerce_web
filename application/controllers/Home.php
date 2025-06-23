<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public Chat_model $chat_model;
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
        $this->load->model('Product_model');
        $this->load->model('Blog_model');
        $this->load->model('Order_model');
        $this->load->model('Chat_model', 'chat_model');
        $this->load->library('form_validation');
    }
    
    public function index() {
        $data['title'] = 'Welcome to Our E-commerce Store';
        $data['featured_products'] = $this->Product_model->get_featured_products(8);
        $data['sale_products'] = $this->Product_model->get_sale_products(6);
        $data['recent_blogs'] = $this->Blog_model->get_recent_blogs(3);
        $data['sliders'] = get_multiple_rows('sliders', array('status' => 'active'), '*', 'sort_order ASC');
        if (is_logged_in()) {
            $data['chat_unread_count'] = $this->chat_model->get_unread_count($this->session->userdata('user_id'));
            // Fix: Use require_once and instantiate Customer_model directly
            require_once(APPPATH . 'models/Customer_model.php');
            $user_id = $this->session->userdata('user_id');
            $customer_model = new Customer_model();
            $data['customers'] = $customer_model->get_all_customers($user_id);
            // Fetch user orders
            $data['orders'] = $this->Order_model->get_user_orders($user_id);
        } else {
            $data['chat_unread_count'] = 0;
            $data['customers'] = array();
        }
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function products() {
        $page = $this->input->get('page') ?: 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        $data['title'] = 'All Products';
        $data['products'] = $this->Product_model->get_all_products($limit, $offset);
        $data['total_products'] = count_rows('products', array('status' => 'active'));
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_products'] / $limit);
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function product($slug) {
        $data['product'] = $this->Product_model->get_product_by_slug($slug);
        
        if (!$data['product']) {
            show_404();
        }
        
        $data['title'] = $data['product']->name;
        $data['related_products'] = $this->Product_model->get_products_by_category($data['product']->category_id, 4);
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/detail', $data);
        $this->load->view('templates/footer');
    }
    
    public function blogs() {
        $page = $this->input->get('page') ?: 1;
        $limit = 9;
        $offset = ($page - 1) * $limit;
        
        $data['title'] = 'Blog';
        $data['blogs'] = $this->Blog_model->get_all_blogs($limit, $offset);
        $data['total_blogs'] = $this->Blog_model->get_blog_count();
        $data['current_page'] = $page;
        $data['total_pages'] = ceil($data['total_blogs'] / $limit);
        
        $this->load->view('templates/header', $data);
        $this->load->view('blogs/list', $data);
        $this->load->view('templates/footer');
    }
    
    public function blog($slug) {
        $data['blog'] = $this->Blog_model->get_blog_by_slug($slug);
        
        if (!$data['blog']) {
            show_404();
        }
        
        $data['title'] = $data['blog']->title;
        $data['recent_blogs'] = $this->Blog_model->get_recent_blogs(5);
        
        $this->load->view('templates/header', $data);
        $this->load->view('blogs/detail', $data);
        $this->load->view('templates/footer');
    }
    
    public function search() {
        $keyword = $this->input->get('q');
        
        if (!$keyword) {
            redirect('products');
        }
        
        $data['title'] = 'Search Results for: ' . $keyword;
        $data['products'] = $this->Product_model->search_products($keyword);
        $data['blogs'] = $this->Blog_model->search_blogs($keyword);
        $data['keyword'] = $keyword;
        
        $this->load->view('templates/header', $data);
        $this->load->view('search/results', $data);
        $this->load->view('templates/footer');
    }
    
    public function cart() {
        $data['title'] = 'Shopping Cart';
        $data['cart_items'] = $this->Order_model->get_cart_items();
        
        $this->load->view('templates/header', $data);
        $this->load->view('cart/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function add_to_cart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $this->input->post('product_id');
            $quantity = $this->input->post('quantity') ?: 1;

            // Fix: Always use 'quantity' as the key in cart session
            $cart = $this->session->userdata('cart') ?: array();
            $found = false;
            foreach ($cart as &$item) {
                if ($item['id'] == $product_id) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $product = $this->Product_model->get_product_by_id($product_id);
                if ($product) {
                    $cart[] = array(
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $quantity,
                        'image' => $product->image
                    );
                }
            }
            $this->session->set_userdata('cart', $cart);
            redirect_with_message('cart', 'Product added to cart successfully!');
        } else {
            // Show a friendly HTML message for GET requests
            $data['title'] = 'Add to Cart';
            $this->load->view('templates/header', $data);
            echo '<div class="container py-5 text-center"><h1 class="mb-4">Add to Cart</h1><p>This page is for adding products to your cart. Please use the <b>Add to Cart</b> button on a product page.</p><a href="' . base_url('products') . '" class="btn btn-primary mt-3">Go to Products</a></div>';
            $this->load->view('templates/footer');
        }
    }
    
    public function update_cart() {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $cart = $this->session->userdata('cart') ?: array();
        foreach ($cart as &$item) {
            if ($item['id'] == $product_id) {
                if ($quantity <= 0) {
                    $cart = array_filter($cart, function($i) use ($product_id) { return $i['id'] != $product_id; });
                } else {
                    $item['quantity'] = $quantity;
                }
                break;
            }
        }
        $this->session->set_userdata('cart', $cart);
        // AJAX response or redirect handled as before
        if ($this->input->is_ajax_request()) {
            $cart_items = $cart;
            $cart_total = 0;
            $cart_count = 0;
            foreach ($cart_items as $item) {
                $cart_total += $item['price'] * $item['quantity'];
                $cart_count += $item['quantity'];
            }
            $response = array(
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_total' => '$' . number_format($cart_total, 2),
                'cart_count' => $cart_count,
                'item_total' => '$' . number_format($item['price'] * $item['quantity'], 2)
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }
        redirect('cart');
    }
    
    public function remove_from_cart($product_id) {
        if ($this->Order_model->remove_from_cart($product_id)) {
            redirect_with_message('cart', 'Product removed from cart successfully!');
        } else {
            redirect_with_message('cart', 'Failed to remove product from cart.', 'error');
        }
    }
    
    public function checkout() {
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to checkout.', 'error');
        }
        
        $cart_items = $this->Order_model->get_cart_items();
        if (empty($cart_items)) {
            redirect_with_message('cart', 'Your cart is empty.', 'error');
        }
        
        $data['title'] = 'Checkout';
        $data['cart_items'] = $cart_items;
        $data['user'] = get_logged_user();
        
        $this->load->view('templates/header', $data);
        $this->load->view('checkout/index', $data);
        $this->load->view('templates/footer');
    }
    
    public function place_order() {
        // Check if it's a POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $data['title'] = 'Place Order';
            $this->load->view('templates/header', $data);
            echo '<div class="container py-5 text-center">
                    <h1 class="mb-4">Place Order</h1>
                    <p class="lead mb-4">This page is for processing your order. Please complete the checkout form to place your order.</p>
                    <a href="' . base_url('checkout') . '" class="btn btn-primary btn-lg me-2">Go to Checkout</a>
                    <a href="' . base_url('cart') . '" class="btn btn-outline-primary btn-lg">View Cart</a>
                  </div>';
            $this->load->view('templates/footer');
            return;
        }
        
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to place order.', 'error');
        }
        
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $this->checkout();
        } else {
            $user_id = $this->session->userdata('user_id');
            $total_amount = get_cart_total();
            $shipping_address = $this->input->post('shipping_address');
            $payment_method = $this->input->post('payment_method');
            
            // Pass customer_id = 0 for user orders
            $order_id = $this->Order_model->create_order($user_id, $total_amount, $shipping_address, $payment_method, 0);
            
            if ($order_id) {
                redirect_with_message('order/success/' . $order_id, 'Order placed successfully!');
            } else {
                redirect_with_message('checkout', 'Failed to place order. Please try again.', 'error');
            }
        }
    }
    
    public function order_success($order_id) {
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to view order details !', 'error');
        }
        
        $order = $this->Order_model->get_order_by_id($order_id);
        if (!$order || $order->user_id != $this->session->userdata('user_id')) {
            show_404();
        }
        
        $data['title'] = 'Order Successfully';
        $data['order'] = $order;
        $data['order_items'] = $this->Order_model->get_order_items($order_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('order/success', $data);
        $this->load->view('templates/footer');
    }
} 