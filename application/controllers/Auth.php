<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
        $this->load->model('User_model');
        $this->load->library('form_validation');
    }
    
    public function register() {
        if (is_logged_in()) {
            redirect('home');
        }
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Register';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register', $data);
            $this->load->view('templates/footer');
        } else {
            $user_data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'role' => 'user' // Ensure new registrations are always users
            );
            
            $user_id = $this->User_model->register($user_data);
            
            if ($user_id) {
                redirect_with_message('login', 'Registration successful! Please login.');
            } else {
                redirect_with_message('register', 'Registration failed. Please try again.', 'error');
            }
        }
    }
    
    public function login() {
        if (is_logged_in()) {
            redirect('home');
        }
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $result = $this->User_model->login($email, $password);
            
            if ($result['success']) {
                $user = $result['user'];
                if ($user->role == 'admin') {
                    // Prevent admin login from user site
                    redirect_with_message('login', 'Admin must login from the admin panel.', 'error');
                } else {
                    $this->session->set_userdata(array(
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'user_email' => $user->email,
                        'user_role' => $user->role
                    ));
                    redirect('home');
                }
            } else {
                redirect_with_message('login', $result['message'], 'error');
            }
        }
    }
    
    public function logout() {
        // Clear user session data
        $this->session->unset_userdata(array('user_id', 'user_name', 'user_email', 'user_role'));
        redirect('home');
    }
    
    public function profile() {
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to view your profile.', 'error');
        }
        
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->User_model->get_user_by_id($user_id);
        $data['title'] = 'My Profile';
        
        $this->load->view('templates/header', $data);
        $this->load->view('auth/profile', $data);
        $this->load->view('templates/footer');
    }
    
    public function update_profile() {
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to update your profile.', 'error');
        }
        
        $user_id = $this->session->userdata('user_id');
        
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim');
        $this->form_validation->set_rules('address', 'Address', 'trim');
        
        if ($this->form_validation->run() == FALSE) {
            $this->profile();
        } else {
            $user_data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address')
            );
            
            // Check if email already exists for another user
            if ($this->User_model->check_email_exists($user_data['email'], $user_id)) {
                redirect_with_message('profile', 'Email already exists.', 'error');
            }
            
            if ($this->User_model->update_user($user_id, $user_data)) {
                redirect_with_message('profile', 'Profile updated successfully!');
            } else {
                redirect_with_message('profile', 'Failed to update profile.', 'error');
            }
        }
    }
    
    public function change_password() {
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to change password.', 'error');
        }
        
        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        
        if ($this->form_validation->run() == FALSE) {
            $this->profile();
        } else {
            $user_id = $this->session->userdata('user_id');
            $user = $this->User_model->get_user_by_id($user_id);
            
            if (!password_verify($this->input->post('current_password'), $user->password)) {
                redirect_with_message('profile', 'Current password is incorrect.', 'error');
            }
            
            $user_data = array('password' => $this->input->post('new_password'));
            
            if ($this->User_model->update_user($user_id, $user_data)) {
                redirect_with_message('profile', 'Password changed successfully!');
            } else {
                redirect_with_message('profile', 'Failed to change password.', 'error');
            }
        }
    }
    
    // Admin Login - Separate from user login
    public function admin_login() {
        if (is_admin_logged_in()) {
            redirect('admin/dashboard');
        }
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Admin Login';
            $this->load->view('admin/auth/login', $data);
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            
            $result = $this->User_model->login($email, $password);
            
            if ($result['success']) {
                $user = $result['user'];
                if ($user->role == 'admin') {
                    $this->session->set_userdata(array(
                        'admin_id' => $user->id,
                        'admin_name' => $user->name,
                        'admin_email' => $user->email,
                        'admin_role' => $user->role
                    ));
                    redirect('admin/dashboard');
                } else {
                    redirect_with_message('admin/login', 'Access denied. Admin privileges required.', 'error');
                }
            } else {
                redirect_with_message('admin/login', $result['message'], 'error');
            }
        }
    }
    
    // Admin Logout - Separate from user logout
    public function admin_logout() {
        $this->session->unset_userdata(array('admin_id', 'admin_name', 'admin_email', 'admin_role'));
        redirect_with_message('admin/login', 'You have been logged out successfully.');
    }
} 