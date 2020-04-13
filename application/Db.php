<?php

class Db extends CI_Controller
{

    
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        if ($this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
        $this->layout->set_template('logged_in');

        $this->load->model('booking_model');
        $this->load->model('event_model');
        $this->load->model('note_model');
        $this->load->model('user_model');
    }

    
    function index()
    {
        //Allowing akses to admin only
        if($this->session->userdata('role') == $this->user_model::ROLE_ADMIN 
                && $this->session->userdata('ga_number') == NULL){
            $this->layout->render_view('styrelsen/dashboard_view', array());
        } else {
            echo "Access Denied";
        }
    }


    function create()
    {
        $dbType = $this->input->post('db_type', TRUE);
        
        if($dbType == 'user')
        {
            $redirect = 'styrelsen/anvandare/';
            
            // todo, only for board members
            $role = $this->user_model::role_GA;
            if($this->session->userdata['role'] == 1 && false)
            {
                $role = $this->user_model::ROLE_ADMIN;
            }
            $gaNumber = (int)$this->input->post('ga_number', TRUE);
            if($role == $this->user_model::ROLE_ADMIN)
            {
                $gaNumber = NULL;
            }

            $user = array(
                'created_by' => $this->session->userdata['user_id'],
                'updated_by' => $this->session->userdata['user_id'],
                'firstname' => $this->input->post('firstname', TRUE),
                'lastname' => $this->input->post('lastname', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => sha1('test1234'),
                'level' => 1,
                'role' => $role,
                'ga_number' => $gaNumber,
            );
            $this->db->insert('user', $user);
        }
        else if($dbType == "note")
        {
            $redirect = 'styrelsen/notiser/';
            $date = $this->input->post('date', TRUE);
            if ($date == "") {
                $date = NULL;
            }
            $expire = $this->input->post('expire', TRUE);
            if ($date == "") {
                $expire = NULL;
            }

            $note = array(
                'date' => $date,
                'titel' => $this->input->post('titel', TRUE),
                'note' => $this->input->post('note', TRUE),
                'color' => $this->input->post('color', TRUE),
                'expire' => $texpire,
                'display_at' => 'all',
            );

            $this->db->insert('note', $note);            
        }
        else if($dbType == 'news')
        {
            $redirect = 'styrelsen/nyheter/';
            $area = 'all';
            if($this->session->userdata('role') ==$this->user_model::ROLE_GA &&
              (int)$this->session->userdata('ga_number') > 0)
            {
                $area = (int)$this->session->userdata('ga_number');
            }
                    
            $news = array(
//                'date' => $this->input->post('date', TRUE),
                'titel' => $this->input->post('titel', TRUE),
                'description' => $this->input->post('description', TRUE),
                'area' => $area
            );

            $this->db->insert('news', $news);
        }
        else if($dbType == 'event')
        {
            $redirect = 'styrelsen/kalender/';
            $event = array(
                   'start' => $this->input->post('start', TRUE),
                   'end' => $this->input->post('end', TRUE),
                   'titel' => $this->input->post('titel', TRUE),
                   'note' => $this->input->post('note', TRUE),
                   'whole_day' => $this->input->post('whole_day', TRUE),
                   'location' => $this->input->post('location', TRUE),
                   'public' => 1 //$this->input->post('public', TRUE),
               );
               $this->db->insert('event', $event);
        }
        else if($dbType == 'event')
        {
           $redirect = 'styrelsen/bokningar/';
            $booking = array(
               'start' => $this->input->post('start', TRUE),
               'end' => $this->input->post('end', TRUE),
               'booking_type' => (int) $this->input->post('booking_type', TRUE),
               'firstname' => $this->input->post('firstname', TRUE),
               'lastname' => $this->input->post('lastname', TRUE),
               'street' => $this->input->post('street', TRUE),
               'email' => $this->input->post('email', TRUE),
               'phone' => $this->input->post('phone', TRUE),
               'note' => $this->input->post('note', TRUE),
           );
           $this->db->insert('house_booking', $booking);            
        }

        
        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0)
        {
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Användaren skapades']);
        }
        else
        {
            $this->session->set_flashdata(['type' => 'warning', 'text' => 'Användaren kunde inte skapas']);
        }
        
        // mail all board members about new user

        // mail new user about the account
        
        redirect($redirect);
    }

 

    
    
    function createbooking()
    {

        $booking = array(
            'start' => $this->input->post('start', TRUE),
            'end' => $this->input->post('end', TRUE),
            'booking_type' => (int) $this->input->post('booking_type', TRUE),
            'firstname' => $this->input->post('firstname', TRUE),
            'lastname' => $this->input->post('lastname', TRUE),
            'street' => $this->input->post('street', TRUE),
            'email' => $this->input->post('email', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'note' => $this->input->post('note', TRUE),
        );
        $this->db->insert('house_booking', $booking);

        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0)
        {
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Bokningen skapades']);            
        }
        else
        {
            $this->session->set_flashdata(['type' => 'waring', 'text' => 'Bokningen kunte inte skapas']);
        }
        redirect('styrelsen/bokningar/');
    }
    
}
