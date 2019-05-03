<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorApplication $instructorApplication
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
				



                <div class="instructorApplications form large-9 medium-8 columns content">
                    <?= $this->Form->create($instructorApplication,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <!-- <div class = 'ibox-title'> -->
                            <legend><?= __('Add Instructor Application') ?></legend>
                        <!-- </div> -->
                         <?php if(!$instructor_id){

                                echo $this->Form->control('instructor_id', ['label'=>'Instructor Name','options' => $instructors]);
                            }
                            ?>
                           





        <div class="form-group">
            <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
            <div class="col-sm-4">
                <div class="img-thumbnail">
                    <?= $this->Html->image($instructorApplication->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                </div> 
                <br> </br>
                <?= $this->Form->control('document_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
<!--     <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
 -->
    <?= $this->Form->end() ?>
</div>
</div>
</div>
</div>
</div>
 <script type ="text/javascript">
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
<script type="text/javascript">
$(document).ready(function(){
    $.validate();
    $.validate({
        modules : 'location',
        onModulesLoaded : function() {
        $('input[name="state"]').suggestState();
        }
    });
});
</script>