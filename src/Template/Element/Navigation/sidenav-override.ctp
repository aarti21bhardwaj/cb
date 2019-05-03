 <!-- style="max-height: 700px !important;overflow-y: scroll;"-->
<nav class="navbar-default navbar-static-side " role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu" >
      <li class="nav-header">
        <div class="dropdown profile-element">
          <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0)">
            <span class="clear"> 
              <span class="block m-t-xs"> 
                <strong class="font-bold">
                  <h2><?= $sideNavData['first_name']." ".$sideNavData['last_name']?></h2>
                </strong>
              </span> 
              <span class="text-muted text-xs block"><?= $sideNavData['role_name']; ?> <b class="caret"></b></span> </span> </a>
              <ul class="dropdown-menu animated fadeInRight m-t-xs">
              <?php if($sideNavData['role_name'] == 'Tenant'){ ?>
                <li>
                <?= $this->Html->link(__('Profile'), ['controller' => 'TenantUsers', 'action' => 'edit', $sideNavData['id']], ['class' => ['fa', 'fa-sign-out']]) ?>
                </li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Tenants', 'action' => 'logout']) ?></li>

                <?php }elseif($sideNavData['role_name'] == 'Instructor'){ ?>
                
                <li>
                <?= $this->Html->link(__('Profile'), ['controller' => 'Instructors', 'action' => 'edit', $sideNavData['id']], ['class' => ['fa', 'fa-sign-out']]) ?>
                </li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Instructors', 'action' => 'logout']) ?></li>
                <?php }else if($sideNavData['role_name'] == 'Corporate Client'){ ?> 
                
                <li><?= $this->Html->link(__('Profile'), ['controller' => 'CorporateClientUsers', 'action' => 'edit', $sideNavData['id'] ]) ?></li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'CorporateClients', 'action' => 'logout']) ?></li>

                <?php }else if($sideNavData['role_name'] == 'Student'){ ?> 
                
                <li><?= $this->Html->link(__('Profile'), ['controller' => 'Students', 'action' => 'edit', $sideNavData['id'] ]) ?></li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Students', 'action' => 'logout']) ?></li>

                <?php }else if($sideNavData['role_name'] == 'TRAINING SITE OWNER'){ ?>

                <li>
                <?= $this->Html->link(__('Profile'), ['controller' => 'TenantUsers', 'action' => 'edit', $sideNavData['id']], ['class' => ['fa', 'fa-sign-out']]) ?>
                </li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Instructors', 'action' => 'logout']) ?></li>

                <?php }else{ ?>

                <li><?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'edit', $sideNavData['id'] ]) ?></li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
                <?php }?>
              </ul>
            </div>
            <div class="logo-element">
              <?= $this->Html->image('icon-reverse-low-rez.png', ['style' => 'width:30px; height:30px;', 'alt'=>'image'])?>
            </div>
          </li>
<?php
$menuItems = [];
if(isset($sideNav) && !empty($sideNav)){
  $menuItems = $sideNav;
}
// pr($tenant->tenant_settings[0]->enable_training_site_module);die;  
foreach($menuItems as $key => $value) {
  // pr();
  $childrenExist = isset($value['children']) && count($value['children']) > 0 ? true : false ;  
  
  if(!empty($tenant->tenant_settings) && isset($tenant->tenant_settings[0]->key_management) && $tenant->tenant_settings[0]->key_management != 1 && $key=='Key Management'){
    
    continue;
  }
  if(!empty($tenant->tenant_settings) && isset($tenant->tenant_settings[0]->shop_menu_visible) && $tenant->tenant_settings[0]->shop_menu_visible != 1 && $key=='Shop' && $loggedInUser['role']->name == 'tenant'){
    
    continue;
  }
  if(!empty($tenant->tenant_settings) && isset($tenant->tenant_settings[0]->enable_aed_pm_module) && $tenant->tenant_settings[0]->enable_aed_pm_module != 1 && $key=='AED Management'){
    
    continue;
  }
  if(!empty($tenant->tenant_settings) && isset($tenant->tenant_settings[0]->enable_aed_pm_module) && $tenant->tenant_settings[0]->enable_aed_pm_module == 1 && $key=='AED Management'){
    
    $value['link'] = $tenant->tenant_settings[0]->aed_pm_module_url;
  }
  if(!$value['show']) {
    continue;
  }
  if(!isset($value['class'])){
    $value['class'] = ''; 
  }

  if(!isset($value['target'])){
    $value['target'] = '';
  }
?>

<li <?= $value['active'] ? 'class="active"' : 'class=""'?>   >
    <a target="<?php echo $value['target']?>" href="<?= $this->Url->build($value['link']);?>"><i class="<?php echo $value['class']?>"></i> <span class="nav-label"><?= $key?> </span><?= $childrenExist ? '<span class="fa arrow"></span>' : '' ?></a>
    <?php 
       //if child exists
       if($childrenExist){
          echo '<ul class="nav nav-second-level collapse">';
          foreach ($value['children'] as $childKey => $childValue) {
            if(!$childValue['show']) {
              continue;
            }          
          $grandChildrenExist = isset($childValue['children']) && count($childValue['children']) > 0 ? true : false ;  
    ?>

        <li>
          <a href="<?= $this->Url->build($childValue['link']);?>"><?= $childKey;?><?= $grandChildrenExist ? '<span class="fa arrow"></span>' : '' ?></a>
              <?php 
                //if grandchild exists
               if($grandChildrenExist){
                    echo '<ul class="nav nav-third-level">';
                  foreach ($childValue['children'] as $grandChildKey => $grandChildValue) {
                    if(!$grandChildValue['show']) {
                        continue;
                      }
              ?>
              
                <li>
                    <a href="<?= $this->Url->build($grandChildValue['link']);?>"><?= $grandChildKey ?></a>
                </li>
            
            <?php }
              echo "</ul>";
            }?>
        </li>
    <?php }
        echo "</ul>";
     }
    ?>
</li>

<?php }?>
</ul>
</div>
</nav>


<?php 
$this->end();

$this->Html->scriptStart(['block' => 'scriptBottom']);
echo "$(function () {
  $('#side-menu').metisMenu();
});";
$this->Html->scriptEnd();

?>
