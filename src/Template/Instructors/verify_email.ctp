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
   
    <?= $this->Form->create(NULL, ['url' => ['controller' => 'Instructors', 'action' => 'verifyEmail']]) ?>
             <?= $this->Form->control("email", array(
                    "label" => false,
                    'required' => true,
                    "class" => "form-control",
                    'type'=>'email',
                    'placeholder'=>"Type your email"));
                    ?>
        <button type="submit" class="btn btn-primary block full-width m-b" id='saveUserPassword'>Verify Email</button>
    <?= $this->Form->end() ?>
     <div class="text-center">
         
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