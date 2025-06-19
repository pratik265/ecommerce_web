<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Common Helper Functions
 */

/**
 * Insert data into table
 */
function insert_data($table, $data) {
    $CI =& get_instance();
    $CI->db->insert($table, $data);
    return $CI->db->insert_id();
}

/**
 * Update data in table
 */
function update_data($table, $data, $where) {
    $CI =& get_instance();
    $CI->db->where($where);
    return $CI->db->update($table, $data);
}

/**
 * Delete data from table
 */
function delete_data($table, $where) {
    $CI =& get_instance();
    $CI->db->where($where);
    return $CI->db->delete($table);
}

/**
 * Get single row from table
 */
function get_single_row($table, $where = array(), $select = '*') {
    $CI =& get_instance();
    $CI->db->select($select);
    if (!empty($where)) {
        $CI->db->where($where);
    }
    return $CI->db->get($table)->row();
}

/**
 * Get multiple rows from table
 */
function get_multiple_rows($table, $where = array(), $select = '*', $order_by = '', $limit = '') {
    $CI =& get_instance();
    $CI->db->select($select);
    if (!empty($where)) {
        $CI->db->where($where);
    }
    if (!empty($order_by)) {
        $CI->db->order_by($order_by);
    }
    if (!empty($limit)) {
        $CI->db->limit($limit);
    }
    return $CI->db->get($table)->result();
}

/**
 * Count rows in table
 */
function count_rows($table, $where = array()) {
    $CI =& get_instance();
    if (!empty($where)) {
        $CI->db->where($where);
    }
    return $CI->db->count_all_results($table);
}

/**
 * Upload file
 */
function upload_file($field_name, $upload_path, $allowed_types = 'gif|jpg|jpeg|png', $max_size = 2048) {
    $CI =& get_instance();
    
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = $allowed_types;
    $config['max_size'] = $max_size;
    $config['encrypt_name'] = TRUE;
    
    $CI->load->library('upload', $config);
    
    if ($CI->upload->do_upload($field_name)) {
        $upload_data = $CI->upload->data();
        return $upload_data['file_name'];
    } else {
        return FALSE;
    }
}

/**
 * Delete file
 */
function delete_file($file_path) {
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return FALSE;
}

/**
 * Generate random string
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $random_string = '';
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $random_string;
}

/**
 * Format price
 */
function format_price($price) {
    return '$' . number_format($price, 2);
}

/**
 * Get cart total
 */
function get_cart_total() {
    $CI =& get_instance();
    $cart_items = $CI->session->userdata('cart');
    $total = 0;
    
    if ($cart_items) {
        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    
    return $total;
}

/**
 * Get cart count
 */
function get_cart_count() {
    $CI =& get_instance();
    $cart_items = $CI->session->userdata('cart');
    
    if ($cart_items) {
        return count($cart_items);
    }
    
    return 0;
}

/**
 * Check if user is logged in
 */
function is_logged_in() {
    $CI =& get_instance();
    return $CI->session->userdata('user_id') && $CI->session->userdata('user_role') === 'user';
}

/**
 * Check if user is admin logged in
 */
function is_admin_logged_in() {
    $CI =& get_instance();
    return $CI->session->userdata('admin_id') && $CI->session->userdata('admin_role') === 'admin';
}

/**
 * Get current user data
 */
function get_logged_user() {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('user_id');
    
    if ($user_id) {
        return get_single_row('users', array('id' => $user_id));
    }
    
    return FALSE;
}

/**
 * Get current admin data
 */
function get_logged_admin() {
    $CI =& get_instance();
    $admin_id = $CI->session->userdata('admin_id');
    
    if ($admin_id) {
        return get_single_row('users', array('id' => $admin_id));
    }
    
    return FALSE;
}

/**
 * Check if user is admin
 */
function is_admin() {
    $admin = get_logged_admin();
    return ($admin && $admin->role == 'admin') ? TRUE : FALSE;
}

/**
 * Redirect with message
 */
function redirect_with_message($url, $message, $type = 'success') {
    $CI =& get_instance();
    $CI->session->set_flashdata('message', $message);
    $CI->session->set_flashdata('message_type', $type);
    redirect($url);
}

/**
 * Get flash message
 */
function get_flash_message() {
    $CI =& get_instance();
    $message = $CI->session->flashdata('message');
    $type = $CI->session->flashdata('message_type');
    
    if ($message) {
        return array('message' => $message, 'type' => $type);
    }
    
    return FALSE;
} 