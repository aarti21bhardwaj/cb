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
<div class="instructors form large-9 medium-8 columns content">
    <?= $this->Form->create($instructor,['class' => 'form-horizontal', 'enctype'=>"multipart/form-data"]) ?>
    <fieldset>
    <div class = 'ibox-title'>
        <legend><?= __('Edit Instructor') ?></legend>
    </div>
    <?= $this->Form->hidden('userId',['value' => $instructor->id]);?>
        <?php if($loggedInUser['role']->name == 'tenant'){ ?>
            <!-- <div class="form-group text required">
                <label class="col-sm-2 control-label" for="duration"></label>
                <div class="col-sm-10">
                    <?= $this->Form->control('tenant_id', ['value' =>$loggedInUser['id'],'type'=>'hidden', 'id' => 'tenantId']); ?>
                </div>
            </div> -->
            <?php } ?>
        
            <!-- echo $this->Form->control('tenant_id', ['options' => $tenants]); -->
            <!-- <?= $this->Form->control('training_site_id', ['options' => $trainingSites]); ?> -->
             <?php
                if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label != 'TRAINING SITE OWNER')  {
                     echo $this->Form->control('training_site_id', ['empty' => '--SELECT ONE--','options' => $trainingSites,'required' => true]);
                }
            ?>
            <?= $this->Form->control('first_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
            <?= $this->Form->control('last_name', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?>
            <?= $this->Form->control('email', ['data-validation'=> "email" ,'type'=> "text"]);?>
            <!-- <?= $this->Form->control('password');?> -->
             <?= $this->Form->hidden('userId',['value' => $instructor->id]);?>
                        <div class="form-group">
                            <?= $this->Form->label('password', __('Password'), ['class' => ['col-sm-2', 'control-label']]); ?>
                                <div class="col-sm-10">
                                    <div class="">
                                      <a data-toggle="modal" id="changePasswordButton" class="btn btn-primary" href="#changePasswordModal">Change Password</a>
                                    </div>
                                </div>
                            </div>

            <!-- <div class="form-group">
            <?= $this->Form->label('image', __('Image Upload'), ['class' => 'col-sm-2 control-label']); ?>

                <div class="col-sm-4">
                <div class="img-thumbnail">
                 <?= $this->Html->image($instructor->image_url, array('height' => 100, 'width' => 100,'id'=>'upload-img')); ?>
                 </div><br><br>
                 <?= $this->Form->control('image_name', ['accept'=>"image/*",'label' => false,['class' => 'form-control'],'type' => "file",'id'=>'imgChange']);?>
                </div>
            </div> -->

            <!-- echo $this->Form->control('image_path'); -->
            <?= $this->Form->control('phone_1',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);?>
            <?= $this->Form->control('phone_2',['type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);?>
            <div class="form-group">
                <?= $this->Form->label('address', __('Address'), ['class' => ['col-sm-2', 'control-label']]) ?>
                <div class="col-sm-10">
                    <?= $this->Form->control('address', ['id'=>'address1','type'=> 'textarea', 'label' => false, 'class' => ['form-control', 'fr-view','tinymceTextarea1']]); ?>
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
                <?= $this->Form->label('city', __('City'),['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$'],['class' => ['col-sm-2', 'control-label']]); ?>
                <div class="col-sm-offset-2">
                    <input id="address" class="form-control" type="text" name="city" value="<?= $instructor->city;?>" >
                    <!-- <button type="button" class="btn btn-primary">Get Coordinates</button> -->
                </div>
                
            </div>
            <div class="hr-line-dashed"></div>
            <!-- <?= $this->Form->control('city', ['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);?> -->
            <?= $this->Form->control('state',['name'=>'state','data-validation'=>'federatestate']);?>
            <?= $this->Form->control('zipcode',['required','type'=>'text','data-validation'=>'number', 'data-validation-length'=>'05-05','data-validation'=> 'number length']);?>
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
			</div> <!-- .ibox-content ends --> 
		</div> <!-- .ibox ends -->
	</div> <!-- .col-lg-12 ends -->
</div> <!-- .row ends -->
<!-- Change Password Modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="changePasswordModal">
  <div class="modal-dialog" role="document">
    <?= $this->Form->create(null, ['class' => 'form-horizontal','data-toggle'=>"validator"]) ?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= __('CHANGE PASSWORD')?></h4>
      </div>

      <div class="modal-body">
      <div class="alert" id="rsp_msg" style=''>

        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("new_pwd", array(
            "label" => false,
            'id'=>'new_pwd',
            "type"=>"password",
            'required' => true,
            "class" => "form-control",'data-minlength'=>5,
            'data-validation'=> "length" ,
            'data-validation-length'=>"min5",
            'placeholder'=>"Enter New Password"));
            ?>
            <div class="help-block with-errors"><?= __('')?></div>
          </div>
        </div>

        <div class="form-group">
          <?= $this->Form->label('name', __('Confirm New Password'), ['class' => ['col-sm-4', 'control-label']]); ?>
          <div class="col-sm-8">
           <?= $this->Form->control("cnf_new_pwd", array(
            "label" => false,
            "type"=>"password",
            'id'=>'cnf_new_pwd',
            'required' => true,
            'data-validation'=> "length" ,
            'data-validation-length'=>"min5",
            "class" => "form-control",'data-minlength'=>5,'data-match'=>"#new_pwd",'data-match-error'=>"__('MISMATCH')",'placeholder'=>"Confirm Password"));
            ?>
            <div class="help-block with-errors"><?= __('')?></div>
          </div>
        </div>


      </div>

        <?= $this->Form->button(__('Submit'), ['class' => ['btn', 'btn-primary'],'id'=>"saveUserPassword"]) ?>
      <?= $this->Form->end() ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
    $(document).ready(function(){
    var host = $('#baseUrl').val();
    $('#saveUserPassword').on('click',function(event){
        if($(this).hasClass('disabled')){
            event.preventDefault();
        }
            var userId = $('input[name=userId]').val();
            var newPwd = $('#new_pwd').val();
            var cnfNewPwd = $('#cnf_new_pwd').val();
            if(newPwd !== cnfNewPwd){
              $('#rsp_msg').addClass('alert-danger');
              $('#rsp_msg').append('<strong>Password Mismatch error</strong>');
              $('#rsp_msg').show();
            }
            if(newPwd && cnfNewPwd && (newPwd == cnfNewPwd)){
                $.ajax({
                    url: host+"api/instructors/updatePassword/"+userId,
                    headers:{"accept":"application/json"},
                    dataType: 'json',
                    data:{
                        "user_id" : userId,
                        "new_password" : newPwd,
                    },
                    type: "put",
                    success:function(data){
                        if($('#rsp_msg').hasClass('alert-danger')){
                            $('#rsp_msg').removeClass('alert-danger');
                        }
                        $('#rsp_msg').empty();
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass('alert-success');
                        $('#rsp_msg').append('<strong>Password changed successfully.</strong>');
                        $('#rsp_msg').show();
                        setTimeout(function(){
                            $('#rsp_msg').fadeIn(500);
                            $('#changePasswordModal').modal('hide');
                            $('#rsp_msg').removeClass('alert-success');
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');
                        }, 2000);
                    },
                    error:function(data){
                        var className = 'alert-danger';
                        if($('#rsp_msg').hasClass('alert-success')){
                            $('#rsp_msg').removeClass('alert-success');
                        }
                        $('#rsp_msg').addClass(className);
                        $('#rsp_msg').append('<strong>' + data.responseJSON.message + '</strong>');
                        setTimeout(function(){
                            if($('#rsp_msg').hasClass(className)){
                                $('#rsp_msg').removeClass(className);
                            }
                            $('#rsp_msg').hide();
                            $('#rsp_msg').html('');

                        }, 2000);
                        $('#rsp_msg').fadeIn(500);

                    },
                    beforeSend: function() {

                    }
                });

            }
            event.preventDefault();
        });
        
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
border: 1px solid #dcdcdc;
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