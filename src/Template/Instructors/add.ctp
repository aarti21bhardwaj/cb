
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvHNfj67D_c98xvNOK30HMjKdfq5-TDaA&language=en&libraries=places">
</script>

<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>',
        // 'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-content">
                    <?= $this->Form->create($instructor, ['data-toggle' => 'validator','class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
                    <fieldset>
                        <div class = 'ibox-title'>
                            <legend><?= __('Add Instructor') ?></legend>
                        </div>
                    <?php if($loggedInUser['role']->name == 'tenant'){ ?>
                        <!-- <div class="form-group text required">
                            <label class="col-sm-2 control-label" for="duration"></label>
                            <div class="col-sm-10">
                                <?= $this->Form->control('tenant_id', ['value' =>$loggedInUser['id'],'type'=>'hidden', 'id' => 'tenantId']); ?>
                            </div>
                        </div> -->
                         <?php } else {?>
                        <div class="form-group">
                            <?= $this->Form->label('name', __('Tenant'), ['class' => ['col-sm-2', 'control-label']]); ?>
                            <div class="col-sm-10">
                               <?= $this->Form->control('tenant_id', ['label' => false, 'required' => true, 'id' => 'tenantId', 'class' => ['form-control']]); ?>
                            </div>
                        </div>
                    <?php } ?>

                        
                        <?php
                            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label != 'TRAINING SITE OWNER')  {
                                 echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites,'required' => true]);
                            }
                        ?>
                        <?= $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                        <?= $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']); ?>
                        <?= $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]); ?>
                        <?= $this->Form->control('password'); ?>

                        <!-- <div class="form-group">
                        <?= $this->Form->label('image', __('Upload Image'), ['class' => 'col-sm-2 control-label']); ?>
                            <div class="col-sm-4">
                                <div class="img-thumbnail">
                                    <?= $this->Html->image($instructor->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                                </div>
                                <br> </br>
                                <?= $this->Form->control('image_name', ['accept'=>"image/*",'label' => false,'required' => true,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']); ?>
                            </div>
                        </div> -->

                        <?= $this->Form->control('phone_1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]); ?>
                        <?= $this->Form->control('phone_2', [ 'type' => 'text']); ?>

                        <div class="form-group">
                            <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                            <div class="col-sm-10">
                                <?= $this->Form->control('address', ['id'=>'address1','type'=> 'textarea','label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea1']]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= $this->Form->label('address_coordinates', __('Address Coordinates'), ['class' => ['col-sm-2','form-control', 'control-label']]) ?>
                            <div style="padding-left: 0px" class="col-sm-5">
                                <input placeholder="Latitude" required="true"  value="<?= $instructor->lat;?>" name="lat" id="latitude" class="form-control" type="textbox">
                            </div>
                            <div class="col-sm-5">
                                <input placeholder="Longitude" required="true"  value="<?= $instructor->lng;?>" name="lng" id="longitude" class="form-control" type="textbox">
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <?= $this->Form->label('city', __('City'),['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$'],['class' => ['col-sm-2',"form-control", 'control-label']]); ?>
                            <div class="col-sm-offset-2">
                                <input id="address" required="true" class="form-control" type="text" name="city">
                                <!-- <button type="button" class="btn btn-primary" >Get Coordinates</button> -->
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <?php
                        // echo $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                        echo $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);
                        echo $this->Form->control('zipcode',['required','type'=>'text','data-validation'=>'number', 'data-validation-length'=>'05-05','data-validation'=> 'number length',"data-validation-error-msg"=> "Please enter 5 digits only"]);
                        ?>
                        <div class="form-group">
                            <div class="col-sm-10">
                                <label class="col-sm-offset-6">
                                    <?= $this->Form->checkbox('status', ['label' => false]); ?> Active
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                    
                    <?= $this->Form->end() ?>
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
<style type ="text/style">
.img-thumbnail {
    background: #fff none repeat scroll 0 0;
    height: 200px;
    margin: 10px 5px;
    padding: 0;
    position: relative;
    width: 200px;
}
.img-thumbnail img {
    border :1px solid #dcdcdc;
    max-width: 100%;
    object-fit: cover;
}
</style>
<script type ="text/javascript">
/**
* @method uploadImage
@return null
*/    
function uploadImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            $('#upload-img').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgChange").change(function(){
    uploadImage(this);
});
</script>
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
    $("#address1").focusout(function(){
        console.log('test12');
    });
    function myFunction(){
        console.log('test');
    }
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
                } else if (!isEmpty(address1)) {
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
                console.log('address1 tab'+address);
                console.log(typeof(address));
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
<script type="text/javascript">
var host = $('#baseUrl').val();
$(document).ready(function(){
    jQuery.ajax({
        type: "GET",
        url: host+"text-clips/clips/",
        headers:{"accept":"application/json"},
        success: function (result) {
                var eventVars = result.data;
                console.log(eventVars);
                console.log('eventVars');
                initEditor(eventVars);
            }
        });
    function initEditor(eventVars){
        console.log('test21');
        var editorConfig = {
        selector: '.tinymceTextarea1',
        height: 200,
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | mybutton',
        menubar: false,
        plugins: [
        'advlist autolink link anchor',
        'searchreplace code',
        'insertdatetime paste code'
        ],
        setup: function (editor) {
            editor.on("blur", function(e) { 
                var content = tinymce.get(e.target.id).getContent();
                getCoordinatesByAddress(content);
            }),
            editor.addButton('mybutton', {
                type: 'listbox',
                text: 'Select Clips',
                icon: false,
                onselect: function (e) {
                    editor.insertContent(this.value());
                },
                values: eventVars,
            });
        },
            forced_root_block : '',
            content_css: ['//www.tinymce.com/css/codepen.min.css']
        };
        tinymce.init(editorConfig);
    }
});
</script>