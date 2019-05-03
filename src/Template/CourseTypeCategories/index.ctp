<div class="row">
    <div class="col-lg-12">
        <!--<div class="courseTypeCategories index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Course Type Categories') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Course Type Category', ['controller' => 'CourseTypeCategories', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('Category Name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Description') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Status') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courseTypeCategories as $key => $courseTypeCategory): ?>
                                <tr>
                                    <td><?= h($courseTypeCategory->name) ?></td>
                                    <td><?= $courseTypeCategory->description ?></td>
                                    <td>
                                        <?php 
                                            if($courseTypeCategory->status == 1){ 
                                                echo  $this->Form->postLink(__('Active'), ['action' => 'updateStatus', $courseTypeCategory->id,$courseTypeCategory->status]);
                                            }else{
                                                echo  $this->Form->postLink(__('Inactive'), ['action' => 'updateStatus', $courseTypeCategory->id,0]);
                                            }
                                        ?>
                                    </td>
                                <td class="actions">
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $courseTypeCategory->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">    <i class="fa fa-eye fa-fw"></i>
                                    </a>
                                    <?= '<a href='.$this->Url->build(['action' => 'edit', $courseTypeCategory->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <?= $this->Form->postLink(__(''), ['action' => 'delete', $courseTypeCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $courseTypeCategory->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                            </td>
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

