<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\DisplayType $displayType
*/
?>



<!-- <div class="displayTypes view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= h($displayType->name) ?></h3>
                </div> <!-- ibox-title end-->
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Name') ?></th>
                            <td><?= h($displayType->name) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Status') ?></th>
                            <td><?= $displayType->status ? __('Yes') : __('No'); ?></td>
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
                    <h4><?= __('Related Course Display Types') ?></h4>
                </div>
                <?php if (!empty($displayType->course_display_types)): ?>
                <div class="ibox-content">
                    <table class="table" cellpadding="0" cellspacing="0">
                        <tr>
                            <th scope="col"><?= __('Id') ?></th>
                            <th scope="col"><?= __('Course Id') ?></th>
                            <th scope="col"><?= __('Display Type Id') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($displayType->course_display_types as $courseDisplayTypes): ?>
                        <tr>
                            <td><?= h($courseDisplayTypes->id) ?></td>
                            <td><?= h($courseDisplayTypes->course_id) ?></td>
                            <td><?= h($courseDisplayTypes->display_type_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CourseDisplayTypes', 'action' => 'view', $courseDisplayTypes->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CourseDisplayTypes', 'action' => 'edit', $courseDisplayTypes->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'CourseDisplayTypes', 'action' => 'delete', $courseDisplayTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseDisplayTypes->id)]) ?>
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