<?php
class Site_model extends CI_Model{

    const SITE_NAME = 'Trumpeten';
    const SITE_FULL_NAME = 'Samfälligheten Trumpeten';
    const NUMBER_OF_AREAS = 11;
    const CSS_JS_VERSION = 1.1;

    
    function latestUpdate()
    {
        $this->db->select('last_updated');
        $this->db->from('site');
        $q = $this->db->get();
        $response = $q->result_array();

        return date("Y-m-d", strtotime($response[0]['last_updated']));
    }
    
    
    function updatePageDate()
    {
        // update notes
        $this->load->model('note_model');
        $this->note_model->writeNotes();
        
        $this->db->where('id', 1);
        $response = $this->db->update('site', array('last_updated' => date("Y-m-d H:i:s"))); 
        return $response;     
    }
    
    
    function test()
    {
        return "site";   
    }
    
}