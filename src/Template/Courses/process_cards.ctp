<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b " {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);


$loginFormTemplate = [
        'radioWrapper' => '<div class="col-sm-offset-2"'
];
$this->Form->setTemplates($loginFormTemplate);
?>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content">
          <div class="addons form large-9 medium-8 columns content">
              <?= $this->Form->create('', ['id' => 'processform']) ?>
                  <fieldset>
                    <div class = 'ibox-title'>
                                        <legend><?= __('Process Cards') ?></legend>
                    </div>
                    <div align="center">
                    <table class ="table table-striped" width="80%" border="0" align="center">
                        <tbody>
                        <tr>
                            <td>
                        <span style="float:left">
                            <strong><?= "Course ID:" ?></strong>
                            <?= $course->id ?>
                        </span>
                        <span style="float:right">
                            <strong><?= "Location "?></strong>
                            <label class="success" data-toggle="tooltip" data-placement="top" title="This will print on cards only and will not save to the database" data-original-title="Tooltip on top"> <i class="fa- fa fa-info-circle"></i></label>
                            <input id="locationText" type="text" name="location">
                        </span>     
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span style="float:left">
                                <strong><?= "Print Training Center info? :" ?></strong>
                                <label data-toggle="tooltip" data-placement="top" title="Do you want Training Center info to be printed on the cards ?" data-original-title="Tooltip on top"> <i class="fa- fa fa-info-circle"></i></label>
                                <input id="printCenterInfo" type="checkbox" name="training_center">
                                <!-- </br> -->
                                <div>
                                    <?php 
                                    if(isset($course->training_site)){
                                    echo $course->training_site->city; 
                                    } else {
                                    echo "";
                                    }?>

                                </div>
                            </span>
                            
                            <span style="float:right">
                                <strong><?= "Instructor ID :" ?></strong>
                                <label data-toggle="tooltip" data-placement="top" title="Instructor ID will print on the card but will not be saved to the database." data-original-title="Tooltip on top"> <i class="fa- fa fa-info-circle"></i></label>
                                <input id="instructorID" type="text" name="instructor_code">
                            </span>
                            </td>
                        </tr>   
                        <tr>
                            <td>
                        <span style="float:left">
                            <strong><?= "Course Type :" ?></strong>
                            <?= $course->course_type->name ?>
                        </span>
                        <span style="float:right">
                            <strong><?= "Course Date(s) :" ?></strong>
                            <?php 
                            if(isset($course->course_dates)){
                            foreach($course->course_dates as $getDates) {
                                // echo nl2br("\n "); 
                                ?>
                                <ul style="left:100px;">
                                    <li><?php echo $getDates->course_date->format('m/d/Y'); ?></li>
                                </ul>                   
                                <?php }} ?> 
                        </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <span style="float:left">
                            <strong><?= "Instructor Name(s):" ?></strong>
                            <?php foreach($course->course_instructors as $getInstructors){ ?>
                                <ul>
                                    <li><?php echo $getInstructors->instructor->first_name; 
                                              echo " ";
                                              echo $getInstructors->instructor->last_name;
                                              echo "  (";
                                        ?>
                                             <a href="mailto:<?php echo $getInstructors->instructor->email ?>?Subject=Hello%20!&body=This is an Email&cc=Mihir.06.96@gmail.co&target="_top"><?php echo $getInstructors->instructor->email ?></a> 
                                             <!-- echo $getInstructors->instructor->email; -->
                                        <?php     echo ")  ";
                                    ?></li>
                                </ul>
                            <?php }?>
                            </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div clas="ibox-content">
                    <table class ="table table-striped" width="80%" border="0" align="center">
                    <thead>
                        <th><input type="checkbox" id="select_all" value="1"></th>
                        <th scope="col">Status </th>
                        <th scope="col">Student Name </th>
                        <th scope="col">Email Address </th>
                    </thead>
                    <tbody>
                        <tr>
                        <?php if(!isset($course->course_students) && empty($course->course_students)){?>
                        <?php echo "No Students exist"; }?>
                        <?php foreach($course->course_students as $getStudents){
                            if($getStudents->course_status == '1'){
                            ?>
                        <td>
                             <input type="checkbox" id="ad_Checkbox<?php echo $getStudents->id ?>" class="ads_Checkbox" value="<?php echo $getStudents->id ?>" name="mychecklist[]" identify="here"> 
                        </td>
                        <td>
                            <span class="label label-primary">Passed</span>
                        </td>
                        <td>
                            <?php echo $getStudents->student->first_name ?>
                            <?php echo $getStudents->student->last_name ?>
                        </td>
                        <td>
                            <?php echo $getStudents->student->email ?>
                        </td>
                            </tr>
                        <?php } }?>
                    </tbody>
                    </table>

                        <div class="text-left">
                            <strong><h2>Card Printing Adjustments</h2></strong>

                        <br>
                            <strong><?= "Printer profile :"?></strong>
                                <div style="width:250px;">
                                    <?php echo $this->Form->control('', ['empty' => 'Please Select one','label'=>false,'options' => $cardProfiles,'id' => 'printerProfile', 'name'=>'printerProfile']);?>
                                </div>
                            </div>

                            </div>
                 </fieldset>
            <!-- <div class="align-left" style="float:left;"> -->
                 <?= $this->Form->button(__('AHA 3 Card Template'), ['id' => 'b3', 'onclick' => "submitProcessForm('aha3Pdf')", 'type' => 'button']) ?>
                 <?= $this->Form->button(__('ASHI 5 Card Template'), ['id' => 'b4', 'onclick' => "submitProcessForm('ashi5Pdf')", 'type' => 'button']) ?>
                 <?= $this->Form->button(__('Print Labels (Avery 8160)'), ['id' => 'b5', 'onclick' => "submitProcessForm('averyPdf')", 'type' => 'button']) ?>
                <?=$this->Html->link('Back', ['controller' => 'Courses', 'action' => 'view',$course->id],['class' => ['btn', 'btn-primary']])?><br>
                <?= $this->Form->button(__('AHA ECard'), ['id' => 'b1', 'onclick' => "submitProcessForm('ahaECard')", 'type' => 'button']) ?> 
                <?= $this->Form->button(__('ASHI-MFA ECARD'), ['id' => 'b2', 'onclick' => "submitProcessForm('ashiECard')", 'type' => 'button']) ?>
                <?= $this->Form->end() ?>
            <!-- </div> -->
          </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">

    currentAction = 'process-cards';
    function submitProcessForm(action){
        current = $('#processform').attr('action');
        newUrl = current.replace(currentAction, action);
        currentAction = action;
        
        if(action == "aha3Pdf"){
            $('#processform').attr('action', newUrl);
        } else if(action == "ashi5Pdf"){
            $('#processform').attr('action', newUrl);
        } else if(action == "averyPdf") {
            $('#processform').attr('action', newUrl);
        } else if(action == "ahaECard"){
            $('#processform').attr('action', newUrl+'.xlsx');
        } else if(action == "ashiECard"){
            $('#processform').attr('action', newUrl);
        }
        $('#processform').submit();
    }

    $(function () {

        var output = '';

        $('#select_all').on('change', function () {

            if ($('#select_all').is(':checked')) {
                $("input[id^='ad_Checkbox']").prop('checked', true);
                // console.log('Here');
            } else {
                $("input[id^='ad_Checkbox']").prop('checked', false);
                // console.log("there");
            }
            output = $.map($('input:checkbox[name^=mychecklist]:checked'), function (n, i) {
                return n.value;
            }).join(',');
            console.log(output);
        });
    });

</script>