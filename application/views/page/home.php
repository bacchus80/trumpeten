<h2>Kommande händelser</h2>
    <?php
    foreach($events as $event) {
    echo '<div style="margin-bottom: 30px;">';
    echo '<h4>';
    echo $event['titel'];
    echo ' <img src="/assets/img/icons/calendar.svg" height="24px" />';
    echo '</h4>';
    if($event['image_path'] !== NULL)
    {
        echo '<img class="img-fluid" alt="Bild" src="'.$event['image_path'].'" /><br />';
    }
    echo '<h5>'.date("Y-m-d H:i", strtotime($event['start'])). " - ".date("H:i", strtotime($event['end']))."</h5>";
    echo '<img src="/assets/img/icons/location-pin.svg" height="24px" /> ';
    echo $event['location'];
    echo '<div>'.$event['note']."</div>";
    echo '</div>';
}
?>

<h2>Nyheter</h2>
<?php
foreach($news as $newsItem) {
    $createdUpdated = date("Y-m-d", strtotime($newsItem['created']));
    if(date("Ymd", strtotime($newsItem['created'])) != date("Ymd", strtotime($newsItem['updated'])))
    {
        $createdUpdated .= ' (uppdaterad '.date("Y-m-d", strtotime($newsItem['updated'])).')';
    }
    echo '<div class="dashbord-info-text">'.$createdUpdated."</div>";
    echo '<div>';
    echo $newsItem['titel'];
    echo ' <img src="/assets/img/icons/newspaper.svg" height="24px" />';
    echo '</div>';
    if($newsItem['image_path'] !== NULL)
    {
        echo '<img class="img-fluid" alt="Bild" src="'.$newsItem['image_path'].'" />';
    }
    echo $newsItem['description']."<br /><br />";
}
?>
<a href="/tidigarenyheter">Tidigare nyheter och händelser</a>