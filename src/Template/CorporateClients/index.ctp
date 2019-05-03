<div class="row">
    <div class="col-lg-12">
        <!--<div class="corporateClients index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Corporate Clients') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Corporate Client', ['controller' => 'CorporateClients', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('Client name') ?></th>
                                <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?>
                                <th scope="col"><?= $this->Paginator->sort('training_site_id') ?></th>
                                <?php } ?>
                                <th scope="col"><?= $this->Paginator->sort('Notes and Documentation') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('zipcode') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($corporateClients as $corporateClient): ?>
                                <tr>
                                    <td><?= h($corporateClient->name) ?></td>
                                    <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?>
                                        <td><?= $corporateClient->training_site->name ?>
                                    <?php } ?>
                                        <td>
                                            <p style='text-align: left;'>Notes: 
                                                <span style="float:right;">
                                                    <?php 
                                                    $viewUrl = $this->Url->build(["controller"=>"corporateClientNotes","action" => "index", $corporateClient->id]);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-eye fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                </span>
                                            </p>
                                            <p style='text-align: left;'>Documents: 
                                                <span style="float:right;">
                                                    <?php 
                                                    $viewUrl = $this->Url->build(["controller"=>"corporateClientDocuments","action" => "index", $corporateClient->id]);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-eye fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                </span>
                                            </p>
                                        </td>
                                        <td><?= h($corporateClient->city) ?></td>
                                        <td><?= h($corporateClient->state) ?></td>
                                        <td><?= h($corporateClient->zipcode) ?></td>
                                        <td>
                                        <?php 
                                            if($corporateClient->status == 1){ 
                                                echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $corporateClient->id,$corporateClient->status]);
                                            }else{
                                                echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $corporateClient->id,0]);
                                            }
                                        ?>
                                        </td>
                                        <td class="actions">
                                            <?php 
                                            $viewUrl = $this->Url->build(["action" => "view", $corporateClient->id]);
                                            ?>
                                            <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-eye fa-fw"></i>
                                            </a>
                                            <?= '<a href='.$this->Url->build(['action' => 'edit', $corporateClient->id]).' class="btn btn-xs btn-warning"">' ?>
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        <?php  if(isset($loggedInUser) && $loggedInUser['role']->label !== 'TRAINING SITE OWNER' ){ ?>
                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $corporateClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporateClient->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                        <?php } ?>
                                        
                                    </td>
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