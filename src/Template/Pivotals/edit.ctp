<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">  
                <div class="pivotals form large-9 medium-8 columns content">
                    <?= $this->Form->create($pivotal) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Edit Pivotal') ?></legend>
                    </div>
                        <?php
                            echo $this->Form->control('key_category_id', ['options' => $keyCategories]);
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('info', __('Info'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('info', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea'], 'required' => 'true']); ?>
                            </div>
                        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->