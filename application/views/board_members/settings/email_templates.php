<?php
require_once(__DIR__.'/../breadcrumb.php');
?>
<h4>Mailmallar</h4>
<table class="table table-striped table-bordered">
  <tr>
    <th>Ämne</th>
  </tr>
    <?php
foreach($mailTemplates as $item)
{
    echo '<tr>';
    echo '<td><a href="./mailmallar/'.$item['id'].'">'.$item['subject'].'</a></td>';
    echo '</tr>';
}
?>
</table>