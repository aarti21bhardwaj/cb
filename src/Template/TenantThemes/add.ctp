<!-- Color picker -->
<?= $this->Html->css(['plugins/colorpicker/bootstrap-colorpicker.min.css']) ?>
<?= $this->Html->script('plugins/colorpicker/bootstrap-colorpicker.min.js') ?>

<?php
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// pr($sitePath); die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorQualification $instructorQualification
 */
?>
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
				<div class="tenantThemes form large-9 medium-8 columns content">
    <?= $this->Form->create($tenantTheme, ['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Tenant Theme') ?></legend>
    </div>
    <!-- <div class="form-group">
        <?= $this->Form->label('color', __('Manage Theme'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <?php 
                    $color = ['light','red', 'orange', 'blue'];
                    echo $this->Form->select('color', $color, ['default'=>$tenantTheme->color]);
                ?>
    </div> -->

    <div class="form-group">
        <?= $this->Form->label('color', __('Dark Color Theme'), ['class' => ['col-sm-2', 'control-label']]) ?>
        <div class="col-sm-offset-2">
            <input type="text" name="theme_color_dark" class="form-control demo1" value="<?php echo $tenantTheme->theme_color_dark;?>" />
        </div>
    </div>
    <div class="form-group">
        <?= $this->Form->label('color', __('Light Color Theme'), ['class' => ['col-sm-2', 'control-label']]) ?>
        <div class="col-sm-offset-2">
            <input type="text" name="theme_color_light" class="form-control demo1" value="<?php echo $tenantTheme->theme_color_light;?>" />
        </div>
    </div>
    
    <div class="hr-line-dashed"></div>

         <div class="form-group">
            <?= $this->Form->label('image', __('Add Logo'), ['class' => 'col-sm-2 control-label']); ?>
            <div class="col-sm-4">
                <div class="img-thumbnail">
                <a href="<?php echo $sitePath.$tenantTheme->logo_path.'/'.$tenantTheme->logo_name;?>">
                    <?= $this->Html->image($sitePath.$tenantTheme->logo_path.'/'.$tenantTheme->logo_name, array('height' => 100, 'width' => 170,'id'=>'upload-img')); ?>
                    </a>
                </div> 
                <br> </br>
                <?= $this->Form->control('logo_name', ['accept'=>"image/*",'label' => false,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
            </div>
        </div>
        <div class="form-group">
                <?= $this->Form->label('content_area', __('Manage Content Area'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('content_area', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                </div>
        </div>
        <div class="form-group">
                <?= $this->Form->label('content_sidebar', __('Manage Sidebar Area'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('content_sidebar', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                </div>
        </div>
        <div class="form-group">
                <?= $this->Form->label('content_header', __('Header Script'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('content_header', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                </div>
        </div>
        <div class="form-group">
                <?= $this->Form->label('content_footer', __('Footer Script'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('content_footer', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                </div>
        </div>
        <?php
            echo $this->Form->control('redirect_url', ['placeholder' => 'www.xyz.com']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
                </div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    // $('.demo1').colorpicker();
    // $('.demo2').colorpicker();

$(".demo1").spectrum({
    // color: "#FFFFFF",
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
});
</script>

<script type ="text/javascript">
$(document).ready(function(){
    // $('.demo1').colorpicker();
    // $('.demo2').colorpicker();
});

    /**
    * @method uploadImage
    @return null
    */    
    function uploadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#upload-img').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgChange").change(function(){
        uploadImage(this);
    });
</script>

