<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseDisplayType $courseDisplayType
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        



    
<div class="courseDisplayTypes form large-9 medium-8 columns content">
    <?= $this->Form->create($courseDisplayType) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Course Display Type') ?></legend>
    </div>
        <?php
            echo $this->Form->control('course_id', ['options' => $courses]);
            echo $this->Form->control('display_type_id', ['options' => $displayTypes]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->