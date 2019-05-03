<?php 
use Cake\I18n\Date;
use Cake\I18n\Time;
// pr($tenantTheme);
?>
<?= $this->Html->script(['plugins/fullcalendar/moment.min']) ?>
<?= $this->Html->script('plugins/fullcalendar/fullcalendar.min') ?>

<?php use Cake\Routing\Router;?>

<?php if(isset($tenantTheme->content_area)){?>
    <div class="panel-body">
      <p><?= $tenantTheme->content_area ?></p>
    </div>  
<?php }?>
<!-- <?= $tenantTheme->theme_color_dark ?> -->
  <div class="col-lg-offset-1 col-xs-12 col-lg-10 bottom_set">
      <div class="input-group">
          <div class="input-group-btn search-panel">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
              <span id="search_concept">Search Radius</span> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#contains">Show all</a></li>
              <li><a href="#its_equal">5 Miles</a></li>
              <li><a href="#greather_than">10 Miles</a></li>
              <li><a href="#less_than">20 Miles </a></li>
              <li><a href="#less_than">50 Miles </a></li>
              <li><a href="#less_than">100 Miles </a></li>
              <li><a href="#less_than">200 Miles </a></li>
            </ul>
          </div>
            <input type="hidden" name="search_param" value="all" id="search_param">         
            <input type="text" id="zipcode" class="form-control" name="x" placeholder="Enter Your Zipcode ">
            <span class="input-group-btn">
                <button class="btn btn-default" id="findcourses" type="button">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
      </div>
  </div>
    <style type="text/css">
      .nav-tabs > li.active > a, .nav-tabs > li.active > a:focus, .nav-tabs > li.active > a:hover {
    color: #555;
    cursor: default;
    background-color: <?= $tenantTheme->theme_color_light ?> !important;
    border: 1px solid #ddd;
        border-bottom-color: rgb(221, 221, 221);
    border-bottom-color: transparent;
}
    </style>
  <div class="col-lg-offset-1 col-lg-10 col-sm-12">
    <div class="tabs-container">
          <ul class="nav nav-tabs">
              <li class="active color_dark ">
              <a data-toggle="tab" class="" href="#tab-1"> Calendar View</a></li>
              <li class="" onclick="listView()"><a data-toggle="tab" href="#tab-2">List View</a></li>
          </ul>
          <div class="tab-content">
              <div id="tab-1" class="tab-pane active">
                  <div class="panel-body">
                      <div id="calendar"></div>
                  </div>
              </div>
              <div id="tab-2" class="tab-pane">
                    <div class="panel-body" id="accordion" style="padding-top: 5%;">
                     
                    </div>
                <?php //endif;?>
              </div> 
          </div>
      </div>
    <!-- <div class="panel master_color">
      <div class="panel-heading">
        <h3>Calender title</h3>
      </div>
    </div>
    <div class="border_sets">
      <h4>Calender come heare...</h4>
    </div> -->
  </div>
  <?= $this->element('Navigation/studentfooter');?>
<!-- <script>
  var host = $('#baseUrl').val();
  $(document).ready(function(){
  jQuery.ajax({
    type: "GET",
    url: host+"api/students/classes/",
    headers:{"accept":"application/json"},
    success: function (result) {
      var calenderVars = result.data;
      console.log(calenderVars);
            initCalender(calenderVars);
            }
        });
    });

    function initCalender(calenderVars){
    console.log('calenderVars');
    console.log(calenderVars);
      /* initialize the external events
         -----------------------------------------------------------------*/
        $('#external-events div.external-event').each(function() {
            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1111999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
        /* initialize the calendar
         -----------------------------------------------------------------*/
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            events: calenderVars
        });
    }

</script> -->
<script type="text/javascript">
  var host = $('#baseUrl').val();
  $(document).ready(function(){
  $('#calendar').fullCalendar({
     header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
     editable: true,
     droppable: true,
     eventSources: [
      {
        url:  host+"api/students/classes/", 
        headers:{"accept":"application/json", "content-type":"application/json"},
        // use the `url` property
        success: function(result){
          var calenderVars = result.event;
          return calenderVars;
        },
      }
      ],

  });
});
</script>
<script type="text/javascript">
  var host = $('#baseUrl').val();
    $(document).ready(function(){
      console.log($('#baseUrl').val());
    var host = $('#baseUrl').val();
    $('#findcourses').on('click',function(event){
        if($(this).hasClass('disabled')){
            event.preventDefault();
        }
        listView();   
        event.preventDefault();

        });
       
    });
   
