<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingSiteNote $trainingSiteNote
 */
?>
<div class="row">
    <div class="col-lg-12">
        <!-- <div class="ibox float-e-margins"> -->
            <!-- <div class="ibox-content"> -->
                
                <div class="trainingSiteNotes form large-9 medium-8 columns content">
                    <?= $this->Form->create($trainingSiteNote) ?>
                    <fieldset>
                        <!-- <div class = 'ibox-title'> -->
                        <div style="padding-left: 15px;">
                            <legend><?= __('Edit Note For ')?><?php echo $trainingSites->name;  ?></legend>
                        </div>
                        <!-- </div> -->
                        <?php if(!$training_site_id){

                            echo $this->Form->control('training_site_id', ['options' => $trainingSites]);
                        }
            // echo $this->Form->control('description');
                        ?>

                        <div class="form-group">
                            <?= $this->Form->label('description', __(' '), ['class' => ['col-sm-2 ', 'control-label']]) ?>
                            
                            <div class = "col-sm-10"></div>
                            <div class="row">    
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10" align="center" style="padding-left: 60px;">
                                    <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view']]); ?>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="col-sm-offset-3">
                    <?= $this->Form->button(__('Submit')) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            <!-- </div> -->
        <!-- </div> -->
    </div>
</div>
