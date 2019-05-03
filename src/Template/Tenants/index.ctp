<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b" {{attrs}}>{{text}}</button>',
'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];
$this->Form->setTemplates($salonTemplate);
// pr($tenants);die();
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Tenants') ?></h3>
                <div class="text-right">
                    <?= $this->Html->link('Add Tenant', ['controller' => 'Tenants' , 'action' => 'add'],['class' => ['btn', 'btn-success']]);?>
                </div>
            </div>
            <div class = "ibox-content">
               <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Training Center Name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Domain Name') ?></th>
                            <th scope="col"><?= h('Status') ?></th>
                            <!-- <th scope="col"><?= h('Login As SuperAdmin') ?></th> -->
                            <th scope="col"><?= h('Login As Tenant') ?></th>
                            <th scope="col"><?= h('Settings') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tenants as $key => $tenant): ?>

                            <tr>
                               <td><?= $key+1 ?></td>
                               <td><?= h($tenant->center_name) ?></td>
                               <td><!-- <?= h($tenant->domain_type) ?> -->
                                   <a target="_blank" href='<?= h($tenant->domain_type) ?>'><?= h($tenant->domain_type) ?></a>
                               </td>
                               <td>
                                <!-- <a href="#"><i class="fa fa-check text-navy"></i></a> -->

                                <?php 
                                if($tenant->status == 1){ 
                                    echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $tenant->id,$tenant->status]);
                                }else{
                                    echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $tenant->id,0]);
                                }
                                ?>
                            </td>
                            <!-- <td class= "text-center"><?= $tenant->status?'<span class=" fa fa-times fa-1x label-primary"></span>':'<span class=" fa fa-times fa-1x label-danger">    </span>' ?></td> -->    
                            <td><?= 
                                '<a href='.$this->Url->build(['controller'=> 'Users','action' => 'loginThroughSuperAdmin', $tenant->id]).' class="">' ?>
                                <i class="">Login</i>
                            </a>
                        </td>
                       <!--  <td> 
                            <a target="_blank" href='http://<?= $tenant->domain_type; ?>'>
                                <i class="">Login</i>
                            </a>

                        </td> -->
                        <td class="text-center">
                            <a href="<?php echo $this->Url->build(['controller'=>'TenantSettings','action' => 'add', $tenant->id])?>"><i class="fa fa-cog"></i> </a>
                        </td>
                        <td class="actions">
                            <?php 
                            $viewUrl = $this->Url->build(["action" => "view", $tenant->id]);
                            ?>
                            <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-eye fa-fw"></i></a>

                                <?= '<a href='.$this->Url->build(['action' => 'edit', $tenant->id]).' class="btn btn-xs btn-warning"">' ?>
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>

                            <?= $this->Form->postLink(__(''), ['controller' => 'Tenants','action' => 'delete', $tenant->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenant->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- </div> -->
</div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->

</div><!-- .row end -->