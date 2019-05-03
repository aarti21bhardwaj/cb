<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorQualification[]|\Cake\Collection\CollectionInterface $instructorQualifications
 */

use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
?>





<div class="row">
    <div class="col-lg-12">
        <!--<div class="instructorQualifications index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Instructor Qualifications') ?></h3>
                <div class="text-right">
                <?php if(isset($instructor_id) && $instructor_id){?>
                <?=$this->Html->link('Add Qualification', ['controller' => 'InstructorQualifications', 'action' => 'add',$instructor_id],['class' => ['btn', 'btn-success']])?>
                <?php }else{?>
                <?=$this->Html->link('Add Qualification', ['controller' => 'InstructorQualifications', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                <?php }?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                             <th scope="col">Id</th>
                            <th scope="col">Qualification Type Id</th>
                            <th scope="col">License Number</th>
                            <th scope="col">Expiry Date</th>
                            <th scope="col">Last Monitored</th>
                            <th scope="col">File Uploaded</th>
<!--                             <th scope="col"><?= $this->Paginator->sort('document_path') ?></th>
 -->                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // pr($instructor_id);die();
                        foreach ($instructorQualifications as $key=> $instructorQualification): ?>
                            <tr>
                            <td><?= $key +1 ?></td>
                           <!--   <td><?= $this->Number->format($instructorQualification->id) ?></td>
                             <td><?= $instructorQualification->has('instructor') ? $this->Html->link($instructorQualification->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorQualification->instructor->id]) : '' ?></td>
                             <td><?= $instructorQualification->has('qualification') ? $this->Html->link($instructorQualification->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $instructorQualification->qualification->id]) : '' ?></td> -->
                             <td><?= h($instructorQualification['qualification']->name) ?></td>
                             <td><?= h($instructorQualification->license_number) ?></td>
                             <td><?= $instructorQualification->expiry_date->format('m/d/Y'); ?></td>
                             <td><?= $instructorQualification->last_monitored->format('m/d/Y'); ?></td>
                             <td>
                             <a href="<?= h($instructorQualification->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View</a></td>
                        <!--      <td></td> -->
                             <td class="actions">
                                    <!-- <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $instructorQualification->id]);
                                    ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a> -->
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $instructorQualification->id,$instructor_id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $instructorQualification->id, $instructor_id], ['confirm' => __('Are you sure you want to delete # {0}?', $instructorQualification->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- </div> -->
    </div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
