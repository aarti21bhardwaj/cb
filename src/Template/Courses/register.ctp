<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script> <link rel="stylesheet" href="https://wfolly.firebaseapp.com/node_modules/sweetalert/dist/sweetalert.css">

<style>
textarea{
    margin-left: 42px;
}
</style>

    
                    <div class="students form large-9 medium-8 columns content">
                        <?= $this->Form->create(null,['id'=>'registerform']) ?>
                        <fieldset>
                            <div class = 'ibox-title'>
                                <legend><?= __('Register New Student') ?></legend>
                            <!-- </div> -->
                        <!-- <div class="form-group">
                                <div class="col-sm-10">
                                    <label class="col-sm-3 control-label" data-toggle="tooltip" data-placement="top" title="First Name,Last Name,E-mail,Phone . Enter multiple students in new lines " data-original-title="Tooltip on top" class ='col-sm-2'> <i class="fa- fa fa-info-circle" "></i>Add Students</label>
                                    </br>
                                    <?= $this->Form->control('studentDetails', ['placeholder'=> 'First Name,Last Name,Email,Phone','type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea']]); ?>
                                </div>
                        </div> -->
                        <div id ="wrapper_level">
                            <div id="forminputs" class="form-group data_1 studentDetails">
                                <div class="col-sm-2">
                                    <div  style="margin-left: 0px;">
                                        <?= $this->Form->control('studentDetails[0][first_name]', ['placeholder'=> 'First Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?>
                                        <!-- <input type="text" class="form-control"  name="studentDetails[0][first_name]" value="" placeholder="First Name" required> -->
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div  style="margin-left: 15px;">
                                        <?= $this->Form->control('studentDetails[0][last_name]', ['placeholder'=> 'Last Name','type'=> 'text','label' => false, 'class' => ['form-control']]); ?>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div  style="margin-left: 15px;">
                                        
                                        <?= $this->Form->control('studentDetails[0][email]', ['placeholder'=> 'Email','type'=> 'email','data-validation' => "email" , 'label' => false, 'class' => ['form-control']]); ?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div  style="margin-left: 15px;">
                                        <?= $this->Form->control('studentDetails[0][phone]', ['placeholder'=> 'Phone','type'=> 'text','data-validation' => "number" ,'label' => false, 'class' => ['form-control']]); ?>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <span id="moreLevels" class="fa fa-plus" style="cursor: pointer;"></span>
                                </div>

                            </div>
                        </div>
                            <div class="form-group">
                                <?= $this->Form->label('cost', __('Per Student Cost'), ['class' => ['col-sm-2', 'control-label']]) ?>
                                <div class="col-sm-10">
                                    <?php echo "$" . $course->cost; ?> 
                                </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <div class="col-sm-10">
                                           <div class="col-sm-offset-6">
                                            <?php echo $this->Form->checkbox('send_email_to_student', ['label'=>false]);?>
                                            Send Email to Student(s)
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                        <?= $this->Form->button(__('Add New Student(s)'),['id'=>"submit"]) ?>
                        <!-- <button id="submit" onclick="verifyData()">temp</button> -->
                        
                        <?= $this->Form->end() ?>
                    <!-- </div> -->
                


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

<script type="text/javascript">
    $(document).ready(function() {


        // $("#submit").attr("disabled", true);        
        var wrapper_level = $("#wrapper_level"); //Fields wrapper_level
        var add_button = $("#moreLevels"); //Add button ID
        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            console.log('clicked');
            e.preventDefault();
                $(wrapper_level).append('<div id="forminputs" class="form-group remove_row'+x+' data_1 studentDetails"><div class="col-sm-2"><div  style="margin-left: 0px;"><?= $this->Form->control('studentDetails[0][first_name]', ['placeholder'=> 'First Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-2"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][last_name]', ['placeholder'=> 'last Name','type'=> 'text', 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-3"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][email]', ['placeholder'=> 'Email','type'=> 'email','data-validation' => "email" , 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-2"><div  style="margin-left: 15px;"><?= $this->Form->control('studentDetails[0][phone]', ['placeholder'=> 'Phone','type'=> 'text','data-validation' => "number" , 'label' => false, 'class' => ['form-control']]) ?></div></div><div class="col-sm-1"><span class="remove_field fa fa-minus" style="cursor: pointer;"></span></div></div>'); //add input box
                    x++; //text box increment
                    // initCalendar();
        });
        
        $(wrapper_level).on("click",".remove_field", function(e){ 
            //user click on remove text
            console.log(x);
            e.preventDefault(); 
            $('#wrapper_level .remove_row'+x+'').remove(); x--;
        })
    });

    $('#submit').click(function(e) {
        /*var studentsInfo = $('#studentFirstname0').val();
        alert(studentsInfo);*/
        // console.log(e);
        e.preventDefault();
        console.log('hi');

        var arrText= new Array();
        var i;
        var emailFlag = $('input[type="checkbox"]').val();
        var id = <?= $id ?>
        // console.log(hh);
        
        $('#forminputs input').each(function(){
            arrText.push($(this).val());
        });
        console.log(arrText);
        requestController = "Courses";
        
        if(arrText){
            var host = $('#baseUrl').val();
            // alert(host);
            jQuery.ajax({
                type: "POST",
                url: host+"api/students/verifyStudentInfo/",
                headers:{"accept":"application/json"},
                dataType: 'json',
                data:{
                        "studentInfo" : arrText,
                        "requestController" : requestController,
                        "emailFlag" : emailFlag,
                        "courseId" : id,
                    },
                success: function (result) {
                    console.log(result);
                    // alert(result);
                    if(result.status == 0 && (typeof result.reason !== 'undefined')){
                        swal({
                                type: 'error',
                                title: result.reason
                            }) 



                    }else{
                        // console.log('result'+result);
                        if(result.saved == 1){
                            swal({
                           title: "Done!",
                           text: "The Student has been registered successfully.",
                           type: "success",
                           timer: 3000,
                           },
                           function () {
                                  location.reload(true);
                                  // tr.hide();
                           });
                        }
                        
                        // e.returnValue = true;
                    }
                }
            });
        }else{
            // console.log('hihihi');
            swal({
                    type: 'error',
                    title: "Please fill student's Information."
                })
        }
            });
    



</script>


    