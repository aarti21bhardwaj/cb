<div class="row">
<div class="col-lg-3">
	<div class="ibox float-e-margins">
	    <div class="ibox-title">
	        <span class="label label-success pull-right">Monthly</span>
	        <h5>Students</h5>
	    </div>
	    <div class="ibox-content">
	        <h4>Current Month: <?= $oneMonthStudents ?>
                <?php if($oneMonthStudents > $twoMonthStudents){ ?>
                    <div class="stat-percent font-bold text-success"><i class="fa fa-level-up fa-2x"></i></div>
                <?php } ?>
                <?php if($oneMonthStudents < $twoMonthStudents){ ?>
                    <div class="stat-percent font-bold text-success"><i class="fa fa-level-down fa-2x"></i></div>
                <?php } ?>
                <?php if($oneMonthStudents == $twoMonthStudents){ ?>
                    <div class="stat-percent font-bold text-success"><i class="fa fa-square fa-2x"></i></div>
                <?php } ?>   
            </h4>
	        <h4>Last Month: <?= $twoMonthStudents ?></h4>
	        
	    </div>
	</div>
</div>
<div class="col-lg-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <span class="label label-info pull-right">Monthly</span>
            <h5>Courses</h5>
        </div>
        <div class="ibox-content">
             <h4>Current Month: <?= $oneMonthCourses ?>
                <?php if($oneMonthCourses > $twoMonthCourses){ ?>
                    <div class="stat-percent font-bold text-info"><i class="fa fa-level-up fa-2x"></i></div>
                <?php } ?>
                <?php if($oneMonthCourses < $twoMonthCourses){ ?>
                    <div class="stat-percent font-bold text-info"><i class="fa fa-level-down fa-2x"></i></div>
                <?php } ?>
                 <?php if($oneMonthCourses == $twoMonthCourses){ ?>
                    <div class="stat-percent font-bold text-info"><i class="fa fa-square "></i></div>
                <?php } ?>
             </h4>
	        <h4>Last Month: <?= $twoMonthCourses ?></h4>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <span class="label label-danger pull-right">Monthly</span>
            <h5>Orders</h5>
        </div>
        <div class="ibox-content">
            <h4>Current Month: $<?= $profitOneMonth ?>
                <?php if($profitOneMonth > $profitTwoMonth){ ?>
                <div class="stat-percent font-bold text-danger"><i class="fa fa-level-up fa-2x"></i></div>
            <?php } ?>
            <?php if($profitOneMonth < $profitTwoMonth){ ?>
                <div class="stat-percent font-bold text-danger"><i class="fa fa-level-down fa-2x"></i></div>
            <?php } ?>
            <?php if($profitOneMonth == $profitTwoMonth){ ?>
                <div class="stat-percent font-bold text-danger"><i class="fa fa-square fa-2x"></i></div>
            <?php } ?>
            </h3>
	        <h4>Last Month: $<?= $profitTwoMonth ?></h4>
            <!-- <small>New orders</small> -->
        </div>
    </div>
