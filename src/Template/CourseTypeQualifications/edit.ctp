<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseTypeQualification $courseTypeQualification
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        



    
<div class="courseTypeQualifications form large-9 medium-8 columns content">
    <?= $this->Form->create($courseTypeQualification) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Course Type Qualification') ?></legend>
    </div>
        <?php
            echo $this->Form->control('course_type_id', ['options' => $courseTypes]);
            echo $this->Form->control('qualification_id', ['options' => $qualifications]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->