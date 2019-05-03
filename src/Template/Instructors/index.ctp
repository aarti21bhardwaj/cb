<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;
$sitePath = Configure::read('fileUpload');
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
                 <?php if($loggedInUser['role']->name !== 'instructor' ): ?>
            <div class = 'ibox-title'>
                <h3><?= __('Instructors') ?></h3>
                <div class="text-right">
                <?=$this->Html->link('Add Instructor', ['controller' => 'Instructors', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <?php endif; ?>
          <!--       </div> -->
                <!-- <div class="text-left">
                <?=$this->Html->link('Add Reference', ['controller' => 'InstructorReferences', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div> -->
                <!-- <div class="text-right"> -->
    <!--             <div class="text-center">
                <?=$this->Html->link('Add Qualification', ['controller' => 'InstructorQualifications', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                <?=$this->Html->link('Add Application Form', ['controller' => 'InstructorApplications', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                <?=$this->Html->link('Add Insurance Form', ['controller' => 'InstructorInsuranceForms', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                <?=$this->Html->link('View References', ['controller' => 'InstructorReferences', 'action' => 'index'],['class' => ['btn', 'btn-success']])?>
                </div> -->
            <?php if($loggedInUser['role']->name == 'tenant'):{ ?>
            <h4>Instructor self-registration link: <a target="_blank" href="<?php echo Router::url(['controller' => 'Instructors', 'action' => 'register'], true)?>"><?php echo Router::url(['controller' => 'Instructors', 'action' => 'register'], true)?></a></h4>
            <?php } endif ?>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables1" >
                    <thead>
                        <tr>
                            <!-- <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?>
                            <th scope="col"><?= $this->Paginator->sort('training_site_id') ?></th>
                            <?php } ?> -->
                            <th >First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Qualifications and Documentation</th>
                            <th scope="col">Phone</th>
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
    
$(document).ready(function(){
    $('#myModal').on('hide.bs.modal', function () {
        console.log('hi');
    location.reload();
    });
});

</script>
<script type="text/javascript">
    $(document).ready(function() {
        
    var table = $('.dataTables1').DataTable( {
        orderCellsTop: true,
        fixedHeader: true,
        "processing": true,
        "serverSide": true,
        "ajax": { 
            url:host+"api/instructors/index/",
            "dataFilter": function ( jsonString ) {
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
    });
    function openViewPopUp(url){
        console.log(url);
        console.log('url');
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