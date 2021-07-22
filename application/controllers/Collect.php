<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Collect extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('news_models');
    }

    public function index() {
        $data['gov_id'] = intval($_POST['gov_id']);
        $data['title'] = trim($_POST['title']);
        $data['url'] = trim($_POST['url']);
        $data['addtime'] = strtotime($_POST['addtime']);
        $data['collecttime'] = intval($_POST['collecttime']);
        $flag = $this->news_models->get_news_by_url($data['url']);
        if(!$flag){
            $this->news_models->add_news_index($data);
        }
       
    }

}
