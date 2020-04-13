<?php
$nav = [
    'Kalender' => '/kalender',
    'Nyheter' => '/nyheter',
    'GA' => '/ga',
    'Nyinfyttad' => '/nyinfyttad',
    'Info' => '/info',
    'Bokningar blå huset' => '/blahuset',
    'Stadgar' => '/stadgar',
    'Kontakt' => '/kontakt',
];
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
       <?php $CI->layout->trigger_title(); ?>
<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/trumpeten.css" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="/">Hem</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      foreach($nav as $key => $val)
      {
          $class = 'nav-item';
          if($_SERVER['REQUEST_URI'] == $val) {
              $class .= ' active';
          }
          ?>
            <li class="<?php echo $class;?>">
        <a class="nav-link" href="<?php echo $val;?>"><?php echo $key;?></a>
      </li>
      <?php
      }
      ?>
    </ul>
  </div>
</nav>
<?php /* $this->load->view($view,$data); */ ?>
<div id="container">
	<h1>Trumpetens samfällighetsförening</h1>
<hr />
    <?php $CI->layout->get_content(); ?>

                <?php $CI->layout->trigger_content_section('content'); ?>
<hr />
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
</body>
</html>