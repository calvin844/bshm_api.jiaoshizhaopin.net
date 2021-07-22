<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('area_models');
        $this->load->model('common_models');
    }

    public function get_area_by_id() {
        $id = $_GET['id'];
        $area = $this->area_models->get_area_one($id);
        $this->common_models->return_view($area);
    }

    public function get_area_list_by_pid() {
        $id = $_GET['pid'];
        $area = $this->area_models->get_area_by_pid($id);
        $this->common_models->return_view($area);
    }

    public function get_area_all() {
        $area = $this->area_models->get_area_all();
        $this->common_models->return_view($area);
    }
	
	

}
