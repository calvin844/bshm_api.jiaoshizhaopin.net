<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('admin_models');
        $this->load->model('common_models');
    }

//检查登录状态
    public function check_login($redirect_url = "") {
        $r = FALSE;
        $uid = $this->session->userdata('admin_id');
        $redirect_url = !empty($redirect_url) ? $redirect_url : $_SERVER['REQUEST_URI'];
        $this->session->set_userdata('redirect_url', $redirect_url);
        if (intval($uid) > 0) {
            $r['admin_id'] = intval($uid);
            $r['username'] = $this->session->userdata('username');
            $r['redirect_url'] = $redirect_url;
        }
        $this->common_models->return_view($r);
    }

    public function get_admin_by_up() {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user = $this->admin_models->get_admin_by_up($username, $password);
        if ($user) {
            $this->session->set_userdata(array("admin_id" => $user['id'], "username" => $user['username']));
            $flag = $user['id'];
        } else {
            $flag = FALSE;
        }
        $this->common_models->return_view($flag);
    }

}
