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
							<legend><?= __('Training Site Insurance Document') ?></legend>
							
							<div class="form-group col-sm-12">
							<!-- <div class = "col-sm-3"></div> -->
								<?= $this->Form->label('image', __('Upload PDF'), ['class' => 'control-label']); ?>
								<div class="col-sm-4">
									<div class="img-thumbnail">	
										<?= $this->Html->image('/img/pdficon.png', array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
									</div> 
									<br>
								</div>
								<div class = "col-sm-8"></div>
							</div>
							<div class = "form-group col-sm-12">
								<!-- <div class = "col-sm-2"></div>	 -->
							  <div class = "col-sm-offset-2 col-sm-3">
									<?= $this->Form->control('site_insurance_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
									
							  </div>
							</div>
							<div class="hr-line-dashed"></div>
							<div class="form-group col-sm-12" id="data_1">
								<div class="col-sm-2">
									<?= $this->Form->label('site_insurance_expiry_date', __('Expiry Date'), ['class' => [ 'control-label']]); ?>
								</div>	
								<div class="col-sm-3">
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" readonly='readonly' class="form-control" name="site_insurance_expiry_date" value="<?php echo $trainingSite->site_insurance_expiry_date?$trainingSite->site_insurance_expiry_date->format('m/d/Y'):"";?>" placeholder="mm-dd-yyyy">
									</div>
								</div>
							</div>
						</div>
					</fieldset><div class="form-group">
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#data_1 .input-group.date').datepicker({
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			calendarWeeks: true,
			autoclose: true
		});

	});
</script>

