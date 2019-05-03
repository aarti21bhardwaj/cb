<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorApplication $instructorApplication
 */
?>

        
    
<!-- <div class="instructorApplications view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($instructorApplication->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Instructor') ?></th>
                        <td><?= $instructorApplication->has('instructor') ? $this->Html->link($instructorApplication->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorApplication->instructor->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Name') ?></th>
                        <td><?= h($instructorApplication->document_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Path') ?></th>
                        <td><?= h($instructorApplication->document_path) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($instructorApplication->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($instructorApplication->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($instructorApplication->modified) ?></td>
                    </tr>
                                                                            </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->