<?php
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
<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/regular.css" />
<link rel="stylesheet" type="text/css" href="/assets/css/trumpeten.css?v=<?php echo $this->site_model::CSS_JS_VERSION; ?>" />
<?php $CI->layout->trigger_css(); ?>

<link rel="shortcut icon" type="image/png" href="/assets/img/favicon/favicon-16x16.png"/>
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
        if($site == "anslagstavlan")
        { ?>
        <div class="col 8">
            <?php /* $this->load->view($view,$data); */ ?>
            <?php $CI->layout->trigger_content_section('content'); ?>
        </div>
        <div class="col 4">
            <div id="notes">  
                <?php
                if(isset($notes))
                {
                    foreach($notes as $note)
                    {
                        $boardNote = '';
                        if($_SERVER['REQUEST_URI'] != '/' && $note['created_by'] == 1)
                        {
                            $boardNote = '<span class="badge badge-primary badge-pill right">från styrelsen</span>';
                        }
                        ?>
                    <div class="alert alert-<?php echo $note['color'];?>" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>

                        <div><?php echo $note['titel'].$boardNote; ?></div>
                        <?php
                        if($note['image_path'] !== NULL)
                        {
                            echo '<div><img class="img-fluid" alt="Bild" src="'.$note['image_path'].'" /></div>';
                        }
                        ?>
                        <div><?php echo $note['note']; ?></div>
                    </div>
                    <?php
                    }
                }
                ?>
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
            <div id="notes"> 
            </div>
        <?php
        }
        ?>
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