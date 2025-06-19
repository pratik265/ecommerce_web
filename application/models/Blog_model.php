<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('common');
    }
    
    public function get_all_blogs($limit = null, $offset = null) {
        $this->db->select('blogs.*, users.name as author_name');
        $this->db->from('blogs');
        $this->db->join('users', 'users.id = blogs.author_id', 'left');
        $this->db->where('blogs.status', 'published');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('blogs.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_blog_by_id($id) {
        $this->db->select('blogs.*, users.name as author_name');
        $this->db->from('blogs');
        $this->db->join('users', 'users.id = blogs.author_id', 'left');
        $this->db->where('blogs.id', $id);
        return $this->db->get()->row();
    }
    
    public function get_blog_by_slug($slug) {
        $this->db->select('blogs.*, users.name as author_name');
        $this->db->from('blogs');
        $this->db->join('users', 'users.id = blogs.author_id', 'left');
        $this->db->where('blogs.slug', $slug);
        $this->db->where('blogs.status', 'published');
        return $this->db->get()->row();
    }
    
    public function get_recent_blogs($limit = 5) {
        $this->db->select('blogs.*, users.name as author_name');
        $this->db->from('blogs');
        $this->db->join('users', 'users.id = blogs.author_id', 'left');
        $this->db->where('blogs.status', 'published');
        $this->db->order_by('blogs.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }
    
    public function search_blogs($keyword) {
        $this->db->select('blogs.*, users.name as author_name');
        $this->db->from('blogs');
        $this->db->join('users', 'users.id = blogs.author_id', 'left');
        $this->db->where('blogs.status', 'published');
        $this->db->group_start();
        $this->db->like('blogs.title', $keyword);
        $this->db->or_like('blogs.content', $keyword);
        $this->db->group_end();
        $this->db->order_by('blogs.created_at', 'DESC');
        return $this->db->get()->result();
    }
    
    public function add_blog($data) {
        return insert_data('blogs', $data);
    }
    
    public function update_blog($id, $data) {
        return update_data('blogs', $data, array('id' => $id));
    }
    
    public function delete_blog($id) {
        $blog = $this->get_blog_by_id($id);
        if ($blog && $blog->image) {
            delete_file('./uploads/blogs/' . $blog->image);
        }
        return delete_data('blogs', array('id' => $id));
    }
    
    public function get_blogs_by_author($author_id, $limit = null) {
        $where = array('author_id' => $author_id, 'status' => 'published');
        return get_multiple_rows('blogs', $where, '*', 'created_at DESC', $limit);
    }
    
    public function publish_blog($id) {
        return update_data('blogs', array('status' => 'published'), array('id' => $id));
    }
    
    public function draft_blog($id) {
        return update_data('blogs', array('status' => 'draft'), array('id' => $id));
    }
    
    public function get_blog_count() {
        return count_rows('blogs', array('status' => 'published'));
    }
} 