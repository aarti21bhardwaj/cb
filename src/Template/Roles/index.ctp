<div class="row">
    <div class="col-lg-12">

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Roles') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('label') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($roles as $role): ?>
                        <tr>
                            <td><?= $this->Number->format($role->id) ?></td>
                            <td><?= h($role->name) ?></td>
                            <td><?= h($role->label) ?></td>
                            <td class="actions">
                                <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $role->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <?= '<a href='.$this->Url->build(['action' => 'edit', $role->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete # {0}?', $role->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->
