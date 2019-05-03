<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>',
];

$this->Form->setTemplates($salonTemplate);
?>
<?php if($loggedInUser['role']->name == 'student'){  
    $salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>',
        'label' => '<label class="control-label col-sm-3" {{attrs}}>{{text}}</label>',
        'input' => '<div class="col-sm-offset-3"><input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/></div>',
        ];

    $this->Form->setTemplates($salonTemplate);
?>
<style type="text/css">
   .form {
    background: #fff !important;
    padding: 12px !important;
    max-width: 600px;
    
}
.form-control {
    display: block;
    width: 90% !important;}
.control-label {
    padding-top: 7px;
    font-weight: normal;
    font-size: 15px;
  
    margin-bottom: 0;
    text-align: right;
}
label{
     
}
</style>
<?php }?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="students form large-9 medium-8 columns content">
                    <?= $this->Form->create($student) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Student') ?></legend>
                        </div>
                        <?php  if($loggedInUser['role']->name == 'tenant'){ ?>
                        
                        <div  id = "schools">
                        <?= $this->Form->control('corporate_client_id', ["id" => "school",'empty' => '--SELECT ONE--','options' => $corporateClients]); ?>
                        </div>
                        <div  id = "campuses">
                        <?= $this->Form->control('subcontracted_client_id', ['empty' => '--SELECT ONE--', 'id' => 'selectCampuses','options' => $subcontractedClients]); ?>
                        </div>

                        <?php if($loggedInUser['role']->label != 'TRAINING SITE OWNER'){  ?>
                            <?= $this->Form->control('training_site_id', ['required','empty' => '--SELECT ONE--','options' => $trainingSites]); ?>
                        
                        <?php }} ?>

                        
                        <?php  if($loggedInUser['role']->name == 'corporate_client'){ ?>
                        
                        <?= $this->Form->control('subcontracted_client_id', ['empty' => '--SELECT ONE--', 'id' => 'selectCampuses','options' => $subcontractedClients]); ?>
                        
                        <?php } ?>
                        <?php
                        echo $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);
                        
                        ?>
                        <?= $this->Form->hidden('userId', ['value' => $student->id]) ?>
                        <div class="form-group">
                            <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-3', 'control-label']]); ?>
                                <div class="col-sm-3">
                                    <div class="">
                                      <a data-toggle="modal" id="changePasswordButton" class="btn btn-primary" href="#changePasswordModal">Change Password</a>
                                    </div>
                                </div>
                        </div>

                        <!-- <div class="form-group text required"><label class="control-label col-sm-3" for="email">Email</label><div class="col-sm-offset-3"><input type="text" class="form-control" name="email" data-validation="email" required="required" maxlength="255" id="email" value="vivek@gmail.com"></div></div> -->

                        <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-3', 'control-label']]) ?>
                            <div class="col-sm-9">
                                <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <?php 
                        echo $this->Form->control('city');
                        echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                        echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>'05-05']);
                        echo $this->Form->control('phone1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                        echo $this->Form->control('phone2');
                        if($loggedInUser['role']['name'] != 'student'){
                        ?>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label class="col-sm-offset-6">
                                        <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                    </label>
                                </div>
                            </div>
                        </div>

                        <?php }?>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger','m-b']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Change Password Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="changePasswordModal">
  <div class="modal-dialog" role="document">
    <?= $this->Form->create(null, ['class' => 'form-horizontal','data-toggle'=>"validator"]) ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= __('CHANGE PASSWORD')?></h4>
      </div>

      <div class="modal-body">
      <div class="alert" id="rsp_msg" style=''>

        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("new_pwd", array(
            "label" => false,
            'id'=>'new_pwd',
            "type"=>"password",
            'required' => true,
            "class" => "form-control",'data-minlength'=>5,
            'data-validation'=> "length" ,
            'data-validation-length'=>"min5",
            'placeholder'=>"Enter New Password"));
            ?>
            <div class="help-block with-errors"><?= __('')?></div>
          </div>
        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('Confirm New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("cnf_new_pwd", array(
            "label" => false,
            "type"=>"password",
            'id'=>'cnf_new_pwd',
            'required' => true,
            'data-validation'=> "length" ,
            'data-validation-length'=>"min5",
            "class" => "form-control",'data-minlength'=>5,'data-match'=>"#new_pwd",'data-match-error'=>"__('MISMATCH')",'placeholder'=>"Confirm Password"));
            ?>
            <div class="help-block with-errors"><?= __('')?></div>
          </div>
        </div>


      </div>
      <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'],'type' => 'button','id'=>"saveUserPassword"]) ?>
      <?= $this->Form->end() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
