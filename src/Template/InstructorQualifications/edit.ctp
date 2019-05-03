<?php
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
// pr($sitePath); die();
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InstructorQualification $instructorQualification
 */
?>
<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>'

];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        




    
<div class="instructorQualifications form large-9 medium-8 columns content">
    <?= $this->Form->create($instructorQualification,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"])  ?>
    <fieldset>
    <!-- <div class = 'ibox-title'> -->
        <legend><?= __('Edit Instructor Qualification') ?></legend>
    <!-- </div> -->
        <?php if(isset($is_admin) && $is_admin){

                                 echo $this->Form->control('instructor_id', ['options' => $instructors]);
                            }
                            ?>
        <?php
            // echo $this->Form->control('instructor_id', ['options' => $instructors]);
            // echo $this->Form->control('qualification_id', ['options' => $qualifications]);
            // echo $this->Form->control('qualification_type_id', ['options' => $qualificationTypes]);
            // echo $this->Form->control('expiry_date');
            // echo $this->Form->control('last_monitored');
            ?>
            <div  id = "schools">
                            <?= $this->Form->control('qualification_id', ["id" => "school",'empty' => '--SELECT ONE--','options' => $qualifications]); ?>
                        </div>
                        <div  id = "campuses">
                            <?= $this->Form->control('qualification_type_id', ['id' => 'selectCampuses','empty' => '--SELECT ONE--','options' => $qualificationTypes]); ?>
                        </div> 
             <div class="form-group" id="data_1">
                        <?= $this->Form->label('expiry_date', __('Expiry Date'), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-3">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" readonly='readonly' class="form-control" name="expiry_date" value="<?php echo $instructorQualification->expiry_date->format('m/d/Y');?>   ">
                            </div>
                        </div>
                        
            </div>
            <div class="form-group" id="data_1">
                        <?= $this->Form->label('last_monitored', __('Last Monitored'), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-3">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" readonly='readonly' class="form-control" name="last_monitored" value="<?php echo $instructorQualification->last_monitored->format('m/d/Y');?>">
                            </div>
                        </div>
                        
            </div>
            <?php
            echo $this->Form->control('license_number');
            // echo $this->Form->control('document_name');
            // echo $this->Form->control('document_path');
        ?>
        <div class="form-group">
                        <?= $this->Form->label('image', __('Edit PDF'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                <a href="<?php echo $sitePath.$instructorQualification->document_path.'/'.$instructorQualification->document_name;?>" target="_blank">
                                   <?= $this->Html->image($sitePath.'/img/pdficon.png', array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                   </a>
                                </div> 
                                <div>
                                    <strong>
                                <a href="<?php echo $sitePath.$instructorQualification->document_path.'/'.$instructorQualification->document_name;?>">

                                    <?php echo $instructorQualification->document_name ; ?> 
                                </a>
                                    </strong>
                                </div>
                                <br> </br>
                                <?= $this->Form->control('document_name', ['label' => false,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                            </div>
                        </div>
                </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?php 
                    if(preg_match("/tenants/",$this->request->referer())){ } else {?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?php } ?>
                    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		<!-- </div> .ibox ends -->
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
$('#data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("campuses").style.display = "none";
        document.getElementById("selectCampuses").required = false;
        var host = $('#baseUrl').val();
        console.log(host);
        $("#school").on('change',function(){
            var QualificationId = $('#school').val();
            // console.log(QualificationId);
            $('#selectCampuses').empty();
            if(QualificationId){
                // console.log('here in if');
                $.ajax({
                    url: host+"api/users/fetchQualificationTypes/"+QualificationId,
                    type: "GET",
                    dataType : 'json',
                    header : {'accept' : "application/json", 'contentType': "application/json"},
                    success: function (data) {
                        console.log(data);
                        if(data){
                        console.log('here in if2');

                            $('#selectCampuses').empty();
                            document.getElementById("campuses").style.display = "block";
                            document.getElementById("selectCampuses").required = true;
                            $.each(data.response, function(i, values){
                                $('select[id = selectCampuses]').append($('<option>',{
                                    value : values.id,
                                    text : values.name
                                }));

                            });
                        }
                        else{
                            // console.log('here in else');
                            // $('select[id = selectCampuses]').empty();
                            document.getElementById("campuses").style.display = "none";
                            document.getElementById("selectCampuses").required = false;
                        }
                    }
                });
            }
            else{
                // $('#selectCampuses').empty();
                document.getElementById("campuses").style.display = "none";
                document.getElementById("selectCampuses").required = false;
            }
        });
    });
</script>
