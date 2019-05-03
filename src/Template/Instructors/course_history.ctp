 <div class="text-center">
 <h3>Course History<h3/>
 </div>
 <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables">
                <thead>
                    <tr>
                        <th scope="col">Course ID </th>
                        <th scope="col">Course Type </th>
                        <th scope="col">Course Date </th>
                        <th scope="col">Location </th>
                        <th scope="col">Instructor Fee </th>
                        <th scope="col">Course Status </th>
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
                    <?= $getCourse->course->id?><br>
                    </td>
                    <td>
                    <?= $getCourse->course->course_type->name?><br>
                    </td>
                    <td>
                    <?php foreach ($getCourse->course->course_dates as $getDates): ?>
                    <?= $getDates->course_date ?><br>
                    <?= $getDates->time_from." - ".$getDates->time_to ?>
                    <?php  endforeach;  ?> 
                    </td>
                    <td>
                    <b><?= $getCourse->course->location->name?></b><br>
                    <?= $getCourse->course->location->city ?><br>
                    <?= $getCourse->course->location->state.", ".$getCourse->course->location->zipcode ?> 
                    </td>

                      
                    <td>
                    <?php
                        if(isset($getCourse->course->pay_structure) && !empty($getCourse->course->pay_structure)){
                            if($getCourse->course->pay_structure == 0){
                                $pay_structure = 'Flat Rate';
                            }if($getCourse->course->pay_structure == 1){
                                $pay_structure = 'Hourly Rate';
                            }if($getCourse->course->pay_structure == 2){
                                $pay_structure = 'Per Student Rate';
                                // die('die');
                            } 
                            echo "<strong>".$pay_structure."</strong>: $".$getCourse->course->instructor_pay;
                           }else{
                                    echo "<strong>--</strong>";
                            } ?>
                         <div class="hr-line-dashed"></div>
                    <?= "<strong>Additional Pay</strong>: $".$getCourse->course->additional_pay ?><br>

                    </td>
                    <td>
                        <?= $getCourse->course->status ?><br>
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



 <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog" style="width: 950px;" >

    <!-- Modal content-->
    <div class="modal-content">
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
</div>