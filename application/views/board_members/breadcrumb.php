<?php
$url = substr($_SERVER['REQUEST_URI'], 1);
$nav = explode("/", $url);
$navTot = '';
$replace = array("styrelsen" => "Start", "installningar" => "Inställningar");
for($i = 0; $i < count($nav); $i++)
{
    $navTot .= $nav[$i].'/';
    if(isset($replace[$nav[$i]]))
    {
        echo '<a href="'.$navTot.'">'.$replace[$nav[$i]].'</a> / ';
    }
    else
    {
        echo $nav[$i];
    }
    
}
?>
<hr />