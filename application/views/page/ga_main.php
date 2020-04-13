<h2><?php echo $this->site_model::SITE_NAME; ?> är uppdelat på nedanstående fem områden</h2>
<h4>En anslagstavla med aktuell information finns på respektive gård. Där kan du prenumerera på en kalender i mobilen.</h4>
<br />
<img width="600" src="assets/img/omraden.png" />
<br />
Att bo i området Utformning Karta Gator & parkeringar Lekplatser Samlingslokal Gemensamma tillgångar
<ul class="list-group">
<?php
for($i = 7; $i <= $this->site_model::NUMBER_OF_AREAS; $i++)
{?>
    <li title="Gå till anslagstavlan för GA<?php echo $i; ?>" class="list-group-item js-list-group-link" data-url="/anslagstavlan/ga<?php echo $i; ?>">GA:<?php echo $i; ?></li>
<?php

}
?>    
</ul>

<hr />
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profile</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">flik 1</div>
  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">flik 2</div>
  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">flik 3</div>
</div>