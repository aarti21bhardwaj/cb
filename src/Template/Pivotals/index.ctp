
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Pivotals') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('key_category_id') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pivotals as $pivotal): ?>
                            <tr>
                                <td><?= $this->Number->format($pivotal->id) ?></td>
                                <td><?= $pivotal->has('key_category') ? $this->Html->link($pivotal->key_category->name, ['controller' => 'KeyCategories', 'action' => 'view', $pivotal->key_category->name]) : '' ?></td>
                                <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $pivotal->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $pivotal->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $pivotal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pivotal->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                    </td>
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

