
<div class="row">
    <div class="col-lg-12">
<!--         <div class="students index large-9 medium-8 columns content">
 -->        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Students') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Student', ['controller' => 'Students', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
                <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                <div class="text-right">
                 <?=$this->Html->link('Export CSV', ['controller' => 'Students', 'action' => 'exportCsv'],['class' => ['btn-xs', 'btn-success']])?>
                 </br></br>
                </div>
                <?php } ?>
            </div>
            <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables1" >
                    <thead>
                        <tr>
                            <th scope="col" name="training-site">Training Site</th>
                            <th scope="col">Corporate Client</th>
                            <th scope="col">Subcontracted Client</th>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                            <th scope="col">Status</th>
                            <?php } ?>
                            <th scope="col">Email</th>
                            <th scope="col">Phone1</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    
            </table>

        </div>
        <!-- </div> -->
    </div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
<script type="text/javascript">
    $(document).ready(function() {
        
    var table = $('.dataTables1').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "processing": true,
        "serverSide": true,
        "ajax": { 
            url:host+"api/students/index/",
            "dataFilter": function ( jsonString ) {
                console.log($(this).attr('data-column'));
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
        "columnDefs": [
                        { 'targets': 0 ,'name': 'training_site'},
                        { 'targets': 1 ,'name': "corporate_client"},
                        { 'targets': 2 ,'name': "subcontracted_client"},
                        { 'targets': 3 ,'name': "first_name"},
                        { 'targets': 4 ,'name': "last_name"},
                        { 'targets': 5 ,'name': "status"},
                        { 'targets': 6 ,'name': "email"},
                        { 'targets': 7 ,'name': "phone1"},
                        { 'targets': 8 ,'name': "city"},
                        { 'targets': 9 ,'name': "state"},
                        
                      ],

    });
    var indexSetting = <?php echo json_encode($indexSettings); ?>;
    for(key in indexSetting){
        table.column(indexSetting[key]+':name').visible(false);
    }

    function openViewPopUp(url, viewTitle){
        url= url+'?layoutType=popUp';
        $("#iframeContent").attr('src', url);
    }
});
</script>
<style type="text/css">
.table.dataTables1 thead th {
  border-bottom: 0;
}
.table.dataTables1.no-footer {
  border-bottom: 0;
}
table.dataTables1 thead .sorting, 
table.dataTables1 thead .sorting_asc, 
table.dataTables1 thead .sorting_desc {
    background : none;
}
</style>