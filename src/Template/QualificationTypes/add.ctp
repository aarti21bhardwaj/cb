<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\QualificationType $qualificationType
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				



    
<div class="qualificationTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($qualificationType) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Qualification Type') ?></legend>
    </div>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('qualification_id', ['options' => $qualifications]);
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
