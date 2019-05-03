<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QualificationType $qualificationType
 */
?>

        
        
    
<!-- <div class="qualificationTypes view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($qualificationType->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($qualificationType->name) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Qualification') ?></th>
                        <td><?= $qualificationType->has('qualification') ? $this->Html->link($qualificationType->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $qualificationType->qualification->id]) : '' ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($qualificationType->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($qualificationType->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($qualificationType->modified) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $qualificationType->status ? __('Yes') : __('No'); ?></td>
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
        <h4><?= __('Related Instructor Qualifications') ?></h4>
        </div>
        <?php if (!empty($qualificationType->instructor_qualifications)): ?>
        <div class="ibox-content">
        <table class="table" cellpadding="0" cellspacing="0">
            <tr>
                                <th scope="col"><?= __('Id') ?></th>
                                <th scope="col"><?= __('Instructor Id') ?></th>
                                <th scope="col"><?= __('Qualification Id') ?></th>
                                <th scope="col"><?= __('Qualification Type Id') ?></th>
                                <th scope="col"><?= __('Expiry Date') ?></th>
                                <th scope="col"><?= __('Last Monitored') ?></th>
                                <th scope="col"><?= __('License Number') ?></th>
                                <th scope="col"><?= __('Document Name') ?></th>
                                <th scope="col"><?= __('Document Path') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($qualificationType->instructor_qualifications as $instructorQualifications): ?>
            <tr>
                                <td><?= h($instructorQualifications->id) ?></td>
                                <td><?= h($instructorQualifications->instructor_id) ?></td>
                                <td><?= h($instructorQualifications->qualification_id) ?></td>
                                <td><?= h($instructorQualifications->qualification_type_id) ?></td>
                                <td><?= h($instructorQualifications->expiry_date) ?></td>
                                <td><?= h($instructorQualifications->last_monitored) ?></td>
                                <td><?= h($instructorQualifications->license_number) ?></td>
                                <td><?= h($instructorQualifications->document_name) ?></td>
                                <td><?= h($instructorQualifications->document_path) ?></td>
                                                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'InstructorQualifications', 'action' => 'view', $instructorQualifications->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'InstructorQualifications', 'action' => 'edit', $instructorQualifications->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'InstructorQualifications', 'action' => 'delete', $instructorQualifications->id], ['confirm' => __('Are you sure you want to delete # {0}?', $instructorQualifications->id)]) ?>
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