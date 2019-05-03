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
<div class="tenants form large-9 medium-8 columns content">
    <?= $this->Form->create($tenant, ['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Tenant') ?></legend>
    </div>
            <?php echo $this->Form->control('center_name');?>
            <?php echo $this->Form->control('email', ['label' => 'Center Email','data-validation'=> "email" ,'type'=> "text"]); ?> 
            <div class="form-group">
            <?= $this->Form->label('image', __('Upload Image'), ['class' => 'col-sm-2 control-label']); ?>
                <div class="col-sm-4">
                    <div class="img-thumbnail">
                        <?= $this->Html->image($tenant->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                    </div>
                    <br> </br>
                    <?= $this->Form->control('image_name', ['accept'=>"image/*",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
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
            <div class="">
                <legend><?= __('Tenant User') ?></legend>
            </div>
            <div class="form-group">
                <?= $this->Form->label('first_name', __('First Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="tenant_users[0][first_name]" value="" data-validation="custom" data-validation-regexp="^[A-Za-z.\s_-]+$">
                </div>
            </div>

            <div class="form-group">
                <?= $this->Form->label('last_name', __('Last Name'), ['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="tenant_users[0][last_name]" value="" data-validation="custom" data-validation-regexp="^[A-Za-z.\s_-]+$">
                </div>
            </div>

            <div class="form-group">
                <?= $this->Form->label('phone', __('Phone'), ['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="tenant_users[0][phone]" value="" data-validation="number length" data-validation-length="6-10">
                </div>
            </div>

            <div class="form-group">
                <?= $this->Form->label('email', __('Email'), ['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="tenant_users[0][email]" value="" data-validation="email">
                </div>
            </div>
            <div class="form-group">
                <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="tenant_users[0][password]" value="">
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
    border :1px solid #dcdcdc;
    max-width: 100%;
    object-fit: cover;
}
</style>
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
</script>
