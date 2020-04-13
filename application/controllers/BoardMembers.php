<?php

class BoardMembers extends CI_Controller
{

    
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        if ($this->session->userdata('logged_in') !== TRUE ||
             $this->session->userdata('role') != $this->user_model::ROLE_ADMIN || 
             (int)$this->session->userdata('ga_number')> 0)
        { 
            redirect('login');
        }
        $this->layout->set_template('logged_in');

        $this->load->model('booking_model');
        $this->load->model('event_model');
        $this->load->model('news_model');
        $this->load->model('note_model');
        $this->load->model('user_model');
        $this->load->model('site_model');

        $this->load->helper('booking');
        $this->load->helper('date');
        $this->load->helper('html');   
    }

    
    function index()
    { 
        
        $activeNotes = $this->note_model->get_active_main_notes();
        $activeNews = $this->news_model->get_active_news();
        $activeEvents = $this->event_model->get_future_events(false);

        //Allowing akses to admin only
        $this->layout->render_view('shared/dashboard', array(
            'activeNotes' => $activeNotes,
            'activeNews' => $activeNews,
            'activeEvents' => $activeEvents,
        ));
    }


    function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    
    function staff()
    {
        //Allowing akses to staff only
        if ($this->session->userdata('level') === '2')
        {
            $this->load->view('dashboard_view');
        }
        else
        {
            echo "Access Denied";
        }
    }
    

    function author()
    {
        //Allowing akses to author only
        if ($this->session->userdata('level') === '3')
        {
            $this->load->view('dashboard_view');
        }
        else
        {
            echo "Access Denied";
        }
    }
    

    function createUser()
    {
        // todo, only for board members
        $role = $this->user_model::ROLE_GA;
        
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
        
        redirect('styrelsen/anvandare/');
    }

    
    function createNote()
    {
        $date = $this->input->post('date', TRUE);
        if ($date == "")
        {
            $date = NULL;
        }
        $expire = $this->input->post('expire', TRUE);
        if ($date == "")
        {
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
        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0)
        {
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Notisen skapades']);
        }
        else
        {
            $this->session->set_flashdata(['type' => 'warning', 'text' => 'Notisen kunde inte skapas']);
        }
        redirect('styrelsen/notiser/');
    }
    

    function createNews()
    {
        $news = array(
            'date' => $this->input->post('date', TRUE),
            'titel' => $this->input->post('titel', TRUE),
            'description' => $this->input->post('description', TRUE),
            'display_at' => $this->input->post('display_at', TRUE),
        );

        $this->db->insert('news', $news);
        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0)
        {
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Nyheten skapades']);
        }
        else
        {
            $this->session->set_flashdata(['type' => 'warning', 'text' => 'Nyheten kunde inte skapas']);
        }
        redirect('styrelsen/nyheter/');
    }

    
    function createEvent()
    {
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
        
        if (!empty($this->db->insert_id()) && $this->db->insert_id() > 0)
        {
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Händelsen skapades']);
        }
        else
        {
            $this->session->set_flashdata(['type' => 'waring', 'text' => 'Händelsen kunte inte skapas']);
        }
        redirect('styrelsen/kalender/');
    }

    
    function createBooking()
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

    
    function news()
    {
        $oldNews = $this->news_model->getOldNews();
        
        $news = array();
        $this->layout->render_view('shared/news', array(
            'oldNews' => $oldNews,
        ));
    }

    
    function notes() {
        $noteColors = $this->note_model->colors();
        $oldNotes = $this->note_model->get_old_main_notes();

        $this->layout->render_view('shared/notes', array(
            'noteColors' => $noteColors,
            'oldNotes' => $oldNotes,
        ));
    }

    
    function calendar()
    {
        $oldEvents = $this->event_model->get_old_main_event();
        $this->layout->render_view('shared/events', array(
            'oldEvents' => $oldEvents, 
        ));
    }

    
    function bookings($listType=false)
    {
        $createStatus = $this->input->get('status', TRUE);
        $bookings = $this->booking_model->get_future_bookings();
        $unconfirmedBookings = $this->booking_model->get_unconfirmed_bookings();
        $this->layout->render_view('styrelsen/bookings', 
            array(
                'bookings' => $bookings,
                'unconfirmedBookings' => $unconfirmedBookings,
                'createStatus' => $createStatus,
                'listType' => $listType));
    }

    
    function users()
    {
        $userGroupValueList = [
            0 => 'Välj',
            $this->user_model::role_GA => 'GA',
            $this->user_model::ROLE_ADMIN => 'Styrelsen',
        ];
        
        $users = $this->user_model->getUsers();
        
        $createStatus = $this->input->get('status', TRUE);
        $this->layout->render_view('styrelsen/users', array(
            'users' => $users,
            'userGroupValueList' => $userGroupValueList,
            'createStatus' => $createStatus
            ));
    }
    
    
    function fileupload()
    {
        if(isset($_FILES['file']) && $_FILES['file']['type'] == 'image/jpeg'
                 && $_FILES['file']['size'] < 800000)
        {
            $baseURL = $_SERVER['DOCUMENT_ROOT']."/assets/img/";
            $destination = $baseURL."main.jpg";
            rename($destination, $baseURL."main_".date("YmdHis").".jpg");
            
            move_uploaded_file($_FILES['file']['tmp_name'], $destination);
            
            $this->session->set_flashdata(['type' => 'success', 'text' => 'Bilden laddades upp']);
        }
        
        redirect('styrelsen/installningar/start-image');
    }

    
    function settings($page='')
    {
        
        $to = 'erlla992@gmail.com';
        $subject = 'Test';
        $message = 'Detta är ett testmail';
        $res = mail($to, $subject, $message);
        
        $navigation = [
            '/styrelsen/installningar/konto' => 'Mitt konto',
            '/styrelsen/installningar/anvandare' => 'Användare',
            '/styrelsen/installningar/styrelse' => 'Styrelse',
            '/styrelsen/installningar/mailmallar' => 'Mailmallar',
            '/styrelsen/installningar/start-image' => 'Ändra startbild',
        ];
        
        if($page == 'anvandare')
        {
            
            $roleTranslation = $this->user_model::ROLE_TRANSLATION;
            $users = $this->user_model->getUsers();
            $amountBoardMembers = 0;
            foreach($users as $user)
            {
                if($user['role'] == $this->user_model::ROLE_ADMIN)
                {
                    $amountBoardMembers++;
                }
            }
            $this->layout->render_view('styrelsen/settings/users', 
                   array('users' => $users,
                       'roleTranslation' => $roleTranslation,
                       'amountBoardMembers' => $amountBoardMembers,
                       ));
        }
        else if($page == 'mailmallar')
        {
            $this->load->model('mailtemplates_model');  
            $mailTemplates = $this->mailtemplates_model->get_all_email_templates();
            
            $this->layout->render_view('styrelsen/settings/email_templates', 
                array('mailTemplates' => $mailTemplates,
            ));
        }
        else if($page == 'start-image')
        {
            $this->layout->render_view('styrelsen/settings/start_image',array());
        }
        else
        {
           $this->layout->render_view('styrelsen/settings', array('navigation' => $navigation));
        }
    }

}
