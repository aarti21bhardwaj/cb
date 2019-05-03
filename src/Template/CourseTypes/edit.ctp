<script src="http://bgrins.github.io/spectrum/spectrum.js"></script>
<link rel="stylesheet" type="text/css" href="http://bgrins.github.io/spectrum/spectrum.css">
<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
               
                <div class="courseTypes form large-9 medium-8 columns content">
                    <?= $this->Form->create($courseType) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Course Type') ?></legend>
                        </div>
                        <?php
                        echo $this->Form->control('course_code');

                        echo $this->Form->control('course_type_category_id', ['options' => $courseTypeCategories]);
                        echo $this->Form->control('agency_id');
                        echo $this->Form->control('name',['label' => ['text'=> 'Course Name']]);                        echo $this->Form->control('valid_for', ['options' =>$courseDurations ]);
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('class_detail', __('Class Details'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('class_detail', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('notes_to_instructor', __('Notes To Instructor'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('notes_to_instructor', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                                    <?= $this->Form->label('color_code', __('Category Color'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                    <div class="col-sm-1">
                                        <?= $this->Form->control('color_code', ['value'=>$courseType->color_code,'id' => 'full','type'=> 'color','label' => false]); ?>
                                    </div>
                                </div>
                        
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends -->
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<style type="text/css">
    .full-spectrum .sp-palette {
        max-width: 200px;
    }
</style>
<script type="text/javascript">

$("#full").spectrum({
    showInput: true,
    className: "full-spectrum",
    showInitial: true,
    showPalette: true,
    showSelectionPalette: true,
    maxSelectionSize: 10,
    preferredFormat: "hex",
    localStorageKey: "spectrum.demo",
    move: function (color) {
       
    },
    show: function () {
   
    },
    beforeShow: function () {
   
    },
    hide: function () {
   
    },
    change: function() {
       
    },
    palette: [
        ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
        "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
        ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
        "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
        ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
        "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
        "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
        "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
        "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
        "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
        "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
        "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
        "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
        "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
    ]
});

</script>