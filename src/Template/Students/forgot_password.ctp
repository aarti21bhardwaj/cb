<?php

$template = [
        'button' => '<button class="dark btn btn-primary full-width m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="control-label mr-auto col-sm-3" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($template);
?>
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content light" >
               <div>
                <h2 class="font-bold text-center">Forgot Password</h2>
                <p><?= __('Enter your email address and you will get a link from where you can update your password.') ?></p>

                <?= $this->Form->create(null, ['id'=>'forgot-password-form','data-toggle'=>"validator", 'class' => 'form-horizontal']); ?>
                
                <?= $this->Form->control('email', ['data-validation' => 'email','label' => false, 'placeholder'=>"Email address" ,'required' => true, 'class' => ['form-control']]); ?>
                <div class="help-block with-errors"></div>
                <?= $this->Form->button(__('Submit')); ?>
                <div class="text-center">
                    <strong><a href="<?= $this->Url->build(['controller' => 'Students','action' => 'login'])?>"><small>Go Back To Login</small></a></strong><br>
                    &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All rights reserved.
                </div>
                <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4"></div>
</div>
