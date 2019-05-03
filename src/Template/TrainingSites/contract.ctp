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
				<div class="trainingSites form large-9 medium-8 columns content">
					<?= $this->Form->create($trainingSite,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
					<fieldset>
						<div class = 'ibox-title'>
							<legend><?= __('Add Training Site Contract Document') ?></legend>
							
							<div class="form-group">
								<?= $this->Form->label('image', __('Upload PDF'), ['class' => 'col-sm-2 control-label']); ?>
								<div class="col-sm-4">
									<div class="img-thumbnail">
									<?= $this->Html->image('/img/pdficon.png', array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
									</div> 
									<br> </br>
									<?= $this->Form->control('site_contract_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
								</div>
							</div>
							<div class="hr-line-dashed"></div>
						</div>
					</fieldset>
					<div class="form-group">
					<div class="row">
					<div class="col-sm-6">
					<?= $this->Form->button(__('Submit')) ?>

					</div>	
					</div>

					<?= $this->Form->end() ?>
					</div>
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
