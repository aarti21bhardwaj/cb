<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="promoCodes form large-9 medium-8 columns content">
                    <?= $this->Form->create($promoCode) ?>
                    <fieldset>
                        <legend><?= __('Edit Promo Code') ?></legend>
                        <?php
                        // echo $this->Form->control('tenant_id', ['options' => $tenants]);
                        echo $this->Form->control('code');
                        echo $this->Form->label('Choose option type', ['label' => 'Client Type']);
                        // echo $this->Form->checkbox('client', ['Corporate Client', 'Subcontracted Client']);
                        ?>
                        <div class="form-group">
                            <div class="col-sm-3">

                                <input type="hidden" name="options" value="0" />
                                <label>
                                    <input type="checkbox" name="options" value="corporateClient" />
                                    Corporate Client
                                </label>
                                <label id="subcontractorCheckbox">
                                    <input type="checkbox" name="options" value="subcontractedClient" />
                                    Subcontracted Client
                                </label>
                            </div>
                        </div>                        
                        <div id="hiddenCorporateClient">
                            <?php
                            echo $this->Form->control('corporate_client_id', ['options' => $corporateClients, 'empty' => true]);
                            ?>
                        </div>
                        <div id="hiddenSubcontractedClient">
                            <?php
                            echo $this->Form->control('subcontracted_client_id', ['options' => $subcontractedClients, 'empty' => true]);
                            ?>
                        </div>

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                              <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                          </div>
                          <?= $this->Form->label('start_date', __(' Start Date'), ['class' => ['col-sm-2', 'control-label']]); ?>
                          <div class="col-sm-3">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="start_date" value="<?php echo $promoCode->start_date;?>">
                            </div>
                        </div>

                        <?= $this->Form->label('end_date', __(' End Date'), ['class' => ['col-sm-2', 'control-label']]); ?>
                        <div class="col-sm-3">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" class="form-control" name="end_date" value="<?php echo $promoCode->end_date;?>   ">
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
          
                    <div class="form-group">
                      <?= $this->Form->label('Choose option type', __('Choose option type'), ['class' => ['col-sm-2', 'control-label']]) ?>

                      <div class="col-sm-10" style="padding-left: 30px;">
                      <input type="radio" checked="checked" name="discount_type" value="Dollars Off"> <b>Dollars Off</b>
                      <div >
                      <input type="radio" name="discount_type" value="Percentage Off" > <b>Percentage Off</b>
                      </div>
                      </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                     <?php
                    echo $this->Form->control('discount', ['data-validation'=>"number", 'min'=>"1"]);
                    echo $this->Form->control('no_of_uses',['min'=>"0",'data-validation'=> "number length", 'data-validation-length'=>'00-05',"data-validation-error-msg"=> "Maximum length should be in 5 digits only"]);
                    ?>
                    <div class="form-group">
                        <?= $this->Form->label('options',__('Options'), ['class' => ['col-sm-2', 'control-label']]); ?> 
                        <div class="col-sm-6">

                            <label>
                            <?php echo $this->Form->checkbox('restrict_by_course_types', ['id'=>'courseTypeCheckbox', 'hiddenField' => false]);?>
                                <!-- <input type="checkbox" id="courseTypeCheckbox"  name="restrict_by_course_types" value="" /> -->
                                Restrict use by course type 
                            </label>
                            <label>
                            <?php echo $this->Form->checkbox('restrict_by_email', ['id'=>'emailCheckbox','hiddenField' => false]);?>
                                <!-- <input type="checkbox" id="emailCheckbox" name="restrict_by_emails" value="" /> -->
                                Restrict use to those with an uploaded list of email addresses
                            </label>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    
                    <div class="form-group" id="courseTypeField">
                        <label class="col-sm-2 control-label" for="name">Course Type</label>
                        <div class="col-sm-10">
                            <?= $this->Form->control('promo_code_course_types',['label' => false,'options'=> $courseTypes,'class'=>['select2_demo_2','form-control'], 'multiple' => true])?>
                        </div>
                    </div>
                    <div class="form-group" id="emailField">
                        <?= $this->Form->label('email', __('Emails Allowed'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('email', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea'], 'id' => 'emailTextArea']); ?>
                          </div>
                    </div>
    
                    <div class="form-group">
                        <div class="col-sm-10">
                            <label class="col-sm-offset-6">
                                <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                            </label>
                        </div>
                    </div> 
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                <?= $this->Form->end() ?>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
      <?= "promoCode = ".json_encode($promoCode).';'?>
        console.log("apple");
        console.log(promoCode);
        setTimeout(function() {

          tinymce.remove('#emailTextArea');
        }, 10);
      
        $(".select2_demo_2").select2();

          $('.input-group.date').datepicker({
              todayBtn: "linked",
              keyboardNavigation: false,
              forceParse: false,
              calendarWeeks: true,
              autoclose: true
          });
        // $('#discount-type-0').prop("checked", true);

        $('#hiddenCorporateClient').hide();
        $('#hiddenSubcontractedClient').hide();
        $(function() {

        var corporateField = $("#hiddenCorporateClient");
        var subcontratedField = $("#hiddenSubcontractedClient");
        var corporateCheckbox = $("input[value=corporateClient]");
        var subcontractedCheckbox = $("input[value=subcontractedClient]");

          corporateCheckbox.change(function() {
            if (corporateCheckbox.is(':checked')) {
              $('#subcontractorCheckbox').hide();
              subcontratedField.hide();
              corporateField.show();
          } else {
              corporateField.hide();
          }
      });
          subcontractedCheckbox.change(function() {
            if (subcontractedCheckbox.is(':checked')) {
              subcontratedField.show();
          } else {
              subcontratedField.hide();
          }
      });
      });

        if(promoCode.corporate_client_id != null){
          $("input[value=corporateClient]").prop("checked",true);
          $("#hiddenCorporateClient").show();
        }
        if (promoCode.subcontracted_client_id != null) {
          $("input[value=subcontractedClient]").prop("checked",true);
          $("#hiddenSubcontractedClient").show();
        }

        $('#courseTypeField').hide();
        $('#emailField').hide();
        $(function() {
          var courseTypeField = $("#courseTypeField");
          var emailField = $("#emailField");
          var courseTypeCheckbox = $("#courseTypeCheckbox");
          var emailCheckbox = $("#emailCheckbox");
          courseTypeCheckbox.change(function() {
            console.log('coursetype_changed');
            if (courseTypeCheckbox.is(':checked')) {
                console.log('coursetype_checked');
              courseTypeField.show();
          } else {
              courseTypeField.hide();
          }
      });
          emailCheckbox.change(function() {
            console.log('email_changed');
            if (emailCheckbox.is(':checked')) {
                console.log('email_checked');
              emailField.show();
          } else {
              emailField.hide();
          }
      });
      });
        if(promoCode.restrict_by_course_types == true){
          $("#courseTypeCheckbox").prop("checked",true);
          $("#courseTypeField").show();
        }
        if (promoCode.restrict_by_email == true) {
          $("#emailCheckbox").prop("checked",true);
          $("#emailField").show();
        }

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
