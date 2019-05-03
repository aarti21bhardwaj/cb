<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseType $courseType
 */
?>





<!-- <div class="courseTypes view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Course ID') ?></th>
                        <td><?= h($courseType->course_code) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Type Category') ?></th>
                        <td><?=$courseType->course_type_category? $courseType->course_type_category->name : ""; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Name') ?></th>
                        <td><?= h($courseType->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Valid For') ?></th>
                        <td><?= h($courseType->valid_for) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Color Code') ?></th>
                        <td><i style="color: <?= $courseType->color_code ?>" class="fa fa-circle" aria-hidden="true"></i></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td><?= $courseType->description ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Class Details') ?></th>
                        <td><?= $courseType->class_detail ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Notes to Instructor') ?></th>
                        <td><?= $courseType->notes_to_instructor ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Agency') ?></th>
<!--                         <td><?= $this->Number->format($courseType->agency_id) ?></td>
 -->                    <td><?= $courseType->agency->name ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $courseType->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
                </table>
                

                
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
