<?php 
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Routing\Router;
?>
<?php if($courseStudent >= 6 ) {?>
<div class="col-lg-8 col-sm-12 ">
    <div class="tabs-container">
          <div class="tab-content">
            <h3><?= $subcontractedClient->name ?></h3>
              <div id="tab-2" class="tab-pane active">
                      <?php //if(isset($courses) && !empty($courses)):?>
                    <div class="panel-body" id="accordion" style="padding-top: 5%;">
                        <?php
                        $i = 1;
                        if(isset($courses) && !empty($courses)){
                        foreach ($courses as $course) :?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i;?>" aria-expanded="false" class="collapsed"><?= $course->course_type? $course->course_type->name: "Not available.Please try again"?></a>
                                </h5>
                            </div>
                            <div id="collapse<?php echo $i;?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                <div class="panel-body">
                                    <h3>Course Description</h3>
                                    <?php $domainType = Router::url('/', true);?>
                                    <a href="<?php echo $domainType.'students/private_course/?course-hash='.$course->private_course_url;?>"><strong>
                                    <?= $course->course_type? $course->course_type->name:"Not available.Please try again";
                                    // echo $course->course_dates[0]->time_from;
                                    ?>
                                    </strong></a><br/>
                                    
                                    <table class="table">
                                      <tbody>
                                      <?php
                                      if(isset($course->course_dates) && !empty($course->course_dates)):
                                      foreach ($course->course_dates as $date) : 
                                          $timeFrom = new Time($date->time_from);
                                          $timeTo = new Time($date->time_to);
                                          // echo "Today is " . date($date->course_date) . "<br>";
                                      ?>
                                      <tr>
                                          <td><?php echo $time = Date::parseDate($date->course_date, 'dd MM, y');?></td>
                                          <td><span class="text-navy"><?php echo $timeFrom->i18nFormat('HH:mm')." - ".$timeTo->i18nFormat('HH:mm');?></span></td>
                                      </tr>
                                      <?php 
                                      endforeach;
                                      endif;
                                      ?>
                                      </tbody>
                                  </table>

                                    

                                    <?php
                                    /*if(isset($course->course_dates) && !empty($course->course_dates)):
                                    foreach ($course->course_dates as $date) :
                                        echo $date->course_date."</br>";
                                        echo $date->time_from."-";
                                        echo $date->time_to."</br>";
                                    endforeach;
                                    endif;*/
                                    ?>
                                    <span class="class-event-location">
                                        <br><?= $course->location ? $course->location->address:"Not available.Please try again";?><br><?= $course->location? $course->location->city : "Not available.Please try again." ;?>,<?= $course->location? $course->location->state : "Not available.Please try again.";?>, <?= $course->location? $course->location->zipcode : "Not available.Please try again";?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php $i++; endforeach; 
                    }?>
                    </div>
                <?php //endif;?>
              </div>
          </div>
      </div>
  </div>
  <?php } else {?>
     <h3><?= $subcontractedClient->name ?></h3><br>
    <div class="col-sm-12" style="background-color:#fad1b6;">
      <div style="margin-top:40px; margin-bottom:40px; border:1px dashed; background-color: #f2dede;">
        <div class="text-center">
          <h5 ><strong>  No currently available classes! </strong></h5>
            Get a group of 6 or more and we will host a class at your location. Please email us at <b>info@nationsbestcpr.com</b>
        </div>
      </div>
    </div>
  <?php } ?>