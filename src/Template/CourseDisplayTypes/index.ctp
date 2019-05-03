<div class="row">
    <div class="col-lg-12">
        <!--<div class="courseDisplayTypes index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Course Display Types') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('course_id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('display_type_id') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courseDisplayTypes as $courseDisplayType): ?>
                                <tr>
                                    <td><?= $this->Number->format($courseDisplayType->id) ?></td>
                                    <td><?= $courseDisplayType->course->course_type->name ?></td>
                                    <td><?= $courseDisplayType->has('display_type') ? $this->Html->link($courseDisplayType->display_type->name, ['controller' => 'DisplayTypes', 'action' => 'view', $courseDisplayType->display_type->id]) : '' ?></td>
                                    <td class="actions">
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $courseDisplayType->id]);
                                        ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $courseDisplayType->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $courseDisplayType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseDisplayType->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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