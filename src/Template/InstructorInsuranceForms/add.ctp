<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorInsuranceForm $instructorInsuranceForm
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
				


                
                <div class="instructorInsuranceForms form large-9 medium-8 columns content">
                    <?= $this->Form->create($instructorInsuranceForm, ['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <!-- <div class = 'ibox-title'> -->
                            <legend><?= __('Add Instructor Insurance Form') ?></legend>
                        <!-- </div> -->

                        <?php 
// pr($instructor_id);die();
                        if(!$instructor_id){

                            echo $this->Form->control('instructor_id', ['options' => $instructors]);
                        }
                        ?>
                        <?php
            // echo $this->Form->control('instructor_id', ['options' => $instructors]);
            // echo $this->Form->control('document_name');
            // echo $this->Form->control('document_path');
            // echo $this->Form->control('date');
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                    <?= $this->Html->image($instructorInsuranceForm->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                </div> 
                                <br> </br>
                                <?= $this->Form->control('document_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group" id="data_1">
                            <?= $this->Form->label('date', __('Date'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-3">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input type="text" readonly='readonly' class="form-control" name="date" value="" placeholder="mm-dd-yyyy">
                                </div>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
<!--                     <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
-->                    <?= $this->Form->end() ?>
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
<script type="text/javascript">
    $(document).ready(function(){
        $('#data_1 .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

    });
</script>
