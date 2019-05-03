<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorporateClientNote[]|\Cake\Collection\CollectionInterface $corporateClientNotes
 */
?>



<div class="row">
  <div class="col-lg-12">
    <!--<div class="corporateClientNotes index large-9 medium-8 columns content">-->

    <div class="ibox float-e-margins">
      <div class = 'ibox-title'>
        <h3><?= __('Corporate Client Notes') ?></h3>
        <div class="text-right">
          <?=$this->Html->link('Add Corporate Client Notes', ['controller' => 'CorporateClientNotes', 'action' => 'add', $id, '?'=>['layoutType'=>'popUp']], ['class' => ['btn', 'btn-success', 'corporateClientDocs']]) ?>
                </div>
              </div>
              <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                  <thead>
                    <?php 
                    // pr($corporateClientNotes); die();
                    if(!$corporateClientNotes): ?>
                      <h5 class="text-center">No note exists</h5>
                    <?php else: ?>
                    <tr>
                      <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                      <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                      <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                    <?php endif; ?>
                  </thead>
                  <tbody>
                    <?php 
                    foreach ($corporateClientNotes as $key=>$corporateClientNote): ?>
                    <tr>

                      <td><?= $key + 1 ?></td>
                      <td><?=$corporateClientNote->description ?></td>                                                                                      <td class="actions">

                      <?= '<a href='.$this->Url->build(['action' => 'edit', '?'=> ['layoutType'=>'popUp'], $corporateClientNote->id, $corporate_client_id]).' class="btn btn-xs btn-warning"">' ?>
                      <i class="fa fa-pencil fa-fw"></i>
                    </a>
                    <?= $this->Form->postLink(__(''), ['action' => 'delete', '?'=> ['layoutType'=>'popUp'], $corporateClientNote->id, $corporate_client_id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporateClientNote->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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
