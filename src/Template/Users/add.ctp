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
                <div class="users form large-9 medium-8 columns content">
                    <?= $this->Form->create($user) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Add User') ?></legend>
                    </div>
                        <?php
                            echo $this->Form->control('first_name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('last_name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]); 
                            echo $this->Form->control('password');
                        ?>
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
