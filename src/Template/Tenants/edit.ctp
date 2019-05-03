<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<div class= "alert alert-info" >
  <div>
    <div style="padding-left: 15px;">
    </div>
        <?php if(!empty($tenant->uuid)): ?>
        <p class="col-sm-2" style="width: 13.667%"> Your Unique ID: </p>
        <p id="p1" class= "col-sm-4" style="width: 7%"><?= $tenant->uuid ?></p>

        <button class="fa fa-copy" onclick="copyToClipboard('#p1')" ></button>
  </div>
        <?php endif; ?>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="tenants form large-9 medium-8 columns content">
                    <?= $this->Form->create($tenant, ['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Edit Tenant') ?></legend>
                    </div>
                    <?= $this->Form->hidden('userId',['value' => $tenant->id]);?>
                    
                    <?php echo $this->Form->control('center_name');
                          echo $this->Form->control('email', ['label'=>'Center Email','data-validation'=> "email" ,'type'=> "text"]);
                    ?>
                    <div class="form-group">
                    <?= $this->Form->label('image', __('Upload Image'), ['class' => 'col-sm-2 control-label']); ?>
                    <div class="col-sm-4">
                    <div class="img-thumbnail">
                    <?= $this->Html->image($tenant->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                    </div>
                    <br> </br>
                    <?= $this->Form->control('image_name', ['accept'=>"image/*",'label' => false,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                    </div>
                    </div>

                    <?php

                    echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                    echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                    echo $this->Form->control('zip',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"5-5"]);

                    echo  $this->Form->control('domain_type',['placeholder'=>'classbyte.twinspark.co']);
                    ?>
                    <div class="form-group">
                    <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                    <div class="col-sm-10">
                    <?= $this->Form->control('address', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                    </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <label class="col-sm-offset-6">
                                <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                            </label>
                        </div>
                    </div>

                </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
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

<style type ="text/style">
.img-thumbnail {
background: #fff none repeat scroll 0 0;
height: 200px;
margin: 10px 5px;
padding: 0;
position: relative;
width: 200px;
}
.img-thumbnail img {
border: 1px solid #dcdcdc;
max-width: 100%;
object-fit: cover;
}
</style>
<script type="text/javascript">
  function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
}

</script>
<script type ="text/javascript">
    /**
    * @method uploadImage
    @return null
    */    
    function uploadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#upload-img').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
  $("#imgChange").change(function(){
        uploadImage(this);
    });


    $(document).ready(function(){
    var host = $('#baseUrl').val();
    $('#saveUserPassword').on('click',function(event){
        //alert('hh');
        if($(this).hasClass('disabled')){
            event.preventDefault();
        }
        var oldPwd = $('#old_pwd').val();
            //alert(oldPwd); die('sss');
            var userId = $('input[name=userId]').val();
            var newPwd = $('#new_pwd').val();
            var cnfNewPwd = $('#cnf_new_pwd').val();
            if(oldPwd && newPwd && cnfNewPwd && (newPwd == cnfNewPwd)){
                $.ajax({
                    url: host+"api/tenants/updatePassword/"+userId,
                    headers:{"accept":"application/json"},
                    dataType: 'json',
                    data:{
                        "user_id" : userId,
                        "old_password" : oldPwd,
                        "new_password" : newPwd,
                    },
                    type: "put",
                    success:function(data){
                        if($('#rsp_msg').hasClass('alert-danger')){
                            $('#rsp_msg').removeClass('alert-danger');
                        }
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass('alert-success');
                        $('#rsp_msg').append('<strong>Password changed successfully.</strong>');
                        $('#rsp_msg').show();
                        setTimeout(function(){
                            $('#rsp_msg').fadeIn(500);
                            $('#changePasswordModal').modal('hide');
                            $('#rsp_msg').removeClass('alert-success');
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');
                        }, 2000);
                    },
                    error:function(data){
                        var className = 'alert-danger';
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass(className);
                        $('#rsp_msg').append('<strong>' + data.responseJSON.message + '</strong>');
                        setTimeout(function(){
                            if($('#rsp_msg').hasClass(className)){
                                $('#rsp_msg').removeClass(className);
                            }
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');

                        }, 2000);
                        $('#rsp_msg').fadeIn(500);

                    },
                    beforeSend: function() {

                    }
                });

            }
            event.preventDefault();
        });
        
    });
</script>


<!-- Change Password Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="changePasswordModal">
  <div class="modal-dialog" role="document">
    <?= $this->Form->create(null, ['class' => 'form-horizontal','data-toggle'=>"validator"]) ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= __('CHANGE PASSWORD')?></h4>
      </div>

      <div class="modal-body">
      <div class="alert" id="rsp_msg" style=''>

        </div>
        <div class="form-group">
          <?= $this->Form->label('name', __('Old Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("old_pwd", array(
            "label" => false,
            'required' => true,
            'id'=>'old_pwd',
            "type"=>"password",
            "class" => "form-control",'data-minlength'=>8,
            'placeholder'=>"Enter Old Password"));
            ?>
            <div class="help-block with-errors"><?= __('Minimum Length required is 8')?></div>
          </div>
        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("new_pwd", array(
            "label" => false,
            'id'=>'new_pwd',
            "type"=>"password",
            'required' => true,
            "class" => "form-control",'data-minlength'=>8,
            'placeholder'=>"Enter New Password"));
            ?>
            <div class="help-block with-errors"><?= __('Minimum Length required is 8')?></div>
          </div>
        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('Confirm New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("cnf_new_pwd", array(
            "label" => false,
            "type"=>"password",
            'id'=>'cnf_new_pwd',
            'required' => true,
            "class" => "form-control",'data-minlength'=>8,'data-match'=>"#new_pwd",'data-match-error'=>"__('MISMATCH')",'placeholder'=>"Confirm Password"));
            ?>
            <div class="help-block with-errors"><?= __('Minimum Length required is 8')?></div>
          </div>
        </div>


      </div>

      <div class="modal-footer text-center">
        <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'],'id'=>"saveUserPassword"]) ?>
      </div>
      <?= $this->Form->end() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->