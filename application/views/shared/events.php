<h1>Passerade händelser</h1>
<?php
foreach($oldEvents as $event) {
    echo $event['titel']."<br />";
    echo date("Y-m-d H:i", strtotime($event['start'])). " - ".date("H:i", strtotime($event['end']))."<br />";
    echo $event['note']."<br /><br />";
}
?>