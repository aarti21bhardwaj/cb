<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */
?>

        
        
    
<div class="row">
    <div class="col-lg-12">
    <!--<div class="events index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Events') ?></h3>
            </div>
            <div class = "ibox-content">
                <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('event_key') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('is_schedulable') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                                                                                                                                                                                        <td><?= $this->Number->format($event->id) ?></td>
                                                                                                                                                                                                                                                    <td><?= h($event->name) ?></td>
                                                                                                                                                                                                                                                    <td><?= h($event->event_key) ?></td>
                                                                                                                                                                                                                                                    <td><?= h($event->is_schedulable) ?></td>
                                                                                                                                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $event->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $event->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $event->id], ['confirm' => __('Are you sure you want to delete # {0}?', $event->id)]) ?>
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
