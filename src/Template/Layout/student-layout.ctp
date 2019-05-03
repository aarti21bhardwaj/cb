<?php
$cakeDescription =  $title.'| Application';
// pr($tenantTheme);die;
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?php echo $this->Html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));?>

     <?= $this->Html->css('bootstrap.min.css') ?>
  <?= $this->Html->css('student-style.css') ?>
  <?= $this->Html->css('animate.css') ?>
  <?= $this->Html->script('super_admin') ?>
  <?= $this->Html->css('plugins/fullcalendar/fullcalendar.css') ?>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css" rel="stylesheet">
  <?= $this->Html->css(["plugins/datapicker/datepicker3"]) ?>
  <?= $this->Html->css("plugins/steps/jquery.steps") ?>
  <?= $this->Html->script('jquery-2.1.1') ?>
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>
<style type="text/css">
  .dropdown-menu{
    width: 200px !important;
  }
</style>
<body class="top-navigation landing-page color_dark">
    <?php /* <div id="wrapper">
        <div id="page-wrapper" class="gray-bg">
        <?=  $this->Form->hidden('baseUrl',['id'=>'baseUrl','value'=>$this->Url->build('/', true)]); ?>
        <?= $this->element('Navigation/studentnav'); ?>
            <div class="wrapper wrapper-content">
                <div class="container">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        <?= $this->element('Navigation/studentfooter'); ?>
        </div>
    </div> */?>

 <div class="">
    <div class="wrap">
      <?=  $this->Form->hidden('baseUrl',['id'=>'baseUrl','value'=>$this->Url->build('/', true)]); ?>
      <?= $this->element('Navigation/studentnav'); ?>
      <?= $this->Flash->render('auth', ['element' => 'Flash/error']) ?>
       <?= $this->Flash->render() ?>
      <div class="container">
        <div class="side-body">
          <div class="">
            <h3 class="page-title text-center"><?php if($this->request->getParam('action') == 'thankYou'){ $data = 'Payment Successful!';}
           else{$data = "";} 
            echo ucfirst($data);?></h3>
            <div class="clearfix"></div>
          </div>
          <div class="row">
            <?= $this->fetch('content');?>
          </div>
        </div>
      </div>
    </div>
  </div>

<!-- Jquery UI Script-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?= $this->Html->script('bootstrap.min') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<!-- Jquery UI Script-->
<?= $this->Html->script('/js/plugins/datapicker/bootstrap-datepicker.js') ?>
<?= $this->Html->script('/js/plugins/clockpicker/clockpicker.js') ?>
<?= $this->Html->script('plugins/staps/jquery.steps.min.js') ?>
<?= $this->Html->script(['plugins/validate/jquery.validate.min.js','/js/plugins/metisMenu/jquery.metisMenu', '/js/plugins/slimscroll/jquery.slimscroll.min']) ?>
<!--dynamic themes styles -->

<style type="text/css">
<?php if(isset($tenantTheme) && !empty($tenantTheme)){?>
.master_color{ background-color:<?php echo $tenantTheme->theme_color_light;?> !important;}
.dark_background{background-color:<?php echo $tenantTheme->theme_color_dark;?> !important; border-color:<?php echo $tenantTheme->theme_color_dark;?> !important;}
.cb_theme_dark {color:<?php echo $tenantTheme->theme_color_dark;?> !important;}
.light_foreground {color:<?php echo $tenantTheme->theme_color_light;?> !important;}
/*.clearfix ul li {background-color: <?php echo $tenantTheme->theme_color_dark;?> !important; border-color:<?php echo $tenantTheme->theme_color_dark;?> !important;}*/
<?php } else{ ?>
.master_color{ background-color: #c5dcf1 !important;}
.dark_background{background-color:#337ab7 !important; border-color:#337ab7 !important;}
.cb_theme_dark {color: #337ab7 !important;}
.light_foreground {color: #c5dcf1 !important;}
<?php } ?>
</style>

<?php
/*if($color == '0'){?>
    <style type="text/css">
        .master_color{background-color:#E5E5E5 !important;}
        .dark{background-color:#888 !important; border-color:#888 !important;}
    </style>
<?php } else if($color == '1'){?>
    <style type="text/css">
        .master_color{background-color:#f5cac1 !important;}
        .dark{background-color:#e74c3c !important; border-color:#e74c3c !important;}
    </style>
<?php }else if($color == '2'){?>x
    <style type="text/css">
        .master_color{ background-color:#FAD1B6 !important;}
        .color_dark .color_set{background-color:#d35400 !important; border-color:#d35400 !important;}
    </style>
<?php }else if($color == '3'){?>
    <style type="text/css">
        .master_color{background-color:#DFEBF7 !important;}
        .dark{background-color:#2980b9 !important; border-color:#2980b9 !important;}
    </style>
<?php } */?>

<?= $this->fetch('scriptBottom'); ?>
<?= $this->Html->script('inspinia') ?>


<script>
  $(function () {
    $('#side-menu').metisMenu();
  });
</script>
</body>

<script>
  $.validate({
    lang: 'en'
  });
</script>


</html>
