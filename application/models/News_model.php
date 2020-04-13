<?php
class News_model extends CI_Model
{

  
    function get_future_news()
    {
        $date = date("Y-m-d", strtotime("-1 months"));

        $this->db->select('*');
        $this->db->where('DATE(created) >= ', $date);
        $this->db->where('display_at IN("main", "all")');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_active_news()
    {
        $now = date("Y-m-d");
        $this->db->select('*');
        $this->db->where('DATE(created) >= ',date("Y-m-d",strtotime($now."-1 months")));
        $this->db->where('display_at IN("main", "all")');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_inactive_news()
    {
        $now = date("Y-m-d");
        $this->db->select('*');
        $this->db->where('DATE(created) < ',date("Y-m-d",strtotime($now."-1 months")));
        $this->db->where('display_at IN("main", "all")');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
    
    function getOldNews()
    {
        $now = date("Y-m-d");
        $this->db->select('*');
        $this->db->where('DATE(created) < ',date("Y-m-d",strtotime($now."-1 months")));
        $this->db->where('display_at IN("main", "all")');
        $this->db->order_by('created', 'DESC');
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_future_ga_news($ga)
    {
        $this->db->select('*');
        $this->db->where('display_at IN("all", "'.$ga.'")');
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_old_ga_news($ga)
    {
        $this->db->select('*');
        $this->db->where('display_at', $ga);
        $q = $this->db->get('news');
        $response = $q->result_array();

        return $response;
    }
    
 /*
    // Select record
    $this->db->select('*');
    $q = $this->db->get('users');
    $response = $q->result_array();

    return $response;
  */
}