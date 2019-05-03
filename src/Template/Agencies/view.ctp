<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agency $agency
 */
?>



<!-- <div class="agencies view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($agency->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($agency->name) ?></td>
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
                <h4><?= __('Related Course Types') ?></h4>
            </div>
            <?php if (!empty($agency->course_types)): ?>
                <div class="ibox-content">
                    <table class="table" cellpadding="0" cellspacing="0">
                        <tr>
                            <th scope="col"><?= __('Id') ?></th>
                            <th scope="col"><?= __('Course Code') ?></th>
                            <th scope="col"><?= __('Course Type Category Id') ?></th>
                            <th scope="col"><?= __('Agency Id') ?></th>
                            <th scope="col"><?= __('Name') ?></th>
                            <th scope="col"><?= __('Valid For') ?></th>
                            <th scope="col"><?= __('Description') ?></th>
                            <th scope="col"><?= __('Class Detail') ?></th>
                            <th scope="col"><?= __('Notes To Instructor') ?></th>
                            <th scope="col"><?= __('Color Code') ?></th>
                            <th scope="col"><?= __('Status') ?></th>
                            <th scope="col"><?= __('Created') ?></th>
                            <th scope="col"><?= __('Modified') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($agency->course_types as $courseTypes): ?>
                            <tr>
                                <td><?= h($courseTypes->id) ?></td>
                                <td><?= h($courseTypes->course_code) ?></td>
                                <td><?= h($courseTypes->course_type_category_id) ?></td>
                                <td><?= h($courseTypes->agency_id) ?></td>
                                <td><?= h($courseTypes->name) ?></td>
                                <td><?= h($courseTypes->valid_for) ?></td>
                                <td><?= $courseTypes->description ?></td>
                                <td><?= h($courseTypes->class_detail) ?></td>
                                <td><?= h($courseTypes->notes_to_instructor) ?></td>
                                <td><?= h($courseTypes->color_code) ?></td>
                                <td><?= h($courseTypes->status) ?></td>
                                <td><?= h($courseTypes->created) ?></td>
                                <td><?= h($courseTypes->modified) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('View'), ['controller' => 'CourseTypes', 'action' => 'view', $courseTypes->id]) ?>
                                    <?= $this->Html->link(__('Edit'), ['controller' => 'CourseTypes', 'action' => 'edit', $courseTypes->id]) ?>
                                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CourseTypes', 'action' => 'delete', $courseTypes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseTypes->id)]) ?>
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