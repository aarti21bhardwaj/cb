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
              <legend><?= __('Add Corporate Client') ?></legend>
            </div>
            <!-- <?php
                if($loggedInUser['role']->name ==  'tenant' && !isset($loggedInUser['training_site_id'])){
                }
            ?> -->

            <?php if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label != 'TRAINING SITE OWNER'){ ?>

                        <!-- <div class="form-group text required">
                            <label class="col-sm-2 control-label" for="duration"></label>
                            <div class="col-sm-10">
                                <?= $this->Form->control('tenant_id', ['value' =>$loggedInUser['id'],'type'=>'hidden', 'id' => 'tenantId']); ?>

                  <?php echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites]); ?>
                            </div>
                          </div> -->
                          <?= $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites]); ?>
                          <?php } else {?>
                          <div class="form-group">
                            <?= $this->Form->label('name', __('Tenant'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-10">
                             <?= $this->Form->control('tenant_id', ['label' => false, 'required' => true, 'id' => 'tenantId', 'class' => ['form-control']]); ?>
                           </div>
                         </div>
                         <?php } ?>


                        <?php //echo $this->Form->control('tenant_id', ['options' => $tenants]);
                        echo $this->Form->control('name',['label' => ['text'=>'Client Name']]);
                        ?>
                        <div class="form-group">
                          <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                          <div class="col-sm-10">
                            <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                          </div>
                        </div>
                        <?php
                        echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                        echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"5-5","data-validation-error-msg"=> "Please enter 5 digits only"]);
                        
                        ?>
                        <div class="form-group" id="WebPageCheck">
                          <div class="col-sm-10">
                            <label class="col-sm-offset-6">
                              <?= $this->Form->checkbox('web_page', ['id' => 'trigger','label' => false]); ?> Web Page
                            </label>
                          </div>
                        </div>
                        <div id="hidden_fields">
<!--                           <?php 
                          echo $this->Form->control('url_id',['placeholder'=> 'http://url.com','data-validation'=> 'url','type' => 'text']);
                          ?>
 -->
                          <div class="form-group">
                            <?= $this->Form->label('corporate_details', __('Corporate Details'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                              <?= $this->Form->control('corporate_details', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                            </div>
                          </div>

                        </div>
                        <!-- Feilds of Corporate Client users -->
                        <div class="">
                          <legend><?= __('Corporate Client User') ?></legend>
                        </div>
                        <div class="form-group">
                          <?= $this->Form->label('first_name', __('First Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="corporate_client_users[0][first_name]" value="" data-validation="custom" data-validation-regexp="^[A-Za-z.\s_-]+$">
                          </div>
                        </div>

                        <div class="form-group">
                          <?= $this->Form->label('last_name', __('Last Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="corporate_client_users[0][last_name]" value="" data-validation="custom" data-validation-regexp="^[A-Za-z.\s_-]+$">
                          </div>
                        </div>


                        <div class="form-group">
                          <?= $this->Form->label('email', __('Email'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="corporate_client_users[0][email]" value="" data-validation="email">
                          </div>
                        </div>

                        <div class="form-group">
                          <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" name="corporate_client_users[0][password]" value="">
                          </div>
                        </div>

                        <div class="form-group">
                          <?= $this->Form->label('phone', __('Phone'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" name="corporate_client_users[0][phone]" value="" data-validation="number length" data-validation-length="6-10">
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
               $(function() {

  // Get the form fields and hidden div
  var checkbox = $("#trigger");
  var hidden = $("#hidden_fields");
  var populate = $("#populate");
  
  // Hide the fields.
  // Use JS to do this in case the user doesn't have JS 
  // enabled.
  hidden.hide();
  
  // Setup an event listener for when the state of the 
  // checkbox changes.
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



