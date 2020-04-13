<?php
// page for "Gårdsombud" (=yard proxy?)
defined('BASEPATH') OR exit('No direct script access allowed');

class YardProxy extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        if($this->session->userdata('logged_in') !== TRUE ||
            (int)$this->session->userdata('ga_number') < 1)
        {
          redirect('login');
        }
        $this->layout->set_template('logged_in');

        $this->load->model('site_model');

        $this->load->model('event_model');
        $this->load->model('booking_model');
        $this->load->model('note_model');
        $this->load->model('news_model');
        $this->load->helper('date');
        $this->load->helper('html');  

    }

    
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $ga = 'ga'.(int)$this->session->userdata('ga_number');
        
        $activeNotes = $this->note_model->get_ga_notes($ga);
        $activeNews = $this->news_model->get_future_ga_news($ga);
        $activeEvents = $this->event_model->get_future_ga_events($ga);

        $this->layout->render_view('shared/dashboard', array(
            'activeNotes' => $activeNotes,
            'activeNews' => $activeNews,
            'activeEvents' => $activeEvents,
        ));    
    }
    
    
    public function nyheter()
    {
        $news = array(); //$this->news_model->get_future_news();
        $this->layout->render_view('shared/news', array(
            'oldNews' => $news,
        ));   
    }
    
    
    public function kalender()
    {
        $events = array(); //$this->news_model->get_future_news();
        $this->layout->render_view('shared/events', array(
            'oldEvents' => $events,
        ));   
    }
    
    
    public function notiser()
    {
        $oldNotes = $this->note_model->get_old_main_notes();

        $this->layout->render_view('shared/notes', array(
            'oldNotes' => $oldNotes,
        ));
    }
    
    
    public function ga7()
    {
        $data = array('a' => 'ga7', 'b' => 444);
        $this->layout->render_view('site/sida2', $data);            
    }
    
    
    function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }
    
    
    function createnote(){
        $note = array(
            'date' => $this->input->post('date',TRUE),
            'titel' => $this->input->post('titel',TRUE),
            'note' => $this->input->post('note',TRUE),
            'expire' => $this->input->post('expire',TRUE),
            'display_at' => 'ga7',
        );

        $this->db->insert('note', $note);  
        $status = 0;
        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0) {
            $status = 1;
        }
        redirect('gardsombud/notiser/?status='.$status);
    }    
    
}
