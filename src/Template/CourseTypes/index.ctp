<div class="row">
    <div class="col-lg-12">
    <!--<div class="courseTypes index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Course Types') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Course Type', ['controller' => 'CourseTypes', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                                                    <th scope="col"><?= $this->Paginator->sort('Course Code') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('agency_id') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('Course Name') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('Certification Length') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courseTypes as $courseType): ?>
                        <tr>
                         <td><?= h($courseType->course_code); ?></td>
                         
                         <td><?= $courseType->agency->name ?></td>
                         <td><?= h($courseType->name) ?></td>
                         <td><?= h($courseType->valid_for) ?></td>
                         <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $courseType->id]);
                                    ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $courseType->id]).' class="btn btn-xs btn-warning"">' ?>
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $courseType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseType->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                        </td>
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
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->