<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
    }
    
    public function index() {
        // Check if user is logged in
        if (!is_logged_in()) {
            redirect_with_message('login', 'Please login to access chat support.', 'error');
        }
        $user_id = $this->session->userdata('user_id');
        $room = $this->Chat_model->get_or_create_room($user_id);
        
        // Get messages
        $messages = $this->Chat_model->get_room_messages($room->id);
        
        // Mark admin messages as read
        $this->Chat_model->mark_as_read($room->id, 'admin');
        
        $data['title'] = 'Chat with Admin';
        $data['room'] = $room;
        $data['messages'] = $messages;
        $data['unread_count'] = $this->Chat_model->get_unread_count($user_id);
        
        $this->load->view('templates/header', $data);
        $this->load->view('chat/index', $data);
        $this->load->view('templates/footer');
    }
    
    // AJAX method to send message
    public function send_message() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        // Check if user is logged in
        if (!is_logged_in()) {
            echo json_encode(array('success' => false, 'message' => 'Please login to send messages'));
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $message = trim($this->input->post('message'));
        
        if (empty($message)) {
            echo json_encode(array('success' => false, 'message' => 'Message cannot be empty'));
            return;
        }
        
        // Get or create room
        $room = $this->Chat_model->get_or_create_room($user_id);
        
        // Send message
        $message_id = $this->Chat_model->send_message($room->id, $user_id, 'user', $message);
        
        if ($message_id) {
            echo json_encode(array(
                'success' => true, 
                'message_id' => $message_id,
                'timestamp' => date('H:i')
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to send message'));
        }
    }
    
    // AJAX method to get new messages
    public function get_messages() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        // Check if user is logged in
        if (!is_logged_in()) {
            echo json_encode(array('success' => false, 'message' => 'Please login to access messages'));
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $room = $this->Chat_model->get_user_room($user_id);
        
        if (!$room) {
            echo json_encode(array('success' => false, 'message' => 'No chat room found'));
            return;
        }
        
        $messages = $this->Chat_model->get_room_messages($room->id);
        
        // Mark admin messages as read
        $this->Chat_model->mark_as_read($room->id, 'admin');
        
        $formatted_messages = array();
        foreach ($messages as $msg) {
            $formatted_messages[] = array(
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_type' => $msg->sender_type,
                'timestamp' => date('H:i', strtotime($msg->created_at)),
                'is_read' => $msg->is_read
            );
        }
        
        echo json_encode(array(
            'success' => true,
            'messages' => $formatted_messages,
            'unread_count' => $this->Chat_model->get_unread_count($user_id)
        ));
    }
    
    // AJAX method to check for new messages
    public function check_new_messages() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        // Check if user is logged in
        if (!is_logged_in()) {
            echo json_encode(array('success' => false, 'message' => 'Please login to access messages'));
            return;
        }
        
        $user_id = $this->session->userdata('user_id');
        $last_message_id = $this->input->post('last_message_id');
        
        $room = $this->Chat_model->get_user_room($user_id);
        if (!$room) {
            echo json_encode(array('success' => false));
            return;
        }
        
        // Get new messages
        $new_messages = $this->db->where('room_id', $room->id)
                                 ->where('id >', $last_message_id)
                                 ->where('sender_type', 'admin')
                                 ->order_by('created_at', 'ASC')
                                 ->get('chat_messages')
                                 ->result();
        
        // Mark as read
        if (!empty($new_messages)) {
            $this->Chat_model->mark_as_read($room->id, 'admin');
        }
        
        $formatted_messages = array();
        foreach ($new_messages as $msg) {
            $formatted_messages[] = array(
                'id' => $msg->id,
                'message' => $msg->message,
                'timestamp' => date('H:i', strtotime($msg->created_at))
            );
        }
        
        echo json_encode(array(
            'success' => true,
            'new_messages' => $formatted_messages,
            'unread_count' => $this->Chat_model->get_unread_count($user_id)
        ));
    }
} 