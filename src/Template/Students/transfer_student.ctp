<?php 
// pr($orderDetails);die;
?>
<script src="https://js.stripe.com/v3/"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            <div class="courses form large-9 medium-8 columns content">
             <?= $this->Form->create(null,['id'=>'transferStudentForm']) ?> 

             <fieldset>
                <div class='ibox-title'>
                    <legend><?= __('Transfer Student') ?></legend>
                </div>
                    <div >
                        <strong><?php echo "Student info :"; ?></strong>
                        <strong><?php echo "  Name - "; ?></strong> 
                           <?php echo $student->first_name; echo " " ;echo $student->last_name; echo " | "; ?> 
                        <strong><?php echo " Email - "; ?></strong> 
                           <?php echo $student->email; echo " | "; ?>
                         <strong><?php echo " City - "; ?></strong> 
                        <?= $student->city ?  $student->city : "No information available" ?>
                           <!-- <?php echo $student->city; ?> -->
                           <?php echo " | "; ?> 
                        <strong><?php echo " State - "; ?></strong>
                           <!-- <?php echo $student->state; ?> -->
                           <?= $student->state ?  $student->state : "No information available" ?>    
                    </div>
                    
                    <div>
                        <strong><?php echo "Current Course info:" ?></strong>
                        <strong><?php echo " Name - ";?></strong>
                            <?php echo $course->course_type->name;?>
                           <strong><?php echo " | Category - "?></strong>
                         <?= $course->course_type_category ?  $course->course_type_category->name : "No information available" ?> 
                        <strong><?php echo " | City - "?></strong>
                         <?= $course->city ?  $course->city : "No information available" ?> 
                        <strong><?php echo " | State - "?></strong>
                        <?= $course->state ?  $course->state : "No information available" ?> 
                        <strong><?php echo " | Address - "?></strong> 
                        <?= $course->address ?  $course->address->name : "No information available" ?> 
                    </div>
                    <div>
                        <strong><?php echo "Amount paid: " ;?></strong>
                            <?php echo "$".$sum;?>
                    </div>
                        <br><br>
              <!--   <div >
                        <span style="float:left";>
                    <label class="control-label">Course Type:</label>
                        </span>
                    <div >
                        <?php echo $this->Form->control('', ['empty' => 'Please Select one','options' => $courseTypes,'label'=>false]);?>
                    </div>
                </div> -->
                 <div>
                        <span style="float:left";>
                    <label class="control-label" >Transfer Type:</label>
                        </span>
                    <div >
                        <?php echo $this->Form->control('', ['default' => 'Transfer Only','options' => $transferType,'label'=>false, 'name' => 'transferType','id' => 'transferType','required'=>true]);?>
                    </div>
                </div>
                
                <div>
                        <span style="float:left";>
                    <label class="control-label" >Transfer To:</label>
                        </span>
                    <div >

                        <?php echo $this->Form->control('course_id', ['empty' => 'Please Select one','options' => $transferToCourses, 'label'=>false,'name' => 'transferToCourses' ,'required'=>true]);?>
                    </div>
                </div>
               
                <div class="form-group row" id = "refund">
                    <div class="col-sm-9">
                        <label class="control-label">Total Paid Amount : <?php echo $sum;?></label>
                          <div class='form-group row'>
                              <span class="col-sm-3" style="float:left";>
                                  <label data-toggle="tooltip" data-placement="top" title="Please enter an amount less than the transaction amount you select, In case you want proceed with a partial refund. " data-original-title="Tooltip on top">Partial Refund : <i class="fa- fa fa-info-circle"></i></label>
                              </span>
                              <div class="col-sm-8">
                                  <input value ="" class="form-control col-sm-4" type="text" id="refund_amount" name = "refund_amount" placeholder="Please Enter Amount">
                              </div>
                          </div>
                    </div>
                </div>     
                <div class='row'>    
                    <div class="col-sm-4 col-sm-offset-2" id="payNow">
                            <a href='#' class="btn btn-primary " data-toggle="modal" data-target="#paymentModal" id="modalButton">Pay Now</a>
                    </div>
                </div>
            </fieldset>
            <div id="transferStudentButton">
            <?= $this->Form->Button('Transfer Student',['id' => 'transferButton','disabled'=>true]) ?>
            </div> 
            <?= $this->Form->end() ?>
            </div>
            </div>
        </div>
    </div>
