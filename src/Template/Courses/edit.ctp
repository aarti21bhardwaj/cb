<?php
use Cake\I18n\Time;
Time::setToStringFormat('HH:mm');
// Time::setJsonEncodeFormat('HH:mm');
?>
<style type="text/css">
.form-horizontal .form-group {margin-left: 0px;}
</style>
<?php 
$salonTemplate = [
'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
'radio' => '<input type="radio" name="{{name}}"  value="{{value}}"{{attrs}}>',
'radioWrapper' => '<div class="radio-inline">{{label}}</div>',
    ];
$this->Form->setTemplates($salonTemplate);
// pr($course);die;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                
            <div class="courses form large-9 medium-8 columns content">
                <?= $this->Form->create($course, ['data-toggle' => 'validator']) ?>
                <fieldset>
                <div class='ibox-title'>
                    <legend><?= __('Edit Course') ?></legend>
                </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="Private Courses do not appear on the front end website" data-original-title="Tooltip on top">Private Course?  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>

                             <div class="col-sm-10" style="padding-left: 30px;">
                          <!--   <input type="radio" name="private_course" value="1"> <b>Yes</b>
                            <input type="radio" name="private_course" value="0" checked="checked"> <b>No</b> -->
                             <?php 
                                $private_course = ['1' => 'Yes','0' => 'No'];
                                echo $this->Form->radio('private_course',$private_course, ['default' => '0','style' => 'padding:15px']);
                            ?>
                            </div>
                        </div>
                      <?php if($loggedInUser['role']->name !== "instructor" && $loggedInUser['role']->name !== "corporate_client") { ?>
                    <?php if(!$trainingSiteOwner){?>
                        <div class="form-group">

                            <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="Courses can be assigned to different training sites. If you do not use this feature, just choose your own training site." data-original-title="Tooltip on top"><i class="fa- fa fa-info-circle" style="padding-right: 5px"></i>Training Site</label>
                            
                            <div class="col-sm-6">
                                <?php echo $this->Form->control('training_site_id', ['onchange'=>"getCorporateClients(this)",'empty' => 'Please Select','required','label'=>false,'id' => 'trainingSite','options' => $trainingSites]);?>
                            </div>
                            <div class="col-sm-4">
                                <?php echo $this->Form->checkbox('send_email_to_site_coordinator', ['label'=>false]);?>
                                Email to training site coordinator
                            </div>
                        </div>
                    <?php } } ?>

                    <?php if($loggedInUser['role']->name !== "instructor" && $loggedInUser['role']->name !== "corporate_client") { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="If this course is for a corporate client, choose them here. This allows them to see the course in the corporate portal." data-original-title="Tooltip on top">Corporate Client   <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>

                        <div class="col-sm-10">
                        <?= $this->Form->control('corporate_client_id', ['label'=>false,'id'=>'corporate_clients', 'class' => 'form-control','empty' => 'Please Select','options' => $corporateClients])?>
                        </div>
                    </div>
                    <?php } ?>
                    

                    <div class="form-group">
                    <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="If this course is for a corporate client, choose them here. This allows them to see the course in the corporate portal." data-original-title="Tooltip on top">Course Type Category  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>
                    <div class="col-sm-6">
                        <?php echo $this->Form->control('course_type_category_id', ['onchange'=>"getCourseTypes(this)",'label'=>false,'required','empty' => 'Please Select','id' => 'courseTypeCategory','options' => $courseTypeCategories]);?>
                    </div>
                    <?php  if($loggedInUser['role_id'] !== 5 && !isset($loggedInUser['role_id'])){ ?>
                        <div class="col-sm-4">
                            <a class="btn btn-w-m btn-primary" target="_blank" href="<?= $this->Url->build(['controller' => 'CourseTypeCategories','action' => 'add'])?>">
                                Add New Course Type Category
                            </a>
                        </div>
                    <?php } ?>
                    </div>


                    <div class="form-group">
                    <label class="col-sm-2 control-label">Course Type</label>
                    <div class="col-sm-10">
                        <?php echo $this->Form->control('course_type_id', ['onchange'=>"getCourseData(this)",'required','empty' => 'Please Select','options' => $courseTypes,'id'=>'course_type_category','label'=>false]);?>
                    </div>
                    </div>

                    <div id ="wrapper_level">
                    <div class="form-group data_1">
                        <?= $this->Form->label('course_date', __(' Course Date'), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-7"></div>
                        <div class="col-sm-3">
                            <span id="moreLevels" class="fa fa-plus" style="cursor: pointer;"></span>
                        </div>

                    </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    

                    <div class="form-group">
                        <?= $this->Form->label('duration', __(''), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-10">
                        <?php 
                            $duration = ['1' => '1 Day', '2' => '2 Days', '3' => '3 Days', '4' => '4 Days', '5' => '5 Days', '6' => '6 Days', '7' => '7 Days', '8' => '8 Days', '9' => '9 Days', '10' => '10 Days'];
                            echo $this->Form->select('duration', $duration, ['default' => '1']);
                        ?>
                        </div>
                    </div>
                    
                    <?= $this->Form->control('location_id', ['empty' => 'Please Select','options' => $locations , 'id' => 'location']);?>
                    <?php if($loggedInUser['role']->name !== "corporate_client") { ?>
                       <div id ="wrapper_level_instructor">

                           
                            <?php foreach ($courseInstructors as $key => $value) {?>
                                <div class="form-group remove_row<?=$key?> data_1">
                                    <?php if($key>0){ echo '<div class="col-sm-2"></div>';}else{ ?> 
                                    <?= $this->Form->label('course_instructors', __(' Select Instructors'), ['class' => ['col-sm-2', 'control-label']]); ?>
                                <?php }?>
                                        <?php   
                                        if(empty($value->instructor_id)){
                                            $option = '<option value= "" >--Select One--</option>';
                                        }else{
                                            $option = '<option value="'.$value->instructor_id.'">'.$instructors[$value->instructor_id].'</option>';
                                        }
                                        ?>
                                
                                    <div class="col-sm-4">
                                       <select name="course_instructors[<?php echo $key; ?>][instructor_id]" class="form-control m-b" id="course-instructors-<?php echo $key; ?>-instructor-id" ><?php echo $option; ?>
                                        <?php foreach ($instructors as $i => $x) {  
                                                    echo "<option value=".$i."  >$x</option>";
                                                    $selected = null;         
                                             }?>
                                       </select>


                                    </div>
                                    <div class="col-sm-2" id="instructor">
                                          <input type="number" class="form-control" name="course_instructors[<?php echo $key; ?>][instructor_pay]" value="<?= $value->instructor_pay ?>" placeholder="pay" min="0" step="1" id="instructor-pay">
                                    </div>
                                    <div class="col-sm-2" id="instructor">
                                          <input type="number" class="form-control" name="course_instructors[<?php echo $key; ?>][additional_pay]" value="<?= $value->instructor_pay ?>"  placeholder="additional" min="0" step="1" id="additional_pay">
                                    </div>
                                    <?php if($key == 0){ ?> 
                                        <div class="col-sm-1">
                                                <span id="addLevels" class="fa fa-plus" style="cursor: pointer;"></span>
                                        </div>
                                        <div class="col-sm-1" ></div>

                                    <?php }else{ ?>
                                        <div class="col-sm-1"><span id="<?= $key?>" onclick="removeRow(<?=$key?>)" class="remove_field fa fa-minus" style="cursor: pointer;"></span></div>
                                        <div class="col-sm-1" ></div>
                                        <div class="col-sm-12" ></div>
                                    <?php }?>

                                </div>
                            <?php }?>
                    </div>  
                    <script type="text/javascript">
                        $(document).ready(function() {
                            var wrapper_level = $("#wrapper_level_instructor"); //Fields wrapper_level
                            var add_button = $("#addLevels"); //Add button ID
                            var x = <?= count($courseInstructors) ?>; //initlal text box count
                            // console.log(x+'x');
                            $(add_button).click(function(e){ //on add input button click
                                console.log('click');
                                e.preventDefault();
                                    $(wrapper_level).append('<div class="form-group remove_row'+x+' data_1"><div class="col-sm-2"></div><div class="col-sm-4"><select name="course_instructors['+x+'][instructor_id]" class="form-control m-b" id="course-instructors-'+x+'-instructor-id"><option value= "" >--Select One--</option><?php foreach ($instructors as $key => $x) {   echo "<option value=$key >$x</option>"; }?> </select></div><div class="col-sm-2" id="instructor"><input class="form-control" type="number" name="course_instructors['+x+'][instructor_pay]" placeholder="pay" min="0" step="1" id="instructor-pay"></div><div class="col-sm-2" id="instructor"><input  class="form-control" name="course_instructors['+x+'][additional_pay]" placeholder="additional" type="number" min="0" step="1" id="course-instructors-'+x+'-additional-pay"></div><div class="col-sm-1"><span id="'+x+'" onclick="removeRow('+x+')" class="remove_field fa fa-minus" style="cursor: pointer;"></span></div></div>'); //add input box
                                        x++; //text box increment
                                        initCalendar();

                            });
                            
                        });
                            function removeRow(index){ 

                                //user click on remove text
                                console.log(index);
                                $('#wrapper_level_instructor .remove_row'+index+'').remove(); 
                            }

                    </script>

                        
                    <?php $ins =  implode(',', $course->course_instructors);?>
                    <!-- <input type="hidden" name="instructorId[]" value="<?= $ins?>" id="onlyselected" /> -->
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">Select Instructors</label>
                        <div class="col-sm-2">
                            <a href='#' onclick="instructorMileage(this)" class="btn-xs btn-success" data-toggle="modal" data-target="#selectInstructors">Add Instructors</a>
                        </div>
                        <div class = "col-sm-6" id= "selected_instructors">

                            <?php foreach($courseInstructors as $getValue){ 
                                  if(!empty($getValue->instructor_id)){?>
                                        <span class="badge badge-warning">
                                    <?php echo $getValue->instructor->first_name;?>
                                </span>
                            <?php } ?>    

                            <?php } ?>    
                        </div>
                    </div>
                    <?php if(isset($tenant_config_settings[0]->instructor_bidding) && !empty($tenant_config_settings[0]->instructor_bidding) && $tenant_config_settings[0]->instructor_bidding == 1 && $loggedInUser['role']->name !== "instructor") {?>
                        <div class="form-group">
                             <div class="form-group">
                                 <div class="col-sm-8" style="padding-left: 64px;">
                                    <?= $this->Form->label('instructor_bidding', __(' Instructor Bidding'), ['class' => ['col-sm-10','control-label']]); ?>
                                    <label class="col-sm-2">
                                        <?= $this->Form->checkbox('instructor_bidding', ['value'=>'1','label' => false , 'id' => "bidding"]); ?>
                                    </label>
                                </div>
                             </div>
                         </div>
 
                      <div class="form-group" id="biddinginstructor">
                         <label class="col-sm-2 control-label">Number of Instructors for Bidding</label>
                         <div class="col-sm-10">
                             <?= $this->Form->control('bidding_number',['label' => false,'type' => 'number'])?>
                         </div>
                     </div>
                     <?php }} ?>

                    <?php if($loggedInUser['role']->name !== "instructor" && $loggedInUser['role']->name !== "corporate_client") { ?>
                    <div class="form-group">
                    <?= $this->Form->label('pay_structure', __('Pay Structure'), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-10">
                            <?php
                            echo $this->Form->radio('pay_structure', ['Flat Rate','Hourly',' Per Student']);
                            echo '<div class="hr-line-dashed"></div>';
                            ?>
                        </div>
                    </div>

                    <div class="form-group" id="hour">
                          <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="This is what you will be paying the instructor. Only instructors in your training site can see this information." data-original-title="Tooltip on top"> <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i>Instructor Pay</label>

                          <div class="col-sm-3" id="instructor">
                              <?php echo $this->Form->control('instructor_pay',['label' => false,'placeholder'=>'']);?>
                          </div>
                          <div class="col-sm-3" id="addnote">
                          <?php echo $this->Form->control('additional_notes',['label' => false,'placeholder'=>'Additional Notes']);?>
                          </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="This is some extra payment to instructor." data-original-title="Tooltip on top">Additional Pay  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>
                        <div class="col-sm-10">
                            <?= $this->Form->control('additional_pay',['label' => false])?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"  title="Once capacity is reached, students can no longer enroll on the front end." >Number of Seats  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>
                        <div class="col-sm-10">
                            <?= $this->Form->control('seats',['label'=>false,'required','id' => 'seats'])?>
                        </div>
                    </div>
                    <?php if($loggedInUser['role']->name !== "instructor" && $loggedInUser['role']->name !== "corporate_client") { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="name">Course Addons</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control('course_addons',['label' => false,'options'=> $addons,'class'=>['select2_demo_2','form-control'], 'multiple' => true])?>

                        </div>
                    </div>
                    <?php }?>
                    <?php if($loggedInUser['role']->name !== "corporate_client") { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Cost</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control('cost',['label'=>false,'required','id' => 'cost']);?>
                        </div>
                    </div>
                    <?php }?>
                    <?php if($loggedInUser['role']->name !== "instructor") { ?>
                <div class="form-group">
                    <?= $this->Form->label('av_provided_by', __('AV Information'), ['class' => ['col-sm-10', 'control-label']]); ?>
                    <!-- <span style="padding-left:125px;"> -->
                    <?= $this->Form->label('', __('Provided By'), ['class' => ['col-sm-10', 'control-label'],'style' => 'padding-right:140px']); ?><br>
                    <!-- </span> -->
                    <!-- <div>Provided By:</div><br> -->
                        <div class="col-sm-10" style="padding-left:175px;">
                            <!-- <div class="radio-inline">
                                    <input type="radio" id="inlineRadio1" value="0" name="av_provided_by">
                                        <label for="inlineRadio1">Client</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" id="inlineRadio2" value="1" name="av_provided_by" >
                                    <label for="inlineRadio2">Instructor</label>
                                </div>
                                <div class="radio-inline">
                                    <input type="radio" id="inlineRadio3" value="2" name="av_provided_by">
                                    <label for="inlineRadio3">Both</label>
                                </div> -->
                            <!-- <br>
                            <input type="radio" name="av_provided_by" value="Client"> <b>Client</b>
                            <input type="radio" name="av_provided_by" value="instructor"> <b>Instructor</b>
                            <input type="radio" name="av_provided_by" value="Both"> <b>Both</b> -->
                             <?php echo $this->Form->radio('av_provided_by', ['Client','Instructor','Both']);?> 
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-1" style="padding-left:100px;"></div>
                        <?= $this->Form->label('display_type',__('Display Type'), ['class' => ['col-sm-6', 'control-label']]); ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-6">
                            <?php 
                            if(isset($displayTypes) && !empty($displayTypes)){
                            foreach ($displayTypes as $key => $getdisplayTypes) {
                            ?>
                            <label>
                                <input type="checkbox" name="course_display_types[<?php echo $key;?>][display_type_id]" value="<?php echo $key?>" <?php if(in_array($key, $course->course_display_types )) echo "checked"; ?> />
                                <?php echo $getdisplayTypes;?>


                            </label>
                            <?php } }?>
                        </div>
                    </div>
                    <?php } ?>

                <div class="form-group">
                    <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="This is publically available information. Will be included in emails sent to the student." data-original-title="Tooltip on top">Class Details  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>

                    <div class="col-sm-10">
                        <?= $this->Form->control('class_details', ['type'=>'textarea','label' => false,'id'=>'class_detail', 'class' => ['form-control','tinymceTextarea']]); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="These notes only appear for the instructor." data-original-title="Tooltip on top">Notes To Instructor  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>
                    <div class="col-sm-10">
                        <?= $this->Form->control('instructor_notes', ['type'=>'textarea','label' => false,'id'=>'instructor_notes_data', 'class' => ['form-control','tinymceTextarea']]); ?>
                    </div>
                </div>
                <?php if($loggedInUser['role']->name !== "corporate_client") { ?>
                <div class="form-group">
                    <label class="col-sm-2 control-label" data-toggle="tooltip" data-placement="top" title="These are notes that only admins can see" data-original-title="Tooltip on top">Notes to Admin  <i class="fa- fa fa-info-circle" style="padding-right: 5px"></i></label>
                    
                    <div class="col-sm-10">
                        <?= $this->Form->control('admin_notes', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                    </div>
                </div>
                <?php }?>
                <?php if($loggedInUser['role']->label == 'Tenant'){ ?>
                 <?= $this->Form->label('assign_to', __('Assign To'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <?php 
                    echo $this->Form->select('owner_id', $tenantUsers,['id' => 'assignTo']);
                ?>
                <?php } ?>
                <?= $this->Form->label('status', __('Status'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <?php 
                    $status = ['publish' => 'Publish', 'draft' => 'Save Draft'];
                    echo $this->Form->select('status', $status, ['default' => 'publish', 'id' => 'courseStatus']);
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

    $("#trainingSite").removeAttr( 'required' );
    $("#corporate_clients").removeAttr( 'required' );
    $("#courseTypeCategory").removeAttr( 'required' );
    $("#course_type_category").removeAttr( 'required' );
    $("#duration").removeAttr( 'required' );
    $("#location").removeAttr( 'required' );
    $("#instructor").removeAttr( 'required' );
    $("#seats").removeAttr( 'required' );
    $("#cost").removeAttr( 'required' );
    $("#courseDate").removeAttr( 'required' );
    $("#pickup").removeAttr( 'required' );
    $("#dropoff").removeAttr( 'required' );

});
    $('#courseStatus').on('change', function() {
          
        if(this.value == 'draft'){
            $("#trainingSite").removeAttr( 'required' );
            // $("#corporate_clients").removeAttr( 'required' );
            $("#courseTypeCategory").removeAttr( 'required' );
            $("#course_type_category").removeAttr( 'required' );
            $("#duration").removeAttr( 'required' );
            $("#location").removeAttr( 'required' );
            $("#instructor").removeAttr( 'required' );
            $("#seats").removeAttr( 'required' );
            $("#cost").removeAttr( 'required' );
            $("#courseDate").removeAttr( 'required' );
            $("#pickup").removeAttr( 'required' );
            $("#dropoff").removeAttr( 'required' );
              

        }else{
            $("#trainingSite").attr( 'required',true );
            // $("#corporate_clients").attr( 'required',true );
            $("#courseTypeCategory").attr( 'required',true );
            $("#course_type_category").attr( 'required',true );
            $("#duration").attr( 'required',true );
            $("#location").attr( 'required',true );
            $("#instructor").attr( 'required',true );
            $("#seats").attr( 'required',true );
            $("#cost").attr( 'required',true );
            $("#courseDate").attr( 'required',true );
            $("#pickup").attr( 'required',true );
            $("#dropoff").attr( 'required',true );
        }
    });
</script>


<script type="text/javascript">
$(document).ready(function(){

    <?php //pr($getCourseDates);?>
    <?= 'var courseDatesValue ='.json_encode($getCourseDates).';'; ?>
    // console.log(courseDatesValue);
    setCourseDates(courseDatesValue);

    $(".select2_demo_2").select2();
    initCalendar();

});

function setCourseDates(courseDatesValue){
    values = courseDatesValue;
    var wrapper_level = $("#wrapper_level");
    var x = 1;
    $.each(values, function (i, values) {
        var fromTime = new Date(values.time_from);
        fromTime = fromTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit',hour12: false});

        var toTime = new Date(values.time_to);
        toTime = toTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit',hour12: false});

        // console.log('to time');
        // console.log(toTime);
        $(wrapper_level).prepend('<div class="form-group remove_row_selected'+x+' data_1"><div class="col-sm-2"></div><div class="col-sm-3"><div class="input-group date"  style="margin-left: 15px;"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" readonly="readonly" class="form-control" name="course_dates['+x+'][course_date]" value='+formatDate(values.course_date)+'></div></div><div class="col-sm-2" readonly="readonly"><div class="input-group clockpicker" data-autoclose="true"><input class="form-control" name="course_dates['+x+'][time_from]" value='+fromTime+' maxlength="255" id="pickup" type="text" readonly="readonly"><span class="input-group-addon"><span class="fa fa-clock-o"></span></span></div></div><div class="col-sm-2"><div class="input-group clockpicker" data-autoclose="true"><input class="form-control" name="course_dates['+x+'][time_to]" value='+ toTime +' maxlength="255" id="dropoff" type="text" readonly="readonly"><span class="input-group-addon"><span class="fa fa-clock-o"></span></span></div></div><div class="col-sm-1"><span class="remove_field_selected fa fa-minus" style="cursor: pointer;"></span></div></div>');
        x++;
    });

    $(wrapper_level).on("click",".remove_field_selected", function(e){ 
        //user click on remove text
        console.log(x);
        e.preventDefault(); $('#wrapper_level .remove_row_selected'+x+'').remove(); x--;
    })

}

function initCalendar(){
    $('.clockpicker').clockpicker();
    $('#wrapper_level .data_1 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });
}
  function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [month,day,year].join('/');
        }
</script>

<script type="text/javascript">
$(document).ready(function(){
     

    $('.dataTable').dataTable(
    {
    // "bSort" : false
    ordering:  false
    } );


});

function updateInstructorsTr(result){
    var selectedchkval = $("#onlyselected").val();
    values = result.instructors;
    $('#showInstructor tbody tr').remove();
    $.each(values, function (i, values) {
         if(selectedchkval.includes(values.id) == true){
            // console.log(values);

            $('#showInstructor tbody').append('<tr><td><input checked onClick="forchekced()" type="checkbox" id="ad_instructor'+values.id+'" class="ads_Checkbox" name="course_instructors[]" value="'+values.id+'" data-first-name="'+values.first_name+' '+values.last_name+'"/></td><td>'+values.first_name+' '+values.last_name+'</td><td>'+values.email+'</td><td>'+values.phone+'</td><td>'+values.distance+'</td></tr>');

        }else{
            console.log('hirrr');
            $('#showInstructor tbody').append('<tr><td><input onClick="forchekced()" type="checkbox" id="ad_instructor'+values.id+'" class="ads_Checkbox" name="course_instructors[]" value="'+values.id+'" data-first-name="'+values.first_name+' '+values.last_name+'"/></td><td>'+values.first_name+' '+values.last_name+'</td><td>'+values.email+'</td><td>'+values.phone+'</td><td>'+values.distance+'</td></tr>');

        }
    });
}

function instructorMileage(){
    var location = $("#location").val();
    if(location){

        var type = "nofilter";
        jQuery.ajax({
            url: host+"api/instructors/getInstructorByLocation/",
            headers:{"accept":"application/json"},
            dataType: 'json',
            data:{
                "location" : location,
                "type" : type,
                },
            type: "post",
            success:function(data){
             
                // console.log('insu');
                // console.log(data);
                // $('#showInstructor thead tr').html('');
                // $('#showInstructor thead tr').append('<th>mileage</th>');
                updateInstructorsTr(data);
            }   
        });
    }
}

// This api request is to get the instructor as per request query
function ajaxCall(query){
    jQuery.ajax({
        type: "GET",
        url: host+"api/instructors/getInstructor/?request="+query,
        headers:{"accept":"application/json"},
        success: function (result) {
            updateInstructorsTr(result);
        }
    });
}

function filterQualified(){
    var qualified = $("#qualified").val();
    var courseType = $("#course_type_category").val();
    alert(courseType);
    if(!courseType) {
        alert("Please Select Course Type");
    }
    ajaxCall(qualified);
}

// This funtion is to filter all instructors
function filter(){
    var all = $("#all").val();
    ajaxCall(all);
}
// This funtion is to filter instructor alphabetically
function filterAlpha(){
    var alpha = $("#alpha").val();
    ajaxCall(alpha);
}
// This funtion is to filter instructor by location
function filterLocation(){
    var location = $("#location-id").val();
    // var location = 3;
    // var distanceInMiles = 100;
    var distanceInMiles = $("#distanceInMiles").val();
    if(!location){
        alert('Please select location');
        return;
    }
    if(!distanceInMiles){
        alert('Please select distance');
        return;
    }else{
        ajaxCallLocation(location,distanceInMiles);
    }
}

function forchekced(){
    console.log('ssss');
    setTimeout(function(){ 
        var sel = $('.ads_Checkbox:checked').map(function(_, el) {
            // console.log($(el).data('first-name'));
            return $(el).val();

        }).get();
        var name = $('.ads_Checkbox:checked').map(function(_, names) {

            // console.log($(name).data('first-name'));
            return {
                data: $(names).data('first-name')
            };
        }).get();
        console.log('incheck');
        $("#onlyselected").val(sel);
        $("#showIns").html('');
            $.each(name, function (i, values) {
        // console.log('values');
        // console.log(values);
         $("#showIns").append('<span class="badge badge-warning"> '+values.data+'</span>&nbsp');
        });
    }, 1000);
    

}

function ajaxCallLocation(location,distanceInMiles){
    jQuery.ajax({
        url: host+"api/instructors/getInstructorByLocation/",
        headers:{"accept":"application/json"},
        dataType: 'json',
        data:{
            "location" : location,
            "distance" : distanceInMiles,
            },
        type: "post",
        success:function(data){
            updateInstructors(data)
        }   
    });
}



$(document).ready(function() {
    var wrapper_level = $("#wrapper_level"); //Fields wrapper_level
    var add_button = $("#moreLevels"); //Add button ID
    var x = (<?= $getCourseDateCount?>)+1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
            $(wrapper_level).append('<div class="form-group remove_row'+x+' data_1"><div class="col-sm-2"></div><div class="col-sm-3"><div class="input-group date"  style="margin-left: 15px;"><span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="course_dates['+x+'][course_date]" value="" readonly="readonly"></div></div><div class="col-sm-2"><div class="input-group clockpicker" data-autoclose="true""><input class="form-control" name="course_dates['+x+'][time_from]" maxlength="255" id="pickup" type="text" readonly="readonly"><span class="input-group-addon"><span class="fa fa-clock-o"></span></span></div></div><div class="col-sm-2"><div class="input-group clockpicker" data-autoclose="true""><input class="form-control" name="course_dates['+x+'][time_to]" maxlength="255" id="dropoff" type="text" readonly="readonly"><span class="input-group-addon"><span class="fa fa-clock-o"></span></span></div></div><div class="col-sm-1"><span class="remove_field fa fa-minus" style="cursor: pointer;"></span></div></div>'); //add input box
                x++; //text box increment
                initCalendar();
    });
    
    $(wrapper_level).on("click",".remove_field", function(e){ 
        //user click on remove text
        console.log(x);
        e.preventDefault(); $('#wrapper_level .remove_row'+x+'').remove(); x--;
    })
});

</script>

<script type="text/javascript">
$(function () {

$('#select_all').on('change', function () {

    if ($('#select_all').is(':checked')) {
        $("input[id^='ad_instructor']").prop('checked', true);
    } else {
        $("input[id^='ad_instructor']").prop('checked', false);
    }
});

$('#allpassed').on('click', function () {
    var output = $.map($('input:checkbox[name^=course_instructors]:checked'), function (n, i) {
        return n.value;
    }).join(',');
    console.log(output);
    // $('#multipleupdaterform').submit();

});

});


</script>



<script type="text/javascript">
$(document).ready(function(){
    $('#pay-structure-0').on('change', function() {
      if ( this.value == '0')
      {
        
        $("#hour").show();
         $("#addnote").hide();
         
      }
    });
    $('#pay-structure-1').on('change', function() {
      if ( this.value == '1')
      {
        $("#hour").show();
        $("#addnote").show();
         $("#instructor-pay").attr("placeholder","Hourly Rate");
       
      }
    });
    $('#pay-structure-2').on('change', function() {
      if ( this.value == '2')
      {
       
        $("#hour").show();
        $("#addnote").show();
        $("#instructor-pay").attr("placeholder","Per Student Rate");
      }
    });
    $("#flat").hide();
    // $("#hour").hide();
    $("#per_student").hide();
});
        
function forchekced(){
    setTimeout(function(){ 
        var sel = $('.ads_Checkbox:checked').map(function(_, el) {
            return $(el).val();
        }).get();
        $("#onlyselected").val(sel);

    }, 1000);

}

// $(document).ready(function(){
//     $.validate();
// });
</script>

<div class="modal fade" id="selectInstructors" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Instructors</h4>
            </div>
            <div class="modal-body" class="white-bg">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table  id="showInstructor" class="table table-striped table-bordered table-hover dataTable" >
                            <thead>
                                <tr>
                                     <th style="padding-left: 11px;"><input  type="checkbox"  onclick="forchecked()" id="select_all" value="1"></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Distance in Miles</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            if(isset($instructors) && !empty($instructors)){
                                $i = 0;
                                foreach($instructors as $key => $getInstructor):
                                    // pr($key);
                                // pr($course->course_instructors);
                                    ?>
                                <?php if($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $key){
                                        continue;
                                    } ?>
                                    <tr>
                                        <td class="align-center">
                                        <input type="checkbox" onclick="forchecked()" id="ad_instructor<?php echo $key ?>" class="ads_Checkbox" name="course_instructors[]" value="<?php echo $key?>" data-first-name="<?php echo $getInstructor->first_name?>" /></td>
                                        <td><?php echo $getInstructor->first_name." ".$getInstructor->last_name;?></td>
                                        <td><?php echo $getInstructor->email;?></td>
                                        <td><?php echo $getInstructor->phone_1;?></td>
                                        <td>N.A.</td>
                                    </tr>
                            <?php $i++;
                                endforeach;
                            }
                            ?>
                            </tbody>
                        </table>
                        <!-- <input type="button" id="allpassed" name="all_value" value="Select" /> -->
                    </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                                <div>
                                    <label>
                                        Show <input onclick="filter(this)" id="all" value="all" name="optionsRadios" type="radio"> All Instructors
                                    </label>
                                    <label>
                                        <input onclick="filterQualified(this)" id="qualified" value="qualified" name="optionsRadios" type="radio"> Only Qualified Instructors 
                                    </label>
                                </div>
                                <div>
                                    <label>
                                    Sort By <input onclick="filterAlpha(this)" id="alpha" value="alpha" name="optionsRadios" type="radio"> Alphabetically </label>
                                    <label> <input onclick="filterLocation(this)" value="distance" name="optionsRadios" type="radio"> Distance in Miles </label>
                                    <label> 
                                        <select name="radius" id="distanceInMiles">
                                            <option value="10">10 Miles</option>
                                            <option value="50">50 Miles</option>
                                            <option value="100">100 Miles</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Save</button>
            </div>
        </div>  
    </div>
</div>
<script type="text/javascript">
$(function () {

$('#select_all').on('change', function () {

    if ($('#select_all').is(':checked')) {
        $("input[id^='ad_instructor']").prop('checked', true);
    } else {
        $("input[id^='ad_instructor']").prop('checked', false);
    }
});

$('#allpassed').on('click', function () {
    var output = $.map($('input:checkbox[name^=course_instructors]:checked'), function (n, i) {
        return n.value;
    }).join(',');
    console.log(output);
    // $('#multipleupdaterform').submit();

});

});


</script>
<script type="text/javascript">
$(document).ready(function(){
    
    $("#biddinginstructor").hide();
    // $("#pay-structure-0").attr('checked', true);
    
    });
    $('#bidding').on('change', function() {
      if ($('#bidding').is(':checked')) {
       $("#biddinginstructor").show();
    } else {
       $("#biddinginstructor").hide();
  }
      
    });

</script>
