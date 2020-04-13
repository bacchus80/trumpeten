<?php
/**
 * Controller for fetching modal windows for creating, and crud for models
 * Merging modal controller with
 */
class Shared extends CI_Controller
{
    
    const ALLOWED_TABLES = ['booking', 'event', 'news', 'note', 'user'];
    const STABLES_SWE = [
        'booking' => 'bokningen', 
        'event' => 'händelsen', 
        'news' => 'nyheten', 
        'note' => 'notisen', 
        'user' => 'användaren'
    ];
    
    // set iCal date-format
    const DATE_ICAL = 'Ymd\THis';
    
    
    function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        if (($_SERVER["REQUEST_URI"] != "/shared/webbooking") && $this->session->userdata('logged_in') !== TRUE) {
            redirect('login');
        }
        $this->layout->set_template('empty');

        $this->load->model('booking_model');
        $this->load->model('event_model');
        $this->load->model('news_model');
        $this->load->model('note_model');
        $this->load->model('user_model');
        $this->load->model('site_model');
    }
    
    /*
    function dummy($type='')
    {
        echo "[".$type.rand(1000,1000000)."]";
        $yearDate = date("Ym");
        echo  $yearDate."@";
        $baseBath = $_SERVER['DOCUMENT_ROOT'].'/assets/upload/'.date("Ym");;
        if(!file_exists($baseBath.$yearDate))
        {
            mkdir($baseBath.$yearDate);
            echo "skapade ".$yearDate;
        }else{
            echo "fanns";
        }
        $path = "/assets";
    }
     */
    
    
    function save($dbType, $id)
    {
        $redirect = $_SERVER['HTTP_REFERER'];
        
        $file = null;
        if(isset($_FILES['file']))
        {
            $file = $_FILES['file'];
        }
        $filePath = NULL;
        if($file['error'] == 0 && $file['size'] > 0)
        {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $imgName = $dbType.'_'.date("YmdHis").'_'.rand(10000,99999).'.'.$extension;

            // create folder if not existing
            $endPath = '/assets/upload/'.date("Ym");
            $yearFolder = BASEPATH.'../'.$endPath;
            $folder = BASEPATH.'../'.$endPath;
            if(!file_exists($folder))
            {
                
                mkdir($baseBath.$yearDate);
            }
            
            if (move_uploaded_file($file['tmp_name'],$folder.'/'.$imgName)) {
                $filePath = $endPath.'/'.$imgName;
            }
        }

        $id = (int)$id;
        if($id < 0)
        {
            redirect("/");
        }
        if($dbType == 'user')
        {
            // todo, only for board members
            $role = $this->user_model::ROLE_GA;
            if($this->session->userdata['role'] == 1)
            {
                $role = $this->user_model::ROLE_ADMIN;
            }
            $gaNumber = (int)$this->input->post('ga_number', TRUE);
            if($role == $this->user_model::ROLE_ADMIN)
            {
                $gaNumber = NULL;
            }

            $data = array(
                'created_by' => $this->session->userdata('user_id'),
                'updated_by' => $this->session->userdata('user_id'),
                'firstname' => $this->input->post('firstname', TRUE),
                'lastname' => $this->input->post('lastname', TRUE),
                'email' => $this->input->post('email', TRUE),
                'password' => sha1('test1234'),
               // 'level' => 1,
                'role' => $role,
                'ga_number' => $gaNumber,
            );
        }
        else if($dbType == 'note')
        {
            $expire = $this->input->post('expire', TRUE);
            if ($expire == "") {
                $expire = NULL;
            }

            $data = array(
                'titel' => $this->input->post('titel', TRUE),
                'note' => $this->input->post('note', TRUE),
                'color' => $this->input->post('color', TRUE),
                'expire' => $expire,
                'image_path' => $filePath,
            );            
        }
        else if($dbType == 'news')
        {

                    
            $data = array(
                'titel' => $this->input->post('titel', TRUE),
                'description' => $this->input->post('description', TRUE),
                'image_path' => $filePath,
            );
        }
        else if($dbType == 'event')
        {
            $data = array(
                'start' => $this->input->post('start', TRUE),
                'end' => $this->input->post('end', TRUE),
                'titel' => $this->input->post('titel', TRUE),
                'note' => $this->input->post('note', TRUE),
                'whole_day' => $this->input->post('whole_day', TRUE),
                'location' => $this->input->post('location', TRUE),
                'public' => $this->input->post('public', TRUE),
                'image_path' => $filePath,
            );
        }
        else if($dbType == "booking")
        {
            $dbType = 'house_booking';
            $data = array(
               'start' => $this->input->post('start', TRUE),
               'end' => $this->input->post('end', TRUE),
               'booking_type' => (int) $this->input->post('booking_type', TRUE),
               'firstname' => $this->input->post('firstname', TRUE),
               'lastname' => $this->input->post('lastname', TRUE),
               'street' => $this->input->post('street', TRUE),
               'email' => $this->input->post('email', TRUE),
               'phone' => $this->input->post('phone', TRUE),
               'note' => $this->input->post('note', TRUE),
               'web_booking' => NULL,
               'confirmed_booking' => 1
           );         
        }
        
        if($dbType == 'event' && strtotime($data['start']) >= strtotime($data['end']))
        {
            redirect('/');
        }
            
        if($id == 0)
        {
            $displayAt = 'all';
            if($this->session->userdata('role') == $this->user_model::ROLE_GA &&
              (int)$this->session->userdata('ga_number') > 0)
            {
                $displayAt = 'ga'.(int)$this->session->userdata('ga_number');
            }
            $data['created_by'] = $this->session->userdata('user_id');
            $data['updated_by'] = $this->session->userdata('user_id');
            if(!($dbType == "user" || $dbType == "booking" || $dbType == 'house_booking'))
            {
               // $data['created_by_role'] = $this->session->userdata('role');
                $data['display_at'] = $displayAt;
            }
            $this->db->insert($dbType, $data); 
        }
        else if($id > 0)
        {
            $data['updated_by'] = $this->session->userdata('user_id');
            $this->db->where('id', $id);
            $this->db->update($dbType, $data); 
        }   
        
        $this->site_model->updatePageDate();
        
        if($dbType == 'event')
        {
            $this->updateCalendar();
            
        }
        
        // mail all board members about new user

        // mail new user about the account
        
        redirect($redirect);
    }
    
    
    private function updateCalendar()
    {
        $events = [];
        if ($this->session->userdata('role') == $this->user_model::ROLE_ADMIN || 
             (int)$this->session->userdata('ga_number') < 1)
        { 

            // update board member calendar
            $events = $this->event_model->get_future_events(false);
            $this->saveCalendarEventsToFile('styrelsen', $events);
            
            // update public calendar
            $events = $this->event_model->get_future_events();
            $this->saveCalendarEventsToFile('trumpeten', $events);


            // update all GA calendars
            for($i = 1; $i <= $this->site_model::NUMBER_OF_AREAS; $i++)
            {
                $ga = 'ga'.$i;
                $events = $this->event_model->get_future_ga_events($ga);
                $this->saveCalendarEventsToFile($ga, $events);
            }
        }
        else if($this->session->userdata('role') == $this->user_model::ROLE_GA || 
             (int)$this->session->userdata('ga_number') > 0)
        {
            // only update GA calendar
            $ga = 'ga'.$this->session->userdata('ga_number');
            $events = $this->event_model->get_future_ga_events($ga);
            $this->saveCalendarEventsToFile($ga, $events);
        }
    }
    
    
    function delete($type, $id)
    {     
        if((int)$id < 1 || !in_array($type, self::ALLOWED_TABLES))
        {
            die("");
        }
        
        //delete
        $record =$this->db->where('id', $id);
        echo $type;
        print_r($record);
        echo 1;exit;
        $result = $this->db->delete($type);
        
        // update 
        $this->site_model->updatePageDate();

        redirect($_SERVER['HTTP_REFERER']);
        exit;
        
        
         $this->db->select('id'); //date, titel, note, expire, color, image
        $this->db->from($type);
        $this->db->where('id', $id);
        if($this->session->userdata('ga_number') != NULL)
        {
           // $this->db->where('display_at', $this->session->userdata('ga_number'));
        }
        $q = $this->db->get();
        $response = $q->result_array();
//        print_r($response);
    }
    
   
    private function emptyData($type)
    {
        if($type == 'news')
        {
           return  [
                'id' => '',
                'date' => '',
                'titel' => '',
                'description' => '',
            ];
        }
        else if($type == 'note')
        {
            return [
                'id' => '',
                'date' => '',
                'titel' => '',
                'note' => '',
                'expire' => '',
                'color' => '',
                'image' => '',
            ];
        }
        else if($type == 'event')
        {
            return [
                'id' => '',
                'start' => '',
                'end' => '',
                'titel' => '',
                'note' => '',
                'whole_day' => '',
                'location' => '',
                'public' => '',
            ];
        }
        else if($type == 'booking')
        {
            return [
                'id' => '',
                'start' => '',
                'end' => '',
                'booking_type' => '',
                'firstname' => '',
                'lastname' => '',
                'street' => '',
                'email' => '',
                'phone' => '',
                'note' => '',
            ];
        }
        else if($type == 'user')
        {
            return [
                'id' => '',
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'role' => '',
                'ga_number' => '',
            ];
        }
        return [];
    }
    
    
    private function quote($string)
    {
        return "\"".$string."\"";
    }
           
    
    function question($type, $id=0)
    {      
        if((int)$id < 1 || !in_array($type, self::ALLOWED_TABLES))
        {
            die("");
        }

        $result = $this->getData($type, $id);
        if(empty($result))
        {
            die("");
        }
        $text = '';
        if($type == 'news' || $type == 'note')
        {
            $text = $this->quote($result['titel'].', ' .
                    date("Y-m-d", strtotime($result['created'])));
        }
        else if($type == 'event')
        {
            $text = $this->quote($result['titel'].', ' .
                    date("Y-m-d", strtotime($result['start'])));
        }
        else if($type == 'booking')
        {
            $text = 'för '.$result['firstname'].' ' .$result['lastname'].
            ' ('.$result['phone'].'/'.$result['email'].'), '.
            date("Y-m-d", strtotime($result['start']));
        }
        else if($type == 'user')
        {
            $text = $this->quote($result['firstname'].' ' .$result['lastname'].
                    ', '.$result['email']);
        }
        
        $this->layout->render_view('modal/delete', array(
            'text' => "Är du säker på att du vill radera ".self::STABLES_SWE[$type]." ".$text."?",
            'id' => $id,
            'type' => $type,
        ));
    }
    
    
    function webBooking()
    {
        $this->layout->render_view('modal/web_booking', array(
        ));
    }
           
    
    function modal($type, $id=0)
    {      
        if(!in_array($type, self::ALLOWED_TABLES))
        {
            die("");
        }
        $data =  $this->emptyData($type);

        if($id > 0)
        {
            $result = $this->getData($type, $id);
            if(empty($result))
            {
                die("");
            }
            
            $data = [];
            foreach($result as $key => $val)
            {
                $data[$key] = $val;
            }
        }
        $isBoardMember = false;
        if($this->user_model::ROLE_ADMIN ==$this->session->userdata('role'))
        {
            $isBoardMember = true;
        }
        
        $userGroupValueList = [
            0 => 'Välj',
            $this->user_model::ROLE_BOOKING => 'Bokning',
            $this->user_model::ROLE_GA => 'Gårdsombud',
            $this->user_model::ROLE_ADMIN => 'Styrelsen',
        ]; 
        $this->layout->render_view('modal/'.$type, array(
            'data' => $data,
            'noteColors' => $this->note_model->colors(),
            'userGroupValueList' => $userGroupValueList,
            'isBoardMember' => $isBoardMember,
        ));
    }
    
    
    /**
     * Only for board member
     */
    /*
    function booking()
    {
        
        $this->layout->render_view('modal/booking', array());
    }
    
    
    function event($id=0)
    {
        $this->layout->render_view('modal/event', array());
    }
    */
    
    /*
    function note($id=0)
    {      
  
        if($id > 0)
        {
            $result = $this->getData('note', $id);
            
            $data = [
                'id' => $result['id'],
                'date' => $result['date'],
                'titel' => $result['titel'],
                'note' => $result['note'],
                'expire' => $result['expire'],
                'color' => $result['color'],
                'image' => $result['image'],
            ];
        }
        $this->layout->render_view('modal/note', array(
            'noteColors' => $this->note_model->colors(),
            'data' => $data
        ));
    }
    */
    
    
    function getData($dbType, $id)
    {
        if(($dbType == 'booking' || $dbType == 'user') &&
              !($this->session->userdata('role') == 1  && $this->session->userdata('ga_number') == NULL))
        {
            echo "1";
        }
        else if(in_array($dbType, self::ALLOWED_TABLES) && $id > 0)
        {
        
            if($dbType == 'booking')
            {
                $dbType = 'house_booking';
            }

            $this->db->select('*'); //date, titel, note, expire, color, image
            $this->db->from($dbType);
            $this->db->where('id', $id);
            if($this->session->userdata('ga_number') != NULL)
            {
               // $this->db->where('display_at', $this->session->userdata('ga_number'));
            }
            $q = $this->db->get();
            $response = $q->result_array();
            if(empty($response))
            {
                return [];
            }
            return $response[0];
        }        
    }

    
    /**
     * Only for board member
     */
    function user()
    {
        $userGroupValueList = [
            0 => 'Välj',
            $this->user_model::ROLE_GA => 'Gårdsombud',
            $this->user_model::ROLE_ADMIN => 'Styrelsen',
        ];  
        
        $this->layout->render_view('modal/user', array(
            'userGroupValueList' => $userGroupValueList,
        ));
    }
    
    
    private function saveCalendarEventsToFile($file, $events)
    {
        $fh = fopen(BASEPATH."../assets/calendar/calendar-".$file.".txt", "w");// or die("can't open file");

        // todo, use correct url for calendar
//        fwrite($fh, "URL:https://trumpeten.se/kalenderprenumeration/".$file."\r\n");
        fwrite($fh, "NAME:Trumpeten - ".$file."\r\n");
        fwrite($fh, "X-WR-CALNAME:Trumpeten - ".$file."\r\n");
        
        foreach($events as $event)
        {
                $this->writeCalendarEvent($fh, $event);
        }
        fclose($fh);
    }

    
    private function writeCalendarEvent($fh, $event)
    {
        $event = (object)$event;
        $timeZone = ';TZID=Europe/Stockholm';

        fwrite($fh, "BEGIN:VEVENT\r\n");
        //fwrite($fh, "CREATED:".date(self::DATE_ICAL,strtotime($event->created))."\r\n");
        fwrite($fh, "SUMMARY:".$event->titel."\r\n");
        fwrite($fh, "X-MICROSOFT-CDO-BUSYSTATUS:BUSY\r\n");
        fwrite($fh, "UID:".$event->id."\r\n");
        fwrite($fh, "STATUS:CONFIRMED\r\n");

        $from = date(self::DATE_ICAL,strtotime($event->start));
        $to = date(self::DATE_ICAL,strtotime($event->end));

        $created = "DTSTAMP:".date(self::DATE_ICAL,strtotime($event->created))."\r\n";
        fwrite($fh, $created);

        $stringData = "DTSTART".$timeZone.":".$from."\r\n";
        if($event->whole_day)
        {
            $stringData = "DTSTART;VALUE=DATE:".date("Ymd",strtotime($event->start))."\r\n";
        }
        fwrite($fh, $stringData);

        $stringData = "DTEND".$timeZone.":".$to."\r\n";
        if($event->whole_day)
        {
            $stringData = "DTEND;VALUE=DATE:".date("Ymd",strtotime("+1 day ".$event->end))."\r\n";
        }
        fwrite($fh, $stringData);

        if($event->note != NULL)
        {
            fwrite($fh, "DESCRIPTION:".str_replace("\n","\r\n",$event->note)."\r\n");
        }

        $last_modified = date(self::DATE_ICAL,strtotime($event->updated));
        fwrite($fh, "LAST-MODIFIED:".$last_modified."\r\n");

        if($event->location != "")
        {
            fwrite($fh, "LOCATION:".$event->location."\r\n");
        }
        fwrite($fh, "END:VEVENT\r\n");
    }
    
}
