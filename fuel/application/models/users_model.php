<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(FUEL_PATH . 'models/base_module_model.php');

class Users_model extends Base_module_model {

    public $required = array('user_name', 'email', 'first_name', 'last_name');
    public $filters = array('first_name', 'last_name', 'user_name');
    public $unique_fields = array('user_name');

    function __construct() {
        $this->load->library('session');
        parent::__construct('liit_users');
    }

    function valid_user($user, $pwd) {
        $where = array('user_name' => $user, 'password' => sha1($pwd), 'is_active' => 1);
        return $this->find_one_array($where);
    }

    function get_user_id_from_user_name($user_name) {
        $result = $this->db->get_where('liit_users', array('user_name' => $user_name));
        return $result->row();
    }

    function user_data() {
        return $this->session->userdata('login_user_info');
    }

    function user_update($category) {
        if ($category['id']) {
            $this->db->where('id', $category['id']);
            $this->db->update('liit_users', $category);
            return $category['id'];
        } else {
            $this->db->insert('liit_users', $category);
            return $this->db->insert_id();
        }
    }

    function user_allready_exists($user_name) {
        $query = $this->db->get_where('liit_users', array('user_name' => $user_name));
        return ($query->num_rows() != 0);
    }

}

//
//class User_model extends Base_module_record {
//    
//}