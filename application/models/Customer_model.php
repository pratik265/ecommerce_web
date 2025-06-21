<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $this->db->insert('customers', $data) ? $this->db->insert_id() : false;
    }

    public function login($email, $password) {
        $customer = $this->db->where('email', $email)->get('customers')->row();
        if ($customer && password_verify($password, $customer->password)) {
            if ($customer->status == 'blocked') {
                return array('success' => false, 'message' => 'Your account has been blocked. Please contact your user.');
            }
            return array('success' => true, 'customer' => $customer);
        }
        return array('success' => false, 'message' => 'Invalid email or password');
    }

    public function get_all_customers($user_id = null) {
        if ($user_id !== null) {
            $this->db->where('user_id', $user_id);
        }
        return $this->db->order_by('created_at', 'DESC')->get('customers')->result();
    }

    public function get_customer_by_id($id) {
        return $this->db->get_where('customers', ['id' => $id])->row();
    }

    public function update_customer($id, $data) {
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['password']);
        }
        return $this->db->where('id', $id)->update('customers', $data);
    }

    public function delete_customer($id) {
        return $this->db->where('id', $id)->delete('customers');
    }

    public function block_customer($id) {
        return $this->db->where('id', $id)->update('customers', array('status' => 'blocked'));
    }

    public function unblock_customer($id) {
        return $this->db->where('id', $id)->update('customers', array('status' => 'active'));
    }

    public function check_email_exists($email, $exclude_id = null) {
        $this->db->where('email', $email);
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        return $this->db->count_all_results('customers') > 0;
    }

    public function update_profile($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('customers', $data);
    }

    public function change_password($id, $current_password, $new_password) {
        $customer = $this->get_customer_by_id($id);
        if ($customer && password_verify($current_password, $customer->password)) {
            $this->db->where('id', $id);
            return $this->db->update('customers', ['password' => password_hash($new_password, PASSWORD_DEFAULT)]);
        }
        return false;
    }
} 