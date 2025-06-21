<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }
    
    public function create_order($user_id, $total_amount, $shipping_address, $payment_method, $customer_id = 0) {
        $order_number = 'ORD-' . date('Ymd') . '-' . rand(1000, 9999);
        
        $order_data = array(
            'order_number' => $order_number,
            'user_id' => $user_id,
            'customer_id' => $customer_id,
            'total_amount' => $total_amount,
            'shipping_address' => $shipping_address,
            'payment_method' => $payment_method
        );
        
        $order_id = insert_data('orders', $order_data);
        
        if ($order_id) {
            $cart_items = $this->session->userdata('cart');
            if ($cart_items) {
                foreach ($cart_items as $item) {
                    $item_data = array(
                        'order_id' => $order_id,
                        'product_id' => $item['id'],
                        'product_name' => $item['name'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    );
                    insert_data('order_items', $item_data);
                    
                    // Update product stock
                    $this->load->model('Product_model');
                    $this->Product_model->update_stock($item['id'], $item['quantity']);
                }
                
                // Clear cart
                $this->session->unset_userdata('cart');
            }
        }
        
        return $order_id;
    }
    
    public function get_order_by_id($id) {
        $this->db->select('orders.*, users.name as customer_name, users.email as customer_email');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->where('orders.id', $id);
        return $this->db->get()->row();
    }
    
    public function get_order_by_number($order_number) {
        $this->db->select('orders.*, users.name as customer_name, users.email as customer_email');
        $this->db->from('orders');
        $this->db->join('users', 'users.id = orders.user_id', 'left');
        $this->db->where('orders.order_number', $order_number);
        return $this->db->get()->row();
    }
    
    public function get_order_items($order_id) {
        return get_multiple_rows('order_items', array('order_id' => $order_id));
    }
    
    public function get_user_orders($user_id, $limit = 10) {
        return $this->db->where('user_id', $user_id)->order_by('created_at', 'DESC')->limit($limit)->get('orders')->result();
    }
    
    public function get_orders_by_customer($customer_id, $limit = 0) {
        $this->db->select('o.*, c.name as customer_name');
        $this->db->from('orders o');
        $this->db->join('customers c', 'c.id = o.customer_id');
        $this->db->where('o.customer_id', $customer_id);
        $this->db->order_by('o.created_at', 'DESC');
        if($limit > 0) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }
    
    public function get_all_orders($limit = 0) {
        $this->db->select('o.*, u.name as user_name');
        $this->db->from('orders o');
        $this->db->join('users u', 'u.id = o.user_id', 'left');
        $this->db->order_by('o.created_at', 'DESC');
        if($limit > 0) {
            $this->db->limit($limit);
        }
        return $this->db->get()->result();
    }
    
    public function update_order_status($order_id, $status) {
        return update_data('orders', array('status' => $status), array('id' => $order_id));
    }
    
    public function get_sales_report($start_date = null, $end_date = null) {
        $this->db->select('DATE(orders.created_at) as date, COUNT(*) as total_orders, SUM(orders.total_amount) as total_revenue');
        $this->db->from('orders');
        $this->db->where('orders.status !=', 'cancelled');
        
        if ($start_date) {
            $this->db->where('orders.created_at >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('orders.created_at <=', $end_date);
        }
        
        $this->db->group_by('DATE(orders.created_at)');
        $this->db->order_by('date', 'DESC');
        
        return $this->db->get()->result();
    }
    
    public function get_order_statistics() {
        $stats = array();
        
        // Total orders
        $stats['total_orders'] = count_rows('orders');
        
        // Pending orders
        $stats['pending_orders'] = count_rows('orders', array('status' => 'pending'));
        
        // Completed orders
        $stats['completed_orders'] = count_rows('orders', array('status' => 'delivered'));
        
        // Cancelled orders
        $stats['cancelled_orders'] = count_rows('orders', array('status' => 'cancelled'));
        
        // Total revenue
        $this->db->select('SUM(total_amount) as total_revenue');
        $this->db->from('orders');
        $this->db->where('status !=', 'cancelled');
        $result = $this->db->get()->row();
        $stats['total_revenue'] = $result ? $result->total_revenue : 0;
        
        // This month's revenue
        $this->db->select('SUM(total_amount) as monthly_revenue');
        $this->db->from('orders');
        $this->db->where('status !=', 'cancelled');
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $result = $this->db->get()->row();
        $stats['monthly_revenue'] = $result ? $result->monthly_revenue : 0;
        
        // This month's orders
        $this->db->where('MONTH(created_at)', date('m'));
        $this->db->where('YEAR(created_at)', date('Y'));
        $stats['monthly_orders'] = count_rows('orders');
        
        return $stats;
    }
    
    public function get_stock_statistics() {
        $stats = array();
        
        // Total products in stock
        $this->db->select('SUM(stock_quantity) as total_stock');
        $this->db->from('products');
        $this->db->where('status', 'active');
        $result = $this->db->get()->row();
        $stats['total_stock'] = $result ? $result->total_stock : 0;
        
        // Low stock products (less than 10)
        $stats['low_stock_products'] = count_rows('products', array('stock_quantity <' => 10, 'status' => 'active'));
        
        // Out of stock products
        $stats['out_of_stock_products'] = count_rows('products', array('stock_quantity' => 0, 'status' => 'active'));
        
        // Products with stock
        $stats['in_stock_products'] = count_rows('products', array('stock_quantity >' => 0, 'status' => 'active'));
        
        return $stats;
    }
    
    public function get_monthly_sales_report($year = null) {
        if (!$year) {
            $year = date('Y');
        }
        
        $this->db->select('MONTH(orders.created_at) as month, COUNT(*) as total_orders, SUM(orders.total_amount) as total_revenue');
        $this->db->from('orders');
        $this->db->where('orders.status !=', 'cancelled');
        $this->db->where('YEAR(orders.created_at)', $year);
        $this->db->group_by('MONTH(orders.created_at)');
        $this->db->order_by('month', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function get_top_selling_products($limit = 10) {
        $this->db->select('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as total_revenue');
        $this->db->from('order_items');
        $this->db->join('orders', 'orders.id = order_items.order_id');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->where('orders.status !=', 'cancelled');
        $this->db->group_by('order_items.product_id');
        $this->db->order_by('total_sold', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result();
    }
    
    public function get_daily_sales_report($start_date = null, $end_date = null) {
        if (!$start_date) {
            $start_date = date('Y-m-01'); // First day of current month
        }
        if (!$end_date) {
            $end_date = date('Y-m-t'); // Last day of current month
        }
        
        $this->db->select('DATE(orders.created_at) as date, COUNT(*) as total_orders, SUM(orders.total_amount) as total_revenue');
        $this->db->from('orders');
        $this->db->where('orders.status !=', 'cancelled');
        $this->db->where('orders.created_at >=', $start_date);
        $this->db->where('orders.created_at <=', $end_date . ' 23:59:59');
        $this->db->group_by('DATE(orders.created_at)');
        $this->db->order_by('date', 'ASC');
        
        return $this->db->get()->result();
    }
    
    public function add_to_cart($product_id, $quantity = 1) {
        $this->load->model('Product_model');
        $product = $this->Product_model->get_product_by_id($product_id);
        
        if (!$product || $product->status != 'active') {
            return false;
        }
        
        $cart_items = $this->session->userdata('cart') ?: array();
        
        // Check if product already in cart
        $found = false;
        foreach ($cart_items as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }
        
        if (!$found) {
            $price = $product->sale_price ? $product->sale_price : $product->price;
            $cart_items[] = array(
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => $quantity,
                'image' => $product->image
            );
        }
        
        $this->session->set_userdata('cart', $cart_items);
        return true;
    }
    
    public function update_cart_quantity($product_id, $quantity) {
        $cart_items = $this->session->userdata('cart') ?: array();
        
        foreach ($cart_items as &$item) {
            if ($item['id'] == $product_id) {
                if ($quantity <= 0) {
                    return $this->remove_from_cart($product_id);
                }
                $item['quantity'] = $quantity;
                break;
            }
        }
        
        $this->session->set_userdata('cart', $cart_items);
        return true;
    }
    
    public function remove_from_cart($product_id) {
        $cart_items = $this->session->userdata('cart') ?: array();
        
        foreach ($cart_items as $key => $item) {
            if ($item['id'] == $product_id) {
                unset($cart_items[$key]);
                break;
            }
        }
        
        $this->session->set_userdata('cart', array_values($cart_items));
        return true;
    }
    
    public function get_cart_items() {
        return $this->session->userdata('cart') ?: array();
    }
    
    public function get_cart_item_total($product_id) {
        $cart_items = $this->session->userdata('cart') ?: array();
        
        foreach ($cart_items as $item) {
            if ($item['id'] == $product_id) {
                return $item['price'] * $item['quantity'];
            }
        }
        
        return 0;
    }
    
    public function clear_cart() {
        $this->session->unset_userdata('cart');
    }
    
    public function count_customer_orders($customer_id) {
        return $this->db->where('customer_id', $customer_id)->count_all_results('orders');
    }
    
    public function get_order_details($order_id) {
        $order = $this->db->get_where('orders', ['id' => $order_id])->row();
        if ($order) {
            $this->db->select('oi.*, p.name, p.image');
            $this->db->from('order_items oi');
            $this->db->join('products p', 'p.id = oi.product_id');
            $this->db->where('oi.order_id', $order_id);
            $order->items = $this->db->get()->result();
        }
        return $order;
    }
} 