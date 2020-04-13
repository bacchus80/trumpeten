<h2>Nedan visas bokningar i Blå huset</h2>
<button class="btn btn-info" id="web-booking">Boka</button>
<?php
$curr = '';
$year = '';
foreach($bookings as $booking)
{
    $now = date("Y-m-d H:i", strtotime($booking['start']));
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
    $startHour = date("H:i", strtotime($now));
    $endHour = date("H:i", strtotime($booking['end']));
    echo $days[$day]." ".date("d", strtotime($now))." ".$startHour."-".$endHour."<br />"; 
}
?>