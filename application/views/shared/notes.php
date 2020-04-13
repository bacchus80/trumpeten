<?php
 $noteColors = $this->note_model->colors();
?>
<h1>Gamla notiser</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Skapad</th>
      <th scope="col">Titel</th>
      <th scope="col">Notering</th>
      <th scope="col">Försvann</th>
    </tr>
  </thead>
<?php
foreach($oldNotes as $note)
{?>
  <tr class="table-<?php echo $note['color'];?>">
      <td><?php echo date("Y-m-d", strtotime($note['created'])); ?></td>
      <td><?php echo $note['titel']; ?></td>
      <td><?php echo $note['note']; ?></td>
      <td><?php echo $note['expire']; ?></td>
  </tr>
<?php
}
?>
</table>