</div>
<div class="col-lg-3"></div>
<!-- <div class="col-lg-12"> -->
<div class="col-lg-6">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Instructor Records</h5>
        </div>
        <div class="ibox-content" >
			<button class="accordion">Certificates Expire in 3 Months : 
                <span id="expiringThreeMonthsButthon">
                 <?php echo count($expiringThreeMonths) ?>
            </span></button>
			  <div class="panel">
			    <div class="table-responsive">
				  <table class="table table-striped table-hover " >
				      <thead>
				          <tr>
				              <th scope="col">#</th>
				              <th scope="col">Instructor</th>
				              <th scope="col">Documents</th>
				              <th scope="col">Expired Date</th>
                              <th scope="col">Send Email</th>
				              <th scope="col">Action</th>
				          </tr>
				      </thead>
				      <tbody id ='expiringThreeMonths'>
                        <?php if(isset($expiringThreeMonths) && !empty($expiringThreeMonths)){ ?>
				          <?php foreach ($expiringThreeMonths as $key => $value): ?>
				            <tr id="pending_<?= $value->id ?>">
				              <td><?= $key+1 ?></td>    
				              <td><?= $value->instructor->first_name." ".$value->instructor->last_name?></td>    
				              <td><?= $value->qualification->name ?></td>    
				              <td><?= $value->expiry_date->format('m-d-y') ?></td>
                              <td class="text-center">
                                  <a href="mailto:<?php echo $value->instructor->email ?>?Subject=Hello%20!&body=This is an Email&cc=Mihir.06.96@gmail.co&target="_top"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                              </td>
                              <td>
                                <?php 
                                    $viewUrl = $this->Url->build(["controller"=>"instructorQualifications","action" => "edit", $value->id]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-plus fa-fw"></i>
                                    </a>
                              </td> 
				              <!-- <td>Action</td>     -->
				            </tr>
				      <?php endforeach; ?>
                  <?php } ?>
				    </tbody>
				  </table>
				</div>
			</div>
			<button class="accordion" aria-expanded="false">Certificates Expired Now 
                <span class="text-right" id="expiringTodayButton">: <?php echo count($expiringToday) ?> </span></button>
			<div class="panel">
        <div class="ibox-content" >
			  <div class="table-responsive">
				  <table class="table table-striped table-hover" >
				      <thead>
				          <tr>
				              <th scope="col">#</th>
				              <th scope="col">Instructor</th>
				              <th scope="col">Documents</th>
				              <th scope="col">Expired Date</th>
                      <th scope="col">Send Email</th>
				              <th scope="col">Action</th>
				          </tr>
				      </thead>
				      <tbody id ='expiringToday'>
                        <?php if(isset($expiringToday) && !empty($expiringToday)){ ?>
				          <?php foreach ($expiringToday as $key => $value): ?>
				            <tr>
				              <td><?= $key+1 ?></td>    
				              <td><?= $value->instructor->first_name." ".$value->instructor->last_name?></td>    
				              <td><?= $value->qualification->name ?></td>    
				              <td><?= $value->expiry_date->format('m-d-y') ?></td>
				              <td class="text-center">
                                <a href="mailto:<?php echo $value->instructor->email ?>?Subject=Hello%20!&body=This is an Email&cc=Mihir.06.96@gmail.co&target="_top"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                              </td>
                              <td>
                               <?php 
                                $viewUrl = $this->Url->build(["controller"=>"instructorQualifications","action" => "edit", $value->id]);
                                ?>
                                <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-plus fa-fw"></i>
                                </a>
                              </td>    
				            </tr>
				      <?php endforeach; ?>
                  <?php } ?>
				    </tbody>
				  </table>
				</div>
			</div>
        </div>
			<button class="accordion">Pending Submissions : 
                <span class="text-right" id="pendingQualificationsButthon"><?php echo count($pendingQualifications) ?> </span></button>
			<div class="panel">
			  <div class="table-responsive">
				  <table class="table table-striped table-hover" >
				      <thead>
				          <tr>
				              <th scope="col">#</th>
				              <th scope="col">Instructor</th>
				              <th scope="col">Days</th>
				              <th scope="col">Actions</th>
				          </tr>
				      </thead>
				      <tbody id = "pendingQualifications">
                        <?php if(isset($pendingQualifications) && !empty($pendingQualifications)) { ?>
				          <?php foreach ($pendingQualifications as $key => $value): ?>
				            <tr id="pending_<?= $value->id ?>">
				              <td ><?= $key+1 ?></td>    
				              <td><?= $value->first_name." ".$value->last_name?></td>    
				              <td><?= date_diff($todayDate,$value->created)->days  ?></td>    
				              <td>
				              	<?php 
							        $viewUrl = $this->Url->build(["controller"=>"instructorQualifications","action" => "add", $value->id]);
							        ?>
							        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="" data-toggle="modal" data-target="#myModal">
							            <i class="fa fa-plus fa-fw"></i>
							        </a>
							        
				              </td>    
				            </tr>
				      <?php endforeach; ?>
                  <?php } ?>
				    </tbody>
				  </table>
				</div>
			</div>
        </div>

    </div>
</div>
<div class="col-lg-6">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Courses</h5>
        </div>
        <div class="ibox-content">
            <button class="accordion">Courses Incomplete Checkouts :  <span class="text-right" id="incompleteCheckoutButthon"><?php echo $count ?> </span></button>
            <div class="panel">
                <div class="table-responsive">
                  <table class="table table-striped table-hover" >
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Course</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Location</th>
                              <th scope="col">Actions</th>
                          </tr>
                      </thead>
                      <tbody id = "incompleteCheckout">
                        <?php if(isset($incompleteCheckout) && !empty($incompleteCheckout)) { 
                            $count = 1;?>
                          <?php foreach ($incompleteCheckout as $key => $value): ?>
                             <?php foreach ($value->course->course_dates as $key => $val): ?>
                            <tr id="pending_<?= $value->id ?>">
                              <td ><?= $count++; ?></td>    
                              <td><?= $value->course->course_type->name?></td>    
                              <td><?= $val->course_date->format('Y-m-d'); ?></td>    
                              <td>
                                <?= $val->time_from?$val->time_from->format('H:i')."-":"-"; ?>
                               <?= $val->time_to?$val->time_to->format('H:i'):"-"; ?></td>
                               <td><?= $value->course->location->name ?></td>    
                              <td>
                                <?php 
                                    $viewUrl = $this->Url->build(["controller"=>"Courses","action" => "view", $value->course_id]);
                                    ?>
                                    <a href="<?=$viewUrl?>"" target=”_blank” >
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    
                              </td>    
                            </tr>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                  <?php } ?>
                    </tbody>
                  </table>
                </div>
            </div>

            <button class="accordion">Overlapping Locations(14 Days) : <span class="text-right" id="courseDatesButthon"><?php echo count($location) ?> </span></button>
            <div class="panel">
              <div class="table-responsive">
                  <table class="table table-striped table-hover" >
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Course</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Location</th>
                              <th scope="col">Actions</th>
                          </tr>
                      </thead>
                      <tbody id = "courseDates">
                        <?php if(isset($courseDates) && !empty($courseDates)) { 
                            $count = 1;?>
                          <?php foreach ($courseDates as $key => $value): ?>
                             <?php foreach ($value as $key1 => $val): ?>
                                <?php foreach ($val as $key2 => $val1):  ?>
                            <tr id="pending_<?= $key2 ?>">
                              <td ><?= $count++; ?></td>    
                              <td><?= $location[$key2]?></td>    
                              <td><?= $key1 ?></td>    
                              <td>
                                <?= $val1->time_from?$val1->time_from->format('H:i')."-":"-"; ?>
                                <?= $val1->time_to?$val1->time_to->format('H:i'):"-"; ?>
                              </td>
                               <td><?= $key ?></td>    
                              <td>
                                <?php 
                                    $viewUrl = $this->Url->build(["controller"=>"Courses","action" => "edit", $key2]);
                                    ?>
                                    <a href="<?=$viewUrl?>"" target=”_blank” >
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    
                              </td>    
                            </tr>
                        <?php endforeach; ?>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                  <?php } ?>
                    </tbody>
                  </table>
                </div>
            </div>

            <button class="accordion">Overlapping Instructors(14 Days) :  <span class="text-right" id="courseInstructorsButthon"><?php echo count($courses) ?> </span></button>
            <div class="panel">
              <div class="table-responsive">
                  <table class="table table-striped table-hover" >
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Course</th>
                              <th scope="col">Date</th>
                              <th scope="col">Time</th>
                              <th scope="col">Instructor</th>
                              <th scope="col">Actions</th>
                          </tr>
                      </thead>
                      <tbody id = "courseInstructors">
                        <?php if(isset($courseInstructors) && !empty($courseInstructors)) { 
                            $count = 1;?>
                          <?php foreach ($courseInstructors as $key => $value): ?>
                             <?php foreach ($value as $key1 => $val): ?>
                                <?php foreach ($val as $key2 => $val1): ?>
                            <tr id="pending_<?= $key ?>">
                              <td ><?= $count++; ?></td>    
                              <td><?= $courses[$key2] ?></td>    
                              <td><?= $key1; ?> </td>    
                              <td><?= $val1->time_from?$val1->time_from->format('H:i')."-":"-"; ?>
                               <?= $val1->time_to?$val1->time_to->format('H:i'):"-"; ?>
                               </td>
                               <td><?= $instructorsData[$key] ?></td>    
                              <td>
                                <?php 
                                    $viewUrl = $this->Url->build(["controller"=>"Instructors","action" => "edit", $key]);
                                    ?>
                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    
                              </td>    
                            </tr>
                         <?php endforeach; ?>
                        <?php endforeach; ?>
                      <?php endforeach; ?>
                  <?php } ?>
                    </tbody>
                  </table>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
<!-- <script type="text/javascript">
  
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });
</script> -->
<script type="text/javascript">
    $(document).ready(function(){   
    	var todayDate = new Date('<?= $todayDate->format("m/d/y") ?>');
        var test = '/classbyte/instructor-qualifications/add/';
        var test3 = '/classbyte/instructor-qualifications/edit/';
        var test4 = '/classbyte/courses/edit/';
        var test5 = '/classbyte/courses/view/';
        var test2 = 'View User';
        $('#myModal').on('hide.bs.modal', function () {
  		// console.log('test2');
           jQuery.ajax({
            url: host+"api/tenants/dashboardDataRefresh",
            headers:{"accept":"application/json"},
            dataType: 'json',
            // data: {'promoCode':promoCode,
            //        // 'studentId':studentId,
            //       },
            type: "get",
            success: function (result) {
                    console.log(result);
    				// console.log('value');
                    $('#pendingQualifications').html('');
                    $('#pendingQualificationsButthon').html('');
                    var ctr = 0;
                    var pendingQualifications = ''; 
                    $.each(result.response.pendingQualifications,function(i, value){
                        // console.log(value);
                        var date1 = new Date(value.created);
                        var bob = '"'+test+value.id+'"';
                        pendingQualifications+='<tr id =pending_'+value.id+'>'
                        pendingQualifications+='<td>'+(i+1)+'</td>\n';
                        pendingQualifications+='<td>'+value.first_name+' '+value.last_name+'</td>';
                        pendingQualifications+='<td>'+Math.ceil((todayDate - date1)/(1000*60*60*24))+'</td>';
                        pendingQualifications+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                        ctr++;
                        if (ctr % 8 == 0) {
                            pendingQualifications+='</tr><tr>\n';
                          }
                    });
                    var count = result.response.pendingQualifications.length;
                    $('#pendingQualifications').append(pendingQualifications)
                    $('#pendingQualificationsButthon').append(result.response.pendingQualifications.length);
                    //Expiring three Month
                    $('#expiringThreeMonths').html('');
                    $('#expiringThreeMonthsButthon').html('');
                    var ctr = 0;
                    var html='';
                    $.each(result.response.expiringThreeMonths,function(i, value){
                        var date1 = new Date(value.expiry_date);
                        var bob = '"'+test3+value.id+'"';
                        html+='<tr id =pending_'+value.id+'>'
                        html+='<td>'+(i+1)+'</td>\n';
                        html+='<td>'+value.instructor.first_name+value.instructor.last_name+'</td>';
                        html+='<td>'+value.qualification.name+'</td>';
                        html+='<td>'+formatDate(date1)+'</td>';
                        html+='<td><a href=mailto:'+value.instructor.email+'?Subject=Hello%20!&body=This is an Email&target=_top><i class="fa fa-paper-plane" aria-hidden="true"></i></a></td>';
                        html+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                        ctr++;
                        if (ctr % 8 == 0) {
                            html+='</tr><tr>\n';
                          }    
                    });
                    $('#expiringThreeMonths').append(html);
                    $('#expiringThreeMonthsButthon').html(result.response.expiringThreeMonths.length);
                    //ExpiringToday Data
                    $('#expiringToday').html('');
                    var ctr = 0;
                    var expiringTodayhtml='';
                    $('#expiringTodayButton').html('');
                    $.each(result.response.expiringToday,function(i, value){
                        var date1 = new Date(value.expiry_date);
                        var bob = '"'+test3+value.id+'"';
                        expiringTodayhtml+='<tr id =pending_'+value.id+'>'
                        expiringTodayhtml+='<td>'+(i+1)+'</td>\n';
                        expiringTodayhtml+='<td>'+value.instructor.first_name+value.instructor.last_name+'</td>';
                        expiringTodayhtml+='<td>'+value.qualification.name+'</td>';
                        expiringTodayhtml+='<td>'+formatDate(date1)+'</td>';
                        expiringTodayhtml+='<td><a href=mailto:'+value.instructor.email+'?Subject=Hello%20!&body=This is an Email&target=_top><i class="fa fa-paper-plane" aria-hidden="true"></i></a></td>';
                        expiringTodayhtml+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                        ctr++;
                        if (ctr % 8 == 0) {
                            expiringTodayhtml+='</tr><tr>\n';
                          }
                    });
                    $('#expiringToday').append(expiringTodayhtml);
                    $('#expiringTodayButton').html(result.response.expiringToday.length);
                    //Incomplete Checkout Data
                    $('#incompleteCheckoutButthon').html('');
                    $('#incompleteCheckout').html('');
                    var ctr = 0;
                    var incompleteCheckout = '';
                    $.each(result.response.incompleteCheckout,function(i, value){
                        $.each(value.course.course_dates,function(i,val){
                        // console.log(value);
                        // console.log('value');
                        var date1 = new Date(value.created);
                        var bob = '"'+test5+value.course_id+'"';
                        incompleteCheckout+='<tr id =pending_'+value.id+'>'
                        incompleteCheckout+='<td>'+(i+1)+'</td>\n';
                        incompleteCheckout+='<td>'+value.course.course_type.name+'</td>';
                        incompleteCheckout+='<td>'+formatDate(val.course_date)+'</td>';
                        incompleteCheckout+='<td>'+formatTime(val.time_from)+'-'+formatTime(val.time_to)+'</td>';
                        incompleteCheckout+='<td>'+value.course.location.name+'</td>';
                        incompleteCheckout+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                        ctr++;
                        if (ctr % 8 == 0) {
                            incompleteCheckout+='</tr><tr>\n';
                          }
                        });
                    });
                    $('#incompleteCheckout').html(incompleteCheckout);
                    $('#incompleteCheckoutButthon').html(ctr);
                    //CourseDate data
                    $('#courseDatesButthon').html('');
                    $('#courseDates').html('');
                    var ctr = 0;
                    var courseDates = '';
                    $.each(result.response.courseDates,function(i, value){
                        $.each(value,function(j,val){
                            $.each(val,function(k,val1){
                            var bob = '"'+test4+k+'"';
                            courseDates+='<tr id =pending_'+k+'>'
                            courseDates+='<td>'+(ctr+1)+'</td>\n';
                            courseDates+='<td>'+result.response.location[k]+'</td>';
                            courseDates+='<td>'+j+'</td>';
                            courseDates+='<td>'+formatTime(val1.time_from)+'-'+formatTime(val1.time_to)+'</td>';
                            courseDates+='<td>'+i+'</td>';
                            courseDates+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                            ctr++;
                            if (ctr % 8 == 0) {
                                courseDates+='</tr><tr>\n';
                              }
                            });
                        });
                    });
                    $('#courseDates').html(courseDates);
                    $('#courseDatesButthon').html(ctr);
                    //CourseInstructors
                    // console.log('CourseInstructors');
                    $('#courseInstructorsButthon').html('');
                    $('#courseInstructors').html('');
                    var ctr = 0;
                    var courseInstructors = '';
                    $.each(result.response.courseInstructors,function(i, value){
                        $.each(value,function(j,val){
                            $.each(val,function(k,val1){
                                var bob = '"'+test4+i+'"';
                                courseInstructors+='<tr id =pending_'+i+'>'
                                courseInstructors+='<td>'+'test'+(ctr+1)+'</td>\n';
                                courseInstructors+='<td>'+result.response.courses[k]+'</td>';
                                courseInstructors+='<td>'+j+'</td>';
                                courseInstructors+='<td>'+formatTime(val1.time_from)+'-'+formatTime(val1.time_to    )+'</td>';
                                courseInstructors+='<td>'+result.response.instructorsData[i]+'</td>';
                                courseInstructors+="<td><a href=# onclick=openViewPopUp("+bob+") data-toggle=modal data-target=#myModal><i class='fa fa-plus fa-fw'></i></a></td>";
                                ctr++;
                                if (ctr % 8 == 0) {
                                    courseInstructors+='</tr><tr>\n';
                                  }
                                });
                            });
                    });
                    $('#courseInstructors').html(courseInstructors);
                    $('#courseInstructorsButthon').html(ctr);


            },
            error: function(error){
                console.log(error);
            }
        });
        });
    });
        // function course_dates(data){
        //     console.log(data);
        //     console.log('data');
        //     var html = '';
        //     $.each(data,function(i,val){
        //        html = html+formatDate(val.course_date);
        //        html = html+'   :  ';
        //        html = html+formatTime(val.time_from);
        //        html = html+'-';
        //        html = html+formatTime(val.time_to);
        //        html = html+'\n';

        //     });
        //     return html;
        // }
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [year, month, day].join('-');
        }

        function formatTime(time){

            var date = new Date(time);
            var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
            var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
            time = hours + ":" + minutes;
            return time;
        }

</script>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight){
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active, .accordion:hover {
  background-color: #ccc;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}


.panel {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  margin-bottom: 0px;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
}
</style>
