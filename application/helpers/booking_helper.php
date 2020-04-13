<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('proper_booking_day'))
{

    function proper_booking_day($booking)
    {
      $now = date("Y-m-d", strtotime($booking['start']));
      $currDate = date("n", strtotime($now));
      $currYear = date("Y", strtotime($now));
      $day = date("D", strtotime($now));
      if($currYear != $year)
      {
          $year = $currYear;
          echo '<h3>'.$currYear.'</h3>';
      }
      if($currDate != $curr)
      {
          $curr = $currDate;
          echo '<h3>'.$months[$currDate-1].'</h3>';
      }
      $startHour = rand(10, 18);
      $endHour = $startHour+rand(3, 8);
      echo $days[$day]." ".date("d", strtotime($now))." ".$startHour.":00-".$endHour.":00";

      if($booking['booking_type'] == $this->booking_model::BOOKING_TYPE_CHILD_BIRTHDAY)
      {
          echo ' <img src="/assets/img/icons/cake.svg" height="24px" />';
      }   
      if($listType == 'detalj')
      {
        echo $booking['firstname'].' '.$booking['lastname'].', ';
        echo $booking['street'].', ';
        echo $booking['email'].', ';
        echo $booking['phone'].', ';
        echo $booking['note'].', ';
      }
    }
}
?>