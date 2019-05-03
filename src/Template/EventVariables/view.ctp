<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVariable $eventVariable
 */
?>

        
    
<!-- <div class="eventVariables view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($eventVariable->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Event') ?></th>
                        <td><?= $eventVariable->has('event') ? $this->Html->link($eventVariable->event->name, ['controller' => 'Events', 'action' => 'view', $eventVariable->event->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($eventVariable->name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td><?= h($eventVariable->description) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Variable Key') ?></th>
                        <td><?= h($eventVariable->variable_key) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($eventVariable->id) ?></td>
                    </tr>
                                                                                                </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->