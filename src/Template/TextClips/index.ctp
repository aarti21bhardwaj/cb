<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Text Clips') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Text Clip', ['controller' => 'TextClips', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('tenant_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
<!--                             <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($textClips as $textClip): ?>
                            <tr>
                                <td><?= $this->Number->format($textClip->id) ?></td>
                                <td><?= $textClip->has('tenant') ? $this->Html->link($textClip->tenant->center_name, ['controller' => 'Tenants', 'action' => 'view', $textClip->tenant->id]) : '' ?></td>
                                <td><?= h($textClip->name) ?></td>
                                <td class=""><?= $textClip->status?'Active':'Inactive' ?></td>
<!--                                 <td><?= h($textClip->created) ?></td>
                                <td><?= h($textClip->modified) ?></td> -->
                                <td class="actions">
                                    <?php 
                                    $viewUrl = $this->Url->build(["action" => "view", $textClip->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $textClip->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $textClip->id], ['confirm' => __('Are you sure you want to delete # {0}?', $textClip->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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