function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

function formatTime(time){

    var date = new Date(time);
    var hours = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    var minutes = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    time = hours + ":" + minutes;
    return time;
}
function listView(){
    var zipcode = $('#zipcode').val();
    if($('#zipcode').val().length == 0){
      var zipcode = '';
    }          
    if(zipcode.length == 5 || zipcode.length == 0){
        console.log('in if');
        $.ajax({
            url: host+"api/Courses/getCourses/?zipcode="+zipcode,
            headers:{"accept":"application/json"},
            success:function(data){
                console.log(data.response);
            $('#accordion').html('');
            // console.log(data.response);
            var origin   = data.domain;
            var dateclass = new Date(data.response.course_dates);
            dateclass = dateclass.getFullYear() + "/" + (dateclass.getMonth() + 1) + "/" + dateclass.getDate();
            console.log(dateclass);
              var j = 0; 
              $.each(data.response,function(i, value){
                $('#accordion').append('<div class="panel panel-default" ><div class="panel-heading"><h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+j+'" aria-expanded="false" class="collapsed"<p>'+i+'</p></a></h5></div><div id="collapse'+j+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"><div class="panel-body" id="smart'+j+'"><h3>Course Description</h3>');
                  $.each(value,function(k,val){
                    if(val.course_dates){
                        $.each(val.course_dates,function(l, date){
                            $('#smart'+j).append('<a href="'+origin+'students/private_course/'+val.id+'/?course-hash='+val.private_course_url+'"><strong>'+i+'</strong></a>');
                            $('#smart'+j).append('<br>'+formatDate(date.course_date)+'<br>'+formatTime(date.time_from)+' - '+formatTime(date.time_to)+'<br>');
                        });
                      }
                    if(val.location){
                      $('#smart'+j).append('<span class="class-event-location"><br>'+val.location.name+'<br>'+val.location.city+', '+val.location.state+', '+val.location.zipcode+'</span><br><br>');
                    }
                  });
                $('#accordion').append('</div></div></div>');
                j=j+1;
              });
            }
        });
      }
        
  }
</script>
<!-- <script type="text/javascript">
  function listView(){
    var host = $('#baseUrl').val();
    $.ajax({
            url: host+"api/Courses/getCourses/",
            headers:{"accept":"application/json"},
            success:function(data){
                        console.log(data.response);
                    $('#accordion').html('');
                    // console.log(data.response);
                    var origin   = window.location.origin;
                    var dateclass = new Date(data.response.course_dates);
                    dateclass = dateclass.getFullYear() + "/" + (dateclass.getMonth() + 1) + "/" + dateclass.getDate();
                    console.log(dateclass);
                    $.each(data.response,function(i, value){
                    
                    $('#accordion').append('<div class="panel panel-default" ><div class="panel-heading"><h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse'+i+'" aria-expanded="false" class="collapsed"<p>'+value.course_type.name+'</p></a></h5></div><div id="collapse'+i+'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;"><div class="panel-body" id="smart'+i+'"><h3>Course Description</h3><a href="'+origin+'/students/private_course/?course-hash='+value.private_course_url+'"><strong>Monday, December 31, 2018 at 7:00 pm</strong></a>');
                        if(value.course_dates){

                        $.each(value.course_dates,function(j, date){

                            $('#smart'+i).append('<br>'+formatDate(date.course_date)+'<br>'+formatTime(date.time_from)+' - '+formatTime(date.time_to)+'<br>');
                            });
                        }
                    if(value.location){    
                      $('#smart'+i).append('<span class="class-event-location"><br>'+value.location.name+'<br>'+value.location.city+', '+value.location.state+', '+value.location.zipcode+'</span>');
                    }
                    $('#accordion').append('</div></div></div>');
                    });
                    }
    });
        
  }
</script> -->
