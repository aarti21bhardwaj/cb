<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b" {{attrs}}>{{text}}</button>',
'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];
$this->Form->setTemplates($salonTemplate);
$this->viewBuilder()->setLayout(false);

// $this->viewBuilder()->enableAutoLayout(false);
?>



<div class="row">
    <div class="col-lg-12">
        <!--<div class="trainingSiteNotes index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Notes ') ?></h3>
                <div class="text-right">
                    <?php if(isset($training_site_id) && $training_site_id){?>
                    <?=$this->Html->link('Add Note', ['controller' => 'TrainingSiteNotes', 'action' => 'add',$training_site_id],['class' => ['btn', 'btn-success']])?>
                    <?php }else{?>
                    
                    <?=$this->Html->link('Add Note', ['controller' => 'TrainingSiteNotes', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                    <?php }?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('S no.') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Notes') ?></th>
                                
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trainingSiteNotes as $key=>$trainingSiteNote): ?>
                                <tr>
                                    <td><?=$key+1 ?></td>
                                    
                                    <td><?= $trainingSiteNote->description ?></td>

                                    <td class="actions" >
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $trainingSiteNote->id]);
                                        ?>
                                        <div style="display:inline">

                                            <?= '<a href='.$this->Url->build(['action' => 'edit', $trainingSiteNote->id,$training_site_id]).' class="btn btn-xs btn-warning"">' ?>
                                            <i class="fa fa-pencil fa-fw"></i>
                                        </a>
                                        

                                        <?= $this->Form->postLink(__(''), ['action' => 'delete', $trainingSiteNote->id,$training_site_id], ['confirm' => __('Are you sure you want to delete # {0}?', [$trainingSiteNote->id,$training_site_id]), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                    </div>
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
