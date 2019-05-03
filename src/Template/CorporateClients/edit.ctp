
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
                <div class="corporateClients form large-9 medium-8 columns content">
                    <?= $this->Form->create($corporateClient) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Corporate Client') ?></legend>
                        </div>
                        <?php
                            if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){
                              echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites]);
                            }
                        ?>
                        
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
                        echo $this->Form->control('name',['label' => ['text'=>'Client Name']]);
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
                        // echo $this->Form->control('contact_name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        // echo $this->Form->control('contact_email',['required', 'type' => "text",'data-validation'=> "email"]);
                        // echo $this->Form->control('contact_phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                        
                        ?>
                        <div class="form-group" id="WebPageCheck">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('web_page', ['id' => 'trigger','label' => false]); ?> Web Page
                                </label>
                            </div>
                        </div>
                        <div id="hidden_fields">
                            <?php
                                echo $this->Form->control('url_id',['label' => 'Web Id','type' => 'text','placeholder'=> 'Enter Web Id to activate URL']);
                              if(empty($corporateClient->url_id)){
                                echo $this->Form->control('web_url',['type' => 'text','disabled']);
                              } else {
                                echo $this->Form->control('web_url',['type' => 'text'],['data-placement'=> "top" ,'title'=> "If this course is for a corporate client, choose them here. This allows them to see the course in the corporate portal." ,'data-original-title' =>"Tooltip on top"]);
                              }
                            ?>
                            <div class="form-group">
                                <?= $this->Form->label('corporate_details', __('Corporate Details'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                <div class="col-sm-10">
                                    <?= $this->Form->control('corporate_details', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                                </div>
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
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<script type="text/javascript">
   $(document).ready(function(){
       $.validate();
       $.validate({
  modules : 'location',
  onModulesLoaded : function() {
    $('input[name="state"]').suggestState();
  }
});
       $(function() {
        console.log('on edit page');     
        var checkbox = $("#trigger");           
        var hidden = $("#hidden_fields");
        var populate = $("#populate");
        hidden.hide();                          // Hide the fields.
        if (checkbox.is(':checked')) {
                                                // Show the hidden fields.
            hidden.show();
        } 
          checkbox.change(function() {
            // Check to see if the checkbox is checked.
            // If it is, show the fields and populate the input.
            // If not, hide the fields.
            if (checkbox.is(':checked')) {
              // Show the hidden fields.
              hidden.show();
              // Populate the input.
              populate.val("Dude, this input got populated!");
            } else {
              // Make sure that the hidden fields are indeed
              // hidden.
              hidden.hide();
              
              // You may also want to clear the value of the 
              // hidden fields here. Just in case somebody 
              // shows the fields, enters data to them and then 
              // unticks the checkbox.
              //
              // This would do the job:
              //
              // $("#hidden_field").val("");
            }
          });
});
   });
</script>