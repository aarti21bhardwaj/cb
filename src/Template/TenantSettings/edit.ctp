<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenantSetting $tenantSetting
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        


    
<div class="tenantSettings form large-9 medium-8 columns content">
    <?= $this->Form->create($tenantSetting) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Tenant Setting') ?></legend>
    </div>
        <?php
            echo $this->Form->control('tenant_id', ['options' => $tenants]);
            echo $this->Form->control('enable_training_site_module');
            echo $this->Form->control('enable_corporate_module');
            echo $this->Form->control('enable_aed_pm_module');
            echo $this->Form->control('shop_menu_visible');
            echo $this->Form->control('default_theme');
            echo $this->Form->control('key_management');
            echo $this->Form->control('admin_email', ['data-validation'=> "email" ,'type'=> "text"]);
            echo $this->Form->control('from_email', ['data-validation'=> "email" ,'type'=> "text"]);
            echo $this->Form->control('allow_duplicate_emails');
            echo $this->Form->control('training_centre_website');
            echo $this->Form->control('bcc_email', ['data-validation'=> "email" ,'type'=> "text"]);
            echo $this->Form->control('title_bar_text');
            echo $this->Form->control('enable_payment_email');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<script type="text/javascript">
   $(document).ready(function(){
       $.validate();
   });
</script>