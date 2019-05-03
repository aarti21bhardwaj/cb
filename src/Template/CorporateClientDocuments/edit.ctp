<?php
use Cake\Core\Configure;
// $sitePath = Configure::read('siteUrl');
$sitePath = Configure::read('fileUpload');
$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				




                <div class="corporateClientDocuments form large-9 medium-8 columns content">
                    <?= $this->Form->create($corporateClientDocument,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Edit Corporate Client Document') ?></legend>
                        </div>
                        <?php
            // echo $this->Form->control('corporate_client_id', ['options' => $corporateClients, 'empty' => true]);
                        // if(isset($is_admin) && $is_admin){
                        //     echo $this->Form->control('corporate_client_id', ['options' => $corporateClients]);
                        // }
                        // echo $this->Form->control('document_name');
                        // echo $this->Form->control('document_path');
                        ?>
                        <div class="form-group">
                            <?= $this->Form->label('image', __('Edit PDF'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                    <a href="<?php echo $sitePath.$corporateClientDocument->document_path.'/'.$corporateClientDocument->document_name;?>" target="_blank">
                                    <?= $this->Html->image($sitePath.'/img/pdficon.png', array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                    </a>
                                </div> 
                                <div>
                                    <strong>
                                    <a href="<?php echo $sitePath.$corporateClientDocument->document_path.'/'.$corporateClientDocument->document_name;?>">
                                    <?php echo $corporateClientDocument->document_name ; ?> 
                                    </a>
                                    </strong>
                                </div>
                                <br> </br>
                                <?= $this->Form->control('document_name', ['accept'=>"application/pdf",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
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