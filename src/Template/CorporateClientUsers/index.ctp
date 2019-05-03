<?php

$salonTemplate = [
'button' => '<button class="btn btn-primary m-b" {{attrs}}>{{text}}</button>',
'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];
$this->Form->setTemplates($salonTemplate);

?>




<div class="row">
    <div class="col-lg-12">

        <!--<div class="corporateClientUsers index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Corporate Client Users') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add User', ['controller' => 'corporateClientUsers', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
             <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('corporate_client_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                            <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                            <?php } ?>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($corporateClientUsers as $corporateClientUser): //pr($corporateClientUser);?>
                            <tr>
                                <td><?= $this->Number->format($corporateClientUser->id) ?></td>
                                <td><?= $corporateClientUser->has('corporate_client') ? $this->Html->link($corporateClientUser->corporate_client->name, ['controller' => 'CorporateClients', 'action' => 'view', $corporateClientUser->corporate_client->id]) : '' ?></td>
                                <td><?= h($corporateClientUser->first_name) ?></td>
                                <td><?= h($corporateClientUser->last_name) ?></td>
                                <td><?= h($corporateClientUser->email) ?></td>
                                <td><?= h($corporateClientUser->phone) ?></td>
                                 <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                                <td><?php 
                                if($corporateClientUser->status == 1){ 
                                    echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $corporateClientUser->id,$corporateClientUser->status]);
                                }else{
                                    echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $corporateClientUser->id,0]);
                                }
                                ?></td>
                                <?php } ?>
                                <td class="actions">
                            <?php 
                            $viewUrl = $this->Url->build(["action" => "view", $corporateClientUser->id]);
                            ?>
                            <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-eye fa-fw"></i></a>
                                <?php if($loggedInUser['role']->name == 'tenant'){ ?>

                                <?= '<a href='.$this->Url->build(['action' => 'edit', $corporateClientUser->id]).' class="btn btn-xs btn-warning"">' ?>
                                <i class="fa fa-pencil fa-fw"></i>
                                <?php } ?> 
                            </a>
                            <?php if($loggedInUser['role']->name == 'tenant'){ ?>

                            <?= $this->Form->postLink(__(''), ['action' => 'delete', $corporateClientUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporateClientUser->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            <?php } ?> 
                        </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- </div> -->
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->
