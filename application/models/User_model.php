<?php
class User_model extends CI_Model
{

    const ROLE_ADMIN = 1;
    const ROLE_GA = 2;
    const ROLE_BOOKING = 3;
    const ROLE_TRANSLATION = [1 => 'Styrelse', 2 => 'Gårdsombud', 3 => 'Bokning'];

    
    public function updateLoginInfo($user, $email)
    {
    }
    
    
    public function isBoardMemberUser()
    {
        if($this->session->userdata('logged_in') !== TRUE)
        {
            return 0;
        }
        else if($this->session->userdata('role') != $this->user_model::ROLE_ADMIN || 
             (int)$this->session->userdata('ga_number')> 0)
        { 
            return 0;
        }
        return 1;
    }
    
    
    public function isGAUser()
    {
        if($this->session->userdata('logged_in') !== TRUE)
        {
            return 0;
        }
        else if((int)$this->session->userdata('ga_number') < 1){
          return 0;
        }
        return 1;
    }
    
    
    public function getUsers()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->order_by('role', 'ASC');
        $this->db->order_by('firstname', 'ASC');
        $this->db->order_by('lastname', 'ASC');
        $this->db->order_by('ga_number', 'ASC');
        $q = $this->db->get();
        $response = $q->result_array();

        return $response;
    }
    
    
    function test()
    {
       return 'user';   
    }
    
}