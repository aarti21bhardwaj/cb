<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CardPrintingProfile $cardPrintingProfile
 */
// pr($cardAlignmentLeft);die();
?>
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
				


    
<div class="cardPrintingProfiles form large-9 medium-8 columns content">
    <?= $this->Form->create($cardPrintingProfile) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Add Card Printing Profile') ?></legend>
    </div>
        <?php
            echo $this->Form->control('name', ['required', 'type'=>'text', 'data-validation'=>'alphanumeric', 'data-validation-allowing' =>'-_ ']); ?>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="name">Select Training Sites</label>
                <div class="col-sm-10">
                    <?= $this->Form->control('card_printing_profile_training_sites',['required','label' => false,'options'=> $trainingSites,'class'=>['select2_demo_2','form-control'], 'multiple' => true])?>
                </div>
            </div>

            <?php echo $this->Form->control('left_right_adjustment', ['empty' => '--SELECT ONE--', 'options' =>$cardAlignment]);
            echo $this->Form->control('up_down_adjustment', ['empty' => '--SELECT ONE--', 'options' =>$cardAlignment]);
            // echo $this->Form->control('status');
        ?>

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
</div>
<script type="text/javascript">
$(document).ready(function(){
    $(".select2_demo_2").select2();
});
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