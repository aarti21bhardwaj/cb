<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorInsuranceForm[]|\Cake\Collection\CollectionInterface $instructorInsuranceForms
 */
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>

        
    
<div class="row">
    <div class="col-lg-12">
    <!--<div class="instructorInsuranceForms index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <!-- <div class = 'ibox-title'> -->
                <h3><?= __('Instructor Insurance Forms') ?></h3>
            <!-- </div> -->
            <div class = "ibox-content">
                 <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                                                    <th scope="col">Id</th>
                                                    <!-- <th scope="col"><?= $this->Paginator->sort('instructor_id') ?></th> -->
                                                   <!--  <th scope="col"><?= $this->Paginator->sort('document_name') ?></th> -->
                                                    <th scope="col">Uploaded Document</th>
                                                    <th scope="col">Date</th>
                                                   <!--  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instructorInsuranceForms as $key=>$instructorInsuranceForm): ?>
                        <tr>
                            <td><?= $key +1 ?></td>
                            <td><a href="<?= h($instructorInsuranceForm->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View</a></td>
                            <!-- <td><?= $instructorInsuranceForm->has('instructor') ? $this->Html->link($instructorInsuranceForm->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorInsuranceForm->instructor->id]) : '' ?></td> -->
<!--                             <td><?= h($instructorInsuranceForm->document_name) ?></td>
                            <td><?= h($instructorInsuranceForm->document_path) ?></td> -->
                            <td><?=  $instructorInsuranceForm->date->format('m/d/Y') ?></td>
<!--                             <td><?= h($instructorInsuranceForm->created) ?></td>
                            <td><?= h($instructorInsuranceForm->modified) ?></td> -->
                             <td class="actions">
                                       <!--  <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $instructorInsuranceForm->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">    <i class="fa fa-eye fa-fw"></i>
                                    </a> -->
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $instructorInsuranceForm->id,$instructor_id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $instructorInsuranceForm->id, $instructor_id], ['confirm' => __('Are you sure you want to delete # {0}?', $instructorInsuranceForm->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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
