<h2>Äldre nyheter</h2>
<?php
foreach($inactiveNews as $newsItem) {
    echo $newsItem['titel']."<br />";
    echo date("Y-m-d H:i", strtotime($newsItem['date']))."<br />";
    echo $newsItem['description']."<br /><br />";
}

?>