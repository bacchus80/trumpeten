<?php
class Js extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->layout->set_template('empty');

        $this->load->model('booking_model');
        $this->load->model('event_model');
        $this->load->model('note_model');
        $this->load->model('user_model');
    }
    

    // read data from file
    function getNotes()
    {   
        echo file_get_contents(BASEPATH."../assets/notes/notes.txt");
    }
    
}
