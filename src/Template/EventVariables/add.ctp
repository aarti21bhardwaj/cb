<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\EventVariable $eventVariable
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				


    
<div class="eventVariables form large-9 medium-8 columns content">
    <?= $this->Form->create($eventVariable) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Event Variable') ?></legend>
    </div>
        <?php
            echo $this->Form->control('event_id', ['options' => $events]);
            echo $this->Form->control('name');
            echo $this->Form->control('description');
            echo $this->Form->control('variable_key');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div>
		</div>
	</div>
</div>
