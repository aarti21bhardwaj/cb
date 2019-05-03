<div class="row">
    <div class="col-lg-12">
    <!--<div class="keyCategories index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Key Categories') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Key Category', ['controller' => 'KeyCategories', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                    <thead>
                        <tr>
                                                    <th scope="col"><?= $this->Paginator->sort('Category name') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('description') ?></th>
                                                    <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($keyCategories as $keyCategory): ?>
                        <tr>
                        <td><?= h($keyCategory->name) ?></td>
                        <td><?=     $keyCategory->description ?></td>

                        <td>
                                <?php 
                                    if($keyCategory->status == 1){ 
                                        echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $keyCategory->id,$keyCategory->status]);
                                    }else{
                                        echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $keyCategory->id,0]);
                                    }
                                ?>
                        </td>
                        <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $keyCategory->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $keyCategory->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $keyCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $keyCategory->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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