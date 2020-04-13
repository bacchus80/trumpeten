<h1>Inställningar</h1>
<ul>
    <?php foreach($navigation as $key => $value)
    {
        echo '<li><a href="'.$key.'">'.$value.'</a></li>';
    }
    ?>
</ul>