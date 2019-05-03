<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorInsuranceForm $instructorInsuranceForm
 */
?>

        
    
<!-- <div class="instructorInsuranceForms view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($instructorInsuranceForm->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Instructor') ?></th>
                        <td><?= $instructorInsuranceForm->has('instructor') ? $this->Html->link($instructorInsuranceForm->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorInsuranceForm->instructor->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Name') ?></th>
                        <td><?= h($instructorInsuranceForm->document_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Path') ?></th>
                        <td><?= h($instructorInsuranceForm->document_path) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($instructorInsuranceForm->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Date') ?></th>
                        <td><?= h($instructorInsuranceForm->date) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($instructorInsuranceForm->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($instructorInsuranceForm->modified) ?></td>
                    </tr>
                                                                            </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->