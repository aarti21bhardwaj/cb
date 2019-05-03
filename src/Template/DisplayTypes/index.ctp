<div class="row">
    <div class="col-lg-12">
        <!--<div class="displayTypes index large-9 medium-8 columns content">-->

            <div class="ibox float-e-margins">
                <div class = 'ibox-title'>
                    <h3><?= __('Display Types') ?></h3>
                </div>
                <div class = "ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($displayTypes as $displayType): ?>
                            <tr>
                                <td><?= $this->Number->format($displayType->id) ?></td>
                                <td><?= h($displayType->name) ?></td>
                                <td><?= $displayType->status?'<span class=" fa fa-check-square fa-2x"></span>':'<span class=" fa fa-times-circle fa-2x"    ">    </span>'?></td>

                                <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $displayType->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $displayType->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $displayType->id], ['confirm' => __('Are you sure you want to delete # {0}?', $displayType->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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