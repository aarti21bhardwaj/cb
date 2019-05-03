<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
// pr($tenantConfigSetting);die;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
               
                    <?= $this->Form->create($tenantConfigSetting) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Config Settings') ?></legend>
                        </div>
        <?php
        ?>
        <div class="form-group">
        <?= $this->Form->label('sandbox', __('Sandbox'), ['class' => ['col-sm-2', 'control-label']]) ?>
                 <!-- <?php 
                    $sandbox = ['1' => 'Yes', '0' => 'No'];
                    echo $this->Form->radio('sandbox', $sandbox, ['id' => 'sandbox','default' => '0']);
                ?>  -->

        <?php if($tenantConfigSetting->sandbox == '1') {?>
                <input type="radio" id="sandbox" name="sandbox" checked = "checked" value="1" /><strong>Yes</strong>
                <input type="radio" id="sandbox" name="sandbox" value="0"/><strong>No</strong>
        <?php } else {?>
                <input type="radio" id="sandbox" name="sandbox" value="1" /><strong>Yes</strong>
                <input type="radio" id="sandbox" name="sandbox" checked = "checked" value="0"/><strong>No</strong>
        <?php }?>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
        <?= $this->Form->label('card_print', __('Card Print'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <?php 
                    $card_print = ['1' => 'Yes', '0' => 'No'];
                    echo $this->Form->radio('card_print', $card_print, ['default' => '1']);
                ?>
        </div>
        <div class="hr-line-dashed"></div>
         <div class="form-group">
        <?= $this->Form->label('instructor_bidding', __('Instructor Bidding'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <?php 
                    $instructor_bidding = ['1' => 'Yes', '0' => 'No'];
                    echo $this->Form->radio('instructor_bidding', $instructor_bidding, ['default' => '1']);
                ?>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
         <?= $this->Form->label('payment_mode', __('Payment Mode'), ['class' => ['col-sm-2', 'control-label','id' => 'mode']]) ?>
                <?php 
                    $color = ['stripe'=>'Stripe','paypal'=>'Paypal', 'auth'=>'Auth', 'intuit'=>'Intuit'];
                    echo $this->Form->select('payment_mode', $color, ['default'=>$tenantConfigSetting->payment_mode,'id' => 'mode', 'readonly' => "readonly"]);
                ?>
                    </div>
        <div class="hr-line-dashed"></div>
        <div id="stripe1">
            <?php
                echo $this->Form->control('stripe_test_published_key');
                echo $this->Form->control('stripe_test_private_key');
        
            ?>
        </div>
        <div id="stripe2">
            <?php
                echo $this->Form->control('stripe_live_published_key');
                echo $this->Form->control('stripe_live_private_key');
        
            ?>
        </div>
        <div id="paypal1">
            <?php
                echo $this->Form->control('API_enpoint');
                echo $this->Form->control('API_username');
                echo $this->Form->control('API_password');
                echo $this->Form->control('API_signature');
                echo $this->Form->control('API_paypal_url');
            ?>
        </div>
        <div id="authorize1">
            <?php
                echo $this->Form->control('authorize_API_url_sandbox');
                echo $this->Form->control('authorize_login_id_sandbox');
                echo $this->Form->control('authorize_transaction_key_sandbox');
                echo $this->Form->control('authorize_API_url_live');
                echo $this->Form->control('authorize_login_id_live');
                echo $this->Form->control('authorize_transaction_key_live');
            ?>
        </div>
        <div id="intuit1">
            <?php
                echo $this->Form->control('intuit_login_id_sandbox');
                echo $this->Form->control('intuit_key_sandbox');
                echo $this->Form->control('intuit_login_id_live');
                echo $this->Form->control('intuit_key_live');
            ?>
        </div>
        <div class="form-group">
            <?= $this->Form->label('termcondition', __('Terms and Conditions'), ['class' => ['col-sm-2', 'control-label']]) ?>
            <div class="col-sm-10">
                <?= $this->Form->control('termcondition', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
            </div>
        </div>
        <div class="form-group">
            <?= $this->Form->label('hear_about', __('How did you hear about us?'), ['class' => ['col-sm-2', 'control-label']]) ?>
            <div class="col-sm-10">
                <?= $this->Form->control('hear_about', ['type'=> 'textarea','placeholder' => 'Redcross.org, Google, Bing, Other', 'label' => false, 'class' => ['form-control']]); ?>
            </div>
        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                
            </div>
        </div>
    </div>
</div>
<!-- ------------REMOVE THIS SCRIPT WHEN MUTIPLE PAYMENT METHODS ARE INCORPORATED ALONG WITH STRIPE--------  -->
<script type="text/javascript">
    $('#mode').on('mousedown', function(e) {
   e.preventDefault();
   this.blur();
   window.focus();
});
</script>
<!-- ------------------------------------------------------------------------------------------------------ -->
<script type="text/javascript">

$(document).ready(function(){
    $("#stripe1").hide();
    $("#stripe2").show();
    $('input:radio[name="sandbox"]').change(
    function(){
        if ($(this).is(':checked') && $(this).val() == '0') {
            $("#stripe2").show();
            $("#stripe1").hide();
            $("#stripe-live-published-key").attr("required", true);
            $("#stripe-live-private-key").attr("required", true);
        } else {
            $("#stripe2").hide();
            $("#stripe1").show();
            $("#stripe-test-published-key").attr("required", true);
            $("#stripe-test-private-key").attr("required", true);
        }
    });
    $("#paypal1").hide();
    $("#authorize1").hide();
    $("#intuit1").hide();

    $('#mode').on('change', function() {
        console.log(this.value);
        if ( this.value == 'stripe')
        {
            if($('#sandbox').is(':checked') && $('#sandbox').val() == 'No'){
                $("#stripe2").show();
                $("#stripe1").hide();
            } else {
                $("#stripe2").hide();
                $("#stripe1").show();
            }
            console.log('here');  
            $("#stripe1").show();
            $("#paypal1").hide();
            $("#authorize1").hide();
            $("#intuit1").hide();

        } else if(this.value == 'paypal')
        {
            console.log('there');
            $("#stripe1").hide();
            $("#stripe2").hide();
            $("#paypal1").show();
            $("#authorize1").hide();
            $("#intuit1").hide();

        } else if(this.value == 'auth')
        {
            console.log('where');
            $("#stripe1").hide();
            $("#stripe2").hide();
            $("#paypal1").hide();
            $("#authorize1").show();
            $("#intuit1").hide();

        } else if(this.value == 'intuit')
        {
            console.log('everywhere');
            $("#stripe1").hide();
            $("#stripe2").hide();
            $("#paypal1").hide();
            $("#authorize1").hide();
            $("#intuit1").show();
        }
    })
});
 </script>

