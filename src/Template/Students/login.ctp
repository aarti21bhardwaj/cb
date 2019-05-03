<?php
$loginFormTemplate = [
        'button' => '<button class="dark button button-block" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '{{content}}',
        'label' => '',
];

$this->Form->setTemplates($loginFormTemplate);
?>
<?php 
$salonTemplate = [
'formStart' => '<form class="" {{attrs}}>',
         'formEnd' => '</form>',
    ];
$this->Form->setTemplates($salonTemplate);
?>

<!-- <div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Login via site</h3>
                </div>
                <div class="panel-body">
                    <?= $this->Form->create(null,['class'=>'m-t'])?>
                    <?= $this->Form->control('email') ?>
                    <?= $this->Form->control('password') 
                    ?>
                    <?= $this->Form->button(__('Login')); ?>
                        <div class="text-center">
                            <strong><a href="<?= $this->Url->build(['controller' => 'Students','action' => 'forgotPassword'])?>"><small>Forgot password?</small></a></strong><br>
                            &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All rights reserved.
                        </div>
                    <?= $this->Form->end() ?>

                      <hr/>
                    <center><h4>OR</h4></center>
                    <input class="btn btn-lg btn-facebook btn-block" type="submit" value="Login via facebook">
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="form">
      
      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Sign Up</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
      </ul>
      
      <div class="tab-content">
        <div id="signup">   
          <h1>Student Sign Up Form</h1>
            <?php echo $this->Form->create(null, ['url' => ['action' => 'register']]); ?>
            <?php //echo $this->Form->create(null,['class'=>'m-t'])?>
            <div class="top-row">
                <div class="field-wrap">
                    <label>First Name<span class="req">*</span></label>
                    <?php echo $this->Form->control('first_name',['label'=>false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$'])?>
                </div>

                <div class="field-wrap">
                    <label>Last Name<span class="req">*</span></label>
                    <?php echo $this->Form->control('last_name',['label'=>false,'required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$'])?>
                </div>
            </div>
            
            <div class="field-wrap">
                <label>Email Address<span class="req">*</span></label>
                <?php echo $this->Form->control('email',['label'=>false,'required'])?>
            </div>
           <div class="field-wrap">
                <label>Phone<span class="req">*</span></label>
                <?php echo $this->Form->control('phone1',['label'=>false,'required'])?>
            </div>
            <div class="field-wrap">
                <label>Create Password<span class="req">*</span></label>
                <!-- <?php echo $this->Form->control('password',['label'=>false,'required','id' => 'password'])?> -->
                <input name="password" id="password" type="password" onkeyup='check();' />
            </div>
            <div class="field-wrap">
                <label>Confirm Password<span class="req">*</span></label>
                <input type="password" name="confirm_password" required="" id="confirm_password" onkeyup='check();' />
                <br>
                <span id='message'></span>
            </div>

            <?php //$this->Form->control('email') ?>
            <?php //$this->Form->control('password') ?><!-- 
            <?php echo $this->Form->button(__('Get Started',['id' => 'submit'])); ?>
 -->
          <!-- <div class="field-wrap text-center col-sm-4 col-md-offset-4"> -->
            <input  type="submit" id= "submit" value="Get Started" style="background-color: #337ab7; color: #ffffff;"/>
          <!-- </div> -->
            <?= $this->Form->end() ?>
          <!-- <form action="/" method="post">
          
          <div class="top-row">
            <div class="field-wrap">
              <label>
                First Name<span class="req">*</span>
              </label>
              <input type="text" required autocomplete="off" />
            </div>
        
            <div class="field-wrap">
              <label>
                Last Name<span class="req">*</span>
              </label>
              <input type="text"required autocomplete="off"/>
            </div>
          </div>

          <div class="field-wrap">
            <label>
              Email Address<span class="req">*</span>
            </label>
            <input type="email"required autocomplete="off"/>
          </div>
          
          <div class="field-wrap">
            <label>
              Set A Password<span class="req">*</span>
            </label>
            <input type="password"required autocomplete="off"/>
          </div>
          
          <button type="submit" class="button button-block"/>Get Started</button>
          
          </form> -->

        </div>
        
        <div id="login">   
          <h1>Welcome Back!</h1>
            <?= $this->Form->create(null)?>
                <div class="field-wrap">
                    <label>Email Address<span class="req">*</span></label>
                    <?php echo $this->Form->control('email',['label'=>false,'required'])?>
                </div>

                <div class="field-wrap">
                    <label>Password<span class="req">*</span></label>
                    <?php echo $this->Form->control('password',['label'=>false,'required'])?>
                </div>
            <?= $this->Form->button(__('Login')); ?>
             <div class="text-center">
                    <strong><a href="<?= $this->Url->build(['controller' => 'Students','action' => 'forgotPassword'])?>"><small>Forgot password?</small></a></strong><br> 
                    <!-- &copy;<?php echo ' '.(date("Y")-1).'-'.date("Y").' '?>Classbyte, LLC, All rights reserved. -->
                </div>
            <?= $this->Form->end() ?>
        </div>
      </div><!-- tab-content -->
</div>

<script type="text/javascript">
   var check = function() {
    if(document.getElementById('password').value == '' && document.getElementById('password').value == ''){
    document.getElementById('message').innerHTML = '';
    } else {     
          if (document.getElementById('password').value ==
            document.getElementById('confirm_password').value) {
            document.getElementById('message').style.color = 'green';
            document.getElementById('message').innerHTML = 'Passwords OK!';
            document.getElementById("submit").disabled = false;
          } else {
            document.getElementById('message').style.color = 'red';
            document.getElementById('message').innerHTML = 'Passwords do not match!';
            document.getElementById("submit").disabled = true;
          }
    }
}
</script>