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
                            <legend><?= __('Add Corporate Client Note') ?></legend>
                        </div>
                        <?php
                        if(!$corporate_client_id){
                            echo $this->Form->control('corporate_client_id', ['options' => $corporateClients]);
                        }
                        // echo $this->Form->control('corporate_client_id', ['options' => $corporateClients, 'empty' => true]);
                        echo $this->Form->control('description');
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
