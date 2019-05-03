<?php
$cakeDescription =  $title.'| Application';
?>
<!DOCTYPE html>
<html>
<head>

    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?php echo $this->Html->meta('favicon.ico','favicon.ico',array('type' => 'icon'));?>

    <?= $this->Html->css('bootstrap.min.css') ?>
    <?= $this->Html->css('font-awesome.min.css') ?>
    <?= $this->Html->css('animate.css') ?>
    <?= $this->Html->css('student-style.css') ?>
    <!-- Gritter -->
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="gray-bg">
  <?= $this->Flash->render() ?>
  <?= $this->Flash->render('auth', ['element' => 'Flash/error']) ?>
    <!-- Content part starts -->
    <!-- <div class="middle-box text-center loginscreen animated fadeInDown"> -->
        <?= $this->fetch('content'); ?>
        
    <!-- </div> -->
    <!-- content part ends -->

    <?= $this->Html->script('jquery-2.1.1') ?>
    <?= $this->Html->script('student-index') ?>
    <?= $this->Html->script('bootstrap.min') ?>
    <?= $this->Html->script(['/js/plugins/validator/validator.js']) ?>
    <?= $this->Html->script(['/js/plugins/slimscroll/jquery.slimscroll.min', '/js/plugins/toastr/toastr.min', '/js/plugins/validator/validator.js']) ?>

</body>

</html>