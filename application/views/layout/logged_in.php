<?php
$user = $this->session->userdata('username').' (styrelsen)';
$basePath = '/styrelsen/';
$nav = [
    'Start' => '/styrelsen',
    'Bokningar (blå huset)' => '/styrelsen/bokningar',
    'Gamla nyheter' => '/styrelsen/nyheter',
    'Gamla notiser' => '/styrelsen/notiser',
    'Gamla händelser' => '/styrelsen/kalender',
//    'Användare' => '/page/anvandare',
    'Inställningar' => '/styrelsen/installningar',
    'Logga ut' => '/styrelsen/logout',
];
$ga = '';
if($this->session->userdata('role') == $this->user_model::ROLE_GA)
{
    $ga = ' (GA:'.$this->session->userdata('ga_number').')';
    $user .= $ga;
    $basePath = '/gardsombud/';
    $nav = [
        'Start' => '/gardsombud',
        'Nyheter' => '/gardsombud/nyheter',
        'Kalender' => '/gardsombud/kalender',
        'Notiser' => '/gardsombud/notiser',
        'Logga ut' => '/gardsombud/logout',
    ];
}
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
       <?php $CI->layout->trigger_title(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/bootstrap.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/trumpeten.css?v=".$this->site_model::CSS_JS_VERSION); ?>" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?php echo $basePath; ?>">Trumpetens samfällighetsförening</a>
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
    <div id="__notes">
<?php
if ($this->session->flashdata())
{
    $flashdata = $this->session->flashdata();
    ?>
        <div class="alert alert-<?php echo $flashdata['type']; ?>">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <strong><?php echo $flashdata['text']; ?></strong>
        </div>
<?php
}
?>
    </div>
<div id="container">
    <div class="nav-user">Välkommen <?php echo $user; ?></div>
<div class="main">
    <?php $CI->layout->get_content(); ?>

                <?php $CI->layout->trigger_content_section('content'); ?>
</div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Skapa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
        <button type="button" class="btn btn-primary" id="modal-button">Spara</button>
      </div>
    </div>
  </div>
</div>


    
    
    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/popper.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/trumpeten.js');?>"></script>
</body>
</html>