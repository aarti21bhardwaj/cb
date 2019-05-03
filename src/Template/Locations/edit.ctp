
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHNfj67D_c98xvNOK30HMjKdfq5-TDaA&language=en&libraries=places"></script>
<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="locations form large-9 medium-8 columns content">
                    <?= $this->Form->create($location) ?>
                    <fieldset>
                    <div class = 'ibox-title'>
                        <legend><?= __('Edit Location') ?></legend>
                    </div>

                        <?php
                            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label != 'TRAINING SITE OWNER')  {

                                 echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','required'=> true,'options' => $trainingSites]);
                            }
                            if($loggedInUser['role']->name != 'corporate_client_id'){
                            echo $this->Form->control('corporate_client_id', ['empty' => '--SELECT ONE--','options' => $corporateClients]);
                        }

                        ?>
                        <?php
                            echo $this->Form->control('contact_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$','label' => ['text'=>'Site Contact Name']]);
                            echo $this->Form->control('contact_email', ['required','data-validation'=> "email" ,'type'=> "text",'label' => ['text'=>'Site Contact Email']]);
                            echo $this->Form->control('contact_phone',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10",'label' => ['text'=>'Site Contact Phone']]);
                            ?>
                            <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('address', ['id'=>'address1','type'=> 'textarea', 'label' => false, 'class' => ['form-control','tinymceTextarea','fr-view']]); ?>
                            </div>
                        </div>
                            <?php
                            echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                            echo $this->Form->control('zipcode',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"5-5"]);
                            echo $this->Form->control('name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$','label' => ['text'=>'Location Name']]);

                        ?>

                        <div class="form-group">
                            <?= $this->Form->label('location', __('Location'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-4">
                                <input id="address" class="form-control" type="text" value="<?= $location->city;?>">
                                <button type="button" class="btn btn-primary" onclick="getCoordinatesByAddress(document.getElementById('address').value)">Get Coordinates</button>
                            </div>
                            <div class="col-sm-3">
                                <input placeholder="Latitude" value="<?= $location->lat;?>" name="lat" id="latitude" class="form-control" type="textbox">
                            </div>
                            <div class="col-sm-3">
                                <input placeholder="Longitude" value="<?= $location->lng;?>" name="lng" id="longitude" class="form-control" type="textbox">
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $this->Form->label('notes', __('Location Notes'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('notes', ['type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea']]); ?>
                            </div>
                        </div>
                        
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    <?= $this->Form->end() ?>
                </div>
            </div> <!-- .ibox-content ends --> 
        </div> <!-- .ibox ends -->
    </div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
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
    function initialize() {

    var input = document.getElementById('address');
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