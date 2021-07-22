<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('news_models');
        $this->load->model('gov_models');
        $this->load->model('common_models');
    }

    public function news_list() {
        $option = $list = $like = "";
        isset($_GET['gov_id']) ? $option['gov_id'] = intval($_GET['gov_id']) : "";
        isset($_GET['start_time']) ? $option['start_time'] = trim($_GET['start_time']) : "";
        isset($_GET['end_time']) ? $option['end_time'] = trim($_GET['end_time']) : "";
        $option['page'] = isset($_GET['page']) ? trim($_GET['page']) : "1";
        isset($_GET['key']) ? $like = trim($_GET['key']) : "";
        $option['state'] = 1;
        $totle = $this->news_models->get_news_totle($option, $like);
        $page_arr = $this->common_models->get_page_arr($totle, $option['page']);
        $news_list = $this->news_models->get_news_list($option, $like, $page_arr['page_num'], $page_arr['offset']);
        foreach ($news_list as $nl) {
            $nl['gov'] = $this->gov_models->get_gov_one($nl['gov_id']);
            $list[] = $nl;
        }
        $r_data['list'] = $list;
        $r_data['page'] = $page_arr;
        $option['key'] = $like;
        $r_data['option'] = $option;
        $this->common_models->return_view($r_data);
    }

    public function del_news() {
        $id_arr_t = isset($_POST['id']) ? $_POST['id'] : 0;
        $id_arr = is_array($id_arr_t) ? $id_arr_t : array($id_arr_t);
        foreach ($id_arr as $i) {
            $r['id'] = $i;
            $r['result'] = $this->news_models->del_news($i) > 0 ? TRUE : FALSE;
            $r_data[] = $r;
        }
        $this->common_models->return_view($r_data);
    }

    public function top_news() {
        $id_arr_t = isset($_POST['id']) ? $_POST['id'] : 0;
        $id_arr = is_array($id_arr_t) ? $id_arr_t : array($id_arr_t);
        foreach ($id_arr as $i) {
            $r['id'] = $i;
            $r['result'] = $this->news_models->top_news($i) > 0 ? TRUE : FALSE;
            $r_data[] = $r;
        }
        $this->common_models->return_view($r_data);
    }

}
