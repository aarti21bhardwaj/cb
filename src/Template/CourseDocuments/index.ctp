<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseDocument[]|\Cake\Collection\CollectionInterface $courseDocuments
 */
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>



<div class="row">
    <div class="col-lg-12">
        <!--<div class="courseDocuments index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Course Documents') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Upload Documents', ['controller' => 'courseDocuments', 'action' => 'add',$course_id],['class' => ['btn', 'btn-success']])?>
                </div>
            
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Description') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('View Upload') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courseDocuments as $key=> $courseDocument): ?>
                            <tr>
                              <td><?= $key + 1 ?></td>
                              <td><?=   $this->Text->autoParagraph($courseDocument->description)   ?></td>
                              <td><a href="<?= h($courseDocument->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View Upload</a></td>
                              <td class="actions">
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $courseDocument->id,$course_id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseDocument->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                    </td>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </div>
        <!-- </div> -->
    </div><!-- .ibox  end -->
    </div>
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
