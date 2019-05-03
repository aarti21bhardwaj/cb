<?= $this->Html->script(['plugins/fullcalendar/moment.min']) ?>
<?= $this->Html->script('plugins/fullcalendar/fullcalendar.min') ?>


<div class="light row border-bottom white-bg dashboard-header" >
	<div class="col-sm-12">
	    <form role="form" class="form-inline text-center">
			<div class="form-group">
			    <input type="text" placeholder="Enter Your Zipcode" id="exampleInputEmail2" class="form-control">
			</div>
			<div class="form-group">
			    <select class="form-control" name="radius">
		            <option>Select Search Radius</option>
		            <option>Show All</option>
		            <option>5 Miles</option>
		            <option>10 Miles</option>
		            <option>20 Miles</option>
		            <option>50 Miles</option>
		            <option>100 Miles</option>
		            <option>200 Miles</option>
		        </select>
			</div>
			<button class="dark btn btn-primary" type="submit" >Go</button>
		</form>
	</div>
</div>

<section class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            	<?= $this->Html->link(__('List View'), ['controller' => 'Students', 'action' => 'classes'], ['class' => ['dark','btn', 'btn-primary' ,'btn-lg']]) ?>

                <h1></h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 features-text">
	            <div class="light ibox-content" >
	            </div>
            </div>
        </div>
    </div>
</section>


<div class="col-lg-9">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Calender </h5>
        </div>
        <div class="ibox-content">
            <div id="calendar"></div>
        </div>
    </div>
</div>


<script>

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

</script>

<!-- [
                {
                    title: 'All Day Eventss',
                    start: new Date(y, m, 1)
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m,tenants/login d-5),
                    end: new Date(y, m, d-2),
                    url: 'http://google.com/'
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d-3, 16, 0),
                    allDay: false
                },
                {
                    id: 999,
                    title: 'Repeating Event',
                    start: new Date(y, m, d+4, 16, 0),
                    allDay: false
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d+1, 19, 0),
                    end: new Date(y, m, d+1, 22, 30),
                    allDay: false
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'http://google.com/'
                }
            ] -->