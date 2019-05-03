<?php
$loginFormTemplate = [
	'button' => '<div class="form-group"></div>',
	'inputContainer' => '{{content}}',
	'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
	'label' => '<label class="col-sm-4 control-label" {{attrs}}>{{text}}</label>',
	'formStart' => '<form class="" {{attrs}}>',
    'formEnd' => '</form>',
];
$this->Form->setTemplates($loginFormTemplate);
?>
<style type="text/css">
.wizard > .content {min-height: 390px;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	    <div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-content">
	                <h2>Register as a student for - <b><?php echo strtoupper($tenantData->center_name);?></b></h2>
	                <?= $this->Form->create($student, ['id'=>'form','class' => ['wizard-big']]) ?>
	                    <h1>Account</h1>
	                    <fieldset>
	                        <h2>Account Information</h2>
	                        <div class="row">
	                            <div class="col-lg-8">
	                                <div class="form-group">
	                                    <?= $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "email"]); ?>
	                                </div>
	                                <div class="form-group">
	                                    <?= $this->Form->control('password'); ?>
	                                </div>
	                                <div class="form-group">
	                                    <label>Confirm Password </label>
	                                    <input id="confirm" name="confirm" type="password" class="form-control required">
	                                </div>
	                            </div>
	                            <div class="col-lg-4">
	                                <div class="text-center">
	                                    <div style="margin-top: 20px">
										<?php if(isset($tenantData->image_url) && !empty($tenantData->image_url)){?>
											<h1 class="logo-name">
											<?= $this->Html->image($tenantData->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
											</h1>
										<?php }?>
										<h1><?php echo $tenantData->center_name;?></h1>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

	                    </fieldset>
	                    <h1>Profile</h1>
	                    <fieldset>
	                        <h2>Profile Information</h2>
	                        <div class="row">
	                            <div class="col-lg-6">
	                                <div class="form-group">
				                        <?= $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
				                    </div>
	                                <div class="form-group">
				                        <?= $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
	                                </div>
	                                <div class="form-group">
	                                	<?= $this->Form->control('phone1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]); ?>
	                                </div>

	                                <div class="form-group">
			                        	<?= $this->Form->control('phone2', [ 'type' => 'text']); ?>
	                                </div>
	                            </div>
	                            <div class="col-lg-6">
	                                <div class="form-group">
	                                	<?php echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
	                                </div>

	                                <div class="form-group">
	                                	<?php echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);?>
	                                </div>

	                                <div class="form-group">
	                                <?php echo $this->Form->control('zipcode',['required','type'=>'text','data-validation'=>'number', 'data-validation-length'=>'05-05','data-validation'=> 'number length']); ?>
	                                </div>

	                                <div class="form-group">
	                                    <label>Address</label>
	                                    <?= $this->Form->control('address', ['type'=> 'text', 'label' => false, 'class' => ['form-control']]); ?>
	                                </div>
	                            </div>
	                        </div>
	                    </fieldset>
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

<script>
    $(document).ready(function(){
        $("#wizard").steps();
        $("#form").steps({
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18)
                {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18)
                {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
                    errorPlacement: function (error, element)
                    {
                        element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
   });
</script>