<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }
    
    public function get_all_products($limit = null, $offset = null) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.status', 'active');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_product_by_id($id) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row();
    }
    
    public function get_product_by_slug($slug) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.slug', $slug);
        $this->db->where('products.status', 'active');
        return $this->db->get()->row();
    }
    
    public function get_products_by_category($category_id, $limit = null) {
        $where = array('category_id' => $category_id, 'status' => 'active');
        return get_multiple_rows('products', $where, '*', 'created_at DESC', $limit);
    }
    
    public function search_products($keyword) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.status', 'active');
        $this->db->group_start();
        $this->db->like('products.name', $keyword);
        $this->db->or_like('products.description', $keyword);
        $this->db->or_like('categories.name', $keyword);
        $this->db->group_end();
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    public function add_product($data) {
        return insert_data('products', $data);
    }
    
    public function update_product($id, $data) {
        return update_data('products', $data, array('id' => $id));
    }
    
    public function delete_product($id) {
        $product = $this->get_product_by_id($id);
        if ($product && $product->image) {
            delete_file('./uploads/products/' . $product->image);
        }
        return delete_data('products', array('id' => $id));
    }
    
    public function get_featured_products($limit = 6) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.status', 'active');
        $this->db->order_by('products.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function get_sale_products($limit = 6) {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('status', 'active');
        $this->db->where('sale_price IS NOT NULL');
        $this->db->where('sale_price >', 0);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function update_stock($product_id, $quantity) {
        $product = $this->get_product_by_id($product_id);
        if ($product) {
            $new_stock = $product->stock_quantity - $quantity;
            if ($new_stock >= 0) {
                return update_data('products', array('stock_quantity' => $new_stock), array('id' => $product_id));
            }
        }
        return false;
    }
    
    public function get_product_sales_report($start_date = null, $end_date = null) {
        $this->db->select('products.name, products.price, SUM(order_items.quantity) as total_sold, SUM(order_items.quantity * order_items.price) as total_revenue');
        $this->db->from('order_items');
        $this->db->join('products', 'products.id = order_items.product_id');
        $this->db->join('orders', 'orders.id = order_items.order_id');
        
        if ($start_date) {
            $this->db->where('orders.created_at >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('orders.created_at <=', $end_date);
        }
        
        $this->db->where('orders.status !=', 'cancelled');
        $this->db->group_by('products.id');
        $this->db->order_by('total_revenue', 'DESC');
        
        return $this->db->get()->result();
    }
} 