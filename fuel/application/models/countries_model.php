<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once(FUEL_PATH . 'models/base_module_model.php');

class Countries_model extends Base_module_model {

    public $required = array('name');
    public $unique_fields = array('name');

    function __construct() {
        parent::__construct('countries');
    }

    function list_items($limit = NULL, $offset = NULL, $col = 'sequence', $order = 'asc') {

        $this->db->select('countries.id, countries.name as Name ', FALSE);
        $data = parent::list_items($limit, $offset, $col, $order);
        return $data;
    }

    function options_list($key = 'name', $val = 'name', $where = array(), $order = 'name') {
        $CI = & get_instance();
        if ($key == 'name') {
            $key = $this->table_name . '.name';
        }
        if ($val == 'name') {
            $val = 'name as name';
        }


        $return = parent::options_list($key, $val, $where, $order);
        return $return;
    }

    function gender_option_list() {
        $return = array();
        $return["Male"] = "Male";
        $return["Female"] = "Female";
        return $return;
    }

    function list_active_items($limit = NULL, $offset = NULL, $col = 'name', $order = 'asc') {

        $this->db->select('countries.id, countries.name as name ', FALSE);
        $data = parent::list_items($limit, $offset, $col, $order);
        return $data;
    }

    function get_country_id($name) {

        $this->db->select('id, name ', FALSE);
        $this->db->where(array('status' => 1, 'name' => $name));
        $data = $this->get('gc_countries')->result();
        return $data[0]['id'];
    }

    function get_country($id) {
        $this->db->where('id', $id);
        return $this->db->get('gc_countries')->row();
    }

    function get_zone($name) {

        $this->db->where('name', $name);
        $zone = $this->db->get('gc_country_zones')->row();
        return $zone;
    }

}

class Country_model extends Data_record {
    
}