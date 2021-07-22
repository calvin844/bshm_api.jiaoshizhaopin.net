<?php

class Area_models extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //根据id或名称获取地区
    public function get_area_one($id = 0, $name = "") {
        if ($id > 0) {
            $this->db->where('region_code', $id);
        }
        if (!empty($name)) {
            $this->db->like('region_name', $name);
        }

        $query = $this->db->get('area');
        return $query->row_array();
    }

    //根据父级id获取地区
    public function get_area_by_pid($pid = 0) {
        $this->db->where('parent_region_code', $pid);
        $this->db->order_by('area_order', 'desc');
        $query = $this->db->get('area');
        return $query->result_array();
    }

    //获取全部地区
    public function get_area_all() {
        $this->db->order_by('area_order', 'desc');
        $query = $this->db->get('area');
        return $query->result_array();
    }

}
