<?php

class Admin_models extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //根据用户名和密码获取管理员
    public function get_admin_by_up($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get('admin');
        return $query->row_array();
    }

    //根据id或名称获取政府部门
    public function get_gov($id = 0, $name = "") {
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($name)) {
            $this->db->like('gov_name', $name);
        }
        $query = $this->db->get('gov');
        return $query->result_array();
    }

}
