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
                <div class="textClips form large-9 medium-8 columns content">
                    <?= $this->Form->create($textClip) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Text Clip') ?></legend>
                        </div>
                        <?php
                        if($loggedInUser['role']->name == 'super_admin'){
                            echo $this->Form->control('tenant_id', ['options' => $tenants]);
                        } 
                        echo $this->Form->control('name');
                        ?>

                        <div class="form-group">
                            <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('description', ['type'=>'textarea','required'=> true,'label' => false, 'class' => ['form-control'/*,'tinymceTextarea'*/]]); ?>
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
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
/*$(document).ready(function(){
    $.validate();
});s*/
</script>