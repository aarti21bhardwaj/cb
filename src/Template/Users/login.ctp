<?php
/**
  * @var \App\View\AppView $this
  */
?>
<?php



$loginFormTemplate = [
        'button' => '<button class="btn btn-primary full-width m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($loginFormTemplate);
?>
<div class="middle-box text-center loginscreen animated fadeInDown">
	<h3>Welcome to ClassByte</h3>
	<?= $this->Form->create(null,['class'=>'m-t']) ?>
	<?= $this->Form->control('email') ?>
	<?= $this->Form->control('password') ?>
	<?= $this->Form->button(__('Login')); ?>   
	<div class="row">
            <div class="text-center">
                <strong><a href="<?= $this->Url->build(['controller' => 'users','action' => 'forgotPassword'])?>"><small>Forgot password?</small></a></strong><br>

                &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>ClassByte, LLC, All Rights Reserved.
            </div>
        </div>  
	<?= $this->Form->end() ?>
</div>