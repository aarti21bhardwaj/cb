<?php
use Cake\Http\Session; 
?>
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary"><i class="fa fa-bars"></i> </a>
    </div>
<ul class="nav navbar-top-links navbar-right">
    <li>
    <?php 
    $this->request->getSession()->read('superAdminUser');
    if($this->request->getSession()->read('superAdminUser')){ ?>
    <?= $this->Html->link(__('Back to Super-Admin'), ['controller' => 'Users', 'action' => 'exitSuperAdminLogin'], ['class' => ['fa', 'fa-sign-out']]) ?>
   <?php } ?>
    </li>
</ul>
<ul class="nav navbar-top-links navbar-right">
    <li>
    <?php if($sideNavData['role_name'] == 'Tenant'){ ?>
        <?= $this->Html->link(__('Logout'), ['controller' => 'Tenants', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
    <?php }elseif($sideNavData['role_name'] == 'Instructor'){ ?>
        <?= $this->Html->link(__('Logout'), ['controller' => 'Instructors', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
    <?php }else if($sideNavData['role_name'] == 'Corporate Client'){ ?> 
        <?= $this->Html->link(__('Logout'), ['controller' => 'CorporateClients', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
    <?php }else if($sideNavData['role_name'] == 'Student'){ ?> 
        <?= $this->Html->link(__('Logout'), ['controller' => 'Students', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>

    <?php }else if($sideNavData['role_name'] == 'TRAINING SITE OWNER'){ ?> 
        <?= $this->Html->link(__('Logout'), ['controller' => 'Tenants', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
    <?php }else{  ?>
        <?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
    <?php }?>
    </li>
</ul>
</nav>