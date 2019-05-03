<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorApplication[]|\Cake\Collection\CollectionInterface $instructorApplications
 */
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>



<div class="row">
    <div class="col-lg-12">
        <!--<div class="instructorApplications index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Instructor Applications') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                           <!--  <th scope="col"><?= $this->Paginator->sort('instructor_id') ?></th> -->
                            <th scope="col">Uploaded File</th>
                            <!-- <th scope="col"><?= $this->Paginator->sort('document_path') ?></th> -->
                           <!--  <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($instructorApplications as $key=>  $instructorApplication): ?>
                            <tr>
                                <td><?= $key +1 ?></td>
<!--                               <td><?= $this->Number->format($instructorApplication->id) ?></td>
 -->                              <!-- <td><?= $instructorApplication->has('instructor') ? $this->Html->link($instructorApplication->instructor->id, ['controller' => 'Instructors', 'action' => 'view', $instructorApplication->instructor->id]) : '' ?></td> -->
                              <!-- <td><?= h($instructorApplication->document_name) ?></td>
                              <td><?= h($instructorApplication->document_path) ?></td> -->
                              <td><a href="<?= h($instructorApplication->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View</a></td>
                            <!--   <td><?= h($instructorApplication->created) ?></td>
                              <td><?= h($instructorApplication->modified) ?></td> -->
                              <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $instructorApplication->id]);
                                    ?>
                                        <!-- <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a> -->
                                     <?= '<a href='.$this->Url->build(['action' => 'edit', $instructorApplication->id,$instructor_id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $instructorApplication->id,$instructor_id], ['confirm' => __('Are you sure you want to delete # {0}?', $instructorApplication->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) 
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
        </div> -->
        <!-- </div> -->
    </div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
