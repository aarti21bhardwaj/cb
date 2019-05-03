<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHNfj67D_c98xvNOK30HMjKdfq5-TDaA&language=en&libraries=places"></script>

<?php
$loginFormTemplate = [
	'button' => '<div class="form-group"></div>',
	'inputContainer' => '{{content}}',
	'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
	'label' => '<label class="col-sm-4 control-label" {{attrs}}>{{text}}</label>',
	'formStart' => '<form class="" {{attrs}}>',
    'select' => '<div class=""><select name="{{name}}" class="form-control m-b" {{attrs}}>{{content}}</select></div>',
    'formEnd' => '</form>',
];
$this->Form->setTemplates($loginFormTemplate);
?>
<style type="text/css">
.wizard > .content {min-height: 390px;}
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
	    <div class="col-lg-12">
	        <div class="ibox">
	            <div class="ibox-content">
	                <h2><b><?php echo strtoupper($tenantData->center_name);?></b> - Register as an instructor</h2>
	                <div class="well">
                    This form is by invitation only and is designated solely for instructors of <?php echo strtoupper($tenantData->center_name);?>. If you have not been sent a direct link for this form, please contact cpr before submitting this form. 
                    </div>
	                <?= $this->Form->create($instructor, ['id'=>'form','class' => ['wizard-big']]) ?>
	                    <h1>Account</h1>
	                    <fieldset>
	                        <h2>Account Information</h2>
	                        <div class="row">
	                            <div class="col-lg-8">
	                                <div class="form-group">
	                                    <?= $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "email"]); ?>
	                                </div>
	                                <div class="form-group">
	                                	<label>Create Password</label>
	                                    <?= $this->Form->control('password',['label'=> false]); ?>

	                                </div>
	                                <div class="form-group">
	                                    <label>Confirm Password </label>
	                                    <input id="confirm" name="confirm" type="password" class="form-control required">
	                                </div>
	                            </div>
	                            <div class="col-lg-4">
	                                <div class="text-center">
	                                    <div style="margin-top: 20px">
										<?php if(isset($tenantData->image_url) && !empty($tenantData->image_url)){?>
											<h1 class="logo-name">
											<?= $this->Html->image($tenantData->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
											</h1>
										<?php }?>
										<h1><?php echo $tenantData->center_name;?></h1>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>

	                    </fieldset>
	                    <h1>Profile</h1>
	                    <fieldset>
	                        <h2>Profile Information</h2>
	                        <div class="row">
	                            <div class="col-lg-6">
	                                <div class="form-group">
				                        <?= $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
				                    </div>
	                                <div class="form-group">
				                        <?= $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
	                                </div>
	                                <div class="form-group">
	                                	<?= $this->Form->control('phone_1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]); ?>
	                                </div>
	                                <div class="form-group">
			                        	  <?= $this->Form->control('training_site_id', ['required','empty' => '--SELECT ONE--','options' => $trainingSites]); ?>  
	                                </div>
	                            </div>
	                            <div class="col-lg-6">
	                            	  	
	                               <!--  <div class="form-group">
	                                	<?php echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
	                                </div> -->

	                                <div class="form-group">
	                                	<?php echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);?>
	                                </div>

	                                <div class="form-group">
	                                <?php echo $this->Form->control('zipcode',['required','type'=>'text','data-validation'=>'number', 'data-validation-length'=>'05-05','data-validation'=> 'number length']); ?>
	                                </div>

	                                <div class="form-group">
	                                    <label>Address</label>
	                                    <?= $this->Form->control('address', ['id'=>'address1','type'=> 'text', 'label' => false, 'class' => ['form-control']]); ?>
	                                </div>
	                                <div class="form-group">
	                                	<div class = "col-lg-12">
	                                	<strong>City</strong><br>
	                                	</div>
	                            	  		<div class="col-lg-3">
				                                	<input name="city" id="address" class="form-control col-lg-2" type="text">
	                            	  		</div>
	                            	  		<div class="col-lg-3">
				                                <button type="button" class="btn btn-primary" onclick="getCoordinatesByAddress(document.getElementById('address1').value)">Get Coordinates</button>
	                            	  		</div>
	                            	  		<div class="col-lg-3">
			                                	<input placeholder="Latitude" value="<?= $instructor->lat;?>" name="lat" id="latitude" class="form-control" type="textbox">
	                            	  		</div>
	                            	  		<div class="col-lg-3">
			                                	<input placeholder="Longitude" value="<?= $instructor->lng;?>" name="lng" id="longitude" class="form-control" type="textbox">
	                            	  		</div>
			                            
			                        	</div>
	                            </div>
	                           
	                        </div>
	                    </fieldset>
	                 <?= $this->Form->end() ?>
	            </div>
	        </div>
	        </div>

	    </div>
</div>
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

<script>
    $(document).ready(function(){

        $("#wizard").steps();
        $("#form").steps({
            enableCancelButton: false,
            bodyTag: "fieldset",
            labels: {
                finish: "Register",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
                if (currentIndex > newIndex)
                {
                    return true;
                }

                // Forbid suppressing "Warning" step if the user is to young
                if (newIndex === 3 && Number($("#age").val()) < 18)
                {
                    return false;
                }

                var form = $(this);

                // Clean up if user went backward before
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    $(".body:eq(" + newIndex + ") label.error", form).remove();
                    $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                }

                // Disable validation on fields that are disabled or hidden.
                form.validate().settings.ignore = ":disabled,:hidden";

                // Start validation; Prevent going forward if false
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                // Suppress (skip) "Warning" step if the user is old enough.
                if (currentIndex === 2 && Number($("#age").val()) >= 18)
                {
                    $(this).steps("next");
                }

                // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                if (currentIndex === 2 && priorIndex === 3)
                {
                    $(this).steps("previous");
                }
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);

                // Disable validation on fields that are disabled.
                // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                form.validate().settings.ignore = ":disabled";

                // Start validation; Prevent form submission if false
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                var form = $(this);

                // Submit form input
                form.submit();
            }
        }).validate({
                    errorPlacement: function (error, element)
                    {
                        element.before(error);
                    },
                    rules: {
                        confirm: {
                            equalTo: "#password"
                        }
                    }
                });
   });
