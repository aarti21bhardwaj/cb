<?php
use Cake\I18n\Date;
use Cake\I18n\Time;
// pr($tenant->tenant_config_settings['0']->remaining_seats); die();
?>
<script src="https://js.stripe.com/v3/"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxKI6elv3aXMzIUY6mP9q6qDMIwWZcGq0&callback=initMap"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> <link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">
<?php
$loginFormTemplate = [
            // 'button' => '<button class="dark btn btn-sm btn-success" {{attrs}}>{{text}}</button>',
    'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
    'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
    'label' => '<label class="col-sm-4 control-label" {{attrs}}>{{text}}</label>',
    'formStart' => '<div class="ibox-content light"><form class="form-horizontal" {{attrs}}>',
    'radioWrapper' => '<div class="radio-inline">{{label}}</div>',
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
        width: 90% !important;
        margin-left: 4% !important;
    }
/*.navbar-right li a {o
    margin: 0px 12px !important ;
   
    height: 60px !important;
}
.nav > li > a {
    padding: 18px !important;
    }*/
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
<!-- <style type="text/css">
    #parent {
        overflow: hidden;
        position: relative;
        width: 100%;
}
    #child-right {
        background:green;
        height: 100%;
        width: 100%;
        position: absolute;
        right: 0;
        top: 0;
}
</style> -->
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
<?php //pr($course);die(); ?> 
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="text-right">
                    <?=$this->Html->link('Bulk Payment', ['controller' => 'Students', 'action' => 'bulkPayment',$course->id,$requestData],['class' => ['btn', 'dark_background'],'style' => ['color: white']])?>
                </div>
                <div class="ibox-content">
                    <div id="wizard">
                        <h1>Course Selection</h1>
