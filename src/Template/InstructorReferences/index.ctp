<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorReference[]|\Cake\Collection\CollectionInterface $instructorReferences
 */
?>

        
    
<div class="row">
    <div class="col-lg-12">
    <!--<div class="instructorReferences index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Instructor References') ?></h3>
                <div class="text-right">
                <?php if(isset($instructor_id) && $instructor_id){?>
                <?=$this->Html->link('Add Reference', ['controller' => 'InstructorReferences', 'action' => 'add',$instructor_id],['class' => ['btn', 'btn-success']])?>
                <?php }else{?>
                <?=$this->Html->link('Add Reference', ['controller' => 'InstructorReferences', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                <?php }?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                                                    <th scope="col">Id</th>
                                                   <!--  <th scope="col"><?= $this->Paginator->sort('instructor_id') ?></th> -->
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Phone Number</th>
                                                    <!-- <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instructorReferences as $key => $instructorReference): ?>
                        <tr>
                          <td><?= $key +1 ?></td>
                            <!-- <td><?= $instructorReference->has('instructor') ? $this->Html->link($instructorReference->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorReference->instructor->id]) : '' ?></td> -->
                            <td><?= h($instructorReference->name) ?></td>
                            <td><?= h($instructorReference->email) ?></td>
                            <td><?= h($instructorReference->phone_number) ?></td>
                            <!-- <td><?= h($instructorReference->created) ?></td>
                            <td><?= h($instructorReference->modified) ?></td> -->
                            <td class="actions">
                                    <!-- <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $instructorReference->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a> -->
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $instructorReference->id,$instructor_id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $instructorReference->id, $instructor_id], ['confirm' => __('Are you sure you want to delete # {0}?', $instructorReference->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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
