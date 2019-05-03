<!-- <div class="row">
    <div class="col-md-4">
        <h2>Summary</h2>
        <strong><?php echo $course->training_site->name;?></strong><br/>
        <strong>Price:</strong>: <span class="text-navy">$<?php echo $course->cost?></span>
        <table class="table">
            <tbody>
                <tr>
                    <td width="13%"><strong>Date/Time</strong></td>
                    <td>
                    <?php
                    if(isset($course->course_dates) && !empty($course->course_dates)):
                    foreach ($course->course_dates as $date) :
                    echo $date->course_date."</br>";
                    echo $date->time_from->format('H:i A')."-";
                    echo $date->time_to->format('H:i A')."</br>";
                    endforeach;
                    endif;
                    ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Location Notes</strong></td>
                    <td>
                    <?php echo $course->location->name;?>
                    <?php echo $course->location->city;?><br>
                    <?php echo $course->location->state;?><br>
                    <?php echo $course->location->zipcode;?><br>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-8">
        <form role="form" id="payment-form">
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>CARD NUMBER</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="Number" placeholder="Valid Card Number" required />
                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7 col-md-7">
                    <div class="form-group">
                        <label>EXPIRATION DATE</label>
                        <input type="text" class="form-control" name="Expiry" placeholder="MM / YY"  required/>
                    </div>
                </div>
                <div class="col-xs-5 col-md-5 pull-right">
                    <div class="form-group">
                        <label>CV CODE</label>
                        <input type="text" class="form-control" name="CVC" placeholder="CVC"  required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                        <label>NAME OF CARD</label>
                        <input type="text" class="form-control" name="nameCard" placeholder="NAME AND SURNAME"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button class="btn btn-primary" type="submit">Make a payment!</button>
                </div>
            </div>
        </form>

    </div>

</div>
 -->