<!-- --------------------------------------START OF TAB 1 HERE----------------------------------------------- -->
                        <div class="step-content">
                            <div class="col-lg-8">
                                <div class="panel panel-default">
                                    <div class="panel-heading dark_background">
                                        <strong><?php echo $course->training_site?$course->training_site->name:"";?></strong>
                                    </div>
                                    <div class="panel-body">
                                        <?php
                                        if(!empty($tenant->tenant_config_settings) && ($tenant->tenant_config_settings['0']->remaining_seats) == '1'){ ?>

                                            <p class="text-right"><span class="badge"><?php echo $course->seats?> Seats Remaining</span></p>
                                        <?php } ?>

                                        <?php if(!empty($tenant->tenant_config_settings) && $tenant->tenant_config_settings['0']->course_description == '1'){ ?>
                                            <p><strong>Description</strong>: <?php echo $course->course_type->description?></p>
                                        <?php }?>

                                        <?php
                                        if(isset($course->course_dates) && !empty($course->course_dates)):
                                            foreach ($course->course_dates as $date) :
                                                $timeFrom = new Time($date->time_from);
                                                $timeTo = new Time($date->time_to);
                                                ?>
                                                <!-- <p><strong>Date</strong>: <?php echo $time = Date::parseDate($date->course_date, 'dd MM, y');?></p> -->
                                                <p><strong>Date</strong>: <?php echo $date->course_date->format('d/m/y')?></p>
                                                <p><strong> Time</strong>: <?php echo $timeFrom->i18nFormat('HH:mm')." - ".$timeTo->i18nFormat('HH:mm');?></p>

                                            <?php endforeach; endif; ?>

                                            <?php if(!empty($tenant->tenant_config_settings) && $tenant->tenant_config_settings['0']->course_description == '1'){ ?>

                                                <p><strong>Location Notes</strong>:
                                                    <?php if(isset($course->location) && !empty($course->location)){ ?>
                                                        <?php echo $course->location->name;?>,&nbsp;
                                                        <?php echo $course->location->city;?>,&nbsp;
                                                        <?php echo $course->location->state;?>,&nbsp;
                                                        <?php echo $course->location->zipcode;?>
                                                    <?php }?>
                                                </p>
                                            <?php } ?>

                                            <?php if(!empty($tenant->tenant_config_settings) && $tenant->tenant_config_settings['0']->course_description == '1'){ ?>
                                                <p><strong>Class Notes</strong>: <?php echo $course->class_details?></p>
                                            <?php }?>

                                            <?php if(isset($course->course_addons) && !empty($course->course_addons)):?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading dark_background">
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
                                                </div>
                                            </div>
                                        <?php endif;?>        
                                    </div>
                                    <div class="panel-footer dark_background text-center">
                                        <h7 id="totalPrice" class=""><b>Total Price: $<?php echo (isset($finalAmount))? ($finalAmount) :$course->cost ?></b></h7>
                                    </div>
                                </div>
                            </div>      
                            <div class="col-lg-4">
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
<!-- ------------------------------------------END OF TAB 1 HERE--------------------------------------------- -->
                        <h1>Register / Login</h1>
                        <div class="step-content">
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="register" id="register_student">
                                        <div class="col-lg-2"></div>
                                        <div class="col-lg-8">
                                            <!-- <div class="ibox float-e-margins"> -->
                                                <?php if(isset($loggedInUser)){?>
                                                    <div class="panel-heading dark_background" style="width: 96%; margin-left:2%;">
                                                        <b>Student Details</b>
                                                        <!-- <h2 class="font-bold text-center">Student Register</h2> -->
                                                    </div>
                                                <?php } else { ?>
                                                    <div class="panel-heading dark_background" style="width: 96%; margin-left:2%;"><b>Register Student</b>
                                                    </div>
                                            <?php } ?>
                                            <div id="not_logged_in">
                                                <?php echo $this->Form->create($student, ['id'=>'form','url' => ['action' => 'register']]); ?>
                                                <div class="col-sm-12">
                                                    <?php if( isset($loggedInUser) && $loggedInUser['role_id'] == 5 ){?>
                                                        <div class="panel body" style="padding-top: 20px;">
                                                            <span style="padding-left: 14px;">First Name</span>
                                                            <?= $this->Form->control('first_name', ['label' => false,'required', 'type'=>'text', 'data-validation'=>'custom','disabled'=>true, 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
                                                            <span style="padding-left: 14px;">Last Name</span>
                                                            <?= $this->Form->control('last_name', ['label' => false,'required', 'type'=>'text', 'data-validation'=>'custom','disabled'=>true, 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                                                            <span style="padding-left: 14px;">Email</span>
                                                            <?= $this->Form->control('email',['label' => false,'disabled'=>true]) ?>
                                                            <span style="padding-left: 14px;">Mobile Number</span>
                                                            <?= $this->Form->control('phone1', ['disabled'=>true,'label'=> false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                                                        </div>
                                                    <?php } else{?>
        <!-- -------------------------CASE WHEN USER IS NOT LOGGED IN---------------------------- -->
                                                        <div class="panel body" style="padding-top: 20px;">
                                                            <span style="padding-left: 14px;">First name</span>
                                                            <?= $this->Form->control('first_name', ['label' => false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
                                                            <input type="hidden" name="course_flag" value="1">
                                                            <span style="padding-left: 14px;">Last Name</span>
                                                            <?= $this->Form->control('last_name', ['label' => false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                                                            <span style="padding-left: 14px;">Email</span>
                                                            <?= $this->Form->control('email',['label' => false,]) ?>
                                                            <span style="padding-left: 14px;">Mobile Number</span>
                                                            <?= $this->Form->control('phone1', ['label'=> false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                                                            <span style="padding-left: 14px;">Create Password</span>
                                                            <?= $this->Form->control('password', ['label'=>false,'id'=>'password','required', 'type'=>'password','onkeyup' => 'check();']); ?>
                                                            <span style="padding-left: 14px;">Confirm Password</span>
                                                            <?= $this->Form->control('confirm_password', ['label' => false,'id'=>'confirm_password','required', 'type'=>'password','onkeyup' => 'check();']); ?>
                                                                <!-- </div> -->
                                                            <span id='message' style="padding-left: 14px;"></span>
                                                        <!-- </div> -->
                                                        <?php }?>
                                                        <?php if( isset($loggedInUser) && $loggedInUser['role_id'] == 5 ){?>
                                    </div>
                                                         <!-- </div> -->
                                                         <?php } else{ ?>
                                                    <!-- <div class="panel-body">         -->
                                                            <div class='text-center col-sm-offset-3'>
                                                                <?= $this->Form->button(__('Register'),['class' => ['dark_background']]); ?>
                                                            </div>
                                                            <p class="col-sm-offset-4">Already have an account ?
                                                                <span onclick ="login()">
                                                                    <a>Login</a>
                                                                </span>
                                                            </p>
                                                    </div>        
                                        </div>
                                                        <?php }?>
                                                        <?= $this->Form->end() ?>
                                                        </div>
                                                    </div>
                                                        <!-- </div> --> <!-- Panel body ends here -->
                                                        <!-- </div> -->
                                                    </div> <!-- register -->        
                                        <div id="login_student">
                                            <div class="col-lg-2"></div>
                                            <div class="col-lg-8">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading dark_background">
                                                        <strong>Student Login</strong>
                                                    </div>
                                                    <div class="panel-body">
                                                     <div class="form-group" autocomplete="off">
                                                        <span>Email *</span>
                                                        <input id="email1" name="email" type="text" class="form-control required email">
                                                    </div>
                                                    <div class="form-group" autocomplete="off">
                                                        <span>Password *</span>
                                                        <input id="password1" name="password1" type="password" class="form-control required password">
                                                    </div>
                                                    <input type='hidden' name="loginStudent"></input>
                                                    <div class="text-center">
                                                        <span class="text-center">
                                                            <button type="submit" class="dark_background" style=" size: 80px; color:#ffffff; font-size:16px;" onclick="studentLogin()">Login</button>
                                                        </span>
                                                        <p>Register instead ?
                                                            <span onclick ="register()">
                                                                <a>Register</a>
                                                            </span>
                                                        </p>
                                                    </div> <!-- buttons login student -->
                                                </div> <!-- panel body login student -->
                                            </div>   <!-- Panel default login student -->      
                                        </div> <!-- lg-8 login student -->
                                    </div> <!-- login student -->
                                </div> <!-- Panel ends here -->
                            </div> <!-- row -->
                        </div> <!-- step content -->
<!-- --------------------------------------PAYMENT DIV STARTS FROM HERE----------------------------------- -->
                                <h1>Payment</h1>
                                <div class="step-content">
                                    <div class="master_color">
                                        <div class="col-sm-12">
                                            <div class="panel panel-default">
                                                <div class="panel-heading dark_background">
                                                    <strong><?php echo $course->training_site?$course->training_site->name:"";?></strong>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="col-sm-6">
                                                    <?php if(isset($course->course_type) && !empty($course->course_type)){?>
                                                        <p><strong>Course Name</strong>:
                                                            <?php echo $course->course_type->name; ?>
                                                        </p>
                                                     <?php }?>   
                                                    <?php
                                                    if(isset($course->course_dates) && !empty($course->course_dates)):
                                                        foreach ($course->course_dates as $date) :
                                                            $timeFrom = new Time($date->time_from);
                                                            $timeTo = new Time($date->time_to);
                                                            ?>
                                                            <!-- <p><strong>Date</strong>: <?php echo $time = Date::parseDate($date->course_date, 'dd MM, y');?></p> -->
                                                            <p><strong>Date</strong>: <?php echo $date->course_date->format('d/m/y')?></p>
                                                            <p><strong> Time</strong>: <?php echo $timeFrom->i18nFormat('HH:mm')." - ".$timeTo->i18nFormat('HH:mm');?></p>
                                                        <?php endforeach; endif; ?>
                                                        <?php if(!empty($tenant->tenant_config_settings) && $tenant->tenant_config_settings['0']->course_description == '1'){ ?>

                                                            <p><strong>Location</strong>:
                                                                <?php if(isset($course->location) && !empty($course->location)){ ?>
                                                                    <?php echo $course->location->name;?>,&nbsp;
                                                                    <?php echo $course->location->city;?>,&nbsp;
                                                                    <?php echo $course->location->state;?>,&nbsp;
                                                                    <?php echo $course->location->zipcode;?>
                                                                <?php }?>
                                                            </p>
                                                        <?php } ?>
                                                        </div> <!-- Col-sm-6 -->
                                                        <div class="col-sm-6">
                                                <?php if(!empty($tenant->tenant_config_settings) && $tenant->tenant_config_settings['0']->promocode == '1'){ ?>
                                                        <div class="">
                                                            <h5 class="" style="padding-left: 87px;"><b>Promo Code</b></h5>
                                                                    <div class="col-sm-2"></div>
                                                                    <div class="row col-sm-6">
                                                                        <!-- <div class="col-xs-7"> -->
                                                                            <div class="form-group ">
                                                                                <input type="text" id="input_promocode" class="form-control" name="promo_code" placeholder="Coupon Code">
                                                                                </div>
                                                                    </div>
                                                                        <div class="row col-sm-4">
                                                                            <div class="col-sm-1">
                                                                                <h4>
                                                                                <a class="master_color btn-sm" onclick="promocode('<?= $course->id ?>')">Apply</a>
                                                                                </h4>
                                                                            </div>
                                                                            <div class="col-sm-2"></div>
                                                                            <div class="col-sm-1">
                                                                                <h4>
                                                                                <a class="master_color btn-sm">Cancel</a>
                                                                                </h4>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer dark_background text-center">
                                                    <!-- <strong>Amount</strong> -->
                                                    <h7 id="total" onchange="myFunction()" class="font-bold"><b>Total Price: $<?php echo (isset($finalAmount))? ($finalAmount) :$course->cost ?></b></h7>
                                                </div>
                                            </div> <!-- End of col-sm-12 -->
                                        </div> <!-- end of master color -->
                                                <div class="col-sm-12" style="margin-top: 4%;">
                                                    <div class="panel panel-default ">
                                                        <div class="panel-heading dark_background">
                                                            <strong>Credit or Debit Card</strong>
                                                            <span class="pull-right">
                                                                <i class="fa fa-cc-amex text-success"></i>
                                                                <i class="fa fa-cc-mastercard text-warning"></i>
                                                                <i class="fa fa-cc-discover text-danger"></i>
                                                            </span>
                                                        </div>
                                                        <div class="panel-body">
                                                            <?= $this->Form->create(null,['id'=>"payment-form",'enctype'=>"multipart/form-data","data-toggle"=>"validator"]);?>
                                                            <span class="">
                                                                <div id="card-element"></div>
                                                                <div id="card-errors" role="alert"></div>
                                                            </span>
                                                            <div class="row">
                                                                <div class="row col-sm-offset-4" style="padding-top: 15px;">
                                                                   <?= $this->Form->button(__('Pay now'), ['class' => ['dark_background','col-sm-offset-6'], 'id' =>'payment-form-submit']) ?>
                                                               </div>
                                                           </div>
                                                           <?= $this->Form->end(); ?>
                                                           <script type="text/javascript">
                                                             var stripe = Stripe("<?php echo (isset($stripePublishedKey))? ($stripePublishedKey) :'pk_test_NmOfcBDkhw6h4fxbpBjGpT6q'?>");
                                                         </script>
                                                         <?= $this->Html->script('stripe') ?>
                                                    </div>
                                                    <div class="panel-footer dark_background" style="height: 40px;">
                                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!-- ------------------------------------PAYMENT DIV IS TILL HERE-------------------------------------- -->
                </div>
                <!-- --till here-- -->
            </div>
        </div>
    </div>
</div>
</div>   

<!-- <script type="text/javascript">
    var stripe = Stripe("<?php echo (isset($stripePublishedKey))? ($stripePublishedKey) :'pk_test_NmOfcBDkhw6h4fxbpBjGpT6q'?>");
</script>
<?= $this->Html->script('stripe') ?> -->

<script type="text/javascript">
    $(document).ready(function(){
        $('#register_student').show();
        $('#login_student').hide();
        $("#logged_in").hide();
        // $('#login_student').show();
    });
    function login(){
            // alert('yoyoyoy');
            $('#register_student').hide();
            $('#login_student').show();
            $('.pull-right').hide();
            // $(".pull-left").hide();
        }
        function register(){
            $('#register_student').show();
            $('#login_student').hide();
            $('.pull-right').show();
        }
        function studentLogin(){
            var email = $("#email1").val();
            var password =  $("#password1").val();
            var host = $('#baseUrl').val();
            jQuery.ajax({
                type: "POST",
                url: host+"api/students/login",
                headers:{"accept":"application/json"},
                dataType: 'json',
                data:{
                    "email" : email,
                    "password" : password,
                },
                success: function (result) {
                    console.log(result);
                    console.log(result.response.response);
                    if(result.response.response == 0){
                        swal({title: "Failed", text:result.response.message, type: "error"});
                        // $('.pull-right').show();    
                    } else {   
                        // var message = result.data;
                        // console.log(message);
                        swal({title: "Done", text:result.response.message, type: "success"});
                        $("#login_student").replaceWith('Sucesfully logged in! Please press Next to proceed with payment!');
                        $('#register_student').hide();
                    }
                        // $(".pull-left").show();
                        // $(".pull-right").replaceWith('Login successful!');
                    },
                    error: function(result){
                        swal({title: "Failed", text: result.response.message, type: "error"});
                    }
                });
        }
    </script>
    <script type="text/javascript">
     var check = function() {
        if(document.getElementById('password').value == '' && document.getElementById('password').value == ''){
            document.getElementById('message').innerHTML = '';
        } else {     

          if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
        document.getElementById('message').innerHTML = 'Passwords OK!';
    } else {
        document.getElementById('message').style.color = 'red';
        document.getElementById('message').innerHTML = 'Passwords do not match!';
    }
}
}
</script>

<script type="text/javascript">
// $(document).ready(function(){
//     var host = $('#baseUrl').val();
//     jQuery.ajax({
//         type: "POST",
//         url: host+"api/students/clearSession/",
//         headers:{"accept":"application/json"},
//         success: function (result) {
//             console.log(result);
//         },
//         error: function(error){
//             swal({
//                     type: 'error',
//                     title: 'Something went wrong! Try again later.'
//                 })
//         }
//     });
// });
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
            "hasAddon" : status,
        },
        success: function (result) {
            console.log(result);
            $('#totalPrice').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+result.data+"</b></h7>");
            $('#total').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+result.data+"</b></h7>");
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
            if(result.status == true){

                $('#totalPrice').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+result.finalAmount+"</b></h7>");
                $('#total').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+result.finalAmount+"</b></h7>");
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
function promocode(courseTypeId = null) {
    console.log(courseTypeId);
    console.log('courseTypeId');
    var promocode = $('#input_promocode').val();
    console.log(promocode);
    if(promocode !== null && promocode !== '') {
        ajaxCall(promocode,courseTypeId);
    }else{
        alert('Please Enter Promocode.');
    }
}
// This api request is to get the instructor as per request query
function ajaxCall(promocode,courseId){
    var host = $('#baseUrl').val();
    console.log(host);
    jQuery.ajax({
        type: "GET",
        url: host+"api/students/promocode/?request="+promocode,
        headers:{"accept":"application/json"},
        success: function (result) {
            console.log(result);
            var totalAmount = result.finalAmount;
            if(result.status == true){
                swal({
                    type: 'success',
                    title: 'Promo Code applied successfully.'
                }),
                $('#totalPrice').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+totalAmount+"</b></h7>");
                $('#total').html("<h7 id='totalPrice' class='font-bold'><b>Total Price: $"+totalAmount+"</h7>");
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
}
$(document).ready(function(){
    $('input[type=radio][name=addon28]').on("change", function(){
        console.log('here in change');
        var addonId = $(this).val();
        alert(addonId);
        addAddons(addonId);
    });
    $(".register").show();
    $(".login").hide();
    $(".loginClick").click(function(){
        $(".login").show();
        $(".register").hide();
    });
    $(".registerClick").click(function(){
        $(".register").show();
        $(".login").hide();
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $.validate();
        $.validate({
            modules : 'location',
            onModulesLoaded : function() {
                $('input[name="state"]').suggestState();
            }
        });
    });
</script>

<script>
    $(document).ready(function(){
        $("#wizard").steps();
    });
</script>

<style type="text/css">
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

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>
  $.validate({
    modules : 'security'
});
</script>

<script type="text/javascript">
    <?php if(empty($course->course_addons)) {?>
        $( document ).ready(function() {
            console.log('ready');
            addAddon();
        });
    <?php } ?> 
</script>
