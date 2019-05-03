<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Addons') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Addon', ['controller' => 'Addons', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('product_code') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Product Name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Product Description') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Product Price') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Product Status') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Product Type') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($addons as $addon): ?>
                        <tr>
                        <td><?= h($addon->product_code) ?></td>
                        <td><?= h($addon->name) ?></td>
                        <td><?= $addon->short_description ?></td>
                        <td><?= h($addon->price) ?></td>
                        <td>
                            <?php 
                                if($addon->option_status == 1){ 
                                    echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $addon->id,$addon->option_status]);
                                }else{
                                    echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $addon->id,0]);
                                }
                            ?>
                        </td>
                        <td><?php 
                        if($addon->type == 0){
                            echo 'Shippable';
                        }else if($addon->type == 1){
                            echo 'Non Shippable';
                        }else if($addon->type == 2){
                            echo isset($addon->key_category)?$addon->key_category->name:'-';
                        }
                        ?>
                            
                        </td>
                        <td class="actions">
                            <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $addon->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <?= '<a href='.$this->Url->build(['action' => 'edit', $addon->id]).' class="btn btn-xs btn-warning"">' ?>
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <?= $this->Form->postLink(__(''), ['action' => 'delete', $addon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $addon->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            </td>
                        </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->