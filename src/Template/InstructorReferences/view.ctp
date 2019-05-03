<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorReference $instructorReference
 */
?>

        
    
<!-- <div class="instructorReferences view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($instructorReference->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Instructor') ?></th>
                        <td><?= $instructorReference->has('instructor') ? $this->Html->link($instructorReference->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorReference->instructor->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($instructorReference->name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($instructorReference->email) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Phone Number') ?></th>
                        <td><?= h($instructorReference->phone_number) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($instructorReference->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($instructorReference->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($instructorReference->modified) ?></td>
                    </tr>
                                                                            </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->