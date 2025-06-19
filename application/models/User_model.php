<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }
    
    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return insert_data('users', $data);
    }
    
    public function login($email, $password) {
        $user = get_single_row('users', array('email' => $email));
        
        if ($user && password_verify($password, $user->password)) {
            if ($user->status == 'blocked') {
                return array('success' => false, 'message' => 'Your account has been blocked. Please contact admin.');
            }
            return array('success' => true, 'user' => $user);
        }
        
        return array('success' => false, 'message' => 'Invalid email or password');
    }
    
    public function get_all_users() {
        return get_multiple_rows('users', array(), '*', 'created_at DESC');
    }
    
    public function get_user_by_id($id) {
        return get_single_row('users', array('id' => $id));
    }
    
    public function update_user($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        
        return update_data('users', $data, array('id' => $id));
    }
    
    public function delete_user($id) {
        return delete_data('users', array('id' => $id));
    }
    
    public function block_user($id) {
        return update_data('users', array('status' => 'blocked'), array('id' => $id));
    }
    
    public function unblock_user($id) {
        return update_data('users', array('status' => 'active'), array('id' => $id));
    }
    
    public function check_email_exists($email, $exclude_id = null) {
        $where = array('email' => $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return count_rows('users', $where) > 0;
    }
} 