<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
                <div class="trainingSites form large-9 medium-8 columns content">
                    <?= $this->Form->create($trainingSite) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Add Training Site') ?></legend>
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
                            echo $this->Form->control('training_site_code',['label' => ['text'=>'Training Site ID']]);

                            echo $this->Form->control('name', ['required', 'type'=>'text','label' => ['text'=>'Site Name']]);
                            echo $this->Form->control('phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);

                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <?php

                            echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                            echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"5-5"]);
                            echo $this->Form->control('contact_name',['required', 'type'=>'text']);

                            echo $this->Form->control('contact_email',['required', 'type' => 'text','data-validation'=> "email"]);
                            echo $this->Form->control('contact_phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                            
                        ?>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    
                    <?= $this->Form->end() ?>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
       $.validate();
       $.validate({
  modules : 'location',
  onModulesLoaded : function() {
    $('input[name="state"]').suggestState();
  }
});
   });
</script>