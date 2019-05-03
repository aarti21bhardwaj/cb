<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Session;
// $sitePath = Configure::read('siteUrl');
$sitePath = Configure::read('fileUpload');
$site = Router::url('/', true);
// pr($waitlistedCourseStudent);die();
// pr($course);die();
// pr($course->course_students);die();
// pr($orders[0]['student_id']);die();
// pr($loggedInUser['role_id']);die();
// pr($getStudent);die();
// pr($id);die(); 
// pr($course->course_addons);die();
?>

<?php 
// pr($courseStudent);die();
    $salonTemplate = [
    'button' => '<button id="studentId" class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>',
    'selectMultiple' => '<select  name="{{name}}[]" multiple="multiple" {{attrs}}>{{content}}</select>',
    'input' => '<input type="hidden" class="form-control" name="{{name}}"{{attrs}}/>',
    'formStart' => '<form class="form-horizontal" {{attrs}}>',
    'formEnd' => '</form>',
        ];

$this->Form->setTemplates($salonTemplate);

?>
<style>
    .table th, .table td {
    padding: 8px;
    line-height: 20px;
    text-align: left;
    vertical-align: top;
    border-top: 1px solid #ddd;
    }
   /* .btn{
    font-size: 11px;
    padding: 3px 5px;
    }*/
    .btn-success.disabled, .btn-success[disabled] {
    background-color: #87b87f !important;
    }
</style>

<div class="tab text-center">
    <button class="tablinks text-center" onclick="openCity(event, 'Courses')" id="defaultOpen">Courses</button>
    <button class="tablinks text-center" onclick="openCity(event, 'Students')">Students</button>
</div>


