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
                <div class="subcontractedClients form large-9 medium-8 columns content">
                    <?= $this->Form->create($subcontractedClient, ['data-toggle' => 'validator','class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Subcontracted Client') ?></legend>
                        </div>
                        <?php
                            if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){
                              echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites]);
                            }
                        ?>
                        <?php
                         // echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites]);  
                        echo $this->Form->control('corporate_client_id', ['label' => ['text'=>'Subcontracting Client Name'],'empty' => '--SELECT ONE--','options' => $corporateClients]);
                        echo $this->Form->control('name',['label' => ['text'=>'Subcontracted Client Name']]);
                        ?>

                        <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>

                        <?php
                        echo $this->Form->control('city');
                        echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                        echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>'05-05']);
                        echo $this->Form->control('contact_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('contact_phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                        echo $this->Form->control('contact_email', ['data-validation'=> "email" ,'type'=> "text"]);
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
                                echo $this->Form->control('web_id', ['type' => 'text', 'label' => 'Web Id','placeholder'=> 'Enter Web Id to activate URL']);  
                            if(empty($subcontractedClient->web_id)){
                                echo $this->Form->control('web_url',['type' => 'text','disabled']);
                            } else {
                               echo $this->Form->control('web_url',['type' => 'text']);
                            } 

                            ?>

                            <!-- <div class="form-group text">
                              <label class="col-sm-2 control-label" for="web-url">Web Url</label>
                                <div class="col-sm-offset-2">
                                    <input type="text" class="form-control" name="web_url" maxlength="255" id="web-url" value="<?php echo $subcontractedClient->web_url ?><?php echo $subcontractedClient->web_id ?>">
                                </div>
                            </div> -->

                            <div class="form-group">
                                <?= $this->Form->label('subcontractedclient_detail', __('Corporate Details'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                <div class="col-sm-10">
                                    <?= $this->Form->control('subcontractedclient_detail', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label class="col-sm-offset-6">
                                        <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                    </label>
                                </div>
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

<script type="text/javascript">
       $(function() {
  
  // Get the form fields and hidden div
  var checkbox = $("#trigger");
  var hidden = $("#hidden_fields");
  var populate = $("#populate");
  
  // Hide the fields.
  // Use JS to do this in case the user doesn't have JS 
  // enabled.
  hidden.hide();
   if (checkbox.is(':checked')) {
                                                // Show the hidden fields.
            hidden.show();
        } 
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
   
</script>

