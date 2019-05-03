<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
// pr($tenantConfigSetting);die;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
               
                    <?= $this->Form->create($tenantConfigSetting) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Registration Settings') ?></legend>
                        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <label class="">
                    <?= $this->Form->checkbox('course_description', ['label' => false]); ?> Course Details
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <label class="">
                    <?= $this->Form->checkbox('location_notes', ['label' => false]); ?> Location Notes
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <label class="">
                    <?= $this->Form->checkbox('class_details', ['label' => false]); ?> Class Details
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <label class="">
                    <?= $this->Form->checkbox('remaining_seats', ['label' => false]); ?> Remaining Seats
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10">
                <label class="">
                    <?= $this->Form->checkbox('promocode', ['label' => false]); ?> Promocode
                </label>
            </div>
        </div>
        
        
            
                    </fieldset>
                    <?= $this->Form->button(__('Submit'),['action' => 'add']) ?>
                    <?= $this->Form->end() ?>
                
            </div>
        </div>
    </div>
</div>

