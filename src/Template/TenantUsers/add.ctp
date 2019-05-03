<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenantUser $tenantUser
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
               <div class="tenantUsers form large-9 medium-8 columns content">
                <?= $this->Form->create($tenantUser,['data-toggle' => 'validator']) ?>
                <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Add Tenant User') ?></legend>
                    </div>
                    <?php
                    if($loggedInUser['role']->name == 'super_admin'){
                        echo $this->Form->control('tenant_id', ['options' => $tenants, 'id' => 'tenant','empty' => 'Please Choose tenant','onchange' => 'getTrainingSites()']);
                    } ?>


            <?php 
            
            echo $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
            echo $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
            echo $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);
            echo $this->Form->control('password',['data-validation'=> "length" ,'data-validation-length'=>"min5"]);
            echo $this->Form->control('phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);
            echo $this->Form->control('training_site_id',['required','id' => 'training_site_id','options' => $trainingSites,'empty' => 'Select Training Site']);
            ?>
             <div class="form-group">
                <div class="form-group">
                    <div class="col-sm-10">
                        <label class="col-sm-offset-6">
                            <?= $this->Form->checkbox('is_site_owner', ['label' => false]); ?> Make Owner?
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <div class="col-sm-10">
                        <label class="col-sm-offset-6">
                            <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                        </label>
                    </div>
                </div>
            </div>

        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    </div>
</div>
</div>
</div>
</div>

<script type="text/javascript">
    var host = $('#baseUrl').val();

    function getTrainingSites(){
        var tenantId = $('#tenant').val();
        console.log(tenantId);
        console.log('in dropdown');
        jQuery.ajax({
            type: "GET",
            url: host+"api/tenants/getTrainingSites/"+tenantId,
            headers:{"accept":"application/json"},
            success: function (result) {
                updateOptions(result);
            },
            error: function(error){
                console.log(error);
                swal({
                    type: 'error',
                    title: 'No Training Site has been found for this Tenant.'
                })
                hidefield();
            }
        });
    }

    function updateOptions(result){
    console.log(result.response);
    console.log('here');
    $('#training_site_id').empty();
    $('#training_site_id').append('<option>Please Select</option>');
    $.each(result.response, function (i, values) {
        $('#training_site_id').append($('<option>', {
            value: values.id,
            text : values.name
        }));

    });
}
    function hidefield(){
        $('#training_site_id').empty();
    }

</script>
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
