<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseDocument $courseDocument
 */
?>
<?php

$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
        
    
<!-- <div class="courseDocuments view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($courseDocument->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Course') ?></th>
                        <td><?= $courseDocument->has('course') ? $this->Html->link($courseDocument->course->id, ['controller' => 'Courses', 'action' => 'view', $courseDocument->course->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Name') ?></th>
                        <td><?= h($courseDocument->document_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Path') ?></th>
                        <td><?= h($courseDocument->document_path) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($courseDocument->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($courseDocument->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($courseDocument->modified) ?></td>
                    </tr>
                                                                            </table>
                                                <div class="row">
                    <div class="col-sm-2">
                        <h4><?= __('Description') ?></h4>
                    </div>
                    <div class="col-sm-10">
                        <?= $this->Text->autoParagraph(h($courseDocument->description)); ?>
                    </div>
                   
                </div>
                                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->