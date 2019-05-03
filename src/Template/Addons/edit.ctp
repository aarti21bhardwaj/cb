<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

$loginFormTemplate = [
        'radioWrapper' => '<div class="radio-inline">{{label}}</div>',
];
$this->Form->setTemplates($loginFormTemplate);
?>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content">
          <div class="addons form large-9 medium-8 columns content">
              <?= $this->Form->create($addon) ?>
              <fieldset>
              <div class = 'ibox-title'>
                  <legend><?= __('Edit Addon') ?></legend>
              </div>
                    <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                        <!-- <div class="form-group text required">
                            <label class="col-sm-2 control-label" for="duration"></label>
                            <div class="col-sm-10">
                                <?= $this->Form->control('tenant_id', ['value' =>$loggedInUser['id'],'type'=>'hidden', 'id' => 'tenantId']); ?>
                            </div>
                        </div> -->
                        <?php } else {?>
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Tenant'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-10">
                               <?= $this->Form->control('tenant_id', ['label' => false, 'required' => true, 'id' => 'tenantId', 'class' => ['form-control']]); ?>
                            </div>
                        </div>
                    <?php } ?>
                  <?php
                      // echo $this->Form->control('tenant_id', ['options' => $tenants]);
                      echo $this->Form->control('product_code');
                      echo $this->Form->control('name');
                  ?>
                      <div class="form-group">
                                      <?= $this->Form->label('description', __('Description'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                      <div class="col-sm-10">
                                          <?= $this->Form->control('description', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                                      </div>
                      </div>

                      <div class="form-group">
                          <?= $this->Form->label('short_description', __('Options'), ['class' => ['col-sm-2', 'control-label']]) ?>
                          <div class="col-sm-3">
                              <?= $this->Form->control('short_description', ['placeholder'=>"Description",'type'=> 'text', 'label' => false, 'class' => ['form-control', 'fr-view'], 'required' => 'true']); ?>
                          </div>
                          <div class="col-sm-3">
                              <?= $this->Form->control('price', ['placeholder'=>"Price",'type'=> 'text', 'label' => false, 'class' => ['form-control', 'fr-view'], 'required' => 'true']); ?>
                          </div>
                          <div class="col-sm-3">
                          <?php $option_status = ['1' => 'Active', '0' => 'Inactive'];
                                echo $this->Form->select('option_status', $option_status, ['empty' => '--Status--']);?>
                          </div>
                      </div>
                      
                      <?php
                      // echo $this->Form->control('short_description',['type' =>'text']);
                      // echo $this->Form->control('price');
                      // echo $this->Form->control('option_status'); 
                      // echo $this->Form->control('type');
                      echo $this->Form->label('Choose option type',['label' => 'Type']); ?>
                      <?php if(isset($tenantSetting) && $tenantSetting->key_management == '1'){?>
                        <?php
                      echo $this->Form->radio('type', ['Shippable Item','Non Shippable Item',' Key Code']);
                      echo '<div class="hr-line-dashed"></div>';
                       ?>

                    <div class="form-group" id="key_category_id_show">
                      <div class="col-sm-10">
                        <?php 
                        echo $this->Form->control('key_category_id', ['options' => $keyCategories , 'empty'=>'--SELECT ONE--']);
                        ?>
                      </div>
                    </div>
                  <?php } else {?>
                      <?php echo $this->Form->radio('type', ['Shippable Item','Non Shippable Item']);
                      echo '<div class="hr-line-dashed"></div>';
                       ?>

                  <?php }?>
              </fieldset>
              <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
      </div> <!-- .ibox-content ends --> 
    </div> <!-- .ibox ends -->
  </div> <!-- .col-lg-12 ends -->

</div> <!-- .row ends -->
<script type="text/javascript">
$(document).ready(function(){
  var a = $('#type-2').prop("checked");
  if(a == true){
      $("#key_category_id_show").show();
    }else{

      $("#key_category_id_show").hide();
    }
    $('#type-2').on('change', function() {
      if ( this.value == '2')
      {
        $("#key_category_id_show").show();
      }
    });
    $('#type-1').on('change', function() {
      if ( this.value == '1')
      {
        $("#key_category_id_show").css("display", "none");
      }
    });
    $('#type-0').on('change', function() {
      if ( this.value == '0')
      {
        $("#key_category_id_show").css("display", "none");
      }
    });
});
</script>
