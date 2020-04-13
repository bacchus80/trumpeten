<h3>Frågor om samfälligheten</h3>
<a href="mailto:styrelsen@trumpeten.se">styrelsen@trumpeten.se</a>
<br />
<br />


<h4>Uthyrare allmän lokal "Blå huset"</h4>
<div>Annmarie Olsson, Basunvägen 59<br />
0300-770 40 / 0701-706 584
</div>
<br />


<ul class="list-group">
    <li class="list-group-item d-flex justify-content-between align-items-center list-title">
        Styrelsen
    </li>
    <?php
    foreach($board as $person)
    {
    ?>
  <li class="list-group-item d-flex justify-content-between align-items-center">
    <span class="badge badge-primary badge-pill badge-pill-board"><?php echo $person['role']; ?></span>
    <?php echo $person['name']; ?>
  </li>
  <?php
    }
    ?>
</ul>