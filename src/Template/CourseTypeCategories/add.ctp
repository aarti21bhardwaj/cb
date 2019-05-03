<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
// pr($this->request->referer());die;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				




    
<div class="courseTypeCategories form large-9 medium-8 columns content">
    <?= $this->Form->create($courseTypeCategory) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Course Type Category') ?></legend>
    </div>
        
        <?php echo $this->Form->control('name',['label' => ['text'=> 'Course Type Category']]); ?>                   
        <div class="form-group">
                <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                </div>
        </div>
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
        <?php echo $this->Form->control('status',['label' => 'Status']); ?> 
        </div>
        <!-- <div class="col-sm-3">
                          <?php $option_status = ['1' => 'Active', '0' => 'Inactive'];
                                echo $this->Form->select('option_status', $option_status, ['empty' => '--Status--']);?>
                          </div> -->

    </fieldset>
    <?= $this->Form->button(__('Submit')) ?> 
                    <?php
                    if(preg_match("/courses/",$this->request->referer())){
                    } elseif(preg_match("/thank-you/",$this->request->referer())){
                    } else { ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?php } ?>
                    <?= $this->Form->end() ?>
</div>
			</div>
		</div>
	</div>
</div>