<?php 
use Cake\Http\Session;
?>
<script src="https://js.stripe.com/v3/"></script>
<div class="col-md-12">
    <?= $this->Form->create(null,['id'=>"payment-form",'enctype'=>"multipart/form-data","data-toggle"=>"validator"]);?>
        <div>
        <table class="table">
          <tbody>
            <tr>
              <td><strong>Course Code</strong></td>
              <td><?= $course->course_type->course_code ?></td>
            </tr>
            <tr>
              <td><strong>Course Name</strong></td>
              <td><?= $course->course_type->name.' ($'.$course->cost.')' ?></td>
            </tr>
            <?php
            if(isset($addons) && !empty($addons)){
            ?>

            <tr>
              <td><strong>Addons Added</strong></td>
              <?php foreach ($addons as $value): ?>
              <td><?= $value->name.' ($'.$value->price.')' ?></td>
              <?php endforeach;?>

            </tr>
            <?php } ?>
            <?php if(isset($courseStudents) && $courseStudents->payment_status == "Partial" ){
            $partialAmountData = $this->request->getSession()->read('getPaymentData');
            ?>
            <tr>
              <td><strong>Total Amount:</strong></td>
              <td><strong>$<?= $partialAmountData[$student->id]['totalAmount']?></strong></td>
            </tr>
            <tr>
              <td><strong>Amount Paid:</strong></td>
              <td><strong>$<?= $partialAmountData[$student->id]['paidAmount']?></strong></td>
            </tr>
            <tr>
              <td><strong>Balance Amount:</strong></td>
              <td><strong>$<?= $partialAmountData[$student->id]['balance']?></strong></td>
            </tr>
            <?php }else{?>
            <tr>
              <td><strong>Total Amount</strong></td>
              <td><strong>$<?= isset($paymentData[$student->id]['finalAmount'])?$paymentData[$student->id]['finalAmount']: $course->cost?></strong></td>
            </tr>
            <?php }?>
          </tbody>
        </table>
        </div>
                <div class='form-group row' >
            <div class="col-sm-12">
                <!-- <div class=""> -->
                    <label class="control-label col-sm-1 text-center" >Amount</label>
                <!-- </div> -->
                <div class="col-sm-10">
                    <input class="form-control" id = "paymentAmount" type="text" name="amount">
                </div>
            </div>
        </div>
        <div class="form-row">
        <label for="card-element">Credit or debit card</label>

        <div class="form-group col-lg-12">
            <div id="card-element"></div>
            <div id="card-errors" role="alert"></div>
        </div>

        <div class="form-group">
        <?= $this->Form->button(__('Pay now'), ['class' => ['btn', 'btn-danger', 'btn-lg'], 'id' =>'payment-form-submit']) ?>
        </div>
    <?= $this->Form->end(); ?>
    
    <script type="text/javascript">
       var stripe = Stripe("<?php echo (isset($stripePublishedKey))? ($stripePublishedKey) :'pk_test_NmOfcBDkhw6h4fxbpBjGpT6q'?>");
    </script>
    <?= $this->Html->script('stripe') ?>
    </div>
</div>

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
