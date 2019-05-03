,'tinymceTextarea'<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
                <div class="keyCategories form large-9 medium-8 columns content">
                    <?= $this->Form->create($keyCategory) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Key Category') ?></legend>
                        </div>
                        <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                        <!-- <div class="form-group text required">
                            <label class="col-sm-2 control-label" for="duration"></label>
                            <div class="col-sm-10">
                                <?= $this->Form->control('tenant_id', ['value' =>$loggedInUser['id'],'type'=>'hidden', 'id' => 'tenantId']); ?>
                            </div>
                        </div> -->
                        <?php } else {?>
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Tenant'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-10">
                               <?= $this->Form->control('tenant_id', ['label' => false, 'required' => true, 'id' => 'tenantId', 'class' => ['form-control']]); ?>
                            </div>
                        </div>
                    <?php } ?>
                        <?php
                            // echo $this->Form->control('tenant_id', ['options' => $tenants]);
                            echo $this->Form->control('name',['label' => ['text'=> 'Category Name']]);
                         ?>
                          <div class="form-group">
                                <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                <div class="col-sm-10">
                                    <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea'],]); ?>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary']]) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->