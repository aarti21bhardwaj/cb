<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DisplayType $displayType
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				


    
<div class="displayTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($displayType) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Display Type') ?></legend>
    </div>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div>
		</div>
	</div>
</div>
