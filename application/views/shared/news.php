<h1>Gamla nyheter</h1>
<?php
foreach($oldNews as $news)
{
    echo '<h3>'.$news['date'].' '.$news['titel'].'</h3>';
    echo $news['description'];
    echo '<br />';
    echo 'Skapad: '.$news['created'];
    echo "<hr />";
}

?>
