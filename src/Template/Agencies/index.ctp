<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Agency[]|\Cake\Collection\CollectionInterface $agencies
 */
?>

        
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Agencies') ?></h3>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >

                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agencies as $agency): ?>
                        <tr>
                            <td><?= $this->Number->format($agency->id) ?></td>
                            <th scope="col"><?= h($agency->name) ?></th>
                            <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $agency->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $agency->id]).' class="btn btn-xs btn-warning"">' ?>
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $agency->id], ['confirm' => __('Are you sure you want to delete # {0}?', $agency->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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