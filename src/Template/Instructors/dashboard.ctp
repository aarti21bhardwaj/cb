<?php if(empty($instructors['instructor_insurance_forms']) || empty($instructors['instructor_applications']) || empty($instructors['instructor_qualifications'])): ?>
<div class= "alert alert-info" >
<button class="close" type="button" data-dismiss="alert">x</button>
<h4>Welcome!</h4>
Please make sure that your instructor profile is completely filled out. Click
<b>
<?php echo $this->Html->link(' here ',['controller' => 'Instructors', 'action' => 'index']);?>
</b>
to complete.
</div>
<?php endif; ?>


<?php //use Cake\I18n\Time;?>
<div class="row">
    <div class="col-lg-12">
        <!--<div class="courses index large-9 medium-8 columns content">-->
       
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
	            <h1><?= __('Course') ?></h1>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
	                    <thead>
	                        <tr>
	                            <th scope="col">Date</th>
	                            <th scope="col">Start Time</th>
	                            <th scope="col">End Time</th>
	                            <th scope="col">Course Id</th>
	                            <th scope="col">Course Type</th>
	                            <th scope="col">Location</th>
	                            <th scope="col">Number of Seats</th>
	                            <th scope="col">Instructor Pay</th>
	                            <th scope="col">Status</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <?php foreach ($course_instructor as $getCourse): ?>
	                            <tr>
	                            	
	                                <td>
	                                <?php 
	                                if(isset($getCourse->course->course_dates) && !empty($getCourse->course->course_dates)){
	                                	foreach ($getCourse->course->course_dates as $value) {
	                                		echo $value->course_date.'<br>';
	                                	}
	                                }
	                                ?>
	                                	
	                                </td>
	                                <td>
	                                <?php 
	                                if(isset($getCourse->course->course_dates) && !empty($getCourse->course->course_dates)){
	                                	foreach ($getCourse->course->course_dates as $value) {
	                                		echo $value->time_from.'<br>';
	                                	}
	                                }
	                                ?>
	                                </td>
	                                <td>
	                                <?php 
	                                if(isset($getCourse->course->course_dates) && !empty($getCourse->course->course_dates)){
	                                	foreach ($getCourse->course->course_dates as $value) {
	                                		echo $value->time_to.'<br>';
	                                	}
	                                }
	                                ?>
	                                </td>
	                                <td class="text-center"><span class="label label-success">
	                                	<?php echo $getCourse->course->id;?>
	                                </span></td>
	                                <td><?php echo $getCourse->course->course_type?$getCourse->course->course_type->name:"-"; ?></td>
	                                <td class="text-center"><?php echo $getCourse->course->location?$getCourse->course->location->city:"-";?></td>
	                                <td class="text-center"><?php echo $getCourse->course->seats;?></td>
	                                <td class="text-center"><?php echo $getCourse->course->additional_pay;?></td>
	                            	<td>
	                            	<?php 
	                            	 if($getCourse->course->full == 1){ ?>

	                            	 		<p>sorry, too late!</p>


	                            	<?php }else{  
	                            	if($getCourse->status == 1){?>
		                            	<p>
		                            		<span class="badge badge-primary">Accepted</span>
			                            	<span class="badge badge-success">
			                            	<?php echo $this->Html->link('Details',['controller' => 'Instructors', 'action' => 'viewCourse',$getCourse->course->id]);?>
			                            	</span>
		                                    Accepted:<?php echo $getCourse->modified;?>
		                            	</p>
		                            <?php } else if($getCourse->status == 2 ){ ?>
		                            <p>
	                            		<span class="badge badge-danger">Declined</span>
	                                    Declined:<?php echo $getCourse->modified;?>
	                            	</p>

		                            <?php }else if($getCourse->status == null){ ?>
			                            <p id="hideAfterUpdate<?= $getCourse->course->id ?>">
		                            		<span class="badge badge-primary" onclick = "acceptCourseByInstructor(<?= $getCourse->course->id ?>,1,<?= $getCourse->instructor_id?>)">Accept</span>
											<span class="badge badge-danger" onclick = "declineCourseByInstructor(<?= $getCourse->course->id ?>,2,<?= $getCourse->instructor_id?>)">Decline</span>
			                            </p>
		                            <?php } }?>
		                            	
		                            	
	                            	</td>
					            </tr>
					       	<?php endforeach; ?>
					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
.badge-success a{color: #fff;}
</style>