</script>

<script>
    function initialize() {

    var input = document.getElementById('address1');
    var autocomplete = new google.maps.places.Autocomplete(input);
    }

    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
        
            <script>
            var map;
            var markersArray = [];
            var marker;
            var infowindow;
            var infowindowArray = [];
            var geocoder = new google.maps.Geocoder;
            var defaultLatLng = new google.maps.LatLng(40.7127837, -74.0059413);
            var defaultAddress = "New York, NY, USA";
            if(navigator.geolocation) {
                var mapOptions = {
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                    
                map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);   
                google.maps.event.addListener(map, "click", function(event)
                {
                    var latLng = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
                    placeMarker(event.latLng);
                });
                var lat = ""; 
                var lng = "";
                var address = "";
                var use_default_location = "";
                if (!isEmpty(lat) && !isEmpty(lng)) {
                    //navigator.geolocation.getCurrentPosition(
                    //  function(position) {
                            var geolocate = new google.maps.LatLng(lat, lng);
                            //document.getElementById('latitude').value = lat;
                            //document.getElementById('longitude').value = lng;
                            placeMarker(geolocate);
                            map.setCenter(geolocate);
                    //  }
                    //);
                } else if (!isEmpty(address)) {
                    getCoordinatesByAddress(address);
                    lat = document.getElementById('latitude').value;
                    lng = document.getElementById('longitude').value;
                    var geolocate = new google.maps.LatLng(lat, lng);
                    map.setCenter(geolocate);
                } else {
                    if(use_default_location){
                        defaultMap();
                    } else {
                        navigator.geolocation.getCurrentPosition(
                            function(position) 
                            {
                                var geolocate = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                                // placeMarker(geolocate);
                                map.setCenter(geolocate);
                            },
                             function() {
                                defaultMap();
                            }
                        );
                    }
                }
            } else {
                defaultMap();
            }
                
            
            
            
            function placeDefaultMarker(location, address) {
                // first remove all markers if there are any
                deleteOverlays();
                deleteOverlaysInfoWindow();

                var marker = new google.maps.Marker({
                    position: location, 
                    map: map
                });

                // add marker in markers array
                markersArray.push(marker);
                
                document.getElementById('latitude').value = location.lat();
                document.getElementById('longitude').value = location.lng();
                var url = "http://www.gps-coordinates.org/my-location.php?lat="+location.lat()+"&lng="+location.lng();
                
                                    document.getElementById('my_location').value = url;
                document.getElementById('coordinates_url').value = "<a href=\""+url+"\" target=\"_blank\">("+location.lat()+","+location.lng()+")</a>";
                                    var latDms = getDD2DMS(location.lat(),"lat");
                var lngDms = getDD2DMS(location.lng(),"lng");
                
                var latDegrees = latDms[0];
                var latMinutes = latDms[1];
                var latSeconds = latDms[2];
                var latDirection = latDms[3];
                
                var lngDegrees = lngDms[0];
                var lngMinutes = lngDms[1];
                var lngSeconds = lngDms[2];
                var lngDirection = lngDms[3];
                
                document.getElementById('latitude_dms_degrees').value = latDegrees;
                document.getElementById('latitude_dms_minutes').value = latMinutes;
                document.getElementById('latitude_dms_seconds').value = latSeconds;
                if(latDirection=="N"){
                    document.getElementById('latitude_dms_n').checked = true;
                }  else {
                    document.getElementById('latitude_dms_s').checked = true;
                }
                
                document.getElementById('longitude_dms_degrees').value = lngDegrees;
                document.getElementById('longitude_dms_minutes').value = lngMinutes;
                document.getElementById('longitude_dms_seconds').value = lngSeconds;
                if(lngDirection=="E"){
                    document.getElementById('longitude_dms_e').checked = true;
                }  else {
                    document.getElementById('longitude_dms_w').checked = true;
                }
                
                
                        var radiusInKm = 0.15;
                        var pointB = location.destinationPoint(0, radiusInKm);
                        document.getElementById('address').value = address;
                        infowindow = new google.maps.InfoWindow({
                            map: map,
                            position: pointB,
                            content:
                            '<h2><b>Geolocation:</b> '+address +'</h2>' +
                            '<h2><b>Latitude:</b> ' +  location.lat()+ '</h2>' +
                            '<h2><b>Longitude:</b> ' + location.lng() +'</h2>'
                        });
                        infowindowArray.push(infowindow);

            }

            // Deletes all markers in the array by removing references to them
            function deleteOverlays() {
                if (markersArray) {
                    for (i in markersArray) {
                        markersArray[i].setMap(null);
                    }
                    markersArray.length = 0;
                }
            }
            
            function deleteOverlaysInfoWindow() {
                if (infowindowArray) {
                    for (i in infowindowArray) {
                        infowindowArray[i].setMap(null);
                    }
                    infowindowArray.length = 0;
                }
            }
            
            function getCoordinatesByAddress(address){
                //address = document.getElementById('address').value;
                geocoder.geocode( { 'address': address}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
                    var geolocate = new google.maps.LatLng(latitude, longitude);
                    placeOnMap(new google.maps.LatLng(latitude, longitude), address);
                    //placeMarker(geolocate);
                  } 
                }); 
            }
            
            
            
            
            google.maps.LatLng.prototype.destinationPoint = function(brng, dist) {
                dist = dist / 6371;  
                brng = brng.toRad();  

                var lat1 = this.lat().toRad(), lon1 = this.lng().toRad();

                var lat2 = Math.asin(Math.sin(lat1) * Math.cos(dist) + 
                          Math.cos(lat1) * Math.sin(dist) * Math.cos(brng));

                var lon2 = lon1 + Math.atan2(Math.sin(brng) * Math.sin(dist) *
                          Math.cos(lat1), Math.cos(dist) - Math.sin(lat1) * Math.sin(lat2));

                 if (isNaN(lat2) || isNaN(lon2)) return null;
                    return new google.maps.LatLng(lat2.toDeg(), lon2.toDeg());
             } 
            /*** function to calculate pointB so that infowindow & marker don't overlapped ***/
            
            /*** show default ***/
            function defaultMap() {
                placeDefaultMarker(defaultLatLng, defaultAddress);
                map.setCenter(defaultLatLng);
            }
            
            function placeOnMap(latlong, address) {
                placeDefaultMarker(latlong, address);
                map.setCenter(latlong);
            }
            
            /*** show default ***/
</script>