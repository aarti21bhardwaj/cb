<?php 
use Cake\I18n\Date;
use Cake\I18n\Time;
// pr($loggedInUser);die;
?>
<script src="https://js.stripe.com/v3/"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxKI6elv3aXMzIUY6mP9q6qDMIwWZcGq0&callback=initMap"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> <link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<?php
    $loginFormTemplate = [
            'button' => '<button class="dark btn btn-sm btn-success" {{attrs}}>{{text}}</button>',
            'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
            // 'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
            // 'label' => '<label class="col-sm-4 control-label" {{attrs}}>{{text}}</label>',
            'formStart' => '<div class="ibox-content light"><form class="form-horizontal" {{attrs}}>',
             'formEnd' => '</form></div>',
    ];
    $this->Form->setTemplates($loginFormTemplate);
    // pr($course->course_addons);die;

?>
<style type="text/css">

.wizard > .content {min-height: 1000px;}
#map {
    height: 400px;  /* The height is 400 pixels */
    width: 100%;  /* The width is the width of the web page */
}
.wizard > .content > .body {
    position: static !important;
}
.wizard > .content {
    min-height: auto !important;
}
.radio-info input{
    margin-left: -62px !important;
    margin-top: -0px !important;
}
.radio_set input{
    margin-left: -32px !important;
    margin-top: 0px;
}
.form-control{
    width: 96% !important;
    margin-left: 4% !important;
}
/*.form-control2{*/
    /*width: 96% !important;*/
    /*margin-left: 4% !important;*/
/*    height: 15px;*/
/*}*/
.hr-line-dashed {
    border-top: 1px dashed #e7eaec;
    color: #ffffff;
    background-color: #ffffff;
    height: 1px;
    margin: 20px 0;
}
.form-horizontal .control-label{
    text-align: left !important;
}
.actions ul li:last-child {
  display: none !important;
}
.actions ul li a[href="#finish"] {
 display: none !important;
}
</style>
<style type="text/css">

    label {
  position: absolute;
  -webkit-transform: translateY(6px);
          transform: translateY(6px);
  left: 44px !important;
  color: black !important;
  transition: all 0.25s ease;
  -webkit-backface-visibility: hidden;
  pointer-events: none;
  font-size: 15px !important;
}
</style>
<style type="text/css">
    .alignment{
        padding-left: 28px;
    }
