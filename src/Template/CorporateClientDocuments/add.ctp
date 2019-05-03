<?php
$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
// pr($corporateClientDocument);die;
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				


    
<div class="corporateClientDocuments form large-9 medium-8 columns content">
    <?= $this->Form->create($corporateClientDocument, ['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Corporate Client Document') ?></legend>
    </div>
        <?php
            // echo $this->Form->control('corporate_client_id', ['options' => $corporateClients, 'empty' => true]);
        if(!$corporate_client_id){
             echo $this->Form->control('corporate_client_id', ['options' => $corporateClients]);
        }
            // echo $this->Form->control('document_name');
            // echo $this->Form->control('document_path');
        ?>
        <div class="form-group">
            <?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
            <div class="col-sm-4">
                <div class="img-thumbnail">
                    <?= $this->Html->image($corporateClientDocument->image_url, array('id'=>'upload-doc','width' => 100 ,'height' => 100)); ?>
                </div> 
                <br> </br>
                <?= $this->Form->control('document_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'docChange']); ?>
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
</div>

<script type ="text/javascript">
/**
* @method uploadImage
@return null
*/    
function uploadImage(input) {
    console.log('here');
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
