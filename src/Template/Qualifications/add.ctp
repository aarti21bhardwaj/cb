<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Qualification $qualification
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				


    
<div class="qualifications form large-9 medium-8 columns content">
    <?= $this->Form->create($qualification) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Qualification') ?></legend>
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
