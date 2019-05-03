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
				<div class="corporateClientUsers form large-9 medium-8 columns content">
                    <?= $this->Form->create($corporateClientUser) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Corporate Client User') ?></legend>
                        </div>
                        <?php  if($loggedInUser['role']->name == 'tenant'){ 
                            echo $this->Form->control('corporate_client_id', ['options' => $corporateClients]);
                            } ?>
                            

                        
                        <?php
                        
                        echo $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);
                        echo $this->Form->control('password');
                        echo $this->Form->control('phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                        
                        ?>
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

