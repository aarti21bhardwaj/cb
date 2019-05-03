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
				<div class="tenantSettings form large-9 medium-8 columns content">
                    <?= $this->Form->create($tenantSetting) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Tenant Setting for ').$tenants->center_name ?></legend>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('enable_training_site_module', ['label' => false]); ?> Enable Training Site Module
                                </label>
                            </div>
                            <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('enable_corporate_module', ['label' => false]); ?> Enable Corporate Module
                                </label>
                            </div>
                            <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('enable_aed_pm_module',['id' => "aed" ],['oncheck' => "myFunction()"],['label' => false]); ?> Enable Aed Pm Module
                                </label>
                            </div>
                            <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('shop_menu_visible', ['label' => false]); ?> Shop Menu Visible
                                </label>
                            </div>
                            </div>
                            <div class="form-group text required" id="show">
                            <?php
                        echo $this->Form->control('aed_pm_module_url', ['data-validation'=> "url" ,'type'=> 'text', 'placeholder' => 'https://www.url.com/']); ?>

                            </div>
                        <?php
                        echo $this->Form->control('default_theme');
                        ?>
                        <div class="form-group">

                        <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('key_management', ['label' => false]); ?> key Management
                                </label>
                            </div>
                            </div>
                        <?php
                        echo $this->Form->control('admin_email', ['data-validation'=> "email" ,'type'=> "text"]);
                        echo $this->Form->control('from_email', ['data-validation'=> "email" ,'type'=> "text"] );
                        ?>
                        <div class="form-group">

                        <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('allow_duplicate_emails', ['label' => false]); ?> Allow Duplicate E-mails
                                </label>
                            </div>
                            </div>

                        
                        <?php
                        
                        echo $this->Form->control('training_centre_website');
                        echo $this->Form->control('bcc_email', ['data-validation'=> "email" ,'type'=> "text"]);
                        echo $this->Form->control('title_bar_text');
                        
                        ?>
                        <div class="form-group">

                        <div class="col-sm-10">
                                <label class="col-sm-offset-2">
                                    <?= $this->Form->checkbox('enable_payment_email', ['label' => false]); ?> Enable Payment E-mails
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
        $('#aed').change(function() {
        if(this.checked) {
            console.log('checked');
            $("#show").show();
            
            // $(this).prop("checked", returnVal);
        }else{
           $("#show").hide();
        }
                
    });

     $.validate();
 
 });
 
</script>
