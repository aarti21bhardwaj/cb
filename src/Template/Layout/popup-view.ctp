<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription =  $title.'| Application';
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

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

  <?= $this->Html->css('bootstrap.min.css') ?>
  <?= $this->Html->css('animate.css') ?>
  <?= $this->Html->css('style.css') ?>
  <?= $this->Html->css('animate.css') ?>
  <?= $this->Html->css('style.css') ?>
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css" rel="stylesheet">
  <?= $this->Html->css(["plugins/datapicker/datepicker3"]) ?>
  <?= $this->Html->css("plugins/steps/jquery.steps") ?>
  <?= $this->Html->css('plugins/select2/select2.min') ?>
  <?= $this->Html->script('jquery-2.1.1') ?>
  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
 
</head>

<body style="background-color: #fff;">
<?= $this->Form->hidden('baseUrl',['id'=>'baseUrl','value'=>$this->Url->build('/', true)]); ?>
<?= $this->Flash->render('auth', ['element' => 'Flash/error']) ?>
<?= $this->Flash->render() ?>
<?= $this->fetch('content'); ?>

<!-- Jquery UI Script-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<?= $this->Html->script('bootstrap.min') ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<!-- Jquery UI Script-->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<?= $this->Html->script('/js/plugins/datapicker/bootstrap-datepicker.js') ?>
<?= $this->Html->script('/js/plugins/clockpicker/clockpicker.js') ?>
<?= $this->Html->script('plugins/staps/jquery.steps.min.js') ?>
<?= $this->Html->script('plugins/validate/jquery.validate.min.js') ?>
<?= $this->Html->script(['/js/plugins/select2/select2.full.min']) ?>



<?= $this->fetch('scriptBottom'); ?>
<?= $this->Html->script('inspinia') ?>

<script>
  $(function () {
    $('#side-menu').metisMenu();
  });
</script>
</body>
<!-- Put HTML tag back at line 157 -->
</html>