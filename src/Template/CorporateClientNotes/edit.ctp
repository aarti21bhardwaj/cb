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
                <div class="corporateClientNotes form large-9 medium-8 columns content">
                    <?= $this->Form->create($corporateClientNote) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Corporate Client Note') ?></legend>
                        </div>
                        <?php
            // echo $this->Form->control('corporate_client_id', ['options' => $corporateClients, 'empty' => true]);
                        // pr($corporate_client_id);die();
                        if(isset($is_admin) && $is_admin){
                            echo $this->Form->control('corporate_client_id', ['options' => $corporateClients]);
                        }
                        echo $this->Form->control('description');
                        ?>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->