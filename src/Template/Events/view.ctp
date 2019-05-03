<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>

        
        
    
<!-- <div class="events view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($event->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($event->name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Event Key') ?></th>
                        <td><?= h($event->event_key) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($event->id) ?></td>
                    </tr>
                                                                                                                        <tr>
                        <th scope="row"><?= __('Is Schedulable') ?></th>
                        <td><?= $event->is_schedulable ? __('Yes') : __('No'); ?></td>
                    </tr>
                                                        </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
    <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
        <h4><?= __('Related Emails') ?></h4>
        </div>
        <?php if (!empty($event->emails)): ?>
        <div class="ibox-content">
        <table class="table" cellpadding="0" cellspacing="0">
            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Tenant Id') ?></th>
                                <th scope="col"><?= __('Event Id') ?></th>
                                <th scope="col"><?= __('Subject') ?></th>
                                <th scope="col"><?= __('From Name') ?></th>
                                <th scope="col"><?= __('From Email') ?></th>
                                <th scope="col"><?= __('Body') ?></th>
                                <th scope="col"><?= __('Status') ?></th>
                                <th scope="col"><?= __('Use System Email') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->emails as $emails): ?>
            <tr>
                                <td><?= h($emails->id) ?></td>
                                <td><?= h($emails->tenant_id) ?></td>
                                <td><?= h($emails->event_id) ?></td>
                                <td><?= h($emails->subject) ?></td>
                                <td><?= h($emails->from_name) ?></td>
                                <td><?= h($emails->from_email) ?></td>
                                <td><?= h($emails->body) ?></td>
                                <td><?= h($emails->status) ?></td>
                                <td><?= h($emails->use_system_email) ?></td>
                                                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Emails', 'action' => 'view', $emails->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Emails', 'action' => 'edit', $emails->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Emails', 'action' => 'delete', $emails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $emails->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div><!-- .ibox-content end -->
        <?php endif; ?>
    
    </div><!-- ibox end-->
    </div><!-- .col-lg-12 end-->
    </div><!-- .row end-->
    <div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
        <h4><?= __('Related Event Variables') ?></h4>
        </div>
        <?php if (!empty($event->event_variables)): ?>
        <div class="ibox-content">
        <table class="table" cellpadding="0" cellspacing="0">
            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Event Id') ?></th>
                                <th scope="col"><?= __('Name') ?></th>
                                <th scope="col"><?= __('Description') ?></th>
                                <th scope="col"><?= __('Variable Key') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($event->event_variables as $eventVariables): ?>
            <tr>
                                <td><?= h($eventVariables->id) ?></td>
                                <td><?= h($eventVariables->event_id) ?></td>
                                <td><?= h($eventVariables->name) ?></td>
                                <td><?= h($eventVariables->description) ?></td>
                                <td><?= h($eventVariables->variable_key) ?></td>
                                                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'EventVariables', 'action' => 'view', $eventVariables->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'EventVariables', 'action' => 'edit', $eventVariables->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'EventVariables', 'action' => 'delete', $eventVariables->id], ['confirm' => __('Are you sure you want to delete # {0}?', $eventVariables->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        </div><!-- .ibox-content end -->
        <?php endif; ?>
    
    </div><!-- ibox end-->
    </div><!-- .col-lg-12 end-->
    </div><!-- .row end-->
<!-- </div>
 -->