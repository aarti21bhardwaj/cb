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

  <style type="text/css">
    .required:after{
      content:"*";
      font-weight:bold;
      color:red;
    }
  </style>
  <?= $this->Html->meta('icon') ?>

  <?php echo $this->Html->meta('favicon.ico','img/favicon.ico.png',array('type' => 'icon'));?>

  <?= $this->Html->css('bootstrap.min.css') ?>
  <?php //$this->Html->css('font-awesome.min.css') ?>

  <?= $this->Html->css('plugins/toastr/toastr.min.css') ?>
  <?= $this->Html->css('animate.css') ?>
  <?= $this->Html->css('style.css') ?>
  <?= $this->Html->css(['plugins/iCheck/custom', 'plugins/steps/jquery.steps']) ?>
  <!-- Inspenia Switchery for toggle buttons -->
  <?= $this->Html->css(['plugins/switchery/switchery'])?>

  <?= $this->Html->css('plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') ?>

    <!-- <?= $this->Html->css('plugins/toastr/toastr.min.css') ?> -->
    <?= $this->Html->css('animate.css') ?>
    <?= $this->Html->css('style.css') ?>
    <?= $this->Html->css('spectrum.css') ?>
    <!-- Inspenia Switchery for toggle buttons -->
    <?= $this->Html->css(['plugins/switchery/switchery'])?>
    <?= $this->Html->css(['https://cdn.datatables.net/fixedcolumns/3.2.6/css/fixedColumns.dataTables.min.css'])?>

    <?= $this->Html->css('plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') ?>
    <?= $this->Html->css(["plugins/dataTables/datatables.min"]) ?>

    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="
    http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">  
    <!-- Bootstrap Tour -->
    <?= $this->Html->css(["plugins/bootstrapTour/bootstrap-tour.min"]) ?>

    <?= $this->Html->css(["plugins/datapicker/datepicker3"]) ?>
    <?= $this->Html->css(["plugins/clockpicker/clockpicker.css"]) ?>
    


    <?= $this->Html->css('plugins/sweetalert/sweetalert') ?>
    <?= $this->Html->script('plugins/sweetalert/sweetalert.min') ?>
    <?= $this->Html->css('plugins/select2/select2.min') ?>

    <?= $this->Html->script('jquery-2.1.1') ?>
   
<?= $this->fetch('meta') ?>
<?= $this->fetch('css') ?>
<?= $this->fetch('script') ?>
</head>

<body>
  <div id="wrapper">

    <?= $this->element('Navigation/sidenav-override' ); //, array('sideNavData' => $sideNavData)); ?>

    <?= $this->fetch('nav') ?>
    <div id="page-wrapper" class="gray-bg">

      <?=  $this->Form->hidden('baseUrl',['id'=>'baseUrl','value'=>$this->Url->build('/', true)]); ?>
      <div class="row border-bottom">
        <?= $this->element('Navigation/topnav-override'); ?>
      </div>
      <?= $this->element('titleband-override')?>
      <div class="wrapper wrapper-content animated fadeIn" id="pageWrapper">
       <?= $this->Flash->render('auth', ['element' => 'Flash/error']) ?>
       <?= $this->Flash->render() ?>

       <?= $this->fetch('content') ?>

     </div>
     <?= $this->element('footer'); ?>
   </div>

 </div>

<?= $this->Html->script('bootstrap.min') ?>
<?= $this->Html->script('super_admin') ?>
<?= $this->Html->script('jquery.nestable') ?>
<?= $this->Html->script('jquery.cookie') ?>
<?= $this->Html->script('spectrum.js') ?>
<?= $this->Html->script(['/js/plugins/metisMenu/jquery.metisMenu', '/js/plugins/pace/pace.min.js', '/js/plugins/slimscroll/jquery.slimscroll.min', '/js/plugins/toastr/toastr.min']) ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>


 <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width: 950px;" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" class="white-bg">
      <iframe id="iframeContent" height = "500" width = "900" scrolling="yes" allowfullscreen="false" >
        </iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Jquery UI Script-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- Jquery UI Script-->
<?= $this->Html->script(["plugins/dataTables/datatables.min",'/js/plugins/select2/select2.full.min']) ?>

<!-- Jquery UI Script-->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<!-- JS cookie -->
<?= $this->Html->script('plugins/jsCookie/js-cookie') ?>

<?= $this->Html->script('plugins/fullcalendar/moment.min.js') ?>


<?= $this->Html->script('/js/plugins/datapicker/bootstrap-datepicker.js') ?>

<?= $this->Html->script('/js/plugins/validate/jquery.validate.min.js') ?>
<?= $this->Html->script('/js/plugins/clockpicker/clockpicker.js') ?>
<!-- <script src="js/plugins/nestable/jquery.nestable.js"></script> -->
 <?= $this->Html->script('https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js') ?>

<!-- Inspenia Switchery for toggle buttons -->
<?= $this->Html->script(['plugins/switchery/switchery'])?>


<script>
   
   $(document).ready(function(){    
        $('.dataTables').DataTable({
            order: [],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                
            ]
        });
    });
</script>
<style type="text/css">
.table.dataTables thead th {
  border-bottom: 0;
}
.table.dataTables.no-footer {
  border-bottom: 0;
}
</style>
<script>
 /* $(document).ready(function(){
    tinymce.init({
      selector: 'textarea',
      height: 200,
      menubar: false,
      plugins: [
      'advlist autolink link lists anchor',
      'searchreplace code',
      'insertdatetime  paste code'
      ],
      toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link',
      content_css: '//www.tinymce.com/css/codepen.min.css'
    });
  })*/
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("input[required]").parent("div").prev('label').addClass("required");
  });

</script>

<script type="text/javascript">

  function openViewPopUp(url, viewTitle){
    url= url+'?layoutType=popUp';
    $("#iframeContent").attr('src', url);
  }
  // $('.corporateClientDocs').on('click', function(){
  //   this->layoutType = popUp;
  // })
</script>

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