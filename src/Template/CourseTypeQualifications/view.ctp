<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\CourseTypeQualification $courseTypeQualification
*/
?>




<!-- <div class="courseTypeQualifications view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= h($courseTypeQualification->id) ?></h3>
                </div> <!-- ibox-title end-->
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Course Type') ?></th>
                            <td><?= $courseTypeQualification->has('course_type') ? $this->Html->link($courseTypeQualification->course_type->name, ['controller' => 'CourseTypes', 'action' => 'view', $courseTypeQualification->course_type->id]) : '' ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Qualification') ?></th>
                            <td><?= $courseTypeQualification->has('qualification') ? $this->Html->link($courseTypeQualification->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $courseTypeQualification->qualification->id]) : '' ?></td>
                        </tr>
                    </table>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
<!-- </div>
 -->