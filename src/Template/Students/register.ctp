<?php
$loginFormTemplate = [
        'button' => '<button class="dark btn btn-primary full-width m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="col-sm-4 control-label" {{attrs}}>{{text}}</label>',
        'formStart' => '<form class="" {{attrs}}>',
        'formEnd' => '</form>',
];
$this->Form->setTemplates($loginFormTemplate);
?>
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4">
        <div class="ibox float-e-margins">
            <div class="ibox-content light" >
               <div>
                <h2 class="font-bold text-center">Student Register</h2>
                <p>Already have an account,
                <?= $this->Html->link(__('Login'), ['controller' => 'Students', 'action' => 'login']) ?>
                </p>

                <?= $this->Form->create(null,['class'=>'m-t'])?>
                <?= $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
            
                <?= $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>

                <?= $this->Form->control('email') ?>
                <?= $this->Form->control('password') ?>
                <!-- <?= $this->Form->control('confirm_password') ?> -->
                <?= $this->Form->button(__('Register')); ?>
                    <div class="text-center">
                        <!-- <strong><a href="<?= $this->Url->build(['controller' => 'Students','action' => 'forgotPassword'])?>"><small>Forgot password?</small></a></strong><br> -->
                        &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All rights reserved.
                    </div>
                <?= $this->Form->end() ?>
                </div>

            </div>
        </div>
    </div>
    <div class="col-lg-4"></div>
</div>
