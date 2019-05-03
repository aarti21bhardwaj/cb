<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CardPrintingProfile[]|\Cake\Collection\CollectionInterface $cardPrintingProfiles
 */
?>



<div class="row">
    <div class="col-lg-12">
        <!--<div class="cardPrintingProfiles index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Card Printing Profiles') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Card Printing Profile', ['controller' => 'CardPrintingProfiles', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('left_right_adjustment') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('up_down_adjustment') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
               <!--              <th scope="col"><?= $this->Paginator->sort('Training Sites') ?></th> -->
                            <!-- <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cardPrintingProfiles as $cardPrintingProfile): ?>
                            <tr>
                             <td><?= $this->Number->format($cardPrintingProfile->id) ?></td>
                             <td><?= h($cardPrintingProfile->name) ?></td>
                             <td><?= $this->Number->format($cardPrintingProfile->left_right_adjustment) ?></td>
                             <td><?= $this->Number->format($cardPrintingProfile->up_down_adjustment) ?></td>
                           <!--   <td><?= h($cardPrintingProfile->status) ?></td> -->
                           <td class=""><?= $cardPrintingProfile->status?'Active':'Inactive' ?></td>
                            <!--  <td><?= h($cardPrintingProfile->created) ?></td> -->
<!--                              <td><?= h($cardPrintingProfile->modified) ?></td>
 -->                             <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $cardPrintingProfile->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $cardPrintingProfile->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $cardPrintingProfile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cardPrintingProfile->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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
