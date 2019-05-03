<?php
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');

// $sitePath = Configure::read('siteUrl');
// pr($loggedInUser); die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorQualification $instructorQualification
 */
// pr($tenantTheme);die;
/*?>
<style type="text/css">
.top-navigation .navbar-brand {padding: 0px 10px;}
</style>
<div class="row border-bottom white-bg">
    <nav class="navbar navbar-static-top" role="navigation">
        <div class="navbar-header">
            <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <i class="fa fa-reorder"></i>
            </button>
            <?php if(isset($tenantTheme->logo_path)){
                    if(isset($loggedInUser) && $loggedInUser['role']['name'] == 'student'){ 
            ?>
            <a style="background:none;" href="<?php echo $this->Url->build(["controller" => "Students","action" => "classes"]);?>" class="navbar-brand"><img style="max-height: 59px; max-width: 127px; padding: 0px 0px;" src="<?php echo $sitePath.$tenantTheme->logo_path.'/'.$tenantTheme->logo_name;?>"></a>
            <?php }else{?>
            <a style="background:none;" href="<?php echo $this->Url->build(["controller" => "Students","action" => "login"]);?>" class="navbar-brand"><img style="max-height: 59px; max-width: 127px; padding: 0px 0px;" src="<?php echo $sitePath.$tenantTheme->logo_path.'/'.$tenantTheme->logo_name;?>"></a>
            <?php }?>
            <?php }?>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
        <?php if(isset($loggedInUser) && $loggedInUser['role']['name'] == 'student'){ ?>
            <ul class="nav  navbar-right">
                <li class="dropdown">
                    <a aria-expanded="false" role="button" href="#" class="dark dropdown-toggle" data-toggle="dropdown" style="color: white;"> <?php  echo $loggedInUser['first_name']." ".$loggedInUser['last_name']; ?> <span class="caret"></span></a>
                    <ul role="menu" style="color: white;" class="dark dropdown-menu">
                        <li>
                            <?= $this->Html->link(__('Edit Profile'), ['controller' => 'Students', 'action' => 'edit', $loggedInUser['id']]) ?>
                        </li>
                        <li><?= $this->Html->link(__('Course History'), ['controller' => 'Students', 'action' => 'courseHistory']) ?></li>
                        <li><?= $this->Html->link(__('Logout'), ['controller' => 'Students', 'action' => 'logout']) ?></li>
                    </ul>
                </li>
                
            </ul>
            <?php } ?>
           
            </style>
           
            <ul class="nav navbar-top-links navbar-right">
                <?php if($loggedInUser['role']['name'] != 'student'){  ?>
                <li>
                    <a href="<?php echo $this->Url->build(["controller" => "Students","action" => "login"]);?>">
                        <span class="dark" style="color:#fff; padding : 4px;" >Login</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
</div>
*/?>
<header class="navbar-fixed-top master_color">
  <div class="row">
    <div class="container-fluid">
      <!-- <div class="pull-left"> -->
        <!-- <div class="pull-left logo text-center color_set"> -->
          <!-- <?php //if(isset($loggedInUser)){  ?> -->
            <?php if(isset($tenantTheme->logo_path)){?>
              <a style="background:none;" href="<?php echo $this->Url->build(["controller" => "Students","action" => "classes"]);?>" class=""><img style="max-height: 59px; max-width: 127px; margin-left: 1px;  padding: 0px 0px;" src="<?php echo $sitePath.$tenantTheme->logo_path.'/'.$tenantTheme->logo_name;?>"></a>
            <?php }else{?>
          <a class="btn-large pull-left cb_theme_dark" style="padding: 6px; margin-left: 10px; margin-top: 8px;" href="<?php echo $this->Url->build(["controller" => "Students","action" => "portal"]);?>">
              <i class="fa fa-home fa-2x"></i>
          </a>
        <?php }  ?>
          


        <!-- </div> -->
      <!-- </div> -->
          
      <div class="pull-right">
        <?php if(isset($loggedInUser) && $loggedInUser['role']['name'] == 'student'){ ?>
          <!-- <ul class="nav navbar-top-links navbar-right"> -->
           <!-- /.dropdown -->
            <!-- <li class="dropdown user">
              <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class=
              "fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu dropdown-user own_set"> -->
              <div class="row" style="margin-right: 0px;">  
                <div class="col-sm-3" style="padding-top: 14px;" title="User Profile">
                  <a class="cb_theme_dark" href="<?php echo $this->Url->build(["controller" => "Students","action" => "edit",$loggedInUser['id']]);?>"><i class="fa fa-user fa-2x"></i></a>
                </div>
                <div class="col-sm-3" style="padding-top: 14px;" title="Course History">
                  <a class="cb_theme_dark" href="<?php echo $this->Url->build(["controller" => "Students","action" => "courseHistory"]);?>"><i class="fa fa-gear fa-2x"></i></a>
                </div>
                <?php if(isset($tenantTheme->content_sidebar)){?>
                  <div class="col-sm-3" style="padding-top: 14px;" title="Contact Us">
                    <a class="cb_theme_dark" href="#" data-toggle="modal" data-target="#contactUs">
                      <i class="fa fa-phone fa-2x" aria-hidden="true"></i>
                    </a>
                  </div>
                <?php } ?>
                <div class="col-sm-3" style="padding-top: 14px;" title="Logout">
                  <a class="cb_theme_dark" href="<?php echo $this->Url->build(["controller" => "Students","action" => "logout"]);?>"><i class="fa fa-sign-out fa-2x"></i></a>
                </div>
              </div>
              <!-- </ul> --><!-- /.dropdown-user -->
           <!--  </li> --><!-- /.dropdown -->
          <!-- </ul> -->
          <?php }else{ ?>
          </div>
          <div class="pull-right clearfix">
            <ul class="nav navbar-top-links navbar-right">
                <li>
                  <a class="btn btn-sm btn-primary" href="<?php echo $this->Url->build(["controller" => "Students","action" => "login"]);?>">Login</a>
                </li>
            </ul>
            <?php }?>
          </div>
    </div>
  </div>
</header>
