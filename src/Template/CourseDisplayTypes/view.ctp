<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\CourseDisplayType $courseDisplayType
*/
?>




<!-- <div class="courseDisplayTypes view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= h($courseDisplayType->id) ?></h3>
                </div> <!-- ibox-title end-->
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Course') ?></th>
                            <td><?= $courseDisplayType->has('course') ? $this->Html->link($courseDisplayType->course->id, ['controller' => 'Courses', 'action' => 'view', $courseDisplayType->course->id]) : '' ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Display Type') ?></th>
                            <td><?= $courseDisplayType->has('display_type') ? $this->Html->link($courseDisplayType->display_type->name, ['controller' => 'DisplayTypes', 'action' => 'view', $courseDisplayType->display_type->id]) : '' ?></td>
                        </tr>
                    </table>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
<!-- </div>
 -->