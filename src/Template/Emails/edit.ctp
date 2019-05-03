<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 */
?>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="emails form large-9 medium-8 columns content">
                    <?= $this->Form->create($email) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Edit Email') ?></legend>
                    </div>
                        <?php
                            // echo $this->Form->control('tenant_id', ['options' => $tenants,'id' => 'bob']);
                            echo $this->Form->control('event_id', ['options' => $events,'id' => 'bob']);
                            echo $this->Form->control('subject');
                            echo $this->Form->control('from_name');
                            echo $this->Form->control('from_email');
                            // echo $this->Form->control('body');
                            echo $this->Form->control('course_type_id', ['options' => $courseTypes , 'id' => 'courseType', 'multiple' => true, 'value' => $selectedCourseTypes]);
                            echo $this->Form->control('schedule', ['options' => $scheduleData,'id' => 'schedule']);
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('body', __('Body'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('body', ['type'=> 'textarea','label' => false ,'required' => false, 'id' => 'tinymceTextarea1']); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('email_goes_to ', __('Email goes to '), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?php if($email->email_configurations && isset($email_configurations) && ($email->email_configurations[0]->recipient == 'student')){
                                    $student = true;
                                } else {
                                    $student = false;
                                }
                                if($email->email_configurations && isset($email->email_configurations) && ($email->email_configurations[0]->recipient == 'instructor')){
                                    $instructor = true;
                                } else {
                                    $instructor = false;
                                }
                                if($email->email_configurations && isset($email->email_configurations) && $email->email_configurations[0]->recipient == 'corporate_client'){
                                    $corporate_client = true;
                                } else {
                                    $corporate_client = false;
                                }
                                 if($email->email_configurations && isset($email->email_configurations) && $email->email_configurations[0]->recipient == 'subcontracted_client'){
                                    $subcontracted_client = true;
                                } else {
                                    $subcontracted_client = false;
                                }
                                ?>
                                <?php echo $this->Form->radio(
                                    'recipient',
                                        [
                                            ['value' => 'student','checked'=> $student,'text' => 'Student', 'id'=>"inlineRadio1"],
                                            ['value' => 'instructor','checked'=> $instructor, 'text' => 'Instructor', 'id'=>"inlineRadio2"],
                                            ['value' => 'corporate_client','checked'=> $corporate_client , 'text' => 'Corporate Client', 'id'=>"inlineRadio3"],
                                            ['value' => 'subcontracted_client','checked'=> $subcontracted_client, 'text' => 'Subcontracted Client', 'id'=>"inlineRadio4"]
                                        ]
                                    );
                                ?>
                            </div>
                        </div>
                        <div class="form-group" id="div1">
                            <label class="col-sm-2 control-label" >Corporate Clients</label>
                            <div class="col-sm-4">
                                <?= $this->Form->control('corporate_ids',['label' => false,'options'=> '','value' => $existingCorporateClients,'class'=>['form-control'], 'multiple' => true])?>
                            </div>
                            <div class="col-sm-4">
                                  <?= $this->Form->control('corporate_options',['label' => false,'options'=> $corporateOptions,'empty' => 'Select One','class'=>['form-control']])?>
                            </div>
                        </div>
                        <div class="form-group" id="div2">
                            <label class="col-sm-2 control-label" >Subcontracted Clients</label>
                            <div class="col-sm-4">
                                <?= $this->Form->control('subcontracte_ids',['label' => false,'options'=> '','value' => $existingSubcontractedClients,'class'=>['form-control'], 'multiple' => true])?>
                            </div>
                            <div class="col-sm-4">
                                  <?= $this->Form->control('subcontracted_options',['label' => false,'empty' => 'Select One','options'=> $subcontractedOptions,'class'=>['form-control']])?>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                </label>
                            </div>
                        </div>
                         <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('use_system_email', ['label' => false]); ?> Use System Email
                                </label>
                            </div>
                        </div>  

                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<script type="text/javascript">

    var tinyFlag = 1;
    <?= "var eventVariables = ".json_encode($eventVariables).";";?>


    $("#inlineRadio3").on('change',function(){
        $('#div1').show();   
        $('#div2').hide();
    });

    $("#inlineRadio4").on('change',function(){
        $('#div2').show();
        $('#div1').hide();
    });
    if (document.getElementById("inlineRadio3").checked) {
        console.log('here in corporate radio');
        $('#div1').show();   
        $('#div2').hide();    
    }
    if(document.getElementById("inlineRadio4").checked){
        console.log('here in subcontracted radio');
        $('#div2').show();
        $('#div1').hide();   
    }  


    $("#bob").on('change', function(){
        eventChange($('#bob').val());
    });


    function eventChange(eventId){
        if(!tinyFlag){
            console.log('here in remove');
            tinymce.remove();
        }

        eventVars = eventVariables[eventId];
        console.log('eventVars');
        console.log(eventVars);
        var editorConfig = {
            selector: '#tinymceTextarea1',
            height: 100,
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | mybutton',
            menubar: false,
            plugins: [
            'advlist autolink link anchor',
            'searchreplace code',
            'insertdatetime paste code'
            ],
            setup: function (editor) {
                // console.log(eventVars);
                console.log('here');
                // editor.on('change', function(e) {
                //    console.log('the event object ', e);
                //    // console.log('the editor object ', ed);
                //    console.log('the content ', editor.getContent());
                // });
                editor.addButton('mybutton', {  
                    type: 'listbox',
                    text: 'Event Variables',
                    icon: false,
                    onselect: function (e) {
                        editor.insertContent(this.value());
                    },
                    values: eventVars,
                });
            },
            forced_root_block : '',
            content_css: ['//www.tinymce.com/css/codepen.min.css']
        };
        tinymce.init(editorConfig);
        tinyFlag = 0;
    }

    $( document ).ready(function () {
        $('#div1').hide();
        $('#div2').hide();
        eventChange($('#bob').val());
    // test(eventVariables[$('#bob').val()]);s



$.ajax({
    url: host+"api/events/corporateClient/",
    type: "GET",
    dataType : 'json',
    header : {'accept' : "application/json", 'contentType': "application/json"},
    success: function (data) {
        console.log(data);
        console.log('data');
        $('select[id = corporate-ids]').empty();
        $('select[id = subcontracte-ids]').empty();
        if(data.length!=0){
           console.log('check');
           $.each(data.corporateType, function(i, values){
            $('select[id = corporate-ids]').append($('<option>',{
               value : i,
               text : values
           }));

        }); 
           $.each(data.subcontractedClients, function(i, values){
            $('select[id = subcontracte-ids]').append($('<option>',{
               value : i,
               text : values
           }));

        });
       }
   }
});
});

</script>
