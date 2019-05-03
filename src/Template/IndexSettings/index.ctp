<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndexSetting[]|\Cake\Collection\CollectionInterface $indexSettings
 */
?>


<div class="row">
    <div class="col-lg-12"> 
        <!--<div class="indexSettings index large-9 medium-8 columns content">-->

            <div class="ibox float-e-margins">
                <div class = 'ibox-title'>
                    <h3><?= __('Index Settings') ?></h3>
                    <?php if($addButtonDisable == false){  ?>
                    <div class="text-right">
                        <?=$this->Html->link('Add Index Setting', ['controller' => 'IndexSettings', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                    </div>
                <?php } ?>
                </div>
                <div class = "ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <!-- <th scope="col">Role Name</th> -->
                                <th scope="col">Index Name</th>
                                <th scope="col">Visible Columns</th>

                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($indexSettings as $indexSetting): ?>
                                <tr>
                                  <!--   -->
                                  <?php     
                                        if($indexSetting->index_name == 'Students'){
                                            $indexSetting->meta = array_diff($studentMeta, $indexSetting->meta);
                                        }else{
                                            $indexSetting->meta = array_diff($courseMeta, $indexSetting->meta);
                                        }     
                                        $indexSetting->meta = array_values($indexSetting->meta);



                                  ?>
                                  <td><?= $indexSetting->index_name ?></td>
                                  <td>  
                                        <?php foreach ($indexSetting->meta as $key => $value) {
                                            # code...
                                            if($key < sizeof($indexSetting->meta) - 1){
                                                echo $value.", ";
                                            }else{
                                                echo $value.". ";
                                            }
                                        } ?>
                                  </td>
                                   <td class="actions">
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $indexSetting->id]);
                                        ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $indexSetting->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $indexSetting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $indexSetting->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
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
