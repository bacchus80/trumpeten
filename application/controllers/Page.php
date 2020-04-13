<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller
{
    
    public $lastUpdated = '';
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('event_model');
        $this->load->model('booking_model');
        $this->load->model('news_model');
        $this->load->model('note_model');
        $this->load->model('login_model');
        $this->load->model('user_model');
        $this->load->model('site_model');

        $this->lastUpdated = $this->site_model->latestUpdate();
        
        if((int)$this->session->userdata('show_notes') < 1)
        {
//            echo $this->session->userdata('show_notes') ;
        }
        $session = $this->session->userdata;
//        echo $session['__ci_last_regenerat'];
//        print_r($this->session->session_id);
    }
    
    
    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $notes = array();
        if($this->session->userdata('show_notes') == 1)
        {
            $notes = $this->note_model->get_notes();
            $this->session->set_userdata(['show_notes' => 0]);
        }
        $events = $this->event_model->get_future_events();
        $news = $this->news_model->get_future_news();
        
        $this->layout->add_css_uri('assets/css/start.css');
        $this->layout->render_view('page/home',  array(
            'notes' => $notes,
            'events' => $events,
            'news' => $news,
        ));            
    }
    
    
    public function page($page='')
    {
//        echo "visa sida [".$page."]";
    }
    
    
    /**
     * TODO
     */
    public function forgot()
    {
        echo "Att göra";
    }
    
    
    public function error404()
    {
        $this->layout->set_title('404 - sidan hittades inte');
        $this->layout->render_view('page/error404',  array());            
    }
    
    
    function login()
    {
        $this->layout->set_title('Logga in');
        $this->layout->render_view('page/login',  array());            
    }
    
    
    function auth()
    {
        $email    = $this->input->post('email',TRUE);
        $password = sha1($this->input->post('password',TRUE));
        $validate = $this->login_model->validate($email, $password);
      
        if($validate->num_rows() > 0)
        {
            $data  = $validate->row_array();
            $firstname  = $data['firstname'];
            $lastname  = $data['lastname'];
            $email = $data['email'];
            $gaNumber = $data['ga_number'];
            $userGroup = $data['role'];
            $sesdata = array(
                'user_id'  => $data['id'],
                'username'  => $firstname. ' '.$lastname,
                'email'     => $email,
                'role'     => $userGroup,
                'ga_number'     => $gaNumber,
                'logged_in' => TRUE
            );

    //          $this->user_model->updateLoginInfo($email, $password);

            $this->session->set_userdata($sesdata);
            // access login for admin
            if($userGroup == $this->user_model::ROLE_ADMIN && $gaNumber == '')
            {
                redirect('/styrelsen');
            // access login for staff
            }
            elseif($userGroup == $this->user_model::ROLE_GA && (int)$gaNumber > 0)
            {
                redirect('gardsombud');
            // access login for author
            }
            else
            {
                redirect('/');
            }
        }
        else
        {
            $this->session->set_flashdata('msg','Användarnamn eller lösenord är felaktigt.');
            redirect('/login');
      }
    }
    
    
    function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }    
    
    
    public function bylaws()
    { 
        $this->layout->set_title('Stadgar');
        $this->layout->render_view('page/bylaws',  array());            
    }  

    
    public function info()
    { 
        $this->layout->render_view('page/information',  array('a' => 'info', 'b' => 444));            
    }  

    
    public function news()
    { 
        $this->layout->render_view('page/news',  array('news' => $news));            
    }  

    
    public function contact()
    { 
        // board
        $board = [
            ['role' => 'Ordförande', 'name' => 'Johan Ronner'],
            ['role' => 'Kassör', 'name' => 'Erik Frid'],
            //['role' => 'Sekreterare', 'name' => 'Stefan Marshall'],
            ['role' => 'Sekreterare', 'name' => 'Andreas Eriksson'],
            ['role' => 'Ledamot', 'name' => 'Erling Larsson'],
            ['role' => 'Suppleant', 'name' => 'Lena Ahrenberg'],
            ['role' => 'Suppleant', 'name' => 'Ninni Alvestan'],
            ['role' => 'Suppleant', 'name' => 'Marcus Karlsson'],
        ];

        $this->layout->set_title('Kontakt');
        $this->layout->render_view('page/contact',  array('board' => $board));            
    }   
    

    public function areas($ga='')
    { 
        $param = substr($ga, 0, 4);
        $view = 'page/ga_main';
        $notes = array();
        $news = array();
        
        if(substr($param, 0, 2) == 'ga'  && in_array(substr($param, 2) , [1,2,3,4,5,6,7,8,9,10,11]))
        {
            $notes = $this->note_model->get_ga_notes($ga);
            $news = $this->news_model->get_future_ga_news($ga);
            $view = 'page/ga';
        }
        
        $ga = mb_strtoupper($ga);
        $gaLowerCase = mb_strtolower($ga);
        
        $this->layout->set_title('Områden');
        $this->layout->render_view($view,  array(
            'ga' => $ga, 
            'gaLowerCase' => $gaLowerCase, 
            'notes' => $notes, 'news' => $news));            
    }    

    
    public function newlyMovedIn()
    { 
        $this->layout->set_title('Nyinfyttad');
        $this->layout->render_view('page/newly_moved_in',  array('a' => 'Ininfyttad', 'b' => 444));            
    }  

    
    public function calendar($param='')
    { 
        $events = $this->event_model->get_future_events();
        
        $this->layout->render_view('page/events',  array('events' => $events));            
    }    

    
    public function calendarSubscription($param='')
    { 
        $allowedParams = ['styrelsen', 'trumpeten'
            , 'ga1', 'ga2', 'ga3', 'ga4', 'ga5', 'ga6', 'ga7', 'ga8', 'ga9', 'ga10', 'ga11'];
        if($param != '' && in_array($param, $allowedParams ))
        {
            if(substr($param, 0, 2) == 'ga')
            {
//                $param = mb_strtoupper($param);
            }
            header("Content-Type: text/Calendar;charset=utf-8");
            header("Content-Disposition: inline; filename=Trumpeten-".$param.".ics");
            $basePath = $_SERVER['DOCUMENT_ROOT']."/assets/calendar/";
            $basePath = BASEPATH."/../assets/calendar/";
            include($basePath."calendar-start.txt");
            include($basePath."calendar-".$param.".txt");
            include($basePath."calendar-end.txt");	            
            exit;
        }
        else if($param != '' && !in_array($param, $allowedParams))
        {
            redirect("/");
        }
    } 
    
    
    public function earlierNews()
    {        
        $inactiveNews = $this->news_model->get_inactive_news();
        $this->layout->render_view('page/earlier_news',  array(
            'inactiveNews' => $inactiveNews));            
    }
    

    public function blahuset($page=false)
    { 
        $this->load->helper('date');
        $web_booking = $this->booking_model->emptyModel();
        $validation = [];

      /*
      return $this->db
     ->where('LastName', 'Svendson');
     ->where('Age', 12);
     ->group_start()
         ->where('FirstName','Tove')
         ->or_where('FirstName','Ola')
         ->or_where('Gender','M')
         ->or_where('Country','India')
     ->group_end()
     ->get('Persons')
     ->result();
      */
      
    
        if($_POST)
        {
          $letters = "abcdefghijklmnopqrstavwxyzABCDEFGHIJKLMNOPQRSTAVWXYZ0123456789-";
          $max = strlen($letters);
          $hash = "";
          for($i = 0; $i < 20;$i++)
          {
            $hash .= substr($letters, rand(0, $max), 1);
          }

          $web_booking = array(
            'start' => $this->input->post('start', TRUE),
            'end' => $this->input->post('end', TRUE),
            'booking_type' => (int) $this->input->post('booking_type', TRUE),
            'firstname' => $this->input->post('firstname', TRUE),
            'lastname' => $this->input->post('lastname', TRUE),
            'street' => $this->input->post('street', TRUE),
            'email' => $this->input->post('email', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'note' => $this->input->post('note', TRUE),
            'ok' => $this->input->post('ok', TRUE),
            'hash' => $hash,
            'ip_number' => $_SERVER["REMOTE_ADDR"],
            'user_agent' => $_SERVER["HTTP_USER_AGENT"]
          );


          $validation = $this->booking_model->validate($web_booking);
          if(empty($validation))
          {
              unset($web_booking["ok"]);
              $this->db->insert('web_booking', $web_booking);
              redirect("/blahuset/tack");
          }


          /*
          SELECT * FROM `house_booking` WHERE 
  (start <= '2019-12-10 11:00:00' and end >= '2019-12-10 17:00:00') or
  (start >= '2019-12-10 11:00:00' and end <= '2019-12-10 17:00:00') or
  (start > '2019-12-10 11:00:00' and start >= '2019-12-10 11:00:00') or
  (end > '2019-12-10 17:00:00' and end <= '2019-12-10 17:00:00')
          */


        }

        $view = "blahuset";
        $title = 'Blå huset';
        if($page == "boka")
        {
          $title .= ", boka";
          $view = "blahuset_reserve";
        }
        else if($page == "tack")
        {
          $title .= ", tack för din bokning";
          $view = "blahuset_thanks";
        }
        
        $bookings = $this->booking_model->get_future_bookings();
        $this->layout->set_title($title);
        $this->layout->render_view('page/'.$view,  array(
            'model' => $web_booking,
            'bookings' => $bookings,
            'days' => days(),
            'months' => months(),
            'validation' => $validation,
            'valueListBookingTypes' => $this->booking_model->valueListBookingTypes(),
        ));            
    } 
    
    
    public function bookingConfirmation()
    {
        $this->layout->render_view('page/booking_confirmation_thanks',  array()); 
    }
    
    
    public function emailConfirmation($hash)
    {
        $this->db->select('*');
        $this->db->where('hash', $hash);
        $this->db->where('clicked', 0);
        $q = $this->db->get('web_booking');
        $response = $q->result_array();
        
        $errorMessage = "";
        if(count($response) == 1)
        {
          $id = $response[0]["id"];
            $web_booking = array(
              'start' => $response[0]["start"],
              'end' => $response[0]["end"],
              'booking_type' => $response[0]["booking_type"],
              'firstname' => $response[0]["firstname"],
              'lastname' => $response[0]["lastname"],
              'street' => $response[0]["street"],
              'email' => $response[0]["email"],
              'phone' => $response[0]["phone"],
              'note' => $response[0]["note"],
              'web_booking' => 1,
              'allow_gdpr' => 1,
              'confirmed_booking' => NULL,
            );
          $this->db->insert('house_booking', $web_booking);
          
            $this->db->where('id', $id);
            $this->db->update('web_booking', array('clicked' => 1));
            redirect("/booking_confirmation");
        }
        else if(count($response) == 0)
        {
            $errorMessage = "Det fanns ingen bokning som matchar din länk";
        }
        $this->layout->render_view('page/booking_confirmation',  array('errorMessage' => $errorMessage)); 
    }
    
    
    public function page2($page='')
    {
        $this->layout->render_view('page/sida2',  array('a' => 11, 'b' => 444));            
    }
}
