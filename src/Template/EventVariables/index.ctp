<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVariable[]|\Cake\Collection\CollectionInterface $eventVariables
 */
?>

        
    
<div class="row">
    <div class="col-lg-12">
    <!--<div class="eventVariables index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Event Variables') ?></h3>
            </div>
            <div class = "ibox-content">
                <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('variable_key') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($eventVariables as $eventVariable): ?>
                        <tr>
                                                                                                                                                                                                                                            <td><?= $this->Number->format($eventVariable->id) ?></td>
                                                                                                                                                                                                                <td><?= $eventVariable->has('event') ? $this->Html->link($eventVariable->event->name, ['controller' => 'Events', 'action' => 'view', $eventVariable->event->id]) : '' ?></td>
                                                                                                                                                                                                                                                                                                                                    <td><?= h($eventVariable->name) ?></td>
                                                                                                                                                                                                                                                                                                        <td><?= h($eventVariable->description) ?></td>
                                                                                                                                                                                                                                                                                                        <td><?= h($eventVariable->variable_key) ?></td>
                                                                                                                                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $eventVariable->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $eventVariable->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $eventVariable->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventVariable->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
<!-- </div> -->
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->
