<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('common');
    }

    public function register($user_id = null) {
        if ($this->session->userdata('customer_logged_in')) {
            redirect('customer/dashboard');
        }
        $data['user_id'] = $user_id;
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[customers.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Customer Register';
            $this->load->view('customer/register', $data);
        } else {
            $customer_data = array(
                'user_id' => $user_id,
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
            );
            $customer_id = $this->Customer_model->register($customer_data);
            if ($customer_id) {
                redirect('customer/login');
            } else {
                $data['error'] = 'Registration failed. Please try again.';
                $this->load->view('customer/register', $data);
            }
        }
    }

    public function login() {
        if ($this->session->userdata('customer_logged_in')) {
            redirect('customer/dashboard');
        }
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Customer Login';
            $this->load->view('customer/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $result = $this->Customer_model->login($email, $password);
            if ($result['success']) {
                $customer = $result['customer'];
                $this->session->set_userdata(array(
                    'customer_logged_in' => true,
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_user_id' => $customer->user_id
                ));
                redirect('customer/dashboard');
            } else {
                $data['error'] = $result['message'];
                $this->load->view('customer/login', $data);
            }
        }
    }

    public function dashboard() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $this->load->model('Product_model');
        $data['title'] = 'Customer Dashboard';
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('customer/dashboard', $data);
    }

    public function logout() {
        $this->session->unset_userdata(array('customer_logged_in', 'customer_id', 'customer_name', 'customer_user_id'));
        redirect('customer/login');
    }

    public function add_to_cart($product_id) {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += 1;
        } else {
            $this->load->model('Product_model');
            $product = $this->Product_model->get_product_by_id($product_id);
            if ($product) {
                $cart[$product_id] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->image,
                    'quantity' => 1
                ];
            }
        }
        $this->session->set_userdata('cart', $cart);
        redirect('customer/dashboard');
    }

    public function cart() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $data['title'] = 'My Cart';
        $data['cart'] = $this->session->userdata('cart') ?: array();
        $this->load->view('customer/cart', $data);
    }

    public function product($product_id) {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product_by_id($product_id);
        if (!$product) {
            show_404();
        }
        $data['title'] = $product->name;
        $data['product'] = $product;
        $this->load->view('customer/product', $data);
    }

    public function blogs() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $this->load->model('Blog_model');
        $data['title'] = 'Blogs';
        $data['blogs'] = $this->Blog_model->get_all_blogs();
        $this->load->view('customer/blogs', $data);
    }

    public function blog($id) {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $this->load->model('Blog_model');
        $blog = $this->Blog_model->get_blog_by_id($id);
        if (!$blog) {
            show_404();
        }
        $data['title'] = $blog->title;
        $data['blog'] = $blog;
        $this->load->view('customer/blog', $data);
    }

    public function about() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $data['title'] = 'About Us';
        $this->load->view('customer/about', $data);
    }

    public function checkout() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $cart = $this->session->userdata('cart') ?: array();
        if (empty($cart)) {
            redirect('customer/cart');
        }
        $data['title'] = 'Checkout';
        $data['cart'] = $cart;
        $this->load->view('customer/checkout', $data);
    }

    public function place_order() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $cart = $this->session->userdata('cart') ?: array();
        if (empty($cart)) {
            redirect('customer/cart');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('shipping_address', 'Shipping Address', 'required');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Checkout';
            $data['cart'] = $cart;
            $this->load->view('customer/checkout', $data);
        } else {
            $this->load->model('Order_model');
            $user_id = $this->session->userdata('customer_user_id');
            $customer_id = $this->session->userdata('customer_id');
            $total_amount = array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart));
            $shipping_address = $this->input->post('shipping_address');
            $payment_method = $this->input->post('payment_method');
            $order_id = $this->Order_model->create_order($user_id, $total_amount, $shipping_address, $payment_method, $customer_id);
            $this->session->unset_userdata('cart');
            $data['title'] = 'Order Placed';
            $this->load->view('customer/order_success', $data);
        }
    }

    public function update_cart() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$product_id])) {
            if ($quantity <= 0) {
                unset($cart[$product_id]);
            } else {
                $cart[$product_id]['quantity'] = $quantity;
            }
        }
        $this->session->set_userdata('cart', $cart);
        redirect('customer/cart');
    }

    public function remove_from_cart($product_id) {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }
        $cart = $this->session->userdata('cart') ?: array();
        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
        }
        $this->session->set_userdata('cart', $cart);
        redirect('customer/cart');
    }

    public function profile() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }

        $customer_id = $this->session->userdata('customer_id');

        // Handle Profile Update
        if ($this->input->post('update_profile')) {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('phone', 'Phone', 'trim');
            $this->form_validation->set_rules('address', 'Address', 'trim');
            if ($this->form_validation->run() == TRUE) {
                $profile_data = [
                    'name' => $this->input->post('name'),
                    'phone' => $this->input->post('phone'),
                    'address' => $this->input->post('address'),
                ];
                if ($this->Customer_model->update_profile($customer_id, $profile_data)) {
                    $this->session->set_userdata('customer_name', $profile_data['name']);
                    redirect_with_message('customer/profile', 'Profile updated successfully!');
                } else {
                    redirect_with_message('customer/profile', 'Failed to update profile.', 'error');
                }
            }
        }

        // Handle Password Change
        if ($this->input->post('change_password')) {
            $this->form_validation->set_rules('current_password', 'Current Password', 'required');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'required|matches[new_password]');
            if ($this->form_validation->run() == TRUE) {
                if ($this->Customer_model->change_password($customer_id, $this->input->post('current_password'), $this->input->post('new_password'))) {
                     redirect_with_message('customer/profile', 'Password changed successfully!');
                } else {
                     redirect_with_message('customer/profile', 'Failed to change password. Please check your current password.', 'error');
                }
            }
        }

        $data['title'] = 'My Profile';
        $data['customer'] = $this->Customer_model->get_customer_by_id($customer_id);
        
        $this->load->view('customer/header', $data);
        $this->load->view('customer/profile', $data);
        $this->load->view('customer/footer');
    }

    public function orders() {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }

        $customer_id = $this->session->userdata('customer_id');
        $this->load->model('Order_model');
        $data['title'] = 'My Orders';
        $data['orders'] = $this->Order_model->get_orders_by_customer($customer_id);

        $this->load->view('customer/header', $data);
        $this->load->view('customer/orders', $data);
        $this->load->view('customer/footer');
    }

    public function order_details($order_id) {
        if (!$this->session->userdata('customer_logged_in')) {
            redirect('customer/login');
        }

        $customer_id = $this->session->userdata('customer_id');
        $this->load->model('Order_model');
        $order = $this->Order_model->get_order_details($order_id);

        // Security check: ensure customer can only view their own orders
        if (!$order || $order->customer_id != $customer_id) {
            redirect_with_message('customer/orders', 'Order not found or access denied.', 'error');
            return;
        }

        $data['title'] = 'Order Details #' . $order->id;
        $data['order'] = $order;

        $this->load->view('customer/header', $data);
        $this->load->view('customer/order_details', $data);
        $this->load->view('customer/footer');
    }
} 