<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndexSetting $indexSetting
 */
?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
				
        

    
<div class="indexSettings form large-9 medium-8 columns content">
    <?= 
        $this->Form->create($indexSetting);
    ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Index Setting') ?></legend>
    </div>
        <?php
            // echo $this->Form->control('for_id');
            // echo $this->Form->control('for_name');
             echo $this->Form->control('index_name', ['options' => array_combine($indexName,$indexName),'onchange' => 'test(this)']);
            // echo $this->Form->control('meta');
        ?>
         <div class="form-group">
            <label class="col-sm-2 control-label" for="name">Columns To Hide</label>
            <div class="col-sm-10">
                <?= $this->Form->control('meta',['label' => false,'options'=> array_combine($meta,$meta),'class'=>['select2_demo_2','form-control'], 'multiple' => true])?>

            </div>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<script type="text/javascript">
$(document).ready(function(){
    $(".select2_demo_2").select2();
});
function test(sel) {
  var tableName = sel.options[sel.selectedIndex].text;
   jQuery.ajax({
        url: host+"api/Tenants/indexSettings/",
        headers:{"accept":"application/json"},
        dataType: 'json',
        data: { 'tableName': tableName},
        type: "post",
        success:function(data){
            console.log(data);
            console.log('data');
            if(data.response.length > 0){
               $('select[id = meta]').empty(); 
            }
            $.each(data.response, function(i, values){
                $('select[id = meta]').append($('<option>',{
                    value : values,
                    text : values
                }));
                                       
            });
        }   
    }); 
}
</script>