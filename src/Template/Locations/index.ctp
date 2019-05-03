<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Location[]|\Cake\Collection\CollectionInterface $locations
 */
?>

<div class="row">
    <div class="col-lg-12">
    <!--<div class="locations index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Locations') ?></h3>
                
                <div class="text-right">
                <?=$this->Html->link('Add Location', ['controller' => 'Locations', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
                
            </div>
            <!-- <div class = "ibox-content"> -->
                <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                            <?php  if($loggedInUser['role']->name != 'tenant'){ ?>
                                <th scope="col"><?= $this->Paginator->sort('tenant_id') ?></th>
                                <?php } ?>
                                <?php  if($loggedInUser['role']->name != 'corporate_client'){ ?>
                                <th scope="col"><?= $this->Paginator->sort('corporate_client_id') ?></th>
                                <?php } ?>
                                
                                <th scope="col"><?= $this->Paginator->sort('Location    name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('zipcode') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($locations as $location): ?>
                            <tr>
                            <?php  if($loggedInUser['role']->name != 'tenant'){ ?>
                            <td><?= $location->tenant->center_name ?></td>
                            <?php } ?>
                            <?php  if($loggedInUser['role']->name != 'corporate_client'){ ?>

                                <td><?= $location->corporate_client ? $location->corporate_client->name : '-'?></td>
                                <?php } ?>
                    
                                <td><?= h($location->name) ?></td>
                                <td><?= h($location->city) ?></td>
                                <td><?= h($location->state) ?></td>
                                <td><?= h($location->zipcode) ?></td>
                                
                                <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $location->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                <?php if($loggedInUser['role']->name !== 'corporate_client') {?> 
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $location->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                <?php } ?>
                                <?php if(!$trainingSiteOwner && $loggedInUser['role']->name == 'tenant') {?>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $location->id], ['confirm' => __('Are you sure you want to delete # {0}?', $location->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                <?php } ?>

                                </td>
                                
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                </table>
                <!-- </div> -->
            </div>
        </div>
    </div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
<!-- </div> -->
