<h2>Kommande händelser för <?php echo $this->site_model::SITE_NAME; ?></h2>
<h4>Prenumerera på Trumptens <a href="webcal://trumpeten.local/kalenderprenumeration/trumpeten">kalender</a>. Vill du istället ha kalendern för din gård, 
    <a href="/omraden">leta upp din gård</a> och välj din gårdskalender</h4>
<?php
foreach($events as $event) {
    echo $event['titel']."<br />";
    echo date("Y-m-d H:i", strtotime($event['start'])). " - ".date("H:i", strtotime($event['end']))."<br />";
    echo $event['note']."<br /><br />";
}
?>