</style>
<script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?php echo $course->location->lat;?>, lng: <?php echo $course->location->lng;?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 16, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title" align="center">
            <h3>Bulk Payment for Students</h3>
        </div>
        <div class="ibox-content">
            <div class="panel-body">
                <?= $this->Form->create(null,['id'=>"payment-form",'enctype'=>"multipart/form-data","data-toggle"=>"validator"]);?>
                <div class="panel-group" id="accordion">
    <!-- ---------------------------------FROM HERE---------------------------------------------                 -->
    <div class="panel panel-default ">
        <div class="panel-heading master_color">
            <h4 class="panel-title ">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">Course Details</a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
            <div class="panel-body">
                <div class="col-sm-8">    
                    <div class="panel panel-default">
                        <div class="panel-heading master_color">
                            <b><?php echo $course->training_site?$course->training_site->name:"";?></b>
                        </div>
                        <div class="panel-body">
                            <?php
                            if(!empty($tenant->tenant_config_settings) && ($tenant->tenant_config_settings['0']->remaining_seats) == '1'){ ?>

                                <p class="text-right"><span class="badge"><?php echo $course->seats?> Seats Remaining</span></p>
                            <?php } ?>
                          <!--   <?php
                            if(isset($course->course_dates) && !empty($course->course_dates)):
                                foreach ($course->course_dates as $date) :
                                    $timeFrom = new Time($date->time_from);
                                    $timeTo = new Time($date->time_to);
                                    ?>
                                    <p><strong>Date</strong>: <?php echo $time = Date::parseDate($date->course_date, 'dd MM, y');?></p>
                                    <p><strong> Time</strong>: <?php echo $timeFrom->i18nFormat('HH:mm')." - ".$timeTo->i18nFormat('HH:mm');?></p>
                                <?php endforeach; endif; ?> -->
                                <p>
                                        <td><strong>Date/Time</strong>:</td>
                                        <td>

                                        <div class="row">
                                            <div class="col-sm-12">
                                            <?php
                                            if(isset($course->course_dates) && !empty($course->course_dates)):
                                            foreach ($course->course_dates as $date) : 
                                                $timeFrom = new Time($date->time_from);
                                                $timeTo = new Time($date->time_to);
                                                // echo "Today is " . date($date->course_date) . "<br>";
                                            ?>  
                                                <small>
                                                    <strong><?php echo $time = Date::parseDate($date->course_date, 'dd MM, y');?> :</strong> <?php echo $timeFrom->i18nFormat('HH:mm')." - ".$timeTo->i18nFormat('HH:mm');?>
                                                </small><br>
                                            <?php endforeach; endif; ?>
                                             </div>
                                        </div>

                                        </td>
                                </p>

                                <p><strong>Location </strong>:
                                    <?php if(isset($course->location) && !empty($course->location)){ ?>
                                        <?php echo $course->location->name;?>,&nbsp;
                                        <?php echo $course->location->city;?>,&nbsp;
                                        <?php echo $course->location->state;?>,&nbsp;
                                        <?php echo $course->location->zipcode;?>
                                    <?php }?>
                                </p>
                                <p>
                                    <strong>Class Notes</strong>:
                                    <?php echo $course->class_details?></p>
                                </p>
                                <p>
                                    <strong>Course Cost</strong>:
                                    $<?php echo $course->cost?>
                                </p>
                                <p>
                                <?php if(isset($course->course_addons) && !empty($course->course_addons)):?>
                                <div class="panel panel-default">
                                    <div class="panel-heading master_color">
                                        <strong>Additional Course Option(s)</strong>
                                    </div>
                                    <div class="panel-body">
                                        <p>Students are required to purchase a manual or bring a previously purchased 2015 manual to class. Purchased books will be made availalbe at the class or can be picked up at our office Monday - Friday.</p>

                                        <table class="table">
                                            <tbody>
                                                <?php foreach ($course->course_addons as  $addons) : ?>
                                                    <tr>
                                                        <td style="padding-top: 17px;"><b><?php echo $addons->addon->name?></b></td>
                                                        <td>
                                                            <div class="radio radio_set radio-inline">
                                                                <input checked="checked" class="testradio" type="radio" value="" name="addon<?php echo $addons->id?>" onclick="removeAddon('<?php echo $addons->addon->id?>','<?php echo $addons->addon->price?>')">
                                                                <span for="inlineRadio2"> No </span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="radio radio-info radio-inline">
                                                                <input <?php if(isset($addonIds) && in_array($addons->addon->id,$addonIds)) echo "checked"; ?> class="testradio" type="radio" value="" name="addon<?php echo $addons->id?>" onclick="addAddon('<?php echo $addons->addon->id?>','<?php echo $addons->addon->price?>', '<?php echo $course->cost?>')">

                                                                <span>Yes (Add $<?php echo $addons->addon->price?>) </span>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach;?>
                                            </tbody>
                                        </table>
                                    </div> <!-- Nested panel body -->
                                </div> <!-- nested Panel -->
                            <?php endif;?> 
                        </div>
                    </div>
                        <div class="panel-footer dark_background text-center">
                            <h7 id="totalPrice">
                                <strong>Total Cost: 
                                    <span>$<?php echo (isset($finalAmount))? ($finalAmount) :$course->cost?></span>
                                </strong>
                            </h7>
                        </p>
                        </div>
                </div> <!-- End of col-sm-8 -->
                        <!-- ---------map goes here-------- -->
                        <div class="col-sm-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="locationsmapdiv">
                                        <p>
                                            <div style="float: left; text-align: center; width: 100%;" >
                                                <div id="map"></div>
                                            </div>
                                            <div  style="width: 100%; height: 300px; visibility:hidden;">
                                                <div id="map_canvas" style="width: 350px; height: 300px; text-align:center;">
                                                </div>
                                                <div style="display:none;"></div>
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </div>    
                        </div>
            </div>
        </div>
    </div>
    <!-- --------------------------------------------------HERE------------------------------------ -->
                    <div class="panel panel-default ">
                        <div class="panel-heading master_color">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" class="collapsed" aria-expanded="false">Student's Details</a>
                            </h4>
                        </div>

                        <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <h4 class=" control-label" style="padding-bottom: 10px; padding-left:25px;"> Add Students <i  id="parent"></i></h4>
                                <div id ="wrapper_level" style="padding-left:25px;">
                                    <div id="forminputs" class="form-group data_1 studentDetails">
                                        <div class="col-sm-2">
                                            <div  style="margin-left: 0px;">
                                                <?= $this->Form->control('studentDetails[0][first_name]', ['placeholder'=> 'First Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?>
                                                <!-- <input type="text" class="form-control"  name="studentDetails[0][first_name]" value="" placeholder="First Name" required> -->
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div  style="margin-left: 15px;">
                                                <?= $this->Form->control('studentDetails[0][last_name]', ['placeholder'=> 'Last Name','type'=> 'text','label' => false, 'class' => ['form-control']]); ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-3">
                                            <div  style="margin-left: 15px;">
                                                
                                                <?= $this->Form->control('studentDetails[0][email]', ['placeholder'=> 'Email','type'=> 'email','data-validation' => "email" , 'label' => false, 'class' => ['form-control']]); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <div  style="margin-left: 15px;">
                                                <?= $this->Form->control('studentDetails[0][phone]', ['placeholder'=> 'Phone','type'=> 'text','data-validation' => "number" ,'label' => false, 'class' => ['form-control']]); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                            <span id="moreLevels" class="fa fa-plus" style="cursor: pointer;"></span>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- <div class="col-sm-1" style="padding-left: 5%;"> -->
                                        <input class="col-sm-1" type="checkbox" name="email_flag" checked style="height: 15px; width: 20px;"/>
                                    <!-- </div> -->
                                    <!-- <div>  -->
                                        Send Email to Student(s)?<br>
                                    <!-- </div> -->
                                </div>           
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default ">
                        <div class="panel-heading master_color" onclick="estimateFinalCost()">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree" class="collapsed" aria-expanded="false">Billing Details</a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                <div class="row">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading master_color">
                                                    <h7>Billing Information</h7>
                                                </div>
                                                <div class="panel-body">
                                    <div class="col-sm-12">
                                        <span class="alignment">First Name</span>
                                        <?= $this->Form->control('first_name', ['label' => false, 'required' => true, 'id' => 'billing', 'class' => ['form-control']]); ?>
                                        <span class="alignment">Last Name</span>
                                        <?= $this->Form->control('last_name', ['label' => false, 'required' => true, 'id' => 'billing', 'class' => ['form-control']]); ?>
                                        <span class="alignment">Email</span>
                                        <?= $this->Form->control('email', ['label' => false, 'required' => true, 'id' => 'billing', 'class' => ['form-control']]); ?>
                                        <span class="alignment">Phone</span>
                                        <?= $this->Form->control('phone', ['label' => false, 'required' => true, 'id' => 'billing', 'class' => ['form-control']]); ?>
                                    </div>
                                                </div>
                                                <div class="panel-footer text-center master_color">
                                                    <h7 id="finalPrice">
                                                        <strong>Total Cost: 
                                                            <span>$<?php echo (isset($finalAmount))? ($finalAmount) :$course->cost?></span>
                                                        </strong>
                                                    </h7>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div clas="col-sm-2" style="padding-left: 15px;"><b><h4>Promocode</h4></b></div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <input type="text" id="input_promocode" class="form-control" name="promo_code" placeholder="Coupon Code">
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <a id ="apply_promocode" style="color: white;" class="btn btn-sm dark_background" onclick="applyPromocode('<?= $course->id ?>')">Apply</a>
                                            </div>
                                            <div class="col-sm-1">
                                                <a id ="remove_promocode" style="color: white;" class="btn btn-sm dark_background" onclick="removePromocode('<?= $course->id ?>')">Remove</a>
                                            </div>
                                        </div>
                                        <!-- ------------ -->
                                        <div class="hr-line-dashed"></div>
                                        <?php //} ?>
                                        <!-- start -->
                                        <!-- <div class="row"> -->
                                        <div class="col-sm-12">
                                            <br>
                                             <div class="form-row">
                                                <label for="card-element">Credit or debit card</label>

                                                <div class="form-group col-lg-12">
                                                    <div id="card-element"></div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                
                                                <div class="row">
                                                    <div class="col-sm-5"></div>
                                                    <div class="col-sm-1">
                                                         <?= $this->Form->submit(__('Pay now'), ['class' => ['dark','btn', 'dark_background', 'btn-sm'], 'id' =>'payment-form-submit','style' => 'color:white;']) ?>
                                                    </div>
                                                    <div class="col-sm-5"></div>
                                                </div>
                                            <script type="text/javascript">
                                               var stripe = Stripe("<?php echo (isset($stripePublishedKey))? ($stripePublishedKey) :'pk_test_NmOfcBDkhw6h4fxbpBjGpT6q'?>");
                                            </script>
                                            <?= $this->Html->script('stripe') ?>
                                            </div>
                                        </div>
                                        <!-- </div> -->
                                        <!-- end -->
                                    <!-- </div> -->

                                    <!-- -----------YAHA------------- -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
  </div>
</div>
<style type="text/css">
    #hover-content {
        display:none;
    }
    #parent:hover #hover-content {
        display:block;
    }


    .StripeElement {
      background-color: white;
      height: 40px;
      padding: 10px 12px;
      border-radius: 4px;
      border: 1px solid transparent;
      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
    }
    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }
    .StripeElement--invalid {
      border-color: #fa755a;
    }
    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }
    .backgroundimg{background-size:cover;background-repeat:repeat;background-image: url('<?php echo $sitePath?>img/bg.jpg');}
    .btn-account{background-color: transparent;border-color: #8e8f8e; color: #FFF;}
    .btn-account:hover{color: #1a7bb9;}

</style>


<script type="text/javascript">
    $(document).ready(function() {
    var wrapper_level = $("#wrapper_level"); //Fields wrapper_level
    var add_button = $("#moreLevels"); //Add button ID
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        console.log('clicked');
        e.preventDefault();
            $(wrapper_level).append('<div id="forminputs" class="form-group remove_row'+x+' data_1 studentDetails"><div class="col-sm-2"><div  style="margin-left: 0px;"><?= $this->Form->control('studentDetails[0][first_name]', ['placeholder'=> 'First Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-2"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][last_name]', ['placeholder'=> 'last Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-3"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][email]', ['placeholder'=> 'Email','type'=> 'email','data-validation' => "email" , 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-2"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][phone]', ['placeholder'=> 'Phone','type'=> 'text','data-validation' => "number" , 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-1"><span class="remove_field fa fa-minus" style="cursor: pointer;"></span></div></div>'); //add input box
                x++; //text box increment
                // initCalendar();
    });
    
    $(wrapper_level).on("click",".remove_field", function(e){ 
        //user click on remove text
        console.log(x);
        e.preventDefault(); $('#wrapper_level .remove_row'+x+'').remove(); x--;
    })
});
</script>

<script type="text/javascript">
    $( document ).ready(function() {
        $('#remove_promocode').hide();
        $('#apply_promocode').show();
    }); 
    function applyPromocode(courseId) {
        // console.log(courseID);
        // alert(courseID);
        var promocode = $('#input_promocode').val();
        console.log(promocode);
        if(promocode) {
            var host = $('#baseUrl').val();
            console.log(host);
            jQuery.ajax({
                type: "GET",
                url: host+"api/students/promocode1/?request="+promocode+"&courseId="+courseId,
                headers:{"accept":"application/json"},
                success: function (result) {
                    console.log(result);
                    if(result.status == true){
                        
                        $('#finalPrice').html("<h7 id='finalPrice'><strong>Total Cost:<span> $"+result.finalAmount+"</span></strong></h7>");
                        $('#remove_promocode').show();
                        $('#apply_promocode').hide();
                        swal({
                                type: 'success',
                                title: 'Promo Code applied successfully.'
                            })
                    }else{
                        swal({
                            type: 'error',
                            title: 'Promo code is not valid.'
                        })    
                    }
                },
                error: function(error){
                    console.log(error);
                    swal({
                            type: 'error',
                            title: 'Promo code is not valid.'
                        })
                }
            });
        }else{
            alert('Please Enter Promocode.');
        }
    }

    function removePromocode() {
        var host = $('#baseUrl').val();
        console.log(host);
        jQuery.ajax({
            type: "GET",
            url: host+"api/students/removePromocode/",
            headers:{"accept":"application/json"},
            success: function (result) {
                console.log(result);
                swal({
                        type: 'success',
                        title: 'Promocode removed.'
                    }),
                $('#finalPrice').html("<h7 id='finalPrice'><strong>Total Cost:<span > $"+result.finalAmount+"</span></strong></h7>");
                $('#remove_promocode').hide();
                $('#apply_promocode').show();
            },
            error: function(error){
                console.log(error);
                swal({
                        type: 'error',
                        title: 'Promo code is not valid.'
                    })
            }
        });
    }

    function estimateFinalCost(){
        /*var studentsInfo = $('#studentFirstname0').val();
        alert(studentsInfo);*/
        var numItems = $('.studentDetails').length;
        console.log('numitem: '+numItems);

        var arrText= new Array();
        var i;
        
        $('#forminputs input').each(function(){
            arrText.push($(this).val());
        });
        console.log(arrText);
        
        if(arrText){
            var host = $('#baseUrl').val();
            // alert(host);
            jQuery.ajax({
                type: "POST",
                url: host+"api/students/verifyStudentInfo/",
                headers:{"accept":"application/json"},
                dataType: 'json',
                data:{
                        "studentInfo" : arrText
                    },
                success: function (result) {
                    // console.log(result);
                    // alert(result);
                    if(result.status == 0 && (typeof result.reason !== 'undefined')){
                        swal({
                                type: 'error',
                                title: result.reason
                            }) 

                    }else{
                        console.log('here in success');
                    $('#finalPrice').html("<h7 id='finalPrice'><strong>Total Cost:<span> $"+result.finalAmount+"</span></strong></h7>");
                    
                    }
                }
            });
        }else{
            swal({
                    type: 'error',
                    title: "Please fill student's Information."
                })
        }
    }

    function addAddon(addonId, addonAmount, courseAmount) {
    <?php if(empty($course->course_addons)) { ?>
        var status = false;
        var courseAmount = <?php echo $course->cost ?>;
        console.log('in if');
        console.log(courseAmount);
    <?php }else{?>
        var status = true;
        console.log('in else');
    <?php } ?>    
    
    var host = $('#baseUrl').val();
    jQuery.ajax({
        type: "POST",
        url: host+"api/students/addAddonToSession/",
        headers:{"accept":"application/json"},
        dataType: 'json',
        data:{
                "addon_id" : addonId,
                "addon_amount" : addonAmount,
                "course_amount" : courseAmount,
                "hasAddon" : status
            },
        success: function (result) {
            console.log(result);
            $('#totalPrice').html("<h7 id='totalPrice'><strong>Total Cost:<span> $"+result.data+"</span></strong></h7>");
        },
        error: function(error){
            swal({
                    type: 'error',
                    title: 'Something went wrong! Try again later.'
                })
        } 
    });
}

function removeAddon(addonId, addonAmount) {
    
    var host = $('#baseUrl').val();
    jQuery.ajax({
        type: "POST",
        url: host+"api/students/removeAddonToSession/",
        headers:{"accept":"application/json"},
        dataType: 'json',
        data:{
                "addon_id" : addonId,
                "addon_amount" : addonAmount
            },
        success: function (result) {
            console.log(result);
            // alert(result);
            // alert(result.finalAmount);
            if(result.status == true){
                $('#totalPrice').html("<h7 id='totalPrice'><strong>Total Cost:<span> $"+result.finalAmount+"</span></strong></h7>");
            }
        },
        error: function(error){
            swal({
                    type: 'error',
                    title: 'Something went wrong! Try again later.'
                })
        } 
    });
}
</script>
<script type="text/javascript">
    <?php if(empty($course->course_addons)) {?>
    $( document ).ready(function() {
        console.log('ready');
        addAddon();
    });
    <?php } ?> 
</script>
<script>
  $.validate({
    lang: 'es'
  });
</script>

