<?php 

//Inflecting the names of the controller
$underscore = \Cake\Utility\Inflector::underscore($this->request->getParam('controller'));
$humanize = \Cake\Utility\Inflector::humanize($underscore);
// pr($humanize);die();
$underscoreAction = \Cake\Utility\Inflector::underscore($this->request->getParam('action'));
$humanizeAction = \Cake\Utility\Inflector::humanize($underscoreAction);
?>
                
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <?php if($humanize == 'Users' && $humanizeAction == 'Dashboard'){
                echo '<h2 id="pageTitle">Dashboard</h2>';
            }else{
        ?>
        <h2 id="pageTitle"><?= $humanize ?></h2>
        <?php }
            if(!($humanize == 'Users' && $humanizeAction == 'Dashboard')){
        ?>
        <ol class="breadcrumb" id="breadcrumb">
            <li>
                <?php echo 'Home'; ?>
            </li>
            <li>
                <?php if(($humanize != "Vendor Settings") && ($humanize != "Reports")){ ?>
                   <?php if($humanize == $humanizeAction) {
                        echo 'Settings';
                        } else { 
                       echo $this->Html->link($humanize,"/".$this->request->getParam('controller')); 
                        }
                 }else{ 
                    echo $humanize;
                    } ?>
            </li>
            <?php if(!($humanizeAction == 'Index') && ($humanize != 'Reports')){ ?>
            <li class="active" style="background-color:#fff;">
                <strong><?= $humanizeAction; //ucfirst($this->request->getParam('action')) ?></strong>
            </li>
            <?php } ?>
        </ol>
        <?php } ?>
    </div>
</div>
