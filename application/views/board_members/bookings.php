<h1>
    (Fiktiva) Bokningar Blå huset
    <button title="Skapa bokning" type="button" class="btn btn-primary j-dashboard-button" data-type="booking">+</button>
</h1>
<a href="/styrelsen/bokningar">Översikt</a>,
<a href="/styrelsen/bokningar/detalj">detaljerad lista</a>
<?php
$curr = '';
$year = '';
$months = months();
$days = days();

foreach($bookings as $booking)
{
//    echo proper_booking_day($booking); 
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
        echo ' <img title="Barnkalas" src="/assets/img/icons/cake.svg" height="24px" />';
    }   
    if($listType == 'detalj')
    {
      echo $booking['firstname'].' '.$booking['lastname'].', ';
      echo $booking['street'].', ';
      echo $booking['email'].', ';
      echo $booking['phone'].', ';
      echo $booking['note'];
    }
    echo '<br />';
}
if(count($unconfirmedBookings) > 0)
{
 echo '<h2>Obekräftade webbokningar</h2>'; 
 foreach($unconfirmedBookings as $booking)
 {
     echo $booking["start"].' '.$booking["end"];
     echo "<br />";
//   print_r($unconfirmedBooking);
 }
}
?>