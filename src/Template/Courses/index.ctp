<?php 
use Cake\I18n\Date;
use Cake\I18n\Time;
// pr($courses);die;
?>

    <div class="row">
    <div class="col-lg-12">
        <!--<div class="courses index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
            <?php if($requestData == 'draft') { ?>

                <h1><?= __('Draft Courses') ?></h1>
            <?php }   if($requestData == 'future-courses') { ?>

                <h1><?= __('Future Courses') ?></h1>
            <?php }   if($requestData == 'past-courses') { ?>

                <h1><?= __('Past Courses') ?></h1>
            <?php }  ?>

                <div class="text-right">
                    <?=$this->Html->link('Add Courses', ['controller' => 'Courses', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                </div>

            </div>
<?php if($loggedInUser['role_id'] == 2){?>
<div class="">
    <div class="text-center">
      <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#allCourses">All Courses</a></li>
            <li ><a data-toggle="tab"  href="#myCourses">My Courses</a></li>
            <li ><a data-toggle="tab"  href="#sharedCourses">Shared Courses</a></li>

      </ul>
    </div>  
  <div class="tab-content">
    <div id="allCourses" class="tab-pane fade in active">
<?php } ?>    
        <div class = "ibox-content">
            <div class="table-responsive">
                <table   class="table display table-striped table-bordered table-hover dataTables2" >
                    <thead>
                        <tr>
                            <th scope="col">Course #</th>
                            <th scope="col">No. of Students</th>
                            <th scope="col">Agency Name</th>
                            <th scope="col">Course Type</th>
                            <th scope="col">Client</th>
                            <th scope="col">Training Site</th>
                            <th scope="col">Date   &   Time</th>
                            <th scope="col">Course Status</th>
                            <th scope="col">Location</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <?php if($loggedInUser['role_id'] != 4){?>
                            <th scope="col">Instructor Status</th>
                            <?php } ?>
                        </tr>
                    </thead>                  
				</table>
			</div>		
		</div>
    </div>
<?php if($loggedInUser['role_id'] == 2){?>
    <div id="myCourses" class="tab-pane fade in">
         <div class = "ibox-content">
        	<div class="table-responsive">
            	<table class="table display table-striped table-bordered table-hover dataTables1" >
                	<thead>
		                <tr>
			                <th scope="col">Course #</th>
			                <th scope="col">No. of Students</th>
			                <th scope="col">Agency Name</th>
			                <th scope="col">Course Type</th>
			                <th scope="col">Client</th>
			                <th scope="col">Training Site</th>
			                <th scope="col">Date   &   Time</th>
			                <th scope="col">Course Status</th>
			                <th scope="col">Location</th>
			                <th scope="col">City</th>
			                <th scope="col">State</th>
			                <?php if($loggedInUser['role_id'] != 4){?>
			                <th scope="col">Instructor Status</th>
			                <?php } ?>
                		</tr>
            		</thead>
				</table>
			</div>
		</div>
    </div>
	<div id="sharedCourses" class="tab-pane fade in">
        <div class = "ibox-content">
            <div class="table-responsive">
                <table   class="table display table-striped table-bordered table-hover dataTables3">
                    <thead>
                        <tr>
                            <th scope="col">Course #</th>
                            <th scope="col">No. of Students</th>
                            <th scope="col">Agency Name</th>
                            <th scope="col">Course Type</th>
                            <th scope="col">Client</th>
                            <th scope="col">Training Site</th>
                            <th scope="col">Date   &   Time</th>
                            <th scope="col">Course Status</th>
                            <th scope="col">Location</th>
                            <th scope="col">City</th>
                            <th scope="col">State</th>
                            <?php if($loggedInUser['role_id'] != 4){?>
                            <th scope="col">Instructor Status</th>
                            <?php } ?>
                        </tr>
                    </thead>             
				</table>
			</div>
		</div>
    </div>
  </div>
</div>
<!-- Common part -->
</div>
</div>
<?php } ?>
</div>

<!-- <style type="text/css">
    thead input {
        width: 100%;
    }
</style> -->

<script type="text/javascript">
function sendMailToInstructor(courseId, status, instructorId = null){
    jQuery.ajax({
            url: host+"api/courses/sendMailToInstructor/",
            headers:{"accept":"application/json"},
            dataType: 'json',
            data: {
                'course_id': courseId,  
                'course_instructor_status' : status,
                'instructor_id' : instructorId,
                  },
            type: "POST",
            success: function (result) {
                swal({title: "Done", text: "Mail sent succesfully!", type: "success"});
            }
        }); 



}

</script>

<script type="text/javascript">
var indexSetting = <?php echo json_encode($indexSettings); ?>;
var loggedInUser = <?php echo json_encode($loggedInUser); ?>;
var columnDefs = [
    { 'targets': 0, 'name': 'course_id'},
    { 'targets': 1 ,'name': "no_of_students"},
    { 'targets': 2 ,'name': "agency"},
    { 'targets': 3 ,'name': "course_type"},
    { 'targets': 4 ,'name': "corporate_client"},
    { 'targets': 5 ,'name': "training_site"},
    { 'targets': 6 ,'name': "date"},
    { 'targets': 7 ,'name': "status"},
    { 'targets': 8 ,'name': "location"},
    { 'targets': 9 ,'name': "city"},
    { 'targets': 10 ,'name': "state"},
    { 'targets': 11 ,'name': "instructor_status"},
];
if(loggedInUser.role_id != 2){
    var columnDefs = [
    { 'targets': 0, 'name': 'course_id'},
    { 'targets': 1 ,'name': "no_of_students"},
    { 'targets': 2 ,'name': "agency"},
    { 'targets': 3 ,'name': "course_type"},
    { 'targets': 4 ,'name': "corporate_client"},
    { 'targets': 5 ,'name': "training_site"},
    { 'targets': 6 ,'name': "date"},
    { 'targets': 7 ,'name': "status"},
    { 'targets': 8 ,'name': "location"},
    { 'targets': 9 ,'name': "city"},
    { 'targets': 10 ,'name': "state"},
    // { 'targets': 11 ,'name': "instructor_status"},
];
}
var cols = [ 2, 3, 4, 5, 7, 8, 9, 10];
var hideFilter = hideFilter(columnDefs,indexSetting,cols);
counter = 0;
$(document).ready(function() {
    // console.log(window.location.search);
    var filterData = {
                        2: <?php echo json_encode($agencyName); ?>,
                        3: <?php echo json_encode($courseTypes); ?>,
                        4: <?php echo json_encode($corporateClients); ?>,
                        5: <?php echo json_encode($trainingSites); ?>,
                        7: <?php echo json_encode($courseStatus); ?>,
                        8: <?php echo json_encode($courseLocations); ?>,
                        9: <?php echo json_encode($courseCity); ?>,
                        10: <?php echo json_encode($courseState); ?>     
                    };
    $('.dataTables2 thead tr').clone(true).appendTo( '.dataTables2 thead' );
    $('.dataTables2 thead tr:eq(1) th').each( function (i) {
        $(this).html('');
    } );    
    var table = $('.dataTables2').DataTable( {
        orderCellsTop: true,
        // fixedHeader: true,
        "processing": true,
        "serverSide": true,
        "ajax": { 
            url:host+"api/courses/index/"+window.location.search,   
            "dataFilter": function ( jsonString ) {
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
        "columnDefs": columnDefs,
        initComplete: function () {
            this.api().columns().every( function (i) {
                var column = this;
                colsIndex = cols.indexOf(i);
                if(colsIndex === -1 && hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++
                    return;
                } 
                if(colsIndex === -1){
                    return;
                }
                if(hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++;
                    return;
                }
                select = $('<select class="myselect"><option value=""></option></select>')
                    .appendTo('.dataTables2 thead tr:eq(1) th:eq('+(i-counter)+')')
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .adjust().draw();
                    } );
                    for(key in filterData[i]){
                        // console.log(filterData[i][key]);
                        select.append( '<option value="'+filterData[i][key]+'">'+filterData[i][key]+'</option>' );
                    }
                
            } );
        }

    } );
     $('.dataTables2').width("100%");

} );
$(document).ready(function() {
   var counter = 0
   var filterData = {
                        2: <?php echo json_encode($agencyName); ?>,
                        3: <?php echo json_encode($courseTypes); ?>,
                        4: <?php echo json_encode($corporateClients); ?>,
                        5: <?php echo json_encode($trainingSites); ?>,
                        7: <?php echo json_encode($courseStatus); ?>,
                        8: <?php echo json_encode($courseLocations); ?>,
                        9: <?php echo json_encode($courseCity); ?>,
                        10: <?php echo json_encode($courseState); ?>     
                    };
   var cols = [ 2, 3, 4, 5, 7, 8, 9, 10]
    $('.dataTables1 thead tr').clone(true).appendTo( '.dataTables1 thead' );
    $('.dataTables1 thead tr:eq(1) th').each( function (i) {
        $(this).html('');
    } );
    //sending param using in api url
    var table1 = $('.dataTables1').DataTable( {
        orderCellsTop: true,
        // fixedHeader: true,
        "searching": true,
        "processing": true,
        "serverSide": true,
          "ajax": { 
            url:host+"api/courses/index/myCourses",   
            "dataFilter": function ( jsonString ) {
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
        "columnDefs": columnDefs,
        initComplete: function () {
            // $('#DataTables_Table_0_filter').addClass('hidden');
            this.api().columns().every( function (i) {
                var column = this;
                colsIndex = cols.indexOf(i);
                if(colsIndex === -1 && hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++
                    return;
                } 
                if(colsIndex === -1){
                    return;
                }
                if(hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++;
                    return;
                }
                select = $('<select class="myselect"><option value=""></option></select>')
                    .appendTo('.dataTables1 thead tr:eq(1) th:eq('+(i-counter)+')')
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .adjust().draw();
                    } );
                for(key in filterData[i]){
                        // console.log(filterData[i][key]);
                        select.append( '<option value="'+filterData[i][key]+'">'+filterData[i][key]+'</option>' );
                    }
            } );
        }

    } );
    $('.dataTables1').width("100%");
});
$(document).ready(function() {
   var counter = 0
   var filterData = {
                        2: <?php echo json_encode($agencyName); ?>,
                        3: <?php echo json_encode($courseTypes); ?>,
                        4: <?php echo json_encode($corporateClients); ?>,
                        5: <?php echo json_encode($trainingSites); ?>,
                        7: <?php echo json_encode($courseStatus); ?>,
                        8: <?php echo json_encode($courseLocations); ?>,
                        9: <?php echo json_encode($courseCity); ?>,
                        10: <?php echo json_encode($courseState); ?>     
                    };
   var cols = [ 2, 3, 4, 5, 7, 8, 9, 10]
    $('.dataTables3 thead tr').clone(true).appendTo( '.dataTables3 thead' );
    $('.dataTables3 thead tr:eq(1) th').each( function (i) {
        $(this).html('');
    } );
    console.log(columnDefs);
    console.log('columnDefs');
    var table1 = $('.dataTables3').DataTable( {
        orderCellsTop: true,
        // fixedHeader: true,
        "searching": false,
        "processing": true,
        "serverSide": true,
          "ajax": { 
            url:host+"api/courses/sharedCourses",
            
            "dataFilter": function ( jsonString ) {
                json = jQuery.parseJSON( jsonString );
                return JSON.stringify( json.response );
            }  
        },
        "columnDefs": columnDefs,
        initComplete: function () {


            // $('#DataTables_Table_0_filter').addClass('hidden');
            this.api().columns().every( function (i) {
                var column = this;
                colsIndex = cols.indexOf(i); 
                if(colsIndex === -1 && hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++
                    return;
                } 
                if(colsIndex === -1){
                    return;
                }
                if(hideFilter.indexOf(i) !== -1){
                    column.visible(false);
                    counter++;
                    return;
                }
                select = $('<select class="myselect"><option value=""></option></select>')
                    .appendTo('.dataTables3 thead tr:eq(1) th:eq('+(i-counter)+')')
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .adjust().draw();
                    } );

                for(key in filterData[i]){
                        // console.log(filterData[i][key]);
                        select.append( '<option value="'+filterData[i][key]+'">'+filterData[i][key]+'</option>' );
                    }
                // column.data().unique().sort().each( function ( d, j ) {
                //     select.append( '<option value="'+d+'">'+d+'</option>' )
                    
                // } );
            } );
        }
    } );
    console.log('here in mycourses');
    console.log(indexSetting);
    // for(key in indexSetting){
    //         table1.column(indexSetting[key]+':name').visible(false);
    // }
    $('.dataTables3').width("100%");

        
});
function hideFilter(columnDefs,indexSetting,colDiff){
    console.log(indexSetting);
   var indexSettings = [];
   if(indexSetting != null){
    $.each(columnDefs,function(index,value){
        $.each(indexSetting,function(index,val){
            if(val == value.name){
                indexSettings.push(value.targets);
            }
        });     
     });
    }
   return indexSettings;
}
</script>
<style type="text/css">
.table.dataTables2 thead th {
  border-bottom: 0;
}
.table.dataTables2.no-footer {
  border-bottom: 0;
}
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
table.dataTables2 thead .sorting, 
table.dataTables2 thead .sorting_asc, 
table.dataTables2 thead .sorting_desc {
    background : none;
}
</style>

<style type="text/css">
.myselect {
  width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  /*white-space: normal;*/
  word-wrap:  break-word !important;
}

.myselect option {
  white-space: nowrap;
  width: 100% border-bottom: 1px #ccc solid;
  /* This doesn't work. */
}
.table.dataTables1 thead th {
  border-bottom: 0;
}
.table.dataTables1.no-footer {
  border-bottom: 0;
}
</style>
<style type="text/css">
.table.dataTables2 thead th {
  border-bottom: 0;
}
.table.dataTables2.no-footer {
  border-bottom: 0;
}
</style>
<style type="text/css">
.table.dataTables3 thead th {
  border-bottom: 0;
}
.table.dataTables3.no-footer {
  border-bottom: 0;
}
</style>