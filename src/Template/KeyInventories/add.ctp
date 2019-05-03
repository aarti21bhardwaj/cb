<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\KeyInventory $keyInventory
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<!-- <div class="ibox-content"> -->
			 <div class="ibox-content">
               <div class="keyInventories form large-9 medium-8 columns content">
                <?= $this->Form->create('') ?>
                <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Add Key Inventory') ?></legend>
                    </div>
                    <?php
                    echo $this->Form->control('key_category_id', ['empty' => '--SELECT ONE--','options' => $keyCategories]);
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="Press Enter, Space or comma to seperate each key " data-original-title="Tooltip on top"> <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i>Add Keys</label>

                        <div class="col-sm-9">
                            <?= $this->Form->control('name', ['placeholder' => 'Press Enter, Space or comma to seperate each key ','type'=> 'textarea', 'label' => false, 'class' => ['form-control']]); ?>
                        </div>
                    </div>
                </fieldset>
                <?= $this->Form->button(__('Save Category')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

    
<!-- <div class="keyInventories form large-9 medium-8 columns content">
    <?= $this->Form->create($keyInventory) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Key Inventory') ?></legend>
    </div>
        <?php
            echo $this->Form->control('key_category_id', ['options' => $keyCategories]);
        ?>
         <div class="form-group">
                            <?= $this->Form->label('name', __('Add Keys'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('name', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                            </div>
                        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div> -->
			<!-- </div> -->
		</div>
	</div>
</div>
