<h2>Nyheter</h2>
<?php
foreach($news as $newsItem) {
    echo $newsItem['titel']."<br />";
    echo date("Y-m-d H:i", strtotime($newsItem['date']))."<br />";
    echo $newsItem['description']."<br /><br />";
}

?>