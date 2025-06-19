<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    // Get or create chat room for user and admin
    public function get_or_create_room($user_id, $admin_id = 1) {
        $room = $this->db->where('user_id', $user_id)
                        ->where('admin_id', $admin_id)
                        ->get('chat_rooms')
                        ->row();
        
        if (!$room) {
            $user = $this->db->where('id', $user_id)->get('users')->row();
            $room_name = 'Chat with ' . ($user ? $user->name : 'User');
            
            $room_data = array(
                'user_id' => $user_id,
                'admin_id' => $admin_id,
                'room_name' => $room_name
            );
            
            $this->db->insert('chat_rooms', $room_data);
            $room_id = $this->db->insert_id();
            
            return $this->db->where('id', $room_id)->get('chat_rooms')->row();
        }
        
        return $room;
    }
    
    // Get all chat rooms for admin
    public function get_admin_rooms() {
        return $this->db->select('cr.*, u.name as user_name, u.email as user_email, 
                                 (SELECT COUNT(*) FROM chat_messages cm WHERE cm.room_id = cr.id AND cm.is_read = 0 AND cm.sender_type = "user") as unread_count,
                                 (SELECT cm.message FROM chat_messages cm WHERE cm.room_id = cr.id ORDER BY cm.created_at DESC LIMIT 1) as last_message,
                                 (SELECT cm.created_at FROM chat_messages cm WHERE cm.room_id = cr.id ORDER BY cm.created_at DESC LIMIT 1) as last_message_time')
                        ->from('chat_rooms cr')
                        ->join('users u', 'u.id = cr.user_id')
                        ->where('cr.admin_id', 1)
                        ->order_by('last_message_time', 'DESC')
                        ->get()
                        ->result();
    }
    
    // Get chat room for user
    public function get_user_room($user_id) {
        return $this->db->select('cr.*, u.name as user_name, u.email as user_email')
                        ->from('chat_rooms cr')
                        ->join('users u', 'u.id = cr.user_id')
                        ->where('cr.user_id', $user_id)
                        ->where('cr.admin_id', 1)
                        ->get()
                        ->row();
    }
    
    // Get messages for a room
    public function get_room_messages($room_id, $limit = 50) {
        return $this->db->where('room_id', $room_id)
                        ->order_by('created_at', 'ASC')
                        ->limit($limit)
                        ->get('chat_messages')
                        ->result();
    }
    
    // Send message
    public function send_message($room_id, $sender_id, $sender_type, $message) {
        $data = array(
            'room_id' => $room_id,
            'sender_id' => $sender_id,
            'sender_type' => $sender_type,
            'message' => $message,
            'is_read' => 0
        );
        
        $this->db->insert('chat_messages', $data);
        return $this->db->insert_id();
    }
    
    // Mark messages as read
    public function mark_as_read($room_id, $sender_type) {
        return $this->db->where('room_id', $room_id)
                        ->where('sender_type', $sender_type)
                        ->where('is_read', 0)
                        ->update('chat_messages', array('is_read' => 1));
    }
    
    // Get unread message count for user
    public function get_unread_count($user_id) {
        $room = $this->get_user_room($user_id);
        if (!$room) return 0;
        
        return $this->db->where('room_id', $room->id)
                        ->where('sender_type', 'admin')
                        ->where('is_read', 0)
                        ->count_all_results('chat_messages');
    }
    
    // Get unread message count for admin
    public function get_admin_unread_count() {
        return $this->db->where('sender_type', 'user')
                        ->where('is_read', 0)
                        ->count_all_results('chat_messages');
    }
    
    // Get recent messages for admin dashboard
    public function get_recent_messages($limit = 5) {
        return $this->db->select('cm.*, cr.room_name, u.name as user_name')
                        ->from('chat_messages cm')
                        ->join('chat_rooms cr', 'cr.id = cm.room_id')
                        ->join('users u', 'u.id = cr.user_id')
                        ->order_by('cm.created_at', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }
    
    // Delete chat room (for admin)
    public function delete_room($room_id) {
        // Delete all messages first
        $this->db->where('room_id', $room_id)->delete('chat_messages');
        // Delete room
        return $this->db->where('id', $room_id)->delete('chat_rooms');
    }
    
    // Get chat statistics
    public function get_chat_stats() {
        $stats = array();
        
        $stats['total_rooms'] = $this->db->count_all('chat_rooms');
        $stats['total_messages'] = $this->db->count_all('chat_messages');
        $stats['unread_messages'] = $this->db->where('is_read', 0)->count_all_results('chat_messages');
        $stats['today_messages'] = $this->db->where('DATE(created_at)', date('Y-m-d'))->count_all_results('chat_messages');
        
        return $stats;
    }
} 