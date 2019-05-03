<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;
$sitePath = Configure::read('fileUpload');
$site = Router::url('/', true);
// pr($trainingSites);die();
// pr($course);die();


$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-0" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
?>
    
<div class="row">
    <div class="col-lg-12">
        <div class="ibox product-detail">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-md-9">
                      <h2 class="font-bold m-b-xs">Course Details</h2>
                      <h2 class="font-bold m-b-xs">Course #<?php echo $course->id;?></h2>
                      <div class="media-body">
                            <strong>Course Status : </strong> 
                              <span class="badge badge-danger">
                                  <?php echo $course->status;?>
                                </span></br>
                            <strong>Instructor Name : 
                        <?php if(isset($course->course_instructors) && !empty($course->course_instructors)){
                        foreach ($course->course_instructors as $getInstructors) {
                          echo $getInstructors->Instructors['first_name']." ".$getInstructors->Instructors['last_name'].'<br>';
                        }
                      }?>
                         </strong> </br>

                            <address>
                              <strong>Address</strong><br>
                              <?php echo $course->location->address;?><br>
                              <?php echo $course->location->city;?>, <?php echo $course->location->state;?> <?php echo $course->location->zipcode;?><br>
                              <abbr title="Phone">P:</abbr> <?php echo $course->location->contact_phone;?>
                          </address>
                          
                          <h2 class="font-bold m-b-xs">Notes</h2>
                          <div class="well">
                                <h3> Location Notes: </h3>
                                <?php echo $course->additional_notes;?>
                            </div>
                            <div class="well">
                                <h3> Notes to Instructor: </h3>
                                <?php echo $course->instructor_notes;?>
                            </div>
                          <div class="well"> 
                            <div class="text-right">
                          </div>
                                <h3> Instructor Notes to Admin: <span onclick="editNote(<?= $course->id;?>)" class="btn btn-danger btn-xs m-b pull-right"><i class="fa fa-pencil"></i></span></h3>
                           
                                <p id="hideWhenEdit" onclick="editNote(<?= $course->id;?>)"><?php echo $course->admin_notes;?></p>
                              <div id="updateInstructorNotes">
                                <?= $this->Form->create($course, ['data-toggle' => 'validator']) ?>
                                 <?= $this->Form->control('admin_notes', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control']]); ?>
                                  <?= $this->Form->button(__('Submit')) ?>
                                  
                                  <span class="btn btn-danger m-b col-sm-offset-1"" onclick="cancelEdit()">Cancel</span>
                                <?= $this->Form->end() ?>
                              </div>
                            </div>

                            <p>

                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#registerStudent">Register Student</button>

                            <?php if($course && isset($course->document_name) && isset($course->document_path)){?>

                            <a href="<?= $sitePath.h($course->document_path) ?>/<?= h($course->document_name) ?>" class="btn btn-sm btn-success" target="_blank">View Uploaded Roster</a>

                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteRoster(<?= $course->id;?>)">Delete Class Roster</button>

                         <!-- <?= $this->Form->postLink(__('Delete Class Roster'), ['controller'=>'courses','action' => 'removeRoster', $course->id], ['confirm' => __('Are you sure you want to delete Roster?', $course->id), 'class' => ['btn', 'btn-sm', 'btn-danger']]) ?> 
 -->
                            <?php }else {?>

                            <button data-toggle="modal" data-target="#uploadRoaster" type="button" class="btn btn-sm btn-warning"><i class="fa fa-upload fa-fw"></i>Upload Class Roster</button>

                            <?php } ?>

                            <button type="button" class="btn btn-sm btn-primary">Mark Course as Completed</button>
                            <?php if($course && isset($course->notes)){?>
                             <label type="label" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="<?php echo $course->notes ?>" data-original-title="">Course Confirmed</label>
                            <?php } else { ?>
                            <button data-toggle="modal" data-target="#addNotes" type="button" class="btn btn-sm btn-info">Add Class Notes</button>
                            <?php } ?>
              
                      <?php $printRoasterUrl = $this->Url->build(["controller"=>"courses","action" => "print_roster",$course->id]);?>
                            <button onclick='openViewPopUp("<?= $printRoasterUrl ?>", "View User")' type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-print fa-fw"></i>Print Roster</button>
                          </p>

                          <?php if($course->private_course == true){ ?>
                          <strong>Private Course : </strong> <a target="_blank" href="<?php echo $site;?>courses/private_course/?course-hash=<?= $course->private_course_url;?> "><?php echo $site;?>courses/private_course/?course-hash=<?= $course->private_course_url;?></a>
                          <?php }?>
                          </br>
                          
                          
                          
                        </div>
                    </div>
                    <div class="col-md-3">
                        <h2 class="font-bold m-b-xs">Class Overview</h2>
                        <div class="media-body">
                            <strong>Class Date : </strong> <?php echo $courseDate->course_date ?> </br>
                            <strong>Course Time : </strong> <?php echo $courseDate->time_from->format('H:i A') .' - '.$courseDate->time_to->format('H:i A') ?></br>
                            <strong>Course Capacity : </strong> <?php echo $course->seats?> </br>
                            <strong>No of Students Registered : </strong> <?php echo $course->seats?> </br>
                            <strong>Remaining Seats : </strong> <?php echo $course->seats?> </br>
                            <strong>Contact Name : </strong> <?php echo $course->location->contact_name?> </br>
                            <strong>Contact Phone : </strong> <?php echo $course->location->contact_phone?> </br>
                            <strong>Fee to Instructor : </strong> <?php echo '$'.$course->instructor_pay?></br>
                            <strong>Instructor Support : </strong> 
                            <?php if(isset($course->training_site) && !empty($course->training_site)) { ?>
                            <?php echo $course->training_site->contact_email ?>
                            <?php } else {
                              echo "No data exists";
                              } ?>
                             </br>
                            <strong>Co-Instructor : </strong> Instructor Data </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Register student modal -->
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
                  <iframe id="registerExisting" height = "500" width = "900" src = "<?= $existingStudentUrl ?>" scrolling="yes" allowfullscreen="false" >
                  </iframe>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane">
                    <div class="panel-body">
                    <?php 
            $newStudentUrl = $this->Url->build(["controller"=>"courses","action" => "register", $course->id]);
                                        //pr($viewUrl);
            ?>
          <iframe id="registerNew" height = "500" width = "900" src = "<?= $newStudentUrl ?>" scrolling="yes" allowfullscreen="false" >
          </iframe>
                        
                    </div>
                </div>
            </div>
        </div>
        </div><!-- MultiTab close -->
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-danger" data-dismiss="modal" ?>Close</button>
        </div>
      </div>

    </div>
  </div>


<!-- upload roaster document -->
<div class="modal fade" id="uploadRoaster" role="dialog">
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
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Upload Roster') ?></legend>
                            
                            <div class="form-group">
                                <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
                                <div class="col-sm-4">
                                    <div class="img-thumbnail">
                                    <?= $this->Html->image($course->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                    </div> 
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

<!-- Course Notes -->
<div class="modal fade" id="addNotes" role="dialog">
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
                    <?= $this->Form->create($course,['url' => ['controller'=>'Courses','action' => 'notes',$course->id],'class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Upload Notes') ?></legend>
                            
                            <div class="form-group">
                                <?= $this->Form->label('notes', __(' '), ['class' => ['col-sm-2 ', 'control-label']]) ?>
                                <div class="col-sm-10">
                                    
                                    <?= $this->Form->control('notes', ['type'=>'textarea','label' => false, 'class' => ['form-control','tinymceTextarea','disabled']]); ?>
                                </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
</div>


<!-- <?= $course->id?>."QQQQQQQQQQQ"; -->
<script type="text/javascript">
$(document).ready(function(){
  
   $('#updateInstructorNotes').hide();
});

function editNote(courseId) {
  $('#hideWhenEdit').hide();
  $('#updateInstructorNotes').show();


}
function cancelEdit() {
  $('#hideWhenEdit').show();
  $('#updateInstructorNotes').hide();


}

var host = $('#baseUrl').val();  

/*This function is to accept the course by instructor*/
function deleteRoster(courseId) {
  swal({
        title: "Are you sure you want to delete this Roster?",
        // text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
    
    $.ajax({
      method: "PUT",
      url: host+"api/courses/removeRoster/"+courseId,
      headers:{"accept":"application/json"},
      contentType: "application/json",
      // data:'{"status":'+status+',"instructor_id":'+instructorId+'}',
    })
    .success(function(data){
      console.log(data);
      swal({title: "Done", text: "Roster Deleted", type: "success"},
          function(){ 
             location.reload();
          }
      );
    });

  });
}
</script>
<script type = "text/javascript">
var host = $('#baseUrl').val();
var courseId = "<?= $course->id ?>";
$("#registerStudent").on("hidden.bs.modal", function () {
    window.location = host+"courses/view/"+courseId;
});
</script>