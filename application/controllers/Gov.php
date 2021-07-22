<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gov extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('gov_models');
        $this->load->model('area_models');
        $this->load->model('common_models');
    }

    public function get_gov_list() {
        $area_id = isset($_POST['area_id']) ? intval($_POST['area_id']) : -1;
        $option['area_id'] = array($area_id);
        if ($area_id > -1) {
            $area = $this->area_models->get_area_one($area_id);
            if ($area['parent_region_code'] == 0) {
                $s1 = $this->area_models->get_area_by_pid($area_id);
                foreach ($s1 as $s1) {
                    $option['area_id'][] = $s1['region_code'];
                    $s2_tmp = $this->area_models->get_area_by_pid($s1['region_code']);
                    foreach ($s2_tmp as $s2t) {
                        $s2[] = $s2t;
                    }
                }
            } else {
                $s2 = $this->area_models->get_area_by_pid($area_id);
            }
            foreach ($s2 as $s) {
                $option['area_id'][] = $s['region_code'];
            }
        }
        $gov = $this->gov_models->get_gov_list($option);
        $this->common_models->return_view($gov);
    }

    public function get_gov_list_page() {
        $option['area_id'] = isset($_POST['area_id']) ? intval($_POST['area_id']) : -1;
        $option['page'] = isset($_POST['page']) ? trim($_POST['page']) : "1";
        $totle = $this->gov_models->get_gov_totle($option);
        $page_arr = $this->common_models->get_page_arr($totle, $option['page'], 5);
        $gov['list'] = $this->gov_models->get_gov_list($option, $page_arr['page_num'], $page_arr['offset']);
        $gov['page'] = $page_arr;
        $gov['option'] = $option;
        $this->common_models->return_view($gov);
    }

    public function get_gov_area_list() {
        $gov = $this->gov_models->get_gov_list();
        foreach ($gov as $g) {
            $g['area'] = $this->area_models->get_area_one($g['area_id']);
            $gov_list[] = $g;
        }
        $this->common_models->return_view($gov_list);
    }

    public function set_gov() {
        $id = intval($_GET['gov_id']);
        $set['area_id'] = intval($_GET['area_id']);
        $set['gov_name'] = trim($_GET['gov_name']);
        $this->gov_models->set_gov_by_id($id, $set);
    }

    public function add_gov() {
        $set['area_id'] = intval($_POST['area_id']);
        $set['gov_name'] = trim($_POST['gov_name']);
        $this->gov_models->add_gov($set);
    }

}
