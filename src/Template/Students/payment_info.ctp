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
                <h2 class="font-bold text-center">Amount already Paid!</h2>
                <h3 class="font-bold text-center">You have been already paid for the course!</h3>
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
                                      <tr>
                                          <td><strong>Location</strong></td>
                                          <td><?php echo $course->location->name.'<br>' ?>
                                                 <?php echo $course->location->city.'<br>' ?> 
                                                 <?php echo $course->location->state.', '.$course->location->zipcode.'<br>'?></td>
                                      </tr>
                                      <tr>
                                          <td><strong>Start Date</strong></td>
                                          <td><?= $course->course_dates[0]->course_date->format('m/d/Y') ?></td>
                                      </tr>
                                      <?php 
                                      if(isset($orderDetails[0]->addon)){
                                      	// die('ss');
                                        ?>
                                      <tr>
                                          <td><strong>Addons Added</strong></td>
                                      <?php foreach ($orderDetails as $value): ?>
                                          <td><?= $value->addon->name.' ($'.$value->addon->price.')' ?></td>
                                          <?php endforeach;?>
                                          
                                      </tr>
                                      <?php } ?>
                                      <tr>
                                          <td><strong>Total Amount Paid</strong></td>
                                          <td>$<?= $finalAmount ?></td>
                                      </tr>
                                      
                                      </tbody>
              </table>
             </div>
<style type="text/css">
input::placeholder {
   font-size: 16px !important;
}</style>
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