<?php
/*$loginFormTemplate = [
        'button' => '<button class="dark btn btn-primary full-width m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
        'formStart' => '<form class="" {{attrs}}>',
         'formEnd' => '</form>',
];

$this->Form->setTemplates($loginFormTemplate);*/
use Cake\Http\Session;
// pr('billing');
// pr($billing);die;
?>
<?php
$loginFormTemplate = [
        'button' => '<button class="dark button button-block" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '{{content}}',
        'label' => '',
        'select' => '<select name="{{name}}" class="form-control m-b" {{attrs}}>{{content}}</select>',
        'formStart' => '<form class="" {{attrs}}>','formEnd' => '</form>',
];

$this->Form->setTemplates($loginFormTemplate);
?>
<style type="text/css">
    label{font-size: 14px;}
    .manual_set{
      margin: 0px auto;
      width: 40%;
    
    }
    .form-group select{
        font-size: 16px;
    display: block;
    width: 100%;
    height: 100%;
    padding: 9px 10px;
    font-weight: normal;
    background: none;
        background-image: none;
    background-image: none;
    border: 1px solid #a0b3b0;
    color: #337ab7;
    opacity: 0.7;
    border-radius: 0;
    transition: border-color .25s ease, box-shadow .25s ease;
} 
.field-wrap select {
        font-size: 16px;
    display: block;
    width: 100%;
    height: 100%;
    padding: 9px 10px;
    font-weight: normal;
    background: none;
        background-image: none;
    background-image: none;
    border: 1px solid #a0b3b0;
    color: #337ab7;
    opacity: 0.7;
    border-radius: 0;
    transition: border-color .25s ease, box-shadow .25s ease;
}
</style>
<div class="row">
    <div class=""></div>
    <div class=" manual_set">
        <div class="ibox float-e-margins">
            <div class="ibox-content light" >
               <div>
                <h2 class="font-bold text-center">Thank You!</h2>
                <h3 class="font-bold text-center">You have been successfully added to the course.</h3>
               <div>
                <table class="table">
                                      <tbody>
                                      <tr>
                                          <td><strong>Course Code</strong></td>
                                          <td><?= $course->course_type->course_code ?></td>
                                      </tr>
                                      <tr>
                                          <td><strong>Course Name</strong></td>
                                          <td><?= $course->course_type->name.' ($'.$course->cost.')' ?></td>
                                      </tr>
                                      <?php  
                                      if(!empty($addons)){?>

                                          <tr>
                                              <td><strong>Addons Added</strong></td>
                                          <?php foreach ($addons as $value): ?>
                                              <td><?= $value->name.' ($'.$value->price.')' ?></td>
                                              <?php endforeach;?>
                                              
                                          </tr>
                                      <?php } ?>
                                      <tr>
                                          <td><strong>Total Amount</strong></td>
                                          <td><strong>$<?= $finalAmount ?></strong></td>
                                      </tr>
                                      <?php if(isset($loggedInUser) && !empty($loggedInUser)){?>
                                      <tr>
                                          <td><strong>Registered Students</strong></td>
                                          <td><strong><?php
                                                  echo $student->first_name." ".$student->last_name." (".$student->email.")"." (".$student->phone1.")"."<br>";
                                          ?></strong></td>
                                      </tr>
                                      <?php } else {?>
                                      <tr>
                                          <td><strong>Registered Students</strong></td>
                                          <td><strong><?php foreach($student as $key=>$value){
                                                  echo $value->first_name." ".$value->last_name." (".$value->email.")"." (".$value->phone1.")"."<br>";
                                          }?></strong></td>
                                      </tr>
                                    <?php } ?>
                                    <?php if(!isset($loggedInUser) && empty($loggedInUser)){?>
                                    <?php if($this->request->getSession()->read('billing_information')){
                                      $billing = $this->request->getSession()->read('billing_information');
                                      // pr($billing);die;
                                      ?>
                                      <div class=''>
                                      <tr>  
                                       <th>BILLING INFORMATION: </th>
                                     </tr>
                                    <tr>
                                        <td><strong>Name:</strong></td>
                                        <td><?= $billing['first_name']." ". $billing['last_name']?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td><?= $billing['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td><?= $billing['phone']?></td>
                                    </tr>
                                  </div>
                                    <?php } }?>

                                      </tbody>
              </table>
             </div>
<style type="text/css">
input::placeholder {
   font-size: 16px !important;
}</style>
                    <div class="error-desc">
                        <h4>Please spare a few more seconds to fill out this form. </h4>
                        <?= $this->Form->create(null,['class'=>'form-inline m-t'])?>
                            
                            
                            <div class="field-wrap">
                                <label></label>
                                <?= $this->Form->control('student_profession', ['type'=> 'text', 'label' => false, 'placeholder' => 'Student Profession', 'class' => ['']]); ?>
                            </div>
                            <div class="field-wrap">
                                
                                <?= $this->Form->control('requested_organisation', ['type'=> 'text', 'label' => false, 'placeholder' => 'What company/organization is requiring you to take this class?', 'class' => ['form-control']]); ?>
                            </div>
                            <div class="field-wrap">
                               
                                <?= $this->Form->control('comments', ['type'=> 'text', 'label' => false,'placeholder' => 'Comments or special requests?', 'class' => ['form-control']]); ?>
                            </div>
                              <?php
                                if(!empty($tenant->tenant_config_settings[0]->hear_about)){

                                
                                $hear_about_us = explode(',', $tenant->tenant_config_settings[0]->hear_about); 
                                  if(!empty($hear_about_us)) { ?>
                            <div class="field-wrap form-groups">

                                <?php
                                echo $this->Form->select('hear_about_us', $hear_about_us, ['onchange'=>"getValue(this)",'empty' => 'How did you hear about us?','name' => 'hear_about_us','class' => ['form-control'] ]);
                                ?>



                            </div>
                            <?php } } ?>
                            <div class="field-wrap form-group" id="show">
                                <?= $this->Form->control('others', ['type'=>'textarea','label' => false,'id'=>'others','placeholder' => 'How did you hear about us?']); ?>
                                
                            </div>
                            
                            <div class="form-group">
                                <!-- <label>Are you a healthcare provider?</label> -->
                                <?php 
                                $health_care_provider = ['yes' => "Yes, I'm a healthcare provider", 'no' => "No, I'm not a healthcare provider"];
                                echo $this->Form->select('health_care_provider', $health_care_provider, ['empty' => 'Are you a healthcare provider?']);
                                ?>
                            </div>
                            
                            <?= $this->Form->button(__('Submit')); ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=""></div>
</div>

<!-- onchange='checkvalue(this.value)' -->
<script type="text/javascript">
$("#show").hide();
function getValue(data){
   $("#show").hide();

   document.getElementById("show").style.display = "none";
    var hearAboutUsId = data.value;
    var total = data.length-2;
    console.log(hearAboutUsId);
    console.log(total);
    if(hearAboutUsId == total){
      console.log('hi');
       $("#show").show();
    }
    // alert(hearAboutUsId);
    
}
</script>