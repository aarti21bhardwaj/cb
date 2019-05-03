<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
?>

<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				<div class="students form large-9 medium-8 columns content">
                    <?= $this->Form->create($student) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Student') ?></legend>
                        </div>
                       
                        
                       <?php  if($loggedInUser['role']->name == 'tenant'){ ?>
                        
                        <div  id = "schools">
                        <?= $this->Form->control('corporate_client_id', ["id" => "school",'empty' => '--SELECT ONE--','options' => $corporateClients]); ?>
                        </div>
                        <div  id = "campuses">
                        <?= $this->Form->control('subcontracted_client_id', ['empty' => '--SELECT ONE--', 'id' => 'selectCampuses','options' => $subcontractedClients]); ?>
                        </div>

                        <?php if($loggedInUser['role']->label != 'TRAINING SITE OWNER'){  ?>
                            <?= $this->Form->control('training_site_id', ['required','empty' => '--SELECT ONE--','options' => $trainingSites]); ?>
                        
                        <?php }} ?>

                        
                       
                        <?php
                        echo $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);
                        echo $this->Form->control('password');
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        <?php 
                        echo $this->Form->control('city');
                        echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                        echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>'05-05',"data-validation-error-msg"=> "Please enter 5 digits only"]);
                        echo $this->Form->control('phone1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
                        echo $this->Form->control('phone2');
                        ?>
                        <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="col-sm-10">
                                    <label class="col-sm-offset-6">
                                        <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                    </label>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>
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
    $(document).ready(function(){
        document.getElementById("campuses").style.display = "none";
        document.getElementById("selectCampuses").required = false;
        var host = $('#baseUrl').val();
        console.log(host);
        $("#school").on('change',function(){
            var CorporateClientId = $('#school').val();
            if(CorporateClientId){
                $.ajax({
                        url: host+"api/users/fetchSubcontractors/"+CorporateClientId,
                        type: "GET",
                        dataType : 'json',
                        header : {'accept' : "application/json", 'contentType': "application/json"},
                        success: function (data) {

                          
                            if(data.response.length > 0){
                                $('select[id = selectCampuses]').empty();
                                    document.getElementById("campuses").style.display = "block";
                                    document.getElementById("selectCampuses").required = true;
                                    $('select[id = selectCampuses]').append($('<option>',{
                                        value : null,
                                        text : "choose Subcontracted client if required"
                                    }));
                                    $.each(data.response, function(i, values){
                                        console.log('here');
                                        console.log(values);
                                        $('select[id = selectCampuses]').append($('<option>',{
                                            value : values.id,
                                            text : values.name
                                        }));
                                       
                                    });
                            }else{
                                $('select[id = selectCampuses]').empty();
                                document.getElementById("campuses").style.display = "none";
                                document.getElementById("selectCampuses").required = false;
                            }
                        }
                    });
            }else{
                document.getElementById("campuses").style.display = "none";
                document.getElementById("selectCampuses").required = false;
            }
        });
    });
</script>