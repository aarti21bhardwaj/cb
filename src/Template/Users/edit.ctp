<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<style type="text/css">
    #collapseSearchResponse .panel-body{
        max-height: 300px;
        overflow-y: scroll;
    }
    #search-user-response-accordion{
        display:none;
    }
    .instantRewardButton{
        width: 39px;
        height: 230px;
        position: fixed;
        z-index: 100002;
        opacity: 0.8;
        transition: opacity 100ms;
    }
    .instantRewardButtonCont{
        bottom: -35px;
        right: 12px;
    }
</style>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
                <div class="users form large-9 medium-8 columns content">
                    <?= $this->Form->create($user) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Edit User') ?></legend>
                    </div>
                    <?= $this->Form->hidden('userId',['value' => $user->id]);?>
                        <?php
                            echo $this->Form->control('first_name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('last_name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);
                        ?>
                        <?php if($loggedInUser['id'] == $user->id){ ?>
                            <div class="form-group">
                            <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-2', 'control-label']]); ?>
                                <div class="col-sm-10">
                                    <div class="">
                                      <a data-toggle="modal" id="changePasswordButton" class="btn btn-primary" href="#changePasswordModal">Change Password</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                     <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
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

        <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'],'id'=>"saveUserPassword"]) ?>
      <?= $this->Form->end() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function(){
    var host = $('#baseUrl').val();
    $('#saveUserPassword').on('click',function(event){
        if($(this).hasClass('disabled')){
            event.preventDefault();
        }
            var userId = $('input[name=userId]').val();
            var newPwd = $('#new_pwd').val();
            var cnfNewPwd = $('#cnf_new_pwd').val();
            if(newPwd !== cnfNewPwd){
              $('#rsp_msg').addClass('alert-danger');
              $('#rsp_msg').append('<strong>Password Mismatch error</strong>');
              $('#rsp_msg').show();
            }
            if(newPwd && cnfNewPwd && (newPwd == cnfNewPwd)){
                $.ajax({
                    url: host+"api/users/updatePassword/"+userId,
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