<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\KeyInventory $keyInventory
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        


    
<div class="keyInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($keyInventory) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Key Inventory') ?></legend>
    </div>
        <?php
            echo $this->Form->control('key_category_id', ['options' => $keyCategories]);
            echo $this->Form->control('name');
            echo $this->Form->control('status');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->