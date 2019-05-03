<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Qualification $qualification
 */
?>

        
    
<!-- <div class="qualifications view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($qualification->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($qualification->name) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($qualification->id) ?></td>
                    </tr>
                                                                                                                        <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $qualification->status ? __('Yes') : __('No'); ?></td>
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
        <h4><?= __('Related Course Type Qualifications') ?></h4>
        </div>
        <?php if (!empty($qualification->course_type_qualifications)): ?>
        <div class="ibox-content">
        <table class="table" cellpadding="0" cellspacing="0">
            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Course Type Id') ?></th>
                                <th scope="col"><?= __('Qualification Id') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($qualification->course_type_qualifications as $courseTypeQualifications): ?>
            <tr>
                                <td><?= h($courseTypeQualifications->id) ?></td>
                                <td><?= h($courseTypeQualifications->course_type_id) ?></td>
                                <td><?= h($courseTypeQualifications->qualification_id) ?></td>
                                                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'CourseTypeQualifications', 'action' => 'view', $courseTypeQualifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'CourseTypeQualifications', 'action' => 'edit', $courseTypeQualifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'CourseTypeQualifications', 'action' => 'delete', $courseTypeQualifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseTypeQualifications->id)]) ?>
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