<?php

$template = [
        'button' => '<div class="form-group"><button class="btn btn-primary" {{attrs}}>{{text}}</button></div>',
            'formStart' => '<div><form class="m-t" {{attrs}}>',
            'formEnd' => '</form></div>',
            'formGroup' => '{{label}}{{input}}',
            'hiddenBlock' => '<div style="display:none;">{{content}}</div>',
            'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
            'inputSubmit' => '<input type="{{type}}"{{attrs}}/>',
            'inputContainer' => '<div class= "form-group" {{type}}{{required}}">{{content}}</div>',
            'inputContainerError' => '<div {{type}}{{required}} error">{{content}}{{error}}</div>',
            'label' => '<label class="control-label" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($template);
?>
<div class="passwordBox animated fadeInDown">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox-content">

            <h3>Welcome to Classbyte</h3>
            <p>            </p>
            <h3>Reset Password</h3>
            <?= $this->Form->create(NULL, ['url' => ['controller' => 'Users', 'action' => 'resetPassword'],'data-toggle'=>"validator"]) ?>
                    <?= $this->Form->control("new_pwd", array(
                            "label" => false,
                            'required' => true,
                            'id'=>'new_pwd',
                            "type"=>"password",
                            "class" => "form-control",
                            'data-minlength'=>5,
                            'data-validation'=> "length" ,
                            'data-validation-length'=>"min5",
                            'placeholder'=>"Enter Password"));
                            ?>
                    <?= $this->Form->hidden('reset-token',['value' => $resetToken]);?>
                    <?= $this->Form->control("cnf_new_pwd", array(
                            "label" => false,
                            'required' => true,
                            "class" => "form-control",
                            'id'=>'cnf_new_pwd',
                            'data-minlength'=>5,
                            'data-validation'=> "length" ,
                            'data-validation-length'=>"min5",
                            'data-match'=>"#new_pwd",
                            "type"=>"password",
                            'data-match-error'=>"Whoops, these don't match",
                            'placeholder'=>"Confirm Password"));
                            ?>
                <button type="submit" class="btn btn-primary block full-width m-b">Reset password</button>
            <?= $this->Form->end() ?>
             <div class="text-center">
          <strong><a href="<?= $this->Url->build(['controller' => 'Users','action' => 'login'])?>"><small>Go Back To Login</small></a></strong><br>
          &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All rights reserved.
        </div> 
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    $('#saveUserPassword').on('click',function(event){
            if($(this).hasClass('disabled')){
                event.preventDefault();
            }
            var newPwd = $('#new_pwd').val();
            var cnfNewPwd = $('#cnf_new_pwd').val();
            if(newPwd && cnfNewPwd ){
                event.preventDefault();
            }
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