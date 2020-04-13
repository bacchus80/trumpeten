<h2>Välkommen till <?php echo $ga;?></h2>
<h3>Här finns relevant information för dig som bor på vår gård</h3>   
<h5>Prenumerera på vår <a href="/kalenderprenumeration/<?php echo $gaLowerCase; ?>">kalender</a> direk i mobilen eller datorn.</h5>
<?php if( count($news) > 0)
{
    ?>
<h4>Nyheter och händelser</h4>
<div>
    <?php foreach($news as $newsItem)
    {
        ?>
    <div>
        <div><?php echo $newsItem['date'];?></div>
        <div><?php echo $newsItem['titel'];?></div>
        <div><?php echo $newsItem['description'];?></div>
    </div>
    <?php
    }
    ?>
</div>  
<?php
}
?>