<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                
  	            <div class="courses form large-9 medium-8 columns content">
  	                <fieldset>
                      <input type="text" name="uuid" id="uuidinput" class="col-sm-6" placeholder="Enter Tenants's unique ID">
                      <div class="col-sm-2">
                        <button class="btn btn-primary col-sm-12" type="submit" onclick="verifyUuid()">Verify Unique ID</button>
                      </div>
  	                
  	    			      </fieldset>
  	            </div>
                <br>
                <div id="tenantinfo">
                    <table class="table table-striped table-bordered table-hover dataTables1">
                        <thead>
                          <tr>
                            <th scope="col" name="center-name">Center Name</th>
                            <th scope="col" name="center-email">Center Email</th>
                            <th scope="col" class="actions"><?= __('Assign') ?></th>
                          </tr>
                        </thead>
                        <tbody >
                          <td id="tabledata0"></td>
                          <td id="tabledata1"></td>
                          <td class="actions" id="tabledata2"></td>
                        </tbody>
                    </table>
                </div>
                <div>
                <div class = 'ibox-title'>
                  <h3><?= __('Shared History') ?></h3>
                </div>
                     <table class="table table-striped table-bordered table-hover dataTables1">
                        <thead>
                          <tr>
                            <th scope="col" name="center-name">Center Name(Email)</th>
                            <th scope="col" name="Date">Created</th>
                            <th scope="col" name="Date">Actions</th>


                          </tr>
                        </thead>
                        <tbody >
                          <?php 
                            foreach ($transferCourse as $value) {
                              // pr($value);die;
                          ?>

                          <tr>
                            <td><?= $value->tenant->center_name.'('.$value->tenant->email.')' ?></td>
                            <td><?= $value->created ?></td>
                            <td>
                              <?php if($value->status == null){ ?>

                                  <p>

                                   <span class="badge badge-warning">Pending</span>
                                   <i class="btn btn-primary fa fa-envelope" style="margin-left: 1em;" onclick="resendMail(<?= $value->tenant->id ?>,<?= $value->course_id ?>)"></i>
                                  </p>
                                  <!-- <?php pr($value->tenant->id) ?> -->

                                     
                                <?php
                                }else{
                                    if($value->status == 1){ ?>
                                  <p>

                                    <span class="badge badge-primary">Accepted</span>
                                    Accepted:<?php echo $value->modified;?>
                                    <?php if($value->access_revoked == 0){  ?>
                                    <?= $this->Form->postLink('Revoke Access', [ 'controller' => 'Courses', 'action' => 'revokeCourseAccess',$value->id],['confirm' => __('Are you sure you want to revoke access of course # {0}?', $value->course_id) ,'class' => ['btn-xs', 'btn-danger']])?>
                                  <?php }else{   ?>
                                       <?= $this->Form->postLink('Undo', ['controller' => 'Courses', 'action' => 'revokeCourseAccess',$value->id],['confirm' => __('Are you sure you want to revoke access of course # {0}?', $value->course_id) ,'class' => ['btn-xs', 'btn-warning']])?>
                                      <span class="badge badge-danger">Access Revoved</span>
                                  <?php } ?>


                                  </p>
                                   <?php }else{ ?>
                                  <p>
                                    <span class="badge badge-danger">Declined</span>
                                    Declined:<?php echo $value->modified;?>
                                  </p>

                                    <?php } ?> 
                               <?php } ?>
                                
                              
                            </td>
                          </tr>

                          <?php
                            }
                          ?>
                        </tbody>
                    </table>
                    
                </div>
        	  </div>
        </div>
    </div>
</div>
    
<script type="text/javascript">

$(document).ready(function() {
   $('#tenantinfo').hide();
});


function  verifyUuid(){
// console.log('clicked');
var uuid = $('#uuidinput').val();
console.log(uuid);
jQuery.ajax({
        type: "GET",
        url: host+"api/courses/verifyTenantUuid/?request="+uuid,
        headers:{"accept":"application/json"},
        dataType: 'json',
        data: {
                'uuid' : uuid,
                  },
        type: "post",
        success: function (result) {
          if(result.status == 0 && (typeof result.reason !== 'undefined')){
                swal({
                        type: 'error',
                        title: result.reason
                    })
          }else{
                // console.log(result);  
                $('#tenantinfo').show(); 
                $('#tenantdata').hide();
                $('#tabledata0').html('');
                $('#tabledata1').html('');
                $('#tabledata2').html('');

                  var url = window.location.href;
                  var temp = url.split("/");
                  var id = temp[temp.length - 1]
                  console.log(origin+'/courses/transfer-course/'+id+'/'+result.response.uuid);
                // $.each(result.response,function(i, value){
                  $('#tabledata0').append(result.response.center_name);
                  $('#tabledata1').append(result.response.email);
                  $('#tabledata2').append('<i class="btn btn-primary fa fa-check" onclick="assignTenant()"></i><i class="btn btn-danger fa fa-times" onclick="removeTenant()"></i>');

                  // $('#tenantdata').show();
                // });

          }
        },
        error: function(error){
                swal({title: "Oops..", text: "Some error occured! Please try again."});
            }
            
    });

            
      


}  
function resendMail(tenant_id,course_id){
console.log('1here');

// console.log(tenant_id);
// console.log(course_id);

jQuery.ajax({
        url: host+"api/courses/mailDataFetch/",
        headers:{"accept":"application/json"},
        dataType: 'json',
        data: {
                'tenant_id'     : tenant_id,
                'course_id'         : course_id,
                  },
        type: "post",
        success: function (result) {
         console.log(result);
         if(result.status == 0 && (typeof result.reason !== 'undefined')){
                swal({
                        type: 'error',
                        title: result.reason
                    })
          }else{

         swal({
           title: "Done!",
           text: "Mail sent successfully.",
           type: "success",
           });
           
          }
        },
        error: function(error){
                swal({title: "Oops..", text: "Some error occured! Mail could not be sent."});
            }
    });


}

function assignTenant(){
  console.log('yaha pe');
  var uuid = $('#uuidinput').val();
  var url = window.location.href;
  var temp = url.split("/");
  var id = temp[temp.length - 1]
// console.log(uuid+'hi');
jQuery.ajax({
        url: host+"api/courses/assignTenantToCourse/?request="+uuid,
        headers:{"accept":"application/json"},
        dataType: 'json',
        data: {
                'assignee_uuid'     : uuid,
                'course_id'         : id,
                  },
        type: "post",
        success: function (result) {
         console.log(result); 
         if(result.status == 0 && (typeof result.reason !== 'undefined')){
                swal({
                        type: 'error',
                        title: result.reason
                    })
          }else{

         swal({
           title: "Done!",
           text: "The Course Has been Shared Successfully.",
           type: "success",
           timer: 3000,
           },
           function () {
                  location.reload(true);
                  // tr.hide();
           });
          }
                $('#tenantinfo').hide(); 

        },
        error: function(error){
          console.log(error);
                swal({title: "Oops..", text: "This course has already been shared with the requested tenant. Resending the mail.",type: "success", timer: 3000,},
           function () {
                  // location.reload(true);
                  // tr.hide();
           });
            }
    });

            
  
}



function removeTenant(){
  console.log(' pe');
  swal({title: "Done", text: "The Tenant has been denied for this course!"});
  $('#tenantinfo').hide(); 

}


</script>