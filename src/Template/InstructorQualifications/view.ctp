<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorQualification $instructorQualification
 */
?>

        
        
        
    
<!-- <div class="instructorQualifications view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($instructorQualification->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Instructor') ?></th>
                        <td><?= $instructorQualification->has('instructor') ? $this->Html->link($instructorQualification->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorQualification->instructor->id]) : '' ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Qualification') ?></th>
                        <td><?= $instructorQualification->has('qualification') ? $this->Html->link($instructorQualification->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $instructorQualification->qualification->id]) : '' ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Qualification Type') ?></th>
                        <td><?= $instructorQualification->has('qualification_type') ? $this->Html->link($instructorQualification->qualification_type->name, ['controller' => 'QualificationTypes', 'action' => 'view', $instructorQualification->qualification_type->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('License Number') ?></th>
                        <td><?= h($instructorQualification->license_number) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Name') ?></th>
                        <td><?= h($instructorQualification->document_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Path') ?></th>
                        <td><?= h($instructorQualification->document_path) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($instructorQualification->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Expiry Date') ?></th>
                        <td><?= h($instructorQualification->expiry_date) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Last Monitored') ?></th>
                        <td><?= h($instructorQualification->last_monitored) ?></td>
                    </tr>
                                                                            </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->