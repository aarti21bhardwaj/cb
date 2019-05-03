<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QualificationType[]|\Cake\Collection\CollectionInterface $qualificationTypes
 */
?>




<div class="row">
    <div class="col-lg-12">
        <!--<div class="qualificationTypes index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Qualification Types') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Qualification Type', ['controller' => 'QualificationTypes', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('qualification_id') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($qualificationTypes as $qualificationType): ?>
                            <tr>
                              <td><?= $this->Number->format($qualificationType->id) ?></td>
                              <td><?= h($qualificationType->name) ?></td>
                              <td><?= h($qualificationType->status) ?></td>
                              <td><?= h($qualificationType->created) ?></td>
                              <td><?= h($qualificationType->modified) ?></td>
                              <td><?= $qualificationType->has('qualification') ? $this->Html->link($qualificationType->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $qualificationType->qualification->id]) : '' ?></td>
                              <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $qualificationType->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $qualificationType->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $qualificationType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $qualificationType->id)]) ?>
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
