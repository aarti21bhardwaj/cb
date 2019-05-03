<?php 
use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>




<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Training Sites') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Training Site', ['controller' => 'TrainingSites', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables2" >
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col"><?= $this->Paginator->sort('Training Site ID') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Site name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Contact') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Email') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Phone') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('Documentation and Notes') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('city') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('state') ?></th>
                                <!-- <th scope="col"><?= $this->Paginator->sort('zipcode') ?></th> -->
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trainingSites as $key => $trainingSite){ ?>
                                <tr>
                                    <td>
                                    <div class="dropdown">
                                
   <button data-html="true" type="button" class="btn btn-xs btn-success" data-container="body" data-toggle="popover" data-placement="bottom" data-content="Instructors: <strong><?php echo (isset($instructorCount[$key]))?($instructorCount[$key]):0; ?></strong><br/> Courses Scheduled: <strong><?php echo (isset($courseCount[$key]['publish']))?($courseCount[$key]['publish']):0 ; ?></strong><br/>Courses Taught: <strong><?php echo (isset($courseCount[$key]['closed']))?($courseCount[$key]['closed']) : 0. ?></strong>" data-original-title="" title="">
                                   <i class="fa fa-sort-desc"></i>
                                   </button>
                                    </td>
                                    <td>
                                    <?= h($trainingSite->training_site_code) ?>
                                    </td>
                                    <td><?= h($trainingSite->name) ?></td>
                                    <td><?= h($trainingSite->contact_name) ?></td>
                                    <td><?= h($trainingSite->contact_email) ?></td>
                                    <td><?= h($trainingSite->contact_phone) ?></td>
                                    <td>
                                        <?php
                                        if($trainingSite->site_contract_name && isset($trainingSite->site_contract_name[0])){
                                            ?>
                                            <p style='text-align: left;'>Site Contract:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "contract", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-pencil  fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                    <a href="<?= $sitePath.h($trainingSite->site_contract_path) ?>/<?= h($trainingSite->site_contract_name) ?>" class="fa fa-download fa-fw" target="_blank">
                                                    </a>

                                                </span>
                                            </p>
                                            

                                            <?php
                                        }
                                        else{
                                            ?>
                                            <p style='text-align: left;'>Site Contract:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "contract", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-plus fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                    

                                                </span>
                                            </p>
                                        


                                            <?php

                                        }

                                        ?>
                                        
                                        <?php
                                        if($trainingSite->site_insurance_name && isset($trainingSite->site_insurance_name[0])){
                                            ?>
                                            <p style='text-align: left;'>Site insurance:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "insurance", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-pencil  fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                    <a href="<?= $sitePath.h($trainingSite->site_insurance_path) ?>/<?= h($trainingSite->site_insurance_name) ?>" class="fa fa-download fa-fw" target="_blank">
                                                    </a>

                                                </span>
                                            </p>
                                        

                                            <?php
                                        }
                                        else{
                                            ?>
                                            <p style='text-align: left;'>Site insurance:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "insurance", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-plus fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>


                                                </span>
                                            </p>
                                        


                                            <?php

                                        }

                                        ?>
                                        <?php
                                        if($trainingSite->site_monitoring_name && isset($trainingSite->site_monitoring_name[0])){
                                            ?>
                                            <p style='text-align: left;'>Monitoring Form:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "monitoringform", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-pencil  fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>
                                                    <a href="<?= $sitePath.h($trainingSite->site_monitoring_path) ?>/<?= h($trainingSite->site_monitoring_name) ?>" class="fa fa-download fa-fw" target="_blank">
                                                    </a>

                                                </span>
                                            </p>
                                        

                                            <?php
                                        }
                                        else{
                                            ?>
                                            <p style='text-align: left;'>Monitoring Form:
                                                <span style="float:right;">
                                                    <?php
                                                    $viewUrl = $this->Url->build(["controller"=>"trainingSites","action" => "monitoringform", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                    ?>
                                                    <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-plus fa-fw" data-toggle="modal" data-target="#myModal">
                                                    </a>


                                                </span>
                                            </p>
                                        


                                            <?php

                                        }

                                        ?>
                                        <p style='text-align: left;'>Site Notes:
                                            <span style="float:right;">
                                            <?php if(empty($trainingSite->training_site_notes)){?>
                                                <?php
                                                $addUrl = $this->Url->build(["controller"=>"trainingSiteNotes","action" => "add", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                ?>
                                                <a href='#' onclick='openViewPopUp("<?= $addUrl ?>", "View User")' class="fa fa-plus fa-fw" data-toggle="modal" data-target="#myModal">
                                                    <!-- <i class="fa fa-eye fa-fw"></i> -->
                                                </a>
                                            <?php }else{?>
                                                 <?php
                                                $viewUrl = $this->Url->build(["controller"=>"trainingSiteNotes","action" => "index", $trainingSite->id]);
                                                    //pr($viewUrl);
                                                ?>
                                                <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="fa fa-eye fa-fw" data-toggle="modal" data-target="#myModal">
                                                    <!-- <i class="fa fa-eye fa-fw"></i> -->
                                                </a>
                                            <?php } ?>    
                                            </span>
                                        </p>
                                    </td>
                                    <td><?= h($trainingSite->city) ?></td>
                                    <td><?= h($trainingSite->state) ?></td>
                                    <!-- <td><?= h($trainingSite->zipcode) ?></td> -->
                                    <td class="actions">
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $trainingSite->id]);
                                        ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $trainingSite->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $trainingSite->id], ['confirm' => __('Are you sure you want to delete # {0}?', $trainingSite->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
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
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function getDetails() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

</script>
<style type="text/css">
.table.dataTables2 thead th {
  border-bottom: 0;
}
.table.dataTables2.no-footer {
  border-bottom: 0;
}
table.dataTables2 thead .sorting, 
table.dataTables2 thead .sorting_asc, 
table.dataTables2 thead .sorting_desc {
    background : none;
}
</style>

<script type="text/javascript">
$(document).ready(function() {
        var table = $('.dataTables2').removeAttr('width').DataTable( {
        paging: true,
        scrollX:true,
        // fixedColumns:true,
        // "columnDefs": columnDefs,
        columnDefs: [
            { width: 135, targets: 6 },
            { width: 65, targets: 9 }
        ],
        // fixedColumns: true
    } );
} );
</script>