</div>
<!--row end -->
<div class="modal fade" id="paymentModal" role="dialog">
<div class="modal-dialog" style="width: 950px;" >
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Payments</h4>
        </div>

        <div class="modal-body" class="white-bg">
           <div class="row">
                    <div class="col-md-12">
                        <form id="payment-form">
                            <div class="form-row">
                                <label for="card-element">Credit or debit card</label>

                                <div class="form-group col-lg-12">
                                    <div id="card-element"></div>
                                    <div id="card-errors" role="alert"></div>
                                </div>
                            </div>
                            <div class='form-group row' >
                                <div class="col-sm-12">
                                    <!-- <div class=""> -->
                                        <label class="control-label col-sm-2 text-center" >Amount</label>
                                    <!-- </div> -->
                                    <div class="col-sm-10">
                                        <input class="form-control" id = "paymentAmount" type="text" name="amount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                     <?= $this->Form->button(__('Transfer Student'), ['class' => ['dark','btn', 'btn-success', 'btn-lg'], 'id' =>'payment-form-submit']) ?>

                                </div>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" id="closeModal" class="btn btn-default btn-danger" data-dismiss="modal">Close</button>
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
        </div>
       </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    // $('#transferButton').attr('disabled',true);
    $("#amount").hide();
    $("#payNow").hide();
    $('#refund').hide();
    
    $("#amount").removeAttr( 'required' );

    $('#transferType').on('change', function() {
        console.log(this.value);
        if ( this.value == 'Transfer & Process Payment')
        {
            console.log('here');  
            $("#amount").hide();
            $("#payNow").show();
            $('#refund').hide();
            $('#transferStudentButton').hide();           
            $("#amountToPay").attr( 'required',true );

        } else if(this.value == 'Transfer & Process Refund')
        {
            console.log('there');
            $("#amount").show();
            $("#payNow").hide();
            $('#refund').show();
            $("#transferStudentButton").show();           
            $("#amountToPay").attr( 'required',true );
                     
        } else if(this.value == 'Transfer Only'){
            
            $("#amount").hide();
            $('#refund').show();           
            $('#refund').hide();
            $("#transferStudentButton").show();           
            $("#amountToPay").removeAttr( 'required' );

        }
    })


    function paymentValidate(){
    $("#amountToPay").attr( 'required',true );
    $("#transferStudentButton").hide();

    }


   $('#course-id').change(function() {
        if($('#course-id').val()){
            $('#transferButton').attr('disabled',false);
        }else{
            $('#transferButton').attr('disabled',true);
        }
        if($('#transferType').val() == 'Transfer & Process Payment' && $('#course-id').val() ){
            $('#modalButton').attr('disabled',false);
        }else{
            $('#modalButton').attr('disabled',true);
        }

    });
   // $('#course-id').change(function() {
   //      console.log($('#course-id').val());
   //      console.log($('#transferType').val());
       

   //  });

});
$('#modalButton').click(function(){

    var stripe = Stripe("<?php echo (isset($stripePublishedKey))? ($stripePublishedKey) :'pk_test_NmOfcBDkhw6h4fxbpBjGpT6q'?>");
    var elements = stripe.elements();
    var courseId = $("#transferToCourses").val();
    var style = {
      base: {
        // Add your base input styles here. For example:
        fontSize: '20px',
        color: "#32325d",
      }
    };

    // Create an instance of the card Element
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>
    console.log("$('#card-element')");
    console.log($('#card-element'));
    card.mount('#card-element');


    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      //var abc = $('#payment-form').validator('validate');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });


    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      if($("#payment-form").valid()) {
          stripe.createToken(card).then(function(result) {
            if (result.error) {
              // Inform the customer that there was an error
              var errorElement = document.getElementById('card-errors');
              errorElement.textContent = result.error.message;
              swal({title: "Error", text: "Payment failed!", type: "error"});
            } else {
              // Send the token to your server
              console.log('hahaha');
              console.log(result.token);
              // var courseId = $("#transferToCourses").val();
              // alert(courseId);
              var amount = $("#paymentAmount").val();
              jQuery.ajax({
                url: host+"api/students/saveToken/",
                headers:{"accept":"application/json"},
                dataType: 'json',
                data: {'token': result.token,
                        'amount': amount},
                type: "POST",
                success: function (result) {
                       console.log('success');
                       swal({title: "Done", text: "Payment succesful!", type: "success"});
                       $("#paymentModal").modal('hide');
                       setTimeout(function() {
                       $('#transferStudentForm').submit();
                        }, 1500);
                    },
                    error: function(result) {
                       console.log('Error');
                       console.log(result);
                       swal({title: "Error", text: "Something went wrong! Please try again", type: "error"});
                    }
                });
              // stripeTokenHandler(result.token);
            }
          });
      }
    });


    $('#payment-form-submit').on('click', function(){
        $("#payment-form").valid();
    });

    function stripeTokenHandler(token) {
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);
      // Submit the form
      // form.submit();
      $('#payment-form-submit').html('Processing ...');
      $('#payment-form-submit').attr("disabled", "disabled");
    }
});
</script>
<script type="text/javascript"></script>