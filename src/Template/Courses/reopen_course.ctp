<?php
    $loginFormTemplate = [
            'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
    ];
    $this->Form->setTemplates($loginFormTemplate);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <!-- <div class="ibox-content"> -->
                
	            <div class="courses form large-9 medium-8 columns content">
	                <?php echo $this->Form->create('Courses', array('url' => ['controller' => 'Courses','action' => 'reopen_course' ])); ?>
	                <fieldset>
	                <!-- <div class='ibox-title'> -->
	                    <legend><?= __('Re-Open Course') ?></legend>
	                <!-- </div> -->
             			<div class="col-sm-3">
                          <?php echo $this->Form->control('Course ID',['label' => false,'placeholder'=>'Enter Course ID']);?>
                      	</div>
	                <?= $this->Form->button(__('Submit')) ?>
	    			<?= $this->Form->end() ?>
	    			</fieldset>
	            </div>
        	<!-- </div> -->
        </div>
    </div>
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
            	 <div class='ibox-title'>
	                    <legend><?= __('Closed Courses') ?></legend>
	              </div>
            	 <div class="table-responsive">
           		<table class="table table-striped table-bordered table-hover dataTablesReopen">
                <thead>
                    <tr>
                        <th scope="col">Course ID</th>
                        <th scope="col">Training Site</th>
                        <th scope="col">Agency</th>
                        <th scope="col">Course</th>
                    </tr>
                </thead>
                <tbody>
                  
                </tbody>
            </table>
        </div>
        	</div>
        </div>
    </div>
</div>
<script type="text/javascript">
var columnDefs = [
    { 'targets': 0 ,'name': "course_id"},
    { 'targets': 1 ,'name': "training_site"},
    { 'targets': 2 ,'name': "agency"},
    { 'targets': 3 ,'name': "course_type"},
];
  $(document).ready(function() {   
    var table = $('.dataTablesReopen').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "processing": true,
        "serverSide": true,
        "ajax": { 
            url:host+"api/courses/reopenCourses/",   
            "dataFilter": function ( jsonString ) {
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
        "columnDefs": columnDefs,
    } );
} )
</script>
<style type="text/css">

.table.dataTablesReopen thead th {
  border-bottom: 0;
}
.table.dataTablesReopen.no-footer {
  border-bottom: 0;
}
table.dataTablesReopen thead .sorting, 
table.dataTablesReopen thead .sorting_asc, 
table.dataTablesReopen thead .sorting_desc {
    background : none;
}

</style>

