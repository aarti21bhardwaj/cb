<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenantUser[]|\Cake\Collection\CollectionInterface $tenantUsers
 */
?>

        
        
    
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Tenant Users') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Tenant User', ['controller' => 'TenantUsers', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('tenant_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('role_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tenantUsers as $tenantUser): ?>
                        <tr>
                        <td><?= $this->Number->format($tenantUser->id) ?></td>
                        <td><?= $tenantUser->has('tenant') ? $this->Html->link($tenantUser->tenant->center_name, ['controller' => 'Tenants', 'action' => 'view', $tenantUser->tenant->id]) : '' ?></td>
                        <td><?= h($tenantUser->role->label) ?></td>
                        <td><?= h($tenantUser->first_name) ?></td>
                        <td><?= h($tenantUser->last_name) ?></td>
                        <td><?= h($tenantUser->email) ?></td>
                        <td><?= h($tenantUser->phone) ?></td>
                        <?php if($loggedInUser['id'] == $tenantUser->id) {?>
                            <td>
                                <?= $tenantUser->status? 'Active' : 'Inactive' ?>
                            </td>
                        <?php } else { ?>
                        <td>
                            <?php 
                                if($tenantUser->status == 1){ 
                                    echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $tenantUser->id,$tenantUser->status]);
                                }else{
                                    echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $tenantUser->id,0]);
                                }
                            ?>
                        </td>
                    <?php } ?>
                        <td class="actions">
                        <?php 
                        $viewUrl = $this->Url->build(["action" => "view", $tenantUser->id]);
                        ?>
                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                            <i class="fa fa-eye fa-fw"></i></a>

                            <?= '<a href='.$this->Url->build(['action' => 'edit', $tenantUser->id]).' class="btn btn-xs btn-warning"">' ?>
                            <i class="fa fa-pencil fa-fw"></i>
                        </a>
                        <?php if($loggedInUser['id'] != $tenantUser->id){?>
                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $tenantUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tenantUser->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                    <?php } ?>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->
