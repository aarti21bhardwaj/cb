<?php

$template = [
        'button' => '<button class="btn btn-primary" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="control-label mr-auto col-sm-3" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($template);
?>
<div class="passwordBox animated fadeInDown">
  <div class="row">
    <div class="col-md-12">
      <div class="ibox-content">
      <h2 class="font-bold"><?= __('Forgot Password') ?></h2>
      <p><?= __('Enter your email address and you will get a link from where you can update your password.') ?></p>
        <div class="row">
          <div class="col-lg-12">
            <?= $this->Form->create(null, ['id'=>'forgot-password-form','data-toggle'=>"validator", 'class' => 'form-horizontal']); ?>
              <div class="form-group">
                <div class="col-sm-12">
                  <?= $this->Form->control('email', ['data-validation' => 'email','label' => false, 'placeholder'=>"Email address" ,'required' => true, 'class' => ['form-control']]); ?>
                  <div class="help-block with-errors"></div>
                </div>
              </div>
              <div class="row text-center">
                <?= $this->Form->button(__('Submit'), ['class' => ['btn','btn-primary','full-width']]) ?>
              </div>
            <?= $this->Form->end() ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="text-center">
      <strong><a href="<?= $this->Url->build(['controller' => 'users','action' => 'login'])?>"><small>Go Back To Login</small></a></strong><br>
      &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All Rights Reserved.
    </div>
  </div>  
</div>
