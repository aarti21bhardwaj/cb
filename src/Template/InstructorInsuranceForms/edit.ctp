<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorInsuranceForm $instructorInsuranceForm
 */
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="instructorInsuranceForms form large-9 medium-8 columns content">
                    <?= $this->Form->create($instructorInsuranceForm,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <!-- <div class = 'ibox-title'> -->
                            <legend><?= __('Edit Instructor Insurance Form') ?></legend>
                        <!-- </div> -->
                        <?php
                        
                         if(isset($is_admin) && $is_admin){
                        echo $this->Form->control('instructor_id', ['options' => $instructors]);   }
                        // echo $this->Form->control('description');
                        
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                    <a href="<?php echo $sitePath.$instructorInsuranceForm->document_path.'/'.$instructorInsuranceForm->document_name;?>" target="_blank">
                                        <?= $this->Html->image($sitePath.'/img/pdficon.png', array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                    </a>
                                </div> 
                                <div>
                                    <strong>
                                    <a href="<?php echo $sitePath.$instructorInsuranceForm->document_path.'/'.$instructorInsuranceForm->document_name;?>">
                                    <?php echo $instructorInsuranceForm->document_name ; ?> 
                                    </a>
                                    </strong>
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
                                    <input type="text" readonly='readonly' class="form-control" name="date" value="<?php echo $instructorInsuranceForm->date->format('m/d/Y');?>" placeholder="mm-dd-yyyy">
                                </div>
                            </div>

                        </div>
                        <div class="hr-line-dashed"></div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<script type ="text/javascript">
/**
* @method uploadImage
@return null
*/    
// function uploadImage(input) {
//     if (input.files && input.files[0]) {
//         var reader = new FileReader();
        
//         reader.onload = function (e) {
//             $('#upload-img').attr('src', e.target.result);
//         }
        
//         reader.readAsDataURL(input.files[0]);
//     }
// }

// $("#imgChange").change(function(){
//     uploadImage(this);
// });
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
