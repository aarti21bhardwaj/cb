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
        <!--<div class="subcontractedClients index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Subcontracted Clients') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Subcontracted Client', ['controller' => 'SubcontractedClients', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
               <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('Client Name') ?></th>
                            <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?>
                                <th scope="col"><?= $this->Paginator->sort('training_site_id') ?></th>
                            <?php } ?>
                            
                            <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('zipcode') ?></th>
                            
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subcontractedClients as $subcontractedClient): ?>
                            <tr>
                                <td><?= h($subcontractedClient->name) ?></td>
                                <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?>
                                    <td><?= $subcontractedClient->training_site->name ?>
                                <?php } ?>
                                <td><?= h($subcontractedClient->city) ?></td>
                                <td><?= h($subcontractedClient->state) ?></td>
                                <td><?= h($subcontractedClient->zipcode) ?></td>
                                
                                

                                 <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $subcontractedClient->id]);
                                    ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $subcontractedClient->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                       <?php  if(isset($loggedInUser) && $loggedInUser['role']->label !== 'TRAINING SITE OWNER' ){ ?>                          <?= $this->Form->postLink(__(''), ['action' => 'delete', $subcontractedClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $subcontractedClient->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                <?php } ?>
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
