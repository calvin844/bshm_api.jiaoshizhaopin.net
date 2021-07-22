<?php

class News_models extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //根据URL获取公告
    public function get_news_by_url($url) {
        $this->db->where('url', $url);
        $query = $this->db->get('news_index');
        return $query->row_array();
    }

    //添加采集公告索引
    public function add_news_index($in) {
        $this->db->insert('news_index', $in);
    }

    //根据选项获取公告总数
    public function get_news_totle($option = "", $like = "") {
        if (!empty($option['gov_id'])) {
            $this->db->where('gov_id', $option['gov_id']);
        }
        if (!empty($option['start_time'])) {
            $this->db->where('addtime >', strtotime($option['start_time']));
        }
        if (!empty($option['end_time'])) {
            $this->db->where('addtime <', strtotime($option['end_time']));
        }
        if (!empty($option['state'])) {
            $this->db->where('state', $option['state']);
        }
        if (!empty($like)) {
            $this->db->like('title', $like);
        }
        $this->db->from('news_index');
        return $this->db->count_all_results();
    }

    //根据选项获取公告列表
    public function get_news_list($option = "", $like = "", $limit = 0, $offset = 0) {
        if (!empty($option['gov_id'])) {
            $this->db->where('gov_id', $option['gov_id']);
        }
        if (!empty($option['start_time'])) {
            $this->db->where('addtime >', strtotime($option['start_time']));
        }
        if (!empty($option['end_time'])) {
            $this->db->where('addtime <', strtotime($option['end_time']));
        }
        if (!empty($option['state'])) {
            $this->db->where('state', $option['state']);
        }
        if (!empty($like)) {
            $this->db->like('title', $like);
        }
        if ($limit > 0 || $offset > 0) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('top', 'desc');
        $this->db->order_by('addtime', 'desc');
        $query = $this->db->get('news_index');
        return $query->result_array();
    }

    //删除公告
    public function del_news($id = 0) {
        $set['state'] = 2;
        $this->db->where('id', $id);
        $this->db->update('news_index', $set);
        return $this->db->affected_rows();
    }

    //置顶公告
    public function top_news($id = 0) {
        $this->db->where('id', $id);
        $query = $this->db->get('news_index');
        $r = $query->row_array();
        $set['top'] = $r['top'] == 0 ? 1 : 0;
        $this->db->where('id', $id);
        $this->db->update('news_index', $set);
        return $this->db->affected_rows();
    }

}
