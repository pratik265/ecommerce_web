<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Chat_model');
        if (!$this->session->userdata('user_id')) {
            redirect_with_message('login', 'Please login to access chat support.', 'error');
        }
    }
    
    public function index() {
        $user_id = $this->session->userdata('user_id');
        
        $data['room'] = $this->Chat_model->get_or_create_room($user_id);
        $data['messages'] = $this->Chat_model->get_room_messages($data['room']->id);
        $data['role'] = $this->session->userdata('role'); // Pass role for consistency

        $this->load->view('chat/dynamic', $data);
    }
    
    // AJAX: Send message
    public function send_message() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $sender_id = $this->session->userdata('user_id');
        $room_id = $this->input->post('room_id');
        $message = trim($this->input->post('message'));

        if (empty($message) || empty($room_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
            return;
        }

        $message_id = $this->Chat_model->send_message(
            $room_id, 
            $sender_id, 
            'user', 
            $message
        );

        if ($message_id) {
            $new_message = $this->db->get_where('chat_messages', ['id' => $message_id])->row();
            echo json_encode(['status' => 'success', 'message' => $new_message]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
        }
    }
    
    // AJAX: Get new messages
    public function get_new_messages($room_id, $last_message_id = 0) {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $new_messages = $this->db->where('room_id', $room_id)
                                 ->where('id >', (int)$last_message_id)
                                 ->order_by('created_at', 'ASC')
                                 ->get('chat_messages')
                                 ->result();

        if (!empty($new_messages)) {
            $this->Chat_model->mark_as_read($room_id, 'admin');
        }
        
        echo json_encode(['status' => 'success', 'messages' => $new_messages]);
    }

    // AJAX: Mark messages as read
    public function mark_as_read() {
        if ($this->input->is_ajax_request()) {
            $room_id = $this->input->post('room_id');
            $this->Chat_model->mark_as_read($room_id, 'admin');
            echo json_encode(['status' => 'success']);
        }
    }
} 