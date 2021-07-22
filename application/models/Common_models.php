<?php

class Common_models extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

//检查登录状态
    public function check_login($redirect_url = "") {
        $uid = $this->session->userdata('uid');
        $redirect_url = !empty($redirect_url) ? $redirect_url : $_SERVER['REQUEST_URI'];
        $this->session->set_userdata('redirect_url', $redirect_url);
        if (!(intval($uid) > 0)) {
            return 0;
        } else {
            return intval($uid);
        }
    }

//返回页面json
    public function return_view($value) {
        if ($value) {
            echo json_encode($value);
        } else {
            echo 0;
        }
        exit;
    }

//获取分页数组
    function get_page_arr($total = 0, $page = 1, $page_num = 20) {
        $page = $page > $total ? $total : $page;
        $page = $page < 1 ? 1 : $page;
        $totalpage = ceil($total / $page_num);
        $offset = ($page - 1) * $page_num;
        $page_arr['offset'] = $offset;
        $page_arr['total'] = $total;
        $page_arr['totalpage'] = $totalpage;
        $page_arr['page_num'] = $page_num;
        $page_arr['now_page'] = $page;
        $page_arr['per_page'] = $page - 1 < 1 ? 1 : $page - 1;
        $page_arr['next_page'] = $page + 1 > $totalpage ? $totalpage : $page + 1;
        $page_arr['start_page'] = $page - 5 > 0 ? $page - 5 : 1;
        $page_arr['end_page'] = $page + 5 > $totalpage ? $totalpage : $page + 5;
        return $page_arr;
    }

}
