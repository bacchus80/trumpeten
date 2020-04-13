<?php
class Event_model extends CI_Model
{

    function get_future_events($onlyShowPublic=true)
    {
        $date = date("Y-m-d");
        $this->db->select('*'); //date, titel, note, expire, color, image
        $this->db->from('event');
        $this->db->where('display_at IN("all", "main")');
        $this->db->where('DATE(start) >= ', $date);
        $this->db->order_by('start', 'ASC');
        if($onlyShowPublic)
        {
            $this->db->where('public', 1);
        }
        $this->db->order_by('start', 'ASC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_future_public_events()
    {
        $this->get_future_events(true);
    }
    
    
    function get_old_main_event()
    {
        $this->db->select('*'); //date, titel, note, expire, color, image
        $this->db->from('event');
        $this->db->where('DATE(start) < ',date("Y-m-d"));
        $this->db->order_by('start', 'DESC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_future_ga_events($ga)
    {
        $this->db->select('*'); //date, titel, note, expire, color, image
        $this->db->from('event');
        $this->db->where('DATE(start) >= ',date("Y-m-d"));
        $this->db->group_start();
        $this->db->where('display_at', 'all');
        $this->db->where('public', 1);
        $this->db->or_where('display_at',$ga);
        $this->db->group_end();
        $this->db->order_by('start', 'ASC');
        $q = $this->db->get();
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