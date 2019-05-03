<div class="row">
    <div class="col-lg-12">
        <!--<div class="courseTypeQualifications index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Course Type Qualifications') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('course_type_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('qualification_id') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courseTypeQualifications as $courseTypeQualification): ?>
                                <tr>
                                    <td><?= $this->Number->format($courseTypeQualification->id) ?></td>
                                    <td><?= $courseTypeQualification->has('course_type') ? $this->Html->link($courseTypeQualification->course_type->name, ['controller' => 'CourseTypes', 'action' => 'view', $courseTypeQualification->course_type->id]) : '' ?></td>
                                    <td><?= $courseTypeQualification->has('qualification') ? $this->Html->link($courseTypeQualification->qualification->name, ['controller' => 'Qualifications', 'action' => 'view', $courseTypeQualification->qualification->id]) : '' ?></td>
                                    <td class="actions">
                                        <?php 
                                            $viewUrl = $this->Url->build(["action" => "view", $courseTypeQualification->id]);
                                        ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $courseTypeQualification->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $courseTypeQualification->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseTypeQualification->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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