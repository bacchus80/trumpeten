<?php
/*
$letters = "abcdefghijklmnopqrstavwxyzABCDEFGHIJKLMNOPQRSTAVWXYZ0123456789-";
$max = strlen($letters);
$r = "";
for($i = 0; $i < 20;$i++)
{
  $r .= substr($letters, rand(0, $max), 1);
}
echo $r;
 */
$tmp = explode("/",$_SERVER['REQUEST_URI']);
$site = $tmp[1];
$fixedTop = '';
if($_SERVER['REQUEST_URI'] == '/')
{
    $fixedTop = ' fixed-top';
}
$nav = [
//    'Kalender' => '/kalender',
//    'Nyheter' => '/nyheter',
    'Området' => '/omraden',
    'Information' => '/info',
    'Kalender' => '/kalender',
    'Nyinfyttad' => '/nyinfyttad',
    'Blå huset' => '/blahuset',
//    'Stadgar' => '/stadgar',
    'Kontakt' => '/kontakt',
    'Logga in' => array('url' => '/login', 'class' => 'right'),
];
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta author="Erling Larsson, erlla992(at)gmail(.)com">
<?php $CI->layout->trigger_title(); ?>
<?php $CI->layout->trigger_metadata(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/bootstrap.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/regular.css"); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url("/assets/css/trumpeten.css?v=".$this->site_model::CSS_JS_VERSION); ?>" />
<?php $CI->layout->trigger_css(); ?>

<link rel="shortcut icon" type="image/png" href="<?php echo base_url("/assets/img/favicon/favicon-16x16.png"); ?>" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light<?php echo $fixedTop; ?>">
        <a class="navbar-brand" href="/"><img height="36" src="/assets/img/logo.png" alt="Trumpeten" /></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php
      foreach($nav as $key => $val)
      {
          $class = 'nav-item';
          if(is_array($val))
          {
            $class .= ' '.$val['class'];
            $val = $val['url'];
          }
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
<div id="container">
<?php
if($_SERVER['REQUEST_URI'] == '/')
{?>
<div class="hero-image header-filter clear-filter" data-parallax="true" style="background-image: url('/assets/img/main.jpg');">
    <h1 class="hero-text">Välkommen till samfälligheten trumpeten</h1>
    <img  src="zz/assets/img/main.jpg" class="d-block w-100 " alt="...">
</div>
<?php
}
?>
<div class="main">
    <div class="row">
        <?php
        if($site == "anslagstavlan" || $site == "")
        { ?>
        <div class="col-7">
            <?php /* $this->load->view($view,$data); */ ?>
            <?php $CI->layout->trigger_content_section('content'); ?>
        </div>
        <div class="col-5">
            <div id="notes">  
            </div> 
        </div>
        <?php
        }
        else
        {?>
        <div class="col-12">
            <?php /* $this->load->view($view,$data); */ ?>
            <?php $CI->layout->trigger_content_section('content'); ?>
            </div>
            <div id="__notes"> 
            </div>
        <?php
        }
        ?>
    </div>
</div>
</div>
  
  <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Skapa x</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
        <button type="button" class="btn btn-primary" id="modal-button-pub">Spara</button>
      </div>
    </div>
  </div>
</div>
  
  
<footer class="fixed-bottom">
    Copyright <?php echo $this->site_model::SITE_FULL_NAME; ?> &copy; <?php echo date("Y"); ?><br />
    Senast uppdaterad <?php echo $this->lastUpdated; ?>
</footer>

    <script src="<?php echo base_url('assets/js/jquery.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/fontawesome.min.js');?>"></script>
    <script src="<?php echo base_url('assets/js/trumpeten.js');?>"></script>
</body>
</html>