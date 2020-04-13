<?php
class Booking_model extends CI_Model
{

    CONST BOOKING_TYPE_CHILD_BIRTHDAY = 1;
    CONST BOOKING_TYPE_OTHER = 2;
    
    
    function get_future_bookings()
    {
        $today = date("Y-m-d");
        
        $this->db->select('*');
        $this->db->where('DATE(start) >=', $today);
        $this->db->where('confirmed_booking', 1);
        $this->db->order_by('start', 'ASC');
        $q = $this->db->get('house_booking');
        
        $response = $q->result_array();

        return $response;
    }   
    
    
    function get_unconfirmed_bookings()
    {
        $today = date("Y-m-d");
        
        $this->db->select('*');
        $this->db->where('DATE(start) >=', $today);
        $this->db->where('confirmed_booking', NULL);
        $this->db->order_by('start', 'ASC');
        $q = $this->db->get('house_booking');
        
        $response = $q->result_array();

        return $response;
    }
    
    
    function get_old_bookings()
    {
    }
    
    
    function valueListBookingTypes()
    {
        return [
            "" => "Välj",
            self::BOOKING_TYPE_CHILD_BIRTHDAY => "Barnkalas",
            self::BOOKING_TYPE_OTHER => "Övrigt"
        ];
    }
    
    
    function isAvailable($start, $end)
    {
        $sql = "SELECT
        *
        FROM
            `house_booking`
        WHERE
            (start >='".$start."' and start <= '".$end."') or
            (start <='".$start."' and end >= '".$end."') or
            (start >='".$start."' and start <= '".$end."') or
            (end >='".$start."' and end <= '".$end."')
        ";

        $query = $this->db->query($sql); 
      
        $record = $query->result_array();
        if(count($record) < 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    
    function validate($booking)
    {
        $currentYear = date("Y");
        $start = strtotime($booking["start"]);
        $end = strtotime($booking["end"]);
        $startYear = date("Y", $start);
        $endYear = date("Y", $end);
        $streets = ["Basunvägen 1","Basunvägen 2"];
        $allowedBookingTypes = [
            self::BOOKING_TYPE_CHILD_BIRTHDAY, 
            self::BOOKING_TYPE_OTHER
        ];
        
        if($end <= $start)
        {
            return ['model' => 'end',
                'error' => 'Slutdatum är mindre än startdatum'];
        }
        else if((int)date("d",$end-$start) > 2)
        {
            return ['model' => 'end',
                'error' => 'Det går inte att boka mer än ett dygn'];
        }
        else if($startYear < $currentYear ||
                $startYear > 1 +$currentYear)
        {
            return ['model' => 'start',
                'error' => 'Du får bara boka i år eller nästa år'];
        }
        else if($endYear < $currentYear ||
                $endYear > 1 +$currentYear)
        {
            return ['model' => 'end',
                'error' => 'Du får bara boka i år eller nästa år'];
        }
        else if(!in_array($booking["street"], $streets))
        {
            return ['model' => 'street',
            'error' => 'Du måste bo i samfällgheten för att kunna boka'];
    
        }
        else if(!in_array ( $booking["booking_type"], $allowedBookingTypes))
        {
            return ['model' => 'booking_type',
            'error' => 'Felaktig bokningstyp'];
        }
        else if(false)
        {
            return ['model' => 'email',
            'error' => 'Felaktig e-postadress'];
        }
        else if($booking["ok"] != 1)
        {
            return ['model' => 'ok',
            'error' => 'Var vänlig godkänn'];
        }
        else if(!$this->isAvailable($booking["start"], $booking["end"]))
        {
            return ['model' => 'start',
            'error' => 'Bokningen krockar med en annan bokning'];
        }
        return [];
    }
    
    
    function emptyModel()
    {
        return [
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
    
}