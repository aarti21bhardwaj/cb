<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Key Categories') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Key Inventory', ['controller' => 'keyInventories', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
<div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables" >
                <thead>
                    <tr>
                        <th scope="col"><?= $this->Paginator->sort('Key name') ?></th>
                        <th scope="col"><?= $this->Paginator->sort('key_category_id') ?></th>

                        <!-- <th scope="col"><?= $this->Paginator->sort('status') ?></th> -->
                        <th scope="col" class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keyInventories as $keyInventory): ?>
                        <tr>
                            <td><?= $keyInventory->name ?></td>
                            <td><?= $keyInventory->key_category->name ?></td>
                            <!-- <td><i> Available </i></td> -->
                            <td class="actions">

                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $keyInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $keyInventory->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- </div> -->
    </div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
</div>
<style type="text/css">
table.dataTables thead .sorting, 
table.dataTables thead .sorting_asc, 
table.dataTables thead .sorting_desc {
    background : none;
}
</style>