<!-- Associated Students Index -->
<div id="Students" class="tabcontent">

     <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-3"> Registered Students</a></li>
                <li class=""><a data-toggle="tab" href="#tab-4">Waitlisted Students</a></li>
                <?php if($loggedInUser['role_id'] != 4){?>
                <li class=""><a data-toggle="tab" href="#tab-5">Cancelled Students</a></li>
                <?php } ?>
            </ul>

    <div class="tab-content">
                <div id="tab-3" class="tab-pane active">
                    <div class="panel-body">


 <div class = 'ibox-title'>
    <div class="text-right">
     <a href='#' class="btn-sm btn-success" data-toggle="modal" data-target="#registerStudent">Register Student</a>
     </br></br>
    </div>
     <div class="text-right">
     <?=$this->Html->link('Export CSV', ['controller' => 'Courses', 'action' => 'exportCsv',$course->id],['class' => ['btn-xs', 'btn-success']])?>
     </br></br>
    </div>
                <h3><?= __('Registered Students') ?></h3> 
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                    <tr>
                        <th ><input type="checkbox" id="select_all" value="1"></th>
                        <th scope="col">Name & Email </th>
                        <th scope="col">Check In </th>
                        <th scope="col">Status </th>
                        <th scope="col">Addon </th>
                        <?php if($loggedInUser['role_id'] != 4){?>
                        <th scope="col">Promo Code </th>
                        <?php } ?>
                        <th scope="col">Payment </th>
                        <th scope="col">Test Score </th>
                        <th scope="col">Skills </th>
                        <?php if($loggedInUser['role_id'] != 4){?>
                        <th scope="col">Actions </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php 
                // pr($CourseStudent->payment_status);die();
                // if(isset($course->course_students) && !empty($course->course_students)){

                    // pr($course->course_students);die();
                foreach ($CourseStudents as $getStudent): ?>
                <?php 
                // pr($getStudent->id);
                // if($getStudent->course_status == 5) {



                    if($getStudent->payment_status == 'Paid' || $getStudent->payment_status == 'Partial'){
                ?>

                <!-- <input  id="ad_Checkbox1" class="ads_Checkbox" type="checkbox" value="1" />
                <input  id="ad_Checkbox2" class="ads_Checkbox" type="checkbox" value="2" />
                <input  id="ad_Checkbox3" class="ads_Checkbox" type="checkbox" value="3" />
                <input  id="ad_Checkbox4" class="ads_Checkbox" type="checkbox" value="4" />
                <input type="button" id="save_value" name="save_value" value="Save" /> -->

                   <tr>
                   <td>
                   <input type="checkbox" id="ad_Checkbox<?php echo $getStudent->id ?>" class="ads_Checkbox" value="<?php echo $getStudent->id ?>" name="mychecklist[]"> 
                   </td>
                    <td><?= $getStudent->student->first_name." ".$getStudent->student->last_name ?><br> 
                    <?= $getStudent->student->phone1 ?><br> 
                    <?= $getStudent->student->email ?></td>
                    <td><?php if(($getStudent->student->checkin)): ?>
                                <i class="fa fa-thumbs-up"></i>                                     <?php else: ?>
                                <i class="fa fa-thumbs-down"></i> 
                                <?php endif;
                            ?></td>
                        
                    <td id="active_student_<?php echo $getStudent->id ?>">

                        <?php if($getStudent->course_status == 1 ) {?>

                        <input type="button" value="passed" name="status" class="btn btn-sm btn-success  " onclick="passedStatus('<?php echo $getStudent->id ?>')" id="passed_<?php echo $getStudent->id ?>">
                        <?php } else {?>

                        <input type="button" value="passed" name="status" class="btn btn-sm   " onclick="passedStatus('<?php echo $getStudent->id ?>')" id="passed_<?php echo $getStudent->id ?>">

                       <?php } if($getStudent->course_status == 2 ){?>
                         <input type="button" value="failed" name="status" class="btn btn-sm btn-success " onclick="failedStatus('<?php echo $getStudent->id ?>')" id='failed_<?php echo $getStudent->id ?>'>

                        <?php } else { ?>

                        <input type="button" value="failed" name="status" class="btn btn-sm  " onclick="failedStatus('<?php echo $getStudent->id ?>')" id='failed_<?php echo $getStudent->id ?>'>
                        <?php } if($getStudent->course_status == 3 ){?>

                         <input type="button" value="absent" name="status" class="btn btn-sm btn-success " onclick="absentStatus('<?php echo $getStudent->id ?>')" id='absent_<?php echo $getStudent->id ?>'>
                         <?php } else { ?>

                         <input type="button" value="absent" name="status" class="btn btn-sm  " onclick="absentStatus('<?php echo $getStudent->id ?>')" id='absent_<?php echo $getStudent->id ?>'>
                        <?php } if($getStudent->course_status == 4 ){?>

                         <input type="button" value="incomplete" name="status" class="btn btn-sm btn-success " onclick="incompleteStatus('<?php echo $getStudent->id ?>')" id ='incomplete_<?php echo $getStudent->id ?>'>
                         <?php } else {?>

                          <input type="button" value="incomplete" name="status" class="btn btn-sm  " onclick="incompleteStatus('<?php echo $getStudent->id ?>')" id ='incomplete_<?php echo $getStudent->id ?>'>
                        <?php } ?>
                    </td>

                    <td id="addon_student_<?php echo $getStudent->student_id ?>" >
                        <!-- <a href='#' onclick='openViewPopUp("#")'  data-toggle="modal" data-target="#myModal"> -->
                        <!-- <a data-toggle="modal" disabled="disabled" onclick="addAddon(<?php echo "$getStudent->student_id" ?> ,<?php  echo "$getStudent->id "?>)" data-target="#addonModal" > -->
                        <center><i class="fa fa-plus fa-fw" disabled="disabled"></i>
                        <!-- </a>  -->
                    </center>
                    </td>
                    <?php if($loggedInUser['role_id'] != 4){?>
                    <td>
                    <!-- <a data-toggle="modal" disabled="disabled" onclick="addPromoCode(<?php echo "$id"?>,<?php echo "$getStudent->student_id" ?>) " data-target="#promoCodeModal"> -->
                        <center><i class="fa fa-plus fa-fw" disabled="disabled"></i>
                        <!-- </a>  -->
                    </center>
                    </td>
                    <?php } ?>
                    <td disabled>
                        <center><text style="background: #ccc; color:  padding: 2px 3px; border: 1px solid #000;"><?= $getStudent->payment_status?></text><br>
                        <?php if($getStudent->payment_status == 'Partial'){?>
                            <?php echo "Total:$".$paymentData[$getStudent->student_id]['totalAmount']; ?>
                            <?php echo "Balance:$".($paymentData[$getStudent->student_id]['balance']); ?>
                        <?php }?>
                        </center>
                    </td>
                    <td id="csid_<?php echo "$getStudent->id" ?>">
                    <input type="text" style="width:70px;" data-csid = "<?php echo "$getStudent->id" ?>" class="testscore" value="<?= $getStudent->test_score ?>"></td>

                    <td>
                    <?php if($getStudent->skills == 'Passed') { ?>
                    <select value="<?= $getStudent->skills ?>" style="width:110px;" onchange="studentSkill(<?php echo "$getStudent->id" ?>, this)" >
                        <option value="<?= $getStudent->skills ?>" >Select One</option>
                        <option value="passed" selected="">Passed</option>
                        <option value="failed" >Failed</option>
                    <?php } else if ($getStudent->skills == 'Failed') {?> 
                        <select value="<?= $getStudent->skills ?>" style="width:110px;" onchange="studentSkill(<?php echo "$getStudent->id" ?>, this)" >
                        <option value="<?= $getStudent->skills ?>" >Select One</option>
                        <option value="passed" >Passed</option>
                        <option value="failed" selected="">Failed</option>
                    <?php } else {?>
                        <select value="<?= $getStudent->skills ?>" style="width:110px;" onchange="studentSkill(<?php echo "$getStudent->id" ?>, this)" >
                        <option value="<?= $getStudent->skills ?>" >Select One</option>
                        <option value="passed" >Passed</option>
                        <option value="failed" >Failed</option>
                    <?php } ?>   
                    </td>
                    <?php if($loggedInUser['role_id'] != 4){?>
                    <td id="<?php echo $getStudent->id ?>">
                        <a href="mailto:<?php echo $getStudent->student->email ?>?Subject=Hello%20!&body=This is an Email&cc=Test@twinspark.co&target="_top">
                                <i class="fa fa-envelope" style=" color: #fff;
                                background: #045e9f !important;  padding: 5px;"></i> 
                        </a> 
                        <a href='#' class="fa fa-times-circle-o" onclick="cancelStudent(<?php echo "$getStudent->student_id"."" ?> , <?php echo "$getStudent->id"?>, <?php echo "$getStudent->course_id"?>,<?php echo "$getStudent->course_id"?>)" data-toggle="modal" data-target="#cancelModal" style=" color: #fff;
                                background: #b74635 !important; padding: 5px;">
                        </a><br>
                        <!-- <a href='#'> -->
                        <a target="_blank" href="<?php echo Router::url(['controller' => 'Students', 'action' => 'transferStudent',$getStudent->student_id,$course->id], true)?>">
                                <i class="fa fa-share" style=" color: #fff;
                                background: #e59729 !important; padding: 5px"></i>
                        </a>
                        <?php if($getStudent->payment_status != "Paid"){?>
                        <a href='<?php echo $this->Url->build(["controller" => "Students","action" => "admin-payment",$getStudent->student_id,$getStudent->course_id, isset($paymentData[$getStudent->student_id]["balance"])?$paymentData[$getStudent->student_id]["balance"]:""]);?>'>
                                <i class="fa fa-dollar" style=" color: #fff;
                                background: #629b58 !important; padding: 5px"></i>
                        </a>
                        <?php }?>
                    </td>
                    <?php } ?>
                   </tr>
                <?php } 
                  endforeach;  ?> 
                
                    <input type="button" name="allattendence" id="allpassed" class="btn btn-small btn-success" value="Passed">
                    <input type="button" name="allattendence" id="allfailed" class="btn btn-small btn-danger" value="Failed">
                    <input type="button" name="allattendence" id="allabsent" class="btn btn-small btn-info" value="Absent">
                    <input type="button" name="allattendence" id="allincomplete" class="btn btn-small btn-warning" value="Incomplete"></br>
                </tbody>
            </table>
        </div>
    </div>
  </div>      

        </div>
        </div>
       

         <div id="tab-4" class="tab-pane active">
                    <div class="panel-body">

 <div class = 'ibox-title'>
                <h3><?= __('Waitlisted Students') ?></h3>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                    <tr>
                        <th scope="col">Name & Email </th>
                        <th scope="col">Check In </th>
                        <th scope="col">Status </th>
                        <th scope="col">Addon </th>
                        <?php if($loggedInUser['role_id'] != 4){?>
                        <th scope="col">Promo Code </th>
                        <?php } ?>
                        <th scope="col">Payment </th>
                        <th scope="col">Test Score </th>
                        <th scope="col">Skills </th>
                        <?php if($loggedInUser['role_id'] != 4){?>
                        <th scope="col">Actions </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                <?php 
                // if(isset($course->course_students) && !empty($course->course_students))
                // if(isset($CourseStudent) && !empty($CourseStudent))
                // {


                foreach ($CourseStudents as $getStudent): ?>
                    <?php if($getStudent->payment_status == 'Not Paid'){ ?>
                   <tr>
                    <td><?= $getStudent->student->first_name." ".$getStudent->student->last_name ?><br> 
                    <?= $getStudent->student->phone1 ?><br> 
                    <?= $getStudent->student->email ?></td>
                    <td><?php if(($getStudent->student->checkin)): ?>
                                <i class="fa fa-thumbs-up"></i>                                     
                            <?php else: ?>
                                <i class="fa fa-thumbs-down"></i> 
                                <?php endif;
                            ?></td>
                            
                    <td><input type="button" value="passed" name="status" class="btn btn-sm " disabled="">
                         <input type="button" value="failed" name="status" class="btn btn-sm " disabled="">
                         <input type="button" value="absent" name="status" class="btn btn-sm " disabled="">
                        <input type="button" value="incomplete" name="status" class="btn btn-sm " disabled="">
                        <input type="hidden" value="registered" name="status" class="btn btn-sm">
                    </td>

                     <td id="addon_student_<?php echo $getStudent->student_id ?>">
                        <!-- <a href='#' onclick='openViewPopUp("#")'  data-toggle="modal" data-target="#myModal"> -->
                        <a data-toggle="modal" onclick="addAddon(<?php echo "$getStudent->student_id" ?> ,<?php  echo "$getStudent->id "?>)" data-target="#addonModal">
                        <center><i class="fa fa-plus fa-fw"></i></a> </center>
                    </td>
                    <?php if($loggedInUser['role_id'] != 4){?>
                    <td id="waitlistedPromoCode_<?= $getStudent->student_id;?>">
                    <a data-toggle="modal" onclick="addPromoCode(<?php echo "$id" ?>,<?php echo "$getStudent->student_id" ?> )" data-target="#promoCodeModal">
                        <center><i class="fa fa-plus fa-fw"></i></a> </center>
                    </td>
                    <?php } ?>
                    <td>
                        <center><text style="background: #ccc; color:  padding: 2px 3px; border: 1px solid #000;"><?= $getStudent->payment_status?></text><br>
                        <?php $paymentData = $this->request->getSession()->read('paymentData'); ?>
                        <p id='waitlistedTotalPrice_<?= $getStudent->student_id;?>' class='font-bold'>Total: $<?php echo isset($paymentData[$getStudent->student_id]['finalAmount'])?$paymentData[$getStudent->student_id]['finalAmount']:($course->cost); ?></p>
                        <p id='waitlistedTotalBalance_<?= $getStudent->student_id;?>' class='font-bold'>Balance: $<?php echo isset($paymentData[$getStudent->student_id]['finalAmount'])?$paymentData[$getStudent->student_id]['finalAmount']:($course->cost); ?></p>
                        </center>
                    </td>
                    <td><input type="text" style="width:70px;" disabled="" ><?= $getStudent->test_score?></td>
                    <td><select  style="width:110px;" disabled="">
                        <option value="" selected="">Select One</option>
                        <option value="passed" >Passed</option>
                        <option value="failed" >Failed</option>
                    </td>

                    <?php if($loggedInUser['role_id'] != 4){?>
                    <td>

                      <a href="mailto:<?php echo $getStudent->student->email ?>?Subject=Hello%20!&body=This is an Email&cc=Test@twinspark.co&target="_top">
                                <i class="fa fa-envelope" style=" color: #fff;
                                background: #045e9f !important;  padding: 5px;"></i> 
                        </a> 
                         <a href='#' class="fa fa-times-circle-o" onclick="cancelStudent(<?php echo "$getStudent->student_id"."" ?> , <?php echo "$getStudent->id"?>, <?php echo "$getStudent->course_id"?>)" data-toggle="modal" data-target="#cancelModal" style=" color: #fff;
                                background: #b74635 !important; padding: 5px;">
                        </a><br>
                        <a target
                        console.log(cid);
                        console.log('cid');="_blank" href="<?php echo Router::url(['controller' => 'Students', 'action' => 'transferStudent',$getStudent->student_id,$course->id], true)?>">
                                <i class="fa fa-share" style=" color: #fff;
                                background: #e59729 !important; padding: 5px"></i>
                        </a>
                        <a href='<?php echo $this->Url->build(["controller" => "Students","action" => "admin-payment",$getStudent->student_id,$getStudent->course_id]);?>'> 
                            
                                <i class="fa fa-dollar" style=" color: #fff;
                                background: #629b58 !important; padding: 5px"></i>
                        </a>
                    </td>
                    <?php } ?>
                   </tr>
                <?php  } endforeach; 
                 // }
                  ?> 
                </tbody>
            </table>
        </div>
    </div>
  </div>
    </div>
    </div>
<?php if($loggedInUser['role_id'] != 4){?>
         <div id="tab-5" class="tab-pane active">
                    <div class="panel-body">
  <div id='color'>
  <div class='ibox-title'>
     <h3><?= __('Cancelled Students') ?></h3>
     <div class='ibox-content'>
     <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                    <tr>
                        <th scope="col">Name & Email </th>
                        <th scope="col">Check In </th>
                        <th scope="col">Status </th>
                        <th scope="col">Registration Date </th>
                        <th scope="col">Paid Amount </th>
                        <th scope="col">Payment Status </th>
                        <th scope="col">Cancellation Date </th>
                    </tr>
                </thead>
                <tbody>
                  <?php 
                // pr($courseStudent);die();
                // if(isset($course->course_students) && !empty($course->course_students)){
                    


                    // pr($course->course_students);die();
            foreach ($CourseStudents as $getStudent): ?>
            <?php if($getStudent->payment_status == 'No Refund' || $getStudent->payment_status == 'Amount Refund'){ ?>
                <tr>
                    <td><?= $getStudent->student->first_name." ".$getStudent->student->last_name ?><br> 
                    <?= $getStudent->student->phone1 ?><br> 
                    <?= $getStudent->student->email ?></td>
                    <td><?php if(($getStudent->student->checkin)): ?>
                                <i class="fa fa-thumbs-up"></i>                                     <?php else: ?>
                                <i class="fa fa-thumbs-down"></i> 
                                <?php endif;
                            ?></td>
                    <td ><input type="button" class="btn btn-danger btn-sm disabled" value="Cancelled"></td>
                    <td><?php echo $getStudent->registration_date ?></td>
                    <td><?php echo $course->cost ?></td>
                    <td><?php if(($getStudent->payment_status) == NULL) {
                        echo "No payment records found!";
                        } else {
                         echo $getStudent->payment_status; } ?></td>
                        
                    <td><?php echo $getStudent->cancellation_date ?></td>

                </tr>
            <?php } endforeach; ?>
                </tbody>
                </table>
            </div>
     </div>
 </div>
 </div>
   </div>
   </div>
<?php }  ?>
   </div>
  </div>
</div>


<!-- <div class="courses view large-9 medium-8 columns content"> -->
<div id="Courses" class="tabcontent">
<div class = 'row'>
    <div class = 'col-lg-12'>
            <div class="ibox-title">   
            <div class="text-right">
            <a href='#' class="btn-sm btn-success" data-toggle="modal" data-target="#registerStudent">Register Student</a>

  <div class="modal fade" id="registerStudent" role="dialog">
    <div class="modal-dialog" style="width: 950px;" >

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" class="white-bg">


        <div class="tabs-container">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1"> Register Existing Student</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">Register New Student</a></li>
            </ul>
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                    <?php 
                    $existingStudentUrl = $this->Url->build(["controller"=>"courses","action" => "addStudentToCourse", $course->id]);
                    ?>
                  <iframe id="registerExisting" height = "500" width = "850" src = "<?= $existingStudentUrl ?>" scrolling="yes" allowfullscreen="false" >
                  </iframe>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                    <?php 
            $newStudentUrl = $this->Url->build(["controller"=>"courses","action" => "register", $course->id]);
                                        //pr($viewUrl);
            ?>
          <iframe id="registerNew" height = "500" width = "850" src = "<?= $newStudentUrl ?>" scrolling="yes" allowfullscreen="false" >
          </iframe>
                        
                    </div>
                </div>
            </div>
        </div>

        </div><!-- MultiTab close -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-danger" data-dismiss="modal" >Close</button>
        </div>
      </div>

    </div>
  </div>
</div>



        <div class="ibox float-e-margins">
            </div> <!-- ibox-title end-->
            <!-- <div class="hr-line-dashed"></div> -->
            <div class="ibox-content">
                <table class="table">
            <div class= "text-center">
        <?php if($loggedInUser['role_id'] != 3) { ?>
            <?php if($course->status != 'closed' && $course->status != 'Cancelled'){ ?>
            <?php if($loggedInUser['role']->name =='tenant'){ ?>
                <!-- <div class="col-sm-2" style="padding-top: 36px;"> -->
                <?=$this->Html->link('Share Course', ['controller' => 'Courses', 'action' => 'transferCourse',$course->id],['class' => ['btn-xs', 'btn-success']])?>
                <!-- </div> -->
            <?php } ?>
            <?php if($loggedInUser['role']->name!='instructor'){ ?>
                <!-- <div class="col-sm-2" style="padding-top: 36px;"> -->
                <?=$this->Html->link('Edit Course Details', ['controller' => 'Courses', 'action' => 'edit',$course->id],['class' => ['btn-xs', 'btn-success']])?>
                <!-- </div> -->
                <?php } }?>
                <!-- <div class="col-sm-2" style="padding-top: 36px;"> -->
                <?php 
                    $viewUrl = $this->Url->build(["controller"=>"courses","action" => "print_roster",$course->id]);
                ?>
                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn-xs btn-primary" data-toggle="modal" data-target="#myModal">
                    <i class="fa fa-print fa-fw"></i>
                    Print Roster
                </a>
                <!-- </div> -->
                <?php if(isset($tenant->tenant_config_settings[0]->card_print) && !empty($tenant->tenant_config_settings[0]->card_print) && $tenant->tenant_config_settings[0]->card_print == 1) {?>
                 <!-- <div class="col-sm-2">    -->
                <?= $this->Form->postLink(__('Process Cards'), ['controller' => 'Courses', 'action' => 'processCards', $course->id],['class' => 'btn-xs btn-success'])?>
                <!-- </div> -->
            <?php } ?>
                <?php  if(!$loggedInUser['role']->id == 5  && !isset($loggedInUser['role'])){ ?>
                <!-- <div class="col-sm-2"> -->
                <?=$this->Html->link('Delete Course', ['controller' => 'Courses', 'action' => 'delete',$course->id],['confirm' => __('Are you sure you want to delete # {0}?'),'class' => ['btn-xs', 'btn-danger']])?>
                <!-- </div> -->
                <?php } ?>
                <?php if($course->status != 'closed' && $course->status != 'Cancelled' && $course->status != 'confirmed'){ ?>
                <?php if($loggedInUser['role']->name!='instructor'){ ?>
                    <!-- <div class="col-sm-2"> -->
                <?=$this->Form->postlink('Cancel Course', ['controller' => 'Courses', 'action' => 'cancel',$course->id],['confirm' => __('Are you sure you want to cancel # {0}?', $course->id),'class' => ['btn-xs', 'btn-danger']])?>
                    <!-- </div> -->
                <?php } }?>

               <!--  <?php  if(!$loggedInUser['role']->id == 5  && !isset($loggedInUser['role'])){ ?> -->
             <!--    <?php } ?> -->
               <?php if($course->status != 'closed' && $course->status != 'Cancelled'&& $course->status != 'confirmed'){ ?>
                <!-- <div class="col-sm-2"> -->
               <?= $this->Form->postLink(__('Close Out Course'), ['controller' => 'Courses', 'action' => 'closeCourse', $course->id], ['confirm' => __('Are you sure you want to close # {0}?', $course->id), 'class'  => ['btn-xs', 'btn-success']])?>
                <!-- </div> -->
               <?php } ?>
                </div>
            <?php } ?>    
                <br>

                    <tr>
                        <th scope="row"><?= __('Visibility') ?></th>
                        <td class="text-center"><?= $course->private_course_flag?'<span class=" fa fa-eye-slash label label-warning">   Private Course</span>':'<span class=" fa fa-eye label label-success">  Public Course</span>' ?></td>
                    </tr>
                    <?php if($course->private_course_flag == true){ ?>
                        <tr>
                             <th scope="row"><?= __('Direct course Link') ?></th>
                             <td>
                             <a target="_blank" href="<?php echo $site;?>students/private_course/?course-hash=<?= $course->private_course_url;?>">
                             <?php echo $site;?>students/private_course/?course-hash=<?= $course->private_course_url;?>
                             </a>
                             </td>
                        </tr>
                    <?php }?>
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?= ($course->corporate_client) ?($course->corporate_client->name) :"No corporate client added"?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                        <td><?= ($course->training_site) ?($course->training_site->name) :"No training site added"?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Type Category') ?></th>
                        <td>
                        <?= ($course->course_type_category) ?($course->course_type_category->name) :"No course type category added"?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Status') ?></th>
                        <td ><?= $course->status  ?></td>
                    </tr>
                    <?php if($loggedInUser['role_id'] != 3){ ?>
                    <tr>
                        <th scope="row"><?=__('Roster') ?></th>
                        <td>
                    <?php if($course && isset($course->document_name) && isset($course->document_path)){?>
                        <a href="<?= h($course->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View Upload</a>
                        <?= $this->Form->postLink(__(''), ['controller'=>'Courses','action' => 'removeRoster', $course->id], ['confirm' => __('Are you sure you want to delete Roster?', $course->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o']]) ?>
                    <?php }else{ ?>
                        <span style="float:left;">
                        <a href='#' class="btn-xs btn-success" data-toggle="modal" data-target="#myModal1">
                        <i class="fa fa-upload fa-fw"></i>
                        Upload Roster</a>
                        </span>
                    <?php }?>
        
                           
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Other Documents') ?></th>
                        <td>
                            <span style="float:left;">
                            <?php 
                                $viewUrl = $this->Url->build(["controller"=>"courseDocuments","action" => "index",$course->id]);
                            ?>
                                <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-upload fa-fw"></i>
                                Upload Documents
                                </a>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Confirmation') ?></th>
                         <td >
                    <?php if($course && isset($course->notes)){?>
                        <div> 
                            <label type="label" class="btn-xs btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $course->notes ?>" data-original-title="">Confirmed</label>
                        </div>
                    <?php } else { ?>
                        <a href='#' class="btn-xs btn-success" data-toggle="modal" data-target="#myModal2">Confirm With Notes</a>
                    <?php } ?>

                    </td>
                    </tr>
                <?php } ?>
                    <tr>
                        <th scope="row"><?= __('Course Type') ?></th>
                        <td><?= $course->course_type->name?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('# Of Days') ?></th>
                        <td><?= h($course->duration) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Date') ?></th>
                        <td>
                            <?php 
                            if(isset($course->course_dates) && !empty($course->course_dates)){
                                foreach ($course->course_dates as $date): 
                                    echo $date->course_date."<br>";
                                endforeach;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Time') ?></th>
                        <td>
                            <?php 
                            if(isset($course->course_dates) && !empty($course->course_dates)){
                                foreach ($course->course_dates as $date): ?>
                                    <!-- echo $date->time_from."-".$date->time_to."<br>"; -->
                            <?= $this->Time->format($date->time_from, \IntlDateFormatter::FULL, null) ?>
                                <?php endforeach;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Location') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->city:'-'?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Location Contact') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->contact_name:''?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Location Notes') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->notes:''?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->address:''?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City,State,Zip') ?></th>
                        <td>
                        <?= isset($course->location) && $course->location?$course->location->city:''?>,<?= isset($course->location) && $course->location?$course->location->state:''?>,<?= isset($course->location) && $course->location?$course->location->zipcode:''?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->contact_phone:''?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= isset($course->location) && $course->location?$course->location->contact_email:''?></td>
                    </tr>
                    <?php if(isset($tenant->tenant_config_settings[0]->instructor_bidding) && !empty($tenant->tenant_config_settings[0]->instructor_bidding) && $tenant->tenant_config_settings[0]->instructor_bidding == 1) {?>
                    <tr>
                        <th scope="row"><?= __('Instructor Bidding') ?></th>
                        <td><?= $course->instructor_bidding? 'Yes'." (".$course->bidding_number.")" :'No' ?></td>
                    </tr>
                <?php }?>
                    <tr>
                        <th scope="row"><?= __('Instructor') ?></th>
                        <td>
                        <?php 
                        if(isset($course->course_instructors) && !empty($course->course_instructors)){
                        foreach ($course->course_instructors as $getInstructor) :
                            if($getInstructor->status == 1){
                        ?>
                            <p>
                                    <?php  if($course->added_by == 'instructor' && $course->owner_id != $getInstructor->instructor->id){
                                    continue; } ?>
                                <a class="btn btn-xs btn-white">
                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <span class="badge badge-primary">
                                Accepted On: <?php echo $getInstructor->modified;?>
                                </span>
                               <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-danger" onclick = "declineCourseByTenant(<?= $getInstructor->course_id ?>,2,<?= $getInstructor->instructor->id?>)">Decline</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-danger " onclick = "declineCourseByInstructor(<?= $getInstructor->course_id ?>,2,<?= $getInstructor->instructor->id?>)">Decline</span>
                               <?php } ?>
                            </p>
                        <?php }else if($getInstructor->status == 2){
                        ?>
                            <p>
                                    <?php  if($course->added_by == 'instructor' && $course->owner_id != $getInstructor->instructor->id){
                                    continue; } ?>
                                <a class="btn btn-xs btn-white">
                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <span class="badge badge-danger">
                                Declined On: <?php echo $getInstructor->modified;?>
                                </span>
                                <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByTenant(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByInstructor(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                               <?php } ?>
                            </p>
                        <?php }else if($getInstructor->status == null){ ?>
                            <?php   if(empty($getInstructor->instructor_id) || is_null($getInstructor->instructor_id)) { 
                                    ?>
                            <p>
                                <span class='badge badge-danger'>Instructor Pending</span>
                            </p>
                            <?php }else {?>
                            <p>
                                   <?php  if($course->added_by == 'instructor' && $course->owner_id != $getInstructor->instructor->id){
                                    continue; } ?>
                                <a class="btn btn-xs btn-white">

                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <?php if(isset($course) && !empty($course) && $course->full != 1 ) {    ?>
                                <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByTenant(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByInstructor(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                               <?php } ?>
                                    
                               <?php } ?>
                            </p>
                        <?php } ?>
                        <?php }
                        endforeach;
                        }?>
                        </td>
                    </tr>
                    <?php if($course->added_by == 'instructor'){  ?>
                    <tr>
                        <th scope="row"><?= __('Course Assistant(s):') ?></th>
                        <td>
                            <?php 
                        if(isset($course->course_instructors) && !empty($course->course_instructors)){
                        foreach ($course->course_instructors as $getInstructor) :
                            if($getInstructor->status == 1){
                        ?>
                            <p>
                                <a class="btn btn-xs btn-white">
                                    <?php  if($course->added_by == 'instructor' && $course->owner_id == $getInstructor->instructor->id){
                                    continue; } ?>
                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <span class="badge badge-primary">
                                Accepted On: <?php echo $getInstructor->modified;?>
                                </span>
                                 <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-danger" onclick="declineCourseByTenant(<?= $getInstructor->course_id ?>,2,<?= $getInstructor->instructor->id?>)">Decline</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-danger " onclick = "declineCourseByInstructor(<?= $getInstructor->course_id ?>,2,<?= $getInstructor->instructor->id?>)">Decline</span>
                               <?php } ?>
                            </p>
                        <?php }else if($getInstructor->status == 2){
                        ?>
                            <p>
                                <a class="btn btn-xs btn-white">
                                    <?php  if($course->added_by == 'instructor' && $course->owner_id == $getInstructor->instructor->id){
                                    continue; } ?>
                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <span class="badge badge-danger">
                                Declined On: <?php echo $getInstructor->modified;?>
                                </span>
                                <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByTenant(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByInstructor(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                                <?php } ?>
                            </p>
                        <?php }else if($getInstructor->status == null){ ?>
                            <p>
                                   <?php  if($course->added_by == 'instructor' && $course->owner_id == $getInstructor->instructor->id){
                                    continue; } ?>
                                <a class="btn btn-xs btn-white">

                                <?php echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name;?>
                                </a>
                                <?php if(isset($course) && !empty($course) && $course->full != 1) { ?>
                                    <?php if($loggedInUser['role']->name == 'tenant'){  ?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByTenant(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                                <?php }elseif($loggedInUser['role']->name == 'instructor' && $loggedInUser['id'] == $getInstructor->instructor_id){?>
                                    <span class="badge badge-primary" onclick = "acceptCourseByInstructor(<?= $getInstructor->course_id ?>,1,<?= $getInstructor->instructor->id?>)">Accept</span>
                               <?php } ?>
                                <?php } ?>
                            </p>
                        <?php }
                        endforeach;
                        }?>
                        </td>
                    </tr>
                <?php } ?>
                    
                    <tr>
                        <th scope="row"><?= __('Instructor Pay') ?></th>
                        <td><?php if($course->instructor_pay){ ?>$<?= h($course->instructor_pay)?> <?php }?></td>
                    </tr>
                    <?php if(isset($course->additional_pay) && !empty($course->additional_pay)){?>
                    <tr>
                        <th scope="row"><?= __('Additional Pay') ?></th>
                        <td>$<?= h($course->additional_pay) ?></td>
                    </tr>
                    <?php }?>
                    <tr>
                        <th scope="row"><?= __('Cost') ?></th>
                        <td>$<?= h($course->cost) ?></td>
                    </tr>

                    <tr>
                        <th scope="row"><?= __('Course Addons') ?></th>
                        <td>
                        <?php 
                        if(isset($course->course_addons) && !empty($course->course_addons) ) {
                            foreach ($course->course_addons as $addons) {
                                if($addons->addon){
                                    echo $addons->addon->name.'<br/>';
                                }else{
                                    echo "No Addons Added";
                                }
                            }
                        }
                        ?>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><?= __('AV Information:') ?></th>
                        <td>
                        <?php 
                        echo 'Provided By: Client'.'<br>';
                        echo 'Display Type: Television'.'<br>'; 
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Total Seats') ?></th>
                        <td><?= $this->Number->format($course->seats) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Remaining Seats') ?></th>
                        <td>
                        <?php if($remSeats == 0) {
                            echo "No seats are remaining for this course!"; } else { ?>
                        <?= $this->Number->format($remSeats) ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Waitlisted Seats') ?></th>
                        <td><?= $this->Number->format($waitlistedStudents) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Class Details') ?></th>
                        <td><?= $course->class_details ?></td>
                    </tr>

                    <tr>
                         <th scope="row"><?= __('Notes To Instructor') ?></th>
                         <td><?=   $this->Text->autoParagraph($course->instructor_notes)   ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Admin Notes') ?></th>
                        <td><?= $course->admin_notes ?></td>
                    </tr>
                    
            </table>
            
        </div> <!-- ibox-content end -->
    </div> <!-- ibox end-->
</div><!-- col-lg-12 end-->
</div> <!-- row end-->
</div>

    <div class="modal fade" id="promoCodeModal" role="dialog">
    <div class="modal-dialog" style="width: 950px;" >
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body" class="white-bg">
                <table class="table">
                    <input type="hidden" name="course_student_id" id="courseStudentAddon" value="">
                    <tr>
                        <th scope="row"><?= ('Enter PromoCode :'); ?> </th>
                        <td><input id="promoCode" type="text"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <input type="button" id="promoCodeForStudent" class="btn btn-small btn-primary" value="Apply"> 
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>

<div class="modal fade" id="addonModal" role="dialog">
<div class="modal-dialog" style="width: 950px;" >
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" class="white-bg">
            <legend><?= __('Course Addons') ?></legend>
                    <strong>15-1010 | 2015 AHA BLS Student Manual |</strong></br>
                    <p><strong>Students are <u>required</u> to purchase a manual or bring a previously purchased 2015 manual to class. Purchased books will be made available at the class or can be picked up at our office Monday - Friday.</strong></p>
            <table class="table">
                <input type="hidden" name="student_id" id="studentAddon" value="">
                <input type="hidden" name="course_student_id" id="couseStudentAddon" value="">
                    <?php 
                    if(isset($course->course_addons) && !empty($course->course_addons)){
                    foreach($course->course_addons as $key => $getAddons){ ?>
                <tr>
                    <th scope="row"><?=  $getAddons->addon->name ?> <br><?="( "." $ ". $getAddons->addon->price." )" ; ?> </th>
                    <td>
                        <input type="radio" name="addon_radio_<?php echo $key?>" value="yes" data-addonid = "<?php echo $getAddons->addon->id?>" class = "addOnRadio" onclick="addAddon('<?php echo $getAddons->addon->id?>','<?php echo $getAddons->addon->price?>',0)">
                        <label for="yes_<?php echo $getAddons->addon->id?>" >Add</label>
                        <input type="radio" name="addon_radio_<?php echo $key?>" value="no" checked data-addonid = "<?php echo $getAddons->addon->id?>" class = "addOnRadio" onclick="removeAddon('<?php echo $getAddons->addon->id?>','<?php echo $getAddons->addon->price?>')">
                        <label for="no_<?php echo $getAddons->addon->id?>">Don't add</label>
                    </td>
                </tr>
                    <?php } }?>
            </table>
        </div>
        <div class="modal-footer">
            <input type="button" id="addonforStudent" class="hide-modal btn btn-small btn-primary" value="Save">
            <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>


<div class="modal fade" id="cancelModal" role="dialog">
<div class="modal-dialog" style="width: 950px;" >

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" class="white-bg">
            <legend><?= __('Cancel Student With Refund') ?></legend>
            <table class="table">
                     <tr>
                        <th scope="row"><?= __('Amount available for refund:') ?></th>
                        <td id = "course-cost"></td>
                     </tr>
                     <tr>
                        <th scope="row"><?= __('Amount To Refund ($) :') ?></th>
                        <td><input type="number" name="amount" id="amount"></td>
                     </tr>
              <input type="hidden" name="student_id" id="studentId" value="">
              <input type="hidden" name="course_student_id" id="courseStudentId" value="">
              <input type="hidden" name="course_id" id="courseId" value="">
            </table>
        </div>
        <div class="modal-footer">
            <input type="button" id="cnrStudent" class="btn btn-small btn-primary" value="Submit">
            <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

 <div class="modal fade" id="myModal2" role="dialog">
<div class="modal-dialog" style="width: 950px;" >

    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" class="white-bg">
            <div class="courses form large-9 medium-8 columns content">
                <?= $this->Form->create($course,['url' => ['controller' => 'Courses','action' => 'notes'],'class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                <fieldset>
                        <legend><?= __('Upload Notes') ?></legend>
                        
                        <div class="form-group">
                            <?= $this->Form->label('notes', __(' '), ['class' => ['col-sm-2 ', 'control-label']]) ?>
                            <div class="col-sm-10">
                                
                                <?= $this->Form->control('notes', ['type'=>'textarea','label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                            </div>
                        </div>
                </fieldset>
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-6">
                            <?= $this->Form->button(__('Confirm Course')) ?>

                        </div>  
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
        </div>

    </div>
</div>
</div>

<div class="modal fade" id="myModal1" role="dialog">
<div class="modal-dialog" style="width: 950px;" >

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"></h4>
  </div>
  <div class="modal-body" class="white-bg">
    <div class="ibox-content">
            <div class="courses form large-9 medium-8 columns content">
            <?php echo $this->Form->create($course, ['type' => 'file','url' => ['controller'=>'Courses','action' => 'roster',$course->id]]); ?>
            
           <!--  <form class="form-horizontal" method="post" accept-charset="utf-8" multipart="" action="/courses/roster/<?php echo $course->id?>" enctype="multipart/form-data"> -->

                <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Upload Roster') ?></legend>
                        
                        <div class="form-group">
                            <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                 <!-- <a href="<?php echo $course->document_path.'/'.$course->document_name;?>"></a> -->
                                <?= $this->Html->image($course->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                </div> 
                                <br> </br>
                                <?= $this->Form->control('document_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </div>
                </fieldset>
                <div class="form-group">
                <div class="row">
                <div class="col-sm-6">
                <?= $this->Form->button(__('Save Roster')) ?>
                </div>  
                </div>

                <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
  </div>
</div>

</div>
</div>







<style type= "text/css">
body {font-family: Arial font-color: #ffffff;}

/* Style the tab */
.tab {
    overflow: hidden;
/*    border: 1px solid #ccc;*/
    background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    float: center;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #0aa880;
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    -webkit-animation: fadeEffect 1s;
    animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}

@keyframes fadeEffect {
    from {opacity: 0;}
    to {opacity: 1;}
}
</style>




<script type="text/javascript">
$('#registerStudent').on('hidden.bs.modal', function () {
 location.reload();
})

</script>


<script type="text/javascript">

$(function () {

    var output = '';

$('#select_all').on('change', function () {

    if ($('#select_all').is(':checked')) {
        $("input[id^='ad_Checkbox']").prop('checked', true);
    } else {
        $("input[id^='ad_Checkbox']").prop('checked', false);
    }
    output = $.map($('input:checkbox[name^=mychecklist]:checked'), function (n, i) {
        return n.value;
    }).join(',');
});

$('#allpassed').on('click', function () {

      var output = $('input[type=checkbox]:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');
    console.log(output);
    courseStudentBulkStatusUpdate(output, 'allpassed');
});
$('#allfailed').on('click', function () {

    var output = $('input[type=checkbox]:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');
    console.log(output);
    courseStudentBulkStatusUpdate(output, 'allfailed');
});
$('#allabsent').on('click', function () {

    var output = $('input[type=checkbox]:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');
    console.log(output);
    courseStudentBulkStatusUpdate(output, 'allabsent');
});
$('#allincomplete').on('click', function () {

    var output = $('input[type=checkbox]:checked').map(function(_, el) {
        return $(el).val();
    }).get().join(',');
    console.log(output);
    courseStudentBulkStatusUpdate(output, 'allincomplete');
});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.hide-modal').click(function(){
        $('#addonModal').modal('hide');
    }); 
});
</script>

<script type="text/javascript">

function addPromoCode(cid, sid){
    $("#courseId").val(cid);
    $("#studentId").val(sid);
    $("#promoCode").val();
}
$(document).ready(function() {
    // $('#promoCodeModal').show();
    $("#promoCodeForStudent").click(function(){
        var promoCode = $("#promoCode").val();
        // console.log(promoCode);
        var studentId = $("#studentId").val();
        // console.log(studentId);
        // console.log(sid);
        var courseId = '<?= $id ?>'
        jQuery.ajax({
            url: host+"api/students/promocode1/?request="+promoCode+'&courseId='+courseId+'&studentId='+studentId,
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {'promoCode':promoCode,
                  },
            type: "get",
            success: function (result) {
                console.log(result);
                if(result.status == true){

                    document.getElementById('waitlistedTotalPrice_'+studentId).innerHTML = 'Total: $' +result.response[studentId].finalAmount;
                    document.getElementById('waitlistedTotalBalance_'+studentId).innerHTML = 'Total: $' +result.response[studentId].finalAmount;
                    $('#promoCodeModal').modal('toggle');
                    document.getElementById('waitlistedPromoCode_'+studentId).innerHTML = '<td><center><i class="fa fa-check"></i></center></td>'
                    // document.getElementById('waitlistedTotalBalance_'+studentId).innerHTML = 'Total: $' +result.response[studentId].finalAmount;
                    swal({title: "Done", text: "PromoCode applied succesfully!", type: "success"});
                }
                
            },
            error: function(error){
                swal({title: "Oops..", text: "PromoCode could not be applied.", type: "error"});
            }
        });
    });     
});
</script>

<script type="text/javascript">

function addAddon(stid, csid){
    $("#studentAddon").val(stid);
    $("#couseStudentAddon").val(csid);
}   

$(document).ready(function() {
    var host = $('#baseUrl').val();
    $("#addonforStudent").click(function(){
    var addonStudentId = $("#studentAddon").val();
    var addonCourseStudentId = $("#couseStudentAddon").val();     
    var checkedRadios = [];

    $(".addOnRadio").each(function() {
      console.log('addon ID');
      var aId = $(this).data('addonid');
      console.log(aId);
      if(this.value == "yes" && this.checked == true)
      {
        checkedRadios.push(aId);     
      }
    });

    var courseId = '<?= $id ?>';
    console.log('bob');
     jQuery.ajax({
            url: host+"api/courses/addAddonForStudent/",
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {
                'student_id': addonStudentId,
                'course_id' : courseId,
                'addon_ids' : checkedRadios,
                'course_student_id' : addonCourseStudentId,
                
                  },
            type: "POST",
            success: function (result) {
                console.log('result');
                document.getElementById('waitlistedTotalPrice_'+addonStudentId).innerHTML = 'Total: $' +result.response[addonStudentId].finalAmount;
                    document.getElementById('waitlistedTotalBalance_'+addonStudentId).innerHTML = 'Total: $' +result.response[addonStudentId].finalAmount;
                if(result.response[addonStudentId].status == 'add'){
                    swal({title: "Done", text: "Course Addons succesfully added!", type: "success"});         
                }else{
                    swal({title: "Done", text: "Course Addons succesfully removed!", type: "success"});
                }
            },
            error: function(result){
                swal({title: "Oppss..", text: "Error while adding Course Addons.", type: "error"});
            }
        });
    });
});

</script>
<script type="text/javascript">

function studentSkill(csid, elem){
    var selectedSkill = elem.selectedIndex;
    // alert(x);
    // alert(csid);
    jQuery.ajax({
            url: host+"api/courses/updateSkill/",
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {
                'skill': selectedSkill,
                'course_student_id' : csid,
                  },
            type: "POST",
            success: function (result) {
                swal({title: "Done", text: "Details updated", type: "success"});
                $('#cancelModal').on('hidden.bs.modal', function () {
                location.reload();
                })
                
            }
        });

}
</script>

<script type="text/javascript">
function sendMail(studentId, courseId ){
    // alert(studentId);
   jQuery.ajax({
            url: host+"api/courses/sendMailToStudent/",
            headers:{"accept":"application/json"},
            dataType: 'json',
           data: {
                'student_id' : studentId,
                'course_id' : courseId, 
                  },
            type: "POST",
            success: function (result) {
                swal({title: "Done", text: "Mail sent succesfully!", type: "success"});
                
                
            }
        });
}
</script>

<script type="text/javascript">

$(document).ready(function(){
    $(".testscore").keyup(function(){
        var testScore = $(this).val();
        var courseStudentId = $(this).data("csid");
         jQuery.ajax({
            url: host+"api/courses/updateTestScore/",
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {
                'test_score' : testScore,
                'course_student_id' : courseStudentId, 
                  },
            type: "POST",
            success: function (result) {
                $('#cancelModal').on('hidden.bs.modal', function () {
                location.reload();
                })
                
            }
        });

    });
});
</script>

<script type="text/javascript">
// $('#cancelStudent_48_1').on('click', function () {
    var totalpayment = <?php echo json_encode($totalPayment); ?>;
function cancelStudent(sid, csid,cid) {
    console.log(totalpayment);
    console.log(sid);
    console.log(cid);
    console.log('here');
        document.getElementById('course-cost').innerHTML = '$' +totalpayment[sid]['paidAmount'];
    var cancelled = $("#cancelStudent_"+sid+csid+cid);
    $("#studentId").val(sid);
    $("#courseStudentId").val(csid);
    $("#courseId").val(cid);
    

}
$(document).ready(function() {
    // var totalpayment = '<?php echo json_encode($paymentData); ?>';

    // console.log(totalpayment);
    // console.log('totalpayment');
    // console.log('complex');
    $("#cnrStudent").click(function(){
        var getStudentId = $("#studentId").val();
        var getCourseStudentId = $("#courseStudentId").val();
        var getCourseId = $("#courseId").val();
        console.log(getCourseId);
        console.log('getCourseId');
        // alert(getStudentId);
        var amount = $('#amount').val();
        var courseId='<?= $id ?>';
        // alert(courseId);
        jQuery.ajax({
            url: host+"api/courses/cancelandrefundStudent/"+courseId,
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {
                'student_id': getStudentId,
                'course_id': getCourseId,
                'course_student_id' : getCourseStudentId,
                'refund_amount' : amount,
                  },
            type: "POST",
            success: function (result) {
                swal({title: "Done", text: "Details updated", type: "success"});
                $('#cancelModal').on('hidden.bs.modal', function () {
                location.reload();
                })
                
            }
        });
    });
});
    
</script>


<script type ='text/javascript'>
// var allpassed= $('#allpassed').val();     
var host = $('#baseUrl').val();
// alert(host);




function passedStatus(csi){
    var passed= $("#passed_"+csi).val();
    
    var elementId = $( "#passed_"+csi ).attr( "id" );
    courseStudentStatusUpdate(1,csi,elementId);
}
function failedStatus(csi){
    var failed= $("#failed_"+csi).val();
    // alert(failed);
    // alert(csi);
    var elementId = $( "#failed_"+csi ).attr( "id" );
    courseStudentStatusUpdate(2,csi,elementId);
}
function absentStatus(csi){
    var absent= $("#absent_"+csi).val();
    // alert(absent);
    // alert(csi);
    var elementId = $( "#absent_"+csi ).attr( "id" );
    courseStudentStatusUpdate(3,csi,elementId);
}
function incompleteStatus(csi){
    var incomplete= $("#incomplete_"+csi).val();
    // alert(incomplete);
    // alert(csi);
    var elementId = $( "#incomplete_"+csi ).attr( "id" );
    courseStudentStatusUpdate(4,csi,elementId);
}

function courseStudentBulkStatusUpdate(output, action){
    // console.log('output nik');
    console.log(output);
    var courseId='<?= $id ?>';

    swal({
        title: "Are you sure you want to update details for these students?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    },
    function(){
        jQuery.ajax({
            url: host+"api/courses/bulkStatusUpdate/"+action+"/"+courseId,
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {'ids': output},
            type: "POST",
            success: function (result) {
                   
                    swal({title: "Done", text: "Details updated", type: "success"});
                    document.location.reload()
                },
                error: function(result) {
                    swal('An error occured');
                }
            });

     })
      
}



function courseStudentStatusUpdate(status,csi,elementId){


    swal({
        title: "Are you sure you want to update Details for this student",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    },
    function(){
        jQuery.ajax({
                url: host+"api/courses/updateStatus/",
                headers:{"accept":"application/json"},
                dataType: 'json',
                data: {
                  "course_status" : status, 
                  "course_student_id" : csi, 
                },
                type: "POST",
                success: function (result) {
                    var status = result.response.status;
                    $('#'+elementId).parent().children('input').removeClass('btn-success');
                    $('#'+elementId).addClass('btn-success');
                    swal({title: "Done", text: "Details updated", type: "success"});
                },
                error: function(result) {
                    swal('An error occured');
                }
            });
    })
}

</script>


<script type ='text/javascript'>

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

function openCity(evt, cityName) {
    // alert(evt);
    // alert(cityName);
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

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
