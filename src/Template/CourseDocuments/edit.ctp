<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseDocument $courseDocument
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        


    
<div class="courseDocuments form large-9 medium-8 columns content">
    <?= $this->Form->create($courseDocument) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Course Document') ?></legend>
    </div>
        <?php
            echo $this->Form->control('course_id', ['options' => $courses]);
            echo $this->Form->control('document_name');
            echo $this->Form->control('document_path');
            echo $this->Form->control('description');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->