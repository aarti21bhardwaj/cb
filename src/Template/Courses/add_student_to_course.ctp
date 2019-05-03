<?php
$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);
?>

<div class="courseStudents form large-9 medium-8 columns content">
<?php echo $this->Form->create(null); ?>
    <fieldset>
                <div class = 'ibox-title'>
                    <legend><?= __('Add Existing Student to Course') ?></legend>
                </div>
                <!-- <input type="text" placeholder="Search.." options=$students multiple="true"> -->
            <div class="form-group">

            <label class="col-sm-2 control-label" for="name">Select Students:</label>
                <div class="col-sm-offset-2">
                <?= $this->Form->control('student_ids',['required','label' => false,'options'=> $students,'class'=>['select2_demo_2','form-control','col-sm-10'],'size' => '8','style'=>'width:80%','placeholder'=>'Select Student(s)', 'multiple' => true,])?>
                </div>
            </div>
        <div class="form-group">
            <?= $this->Form->label('cost', __('Per Student Cost'), ['class' => ['col-sm-2', 'control-label']]) ?>
                    <div class="col-sm-10">
                        <?php echo "$" . $course->cost; ?> 
                    </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <div class="col-sm-offset-6">
                        <?php echo $this->Form->checkbox('send_email_to_student', ['label'=>false]);?>
                        Send Email to Student
                    </div>
                   <!--  <label class="col-sm-offset-6">
                        <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                    </label> -->
                </div>
            </div>
        </fieldset>
        <?= $this->Form->button(__('Add Student(s)')) ?>
    
    <?= $this->Form->end() ?>
</div>
<style type="text/css">
    .select2_demo_2{
        width:80%;
    }
</style>
<script type="text/javascript">
$(document).ready(function(){
    $(".select2_demo_2").select2();
});
</script>
