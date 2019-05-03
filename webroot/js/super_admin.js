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
});

function initEditor(eventVars){
	var editorConfig = {
		selector: '.tinymceTextarea',
		height: 200,
		toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | mybutton',
		menubar: false,
		plugins: [
		'advlist autolink link anchor',
		'searchreplace code',
		'insertdatetime paste code'
		],
		setup: function (editor) {
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


function getCorporateClients(data){
    var trainingSiteId = data.value;
    // console.log(trainingSiteId);
    jQuery.ajax({
        type: "GET",
        url: host+"api/CorporateClients/index/?training_site_id="+trainingSiteId,
        headers:{"accept":"application/json"},
        success: function (result) {
	            // console.log(result);
	            updateCorporateClientsOptions(result);
            }
        });
}
    
function updateCorporateClientsOptions(result){
    // console.log(result.corporateClients);
    values = result.corporateClients;
    console.log(values);
    //var removeOptions = '<option>';
    $('#corporate_clients').empty();
    $('#corporate_clients').append('<option>Please Select</option>');
    $.each(values, function (i, values) {
        $('#corporate_clients').append($('<option>', {
            value: values.id,
            text : values.name
        }));

    });
}


function getCourseTypes(data){
	var courseTypeCategoryId = data.value;
	jQuery.ajax({
		type:'GET',
		url: host+"api/CorporateClients/courseTypes/?course_type_category_id="+courseTypeCategoryId,
		headers:{"accept":"application/json"},
		success: function(result){
			setCourseTypeCategoriesOptions(result);
		}
	});
}
function setCourseTypeCategoriesOptions(result){
	values = result.courseTypes;
    $('#course_type_category').empty();
    $('#course_type_category').append('<option>Please Select</option>');
    $.each(values, function (i, values) {
        $('#course_type_category').append($('<option>', {
            value: values.id,
            text : values.name
        }));

    });
}

function getCourseData(data){
	var courseTypeId = data.value;
	jQuery.ajax({
		type:'GET',
		url: host+"api/CorporateClients/courseData/?course_type_id="+courseTypeId,
		headers:{"accept":"application/json"},
		success: function(result){
			tinyMCE.get('class_detail').setContent(result.courseTypeData.class_detail);
			tinyMCE.get('instructor_notes_data').setContent(result.courseTypeData.notes_to_instructor);
		}
	});
}


/*This function is to accept the course by instructor*/

function acceptCourseByTenant(courseId,status,instructorId=null) {

	swal({
        title: "Are you sure you want to accept this course on behalf of this instructor?",
        // text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
		
		$.ajax({
			method: "PUT",
			url: host+"api/courses/edit/"+courseId,
			headers:{"accept":"application/json"},
			contentType: "application/json",
			data:'{"status":'+status+',"instructor_id":'+instructorId+'}',
		})
		.success(function(data){
			console.log(data);
			swal({title: "Done", text: "Course Accepted", type: "success"},
			   	function(){ 
			       location.reload();
			   	}
			);
			// swal("Done!", "Course Accepted", "success");
			// $('#hideAfterUpdate'+courseId).hide();
			// $('#showIfAlreadyAdded'+courseId).show();
		});

	});
}

function acceptCourseByInstructor(courseId,status,instructorId=null) {

	swal({
        title: "Are you sure you want to accept this course?",
        // text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
		
		$.ajax({
			method: "PUT",
			url: host+"api/courses/edit/"+courseId,
			headers:{"accept":"application/json"},
			contentType: "application/json",
			data:'{"status":'+status+',"instructor_id":'+instructorId+'}',
		})
		.success(function(data){
			console.log(data);
			swal({title: "Done", text: "Course Accepted", type: "success"},
			   	function(){ 
			       location.reload();
			   	}
			);
			// swal("Done!", "Course Accepted", "success");
			// $('#hideAfterUpdate'+courseId).hide();
			// $('#showIfAlreadyAdded'+courseId).show();
		});

	});
}

function declineCourseByInstructor(courseId,status,instructorId=null) {
	// alert(courseId);
	// alert(status);
	// alert(instructorId);
	swal({
        title: "Are you sure you want to decline this course?",
        // text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
		
		$.ajax({
			method: "PUT",
			url: host+"api/courses/edit/"+courseId,
			headers:{"accept":"application/json"},
			contentType: "application/json",
			data:'{"status":'+status+',"instructor_id":'+instructorId+'}',
		})
		.success(function(data){
			console.log(data);
			swal({title: "Done", text: "Course declined", type: "warning"},
			   	function(){ 
			       location.reload();
			   	}
			);
		});
	});
}

function declineCourseByTenant(courseId,status,instructorId=null) {
	// alert(courseId);
	// alert(status);
	// alert(instructorId);
	swal({
        title: "Are you sure you want to decline this course on behalf of this Instructor?",
        // text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
		
		$.ajax({
			method: "PUT",
			url: host+"api/courses/edit/"+courseId,
			headers:{"accept":"application/json"},
			contentType: "application/json",
			data:'{"status":'+status+',"instructor_id":'+instructorId+'}',
		})
		.success(function(data){
			console.log(data);
			swal({title: "Done", text: "Course declined", type: "warning"},
			   	function(){ 
			       location.reload();
			   	}
			);
		});
	});
}