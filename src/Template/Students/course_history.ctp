 <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                    <tr>
                        <th scope="col">Course Date </th>
                        <th scope="col">Course ID </th>
                        <th scope="col">Course </th>
                        <th scope="col">Location </th>
                        <th scope="col">Cost </th>
                        <th scope="col">Payment</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                if(isset($history) && !empty($history)){
                foreach ($history as $getCourse):
                // pr($getCourse->course->private_course_url); 
                ?>
                
                   <tr>
                    <td>
                    <?php foreach ($getCourse->course->course_dates as $getDates): ?>
                    <strong> <?= $getDates->course_date->format('m-d-y') ?></strong><br>
                    <?= $getDates->time_from->format('H:i')." - ".$getDates->time_to->format('H:i') ?><br>
                    <?php  endforeach;  ?>
                    </td>
                    <td>
                    <?= $getCourse->course->id?><br>
                    </td>
                    <td>
                    <?= $getCourse->course->course_type->course_code." ".$getCourse->course->course_type->name?><br>
                    </td>
                    <td>
                    <b><?= $getCourse->course->location? $getCourse->course->location->name : "-" ?></b><br>
                    <?= $getCourse->course->location? $getCourse->course->location->city : "-" ?><br>
                    <?= $getCourse->course->location? $getCourse->course->location->state.", ".$getCourse->course->location->zipcode : "-" ?> 
                    </td>
                    <td>
                    <?= $getCourse->course->cost ?><br>
                    </td>
                    <!-- <td>
                        <?= $getCourse->course->cost ?><br>
                        <a href='#' data-toggle="modal" data-target="#myModal">view details</a>
                    </td> -->
                   
                    <td>
                    <?php if($getCourse->payment_status == 'Paid'){?>
                        <i class= "fa fa-check-square-o"></i>
                    <?php }else{?>
                        <?=$this->Html->link('PAY NOW', ['controller' => 'Students', 'action' => 'private_course',$getCourse->course->id,'?course-hash='.$getCourse->course->private_course_url],['class' => ['btn','btn-w-m', 'btn-primary']])?>
                    <?php } ?>
                    </td>
                   </tr>
                <?php  endforeach; }
                    else{
                    echo 'No record found';
                    } ?> 
                </tbody>
            </table>
        </div>
</div>



 <!-- <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width: 950px;" >
 -->
    <!-- Modal content-->
    <!-- <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body" class="white-bg">
        one + six = 0 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div> -->