<?php  if($loggedInUser['role']->name == 'tenant' ){ ?>

<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("campuses").style.display = "none";
        document.getElementById("selectCampuses").required = false;
        var host = $('#baseUrl').val();
        $("#school").on('change',function(){
            var CorporateClientId = $('#school').val();
            if(CorporateClientId){
                $.ajax({
                        url: host+"api/users/fetchSubcontractors/"+CorporateClientId,
                        type: "GET",
                        dataType : 'json',
                        header : {'accept' : "application/json", 'contentType': "application/json"},
                        success: function (data) {

                          
                            if(data.response.length > 0){
                                $('select[id = selectCampuses]').empty();
                                    document.getElementById("campuses").style.display = "block";
                                    document.getElementById("selectCampuses").required = true;
                                    $('select[id = selectCampuses]').append($('<option>',{
                                        value : null,
                                        text : "choose Subcontracted client if required"
                                    }));
                                    $.each(data.response, function(i, values){
                                        
                                        $('select[id = selectCampuses]').append($('<option>',{
                                            value : values.id,
                                            text : values.name
                                        }));
                                       
                                    });
                            }else{
                                $('select[id = selectCampuses]').empty();
                                document.getElementById("campuses").style.display = "none";
                                document.getElementById("selectCampuses").required = false;
                            }
                        }
                    });
            }else{
                document.getElementById("campuses").style.display = "none";
                document.getElementById("selectCampuses").required = false;
            }
        });
    });
</script>
<?php } ?>
<script type="text/javascript">
console.log('here');
    $(document).ready(function(){
    var host = $('#baseUrl').val();
    $('#saveUserPassword').on('click',function(event){
        if($(this).hasClass('disabled')){
            event.preventDefault();
        }
            var userId = $('input[name=userId]').val();
            console.log(userId);

            var newPwd = $('#new_pwd').val();            
            var cnfNewPwd = $('#cnf_new_pwd').val();
            if(newPwd !== cnfNewPwd){
              $('#rsp_msg').addClass('alert-danger');
              $('#rsp_msg').append('<strong>Password Mismatch error</strong>');
              $('#rsp_msg').show();
            }
            if(newPwd && cnfNewPwd && (newPwd == cnfNewPwd)){
                console.log('in if');
                $.ajax({
                    url: host+"api/Students/updatePassword/"+userId,
                    headers:{"accept":"application/json"},
                    dataType: 'json',
                    data:{
                        "user_id" : userId,
                        "new_password" : newPwd,
                    },
                    type: "put",
                    success:function(data){
                        if($('#rsp_msg').hasClass('alert-danger')){
                            $('#rsp_msg').removeClass('alert-danger');
                        }
                        $('#rsp_msg').empty();
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass('alert-success');
                        $('#rsp_msg').append('<strong>Password changed successfully.</strong>');
                        $('#rsp_msg').show();
                        setTimeout(function(){
                            $('#rsp_msg').fadeIn(500);
                            $('#changePasswordModal').modal('hide');
                            $('#rsp_msg').removeClass('alert-success');
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');
                        }, 2000);
                    },
                    error:function(data){
                        var className = 'alert-danger';
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass(className);
                        $('#rsp_msg').append('<strong>' + data.responseJSON.message + '</strong>');
                        setTimeout(function(){
                            if($('#rsp_msg').hasClass(className)){
                                $('#rsp_msg').removeClass(className);
                            }
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');

                        }, 2000);
                        $('#rsp_msg').fadeIn(500);

                    },
                    beforeSend: function() {

                    }
                });

            }
            event.preventDefault();
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