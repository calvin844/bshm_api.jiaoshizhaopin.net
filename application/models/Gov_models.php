<?php

class Gov_models extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //根据id或名称获取政府部门
    public function get_gov_one($id = 0, $name = "") {
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($name)) {
            $this->db->like('gov_name', $name);
        }
        $query = $this->db->get('gov');
        return $query->row_array();
    }

    //根据选项获取公告列表
    public function get_gov_list($option = array('area_id' => -1), $limit = 0, $offset = 0) {
        if ($option['area_id'][0] > -1) {
            $this->db->where_in('area_id', $option['area_id']);
        }
        if ($limit > 0 || $offset > 0) {
            $this->db->limit($limit, $offset);
        }
        $query = $this->db->get('gov');
        return $query->result_array();
    }

    //根据父级id获取地区
    public function set_gov_by_id($id = 0, $set) {
        $this->db->where('id', $id);
        $this->db->update('gov', $set);
    }

    public function add_gov($data) {
        $this->db->insert('gov', $data);
        $add_id = $this->db->insert_id();
        return $add_id;
    }

    //根据选项获取公告总数
    public function get_gov_totle($option = "") {
        if ($option['area_id'] > -1) {
            $this->db->where('area_id', $option['area_id']);
        }
        $this->db->from('gov');
        return $this->db->count_all_results();
    }

}
