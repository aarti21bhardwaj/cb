<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Promo Codes') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Promo Code', ['controller' => 'PromoCodes', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
               <div class="table-responsive">
                   <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('code') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('start_date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('end_date') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('discount_type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('discount') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('no_of_uses') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promoCodes as $promoCode): ?>
                            <tr>
                                <td><?= $this->Number->format($promoCode->id) ?></td>
                                <td><?= h($promoCode->code) ?></td>
                                <td><?= h($promoCode->start_date) ?></td>
                                <td><?= h($promoCode->end_date) ?></td>
                                <td><?= h($promoCode->discount_type ? 'Percentage Off' : 'Dollars Off')?></td>
                                <td><?= $this->Number->format($promoCode->discount) ?></td>
                                <td><?= $this->Number->format($promoCode->no_of_uses) ?></td>
                                <!-- <td><?= h($promoCode->status) ?></td> -->
                                 <td>
                                    <?php 
                                        if($promoCode->status == 1){ 
                                            echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $promoCode->id,$promoCode->status]);
                                        }else{
                                            echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $promoCode->id,0]);
                                        }
                                    ?>
                                </td>
                                <td class="actions">
                                    <?php 
                                    $viewUrl = $this->Url->build(["action" => "view", $promoCode->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $promoCode->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $promoCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promoCode->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                    <!-- <?= $this->Html->link(__('View'), ['action' => 'view', $promoCode->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $promoCode->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $promoCode->id], ['confirm' => __('Are you sure you want to delete # {0}?', $promoCode->id)]) ?> -->
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>
</div>
</div>
