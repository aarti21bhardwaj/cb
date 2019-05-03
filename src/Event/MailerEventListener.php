<?php 
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\Log\Log;
use Cake\Mailer\MailerAwareTrait;
use Cake\Http\Exception;
use Cake\Controller\Controller;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class MailerEventListener implements EventListenerInterface {

	use MailerAwareTrait;

	public function initialize(){
    	// pr('test');die;
		$this->Events = TableRegistry::get('Events');
		$this->TenantSettings = TableRegistry::get('TenantSettings');
		$this->Courses = TableRegistry::get('Courses');
		$this->CourseInstructors = TableRegistry::get('CourseInstructors');
		$this->CorporateClients = TableRegistry::get('CorporateClients');
		$this->CourseStudents = TableRegistry::get('CourseStudents');
		$this->CorporateClients = TableRegistry::get('CorporateClients');	
  	}

	public function implementedEvents()
	{	
		// die('ssss');
	    return [
	        "forgot_password" => 'forgotPassword',
	        "cancel_course" => 'cancelCourse',
	        "corporate_admin_registration" => 'corporateRegistration',
	        "instructor_accept_course" => 'instructorAcceptCourse',
	        "instructor_decline_course" => 'instructorDeclineCourse',
	        "register_student_to_course" => 'registerStudentToCourse',
	        'account_confirmation_instructor' => 'accountConfirmationInstructor',
	        'password_update_tenant' => 'passwordUpdateTenant',
	        'password_update_super_admin'=> 'passwordUpdateSuperAdmin',
	        'password_update_student' => 'passwordUpdateStudent',
	        'instructor_certifications' => 'InstructorExpirationData',
	        'course_registration_confirmation' => 'CourseRegistrationConfirmation',
	        'course_payment_confirmation' => 'CoursePaymentConfirmation',
	        'account_password_update_instructor' => 'AccountPasswordUpdateInstructor',
	        'account_creation_notification_instructor' => 'AccountCreationNotificationInstructor',
	        'training_opportunity_notification_instructor' => 'TrainingOpportunityNotificationInstructor',
	        'training_opportunity_reassignment_notification_instructor' => 'TrainingOpportunityReassignmentNotificationInstructor',
	        'account_password_update_notification_corporate' => 'accountPasswordUpdateNotificationCorporate',
	        'instructor_certifications_expiring_in_90_days' => 'instructorCertificationsExpiringIn90Days',
	        'instructor_certifications_expiring_in_90_days' => 'instructorCertificationsExpiringIn90Days',
	        '1_day_course_reminder_student' => 'OneDayCourseReminderStudent',
	        '7_day_course_reminder_instructor' =>'SevenDayCourseReminderInstructor',
	        'instructor_certifications_expiring_notification_60_days' => 'instructorCertificationsExpiringIn60Days',
	        'instructor_certifications_expiring_notification_30_days' => 'instructorCertificationsExpiringIn30Days',
	        'instructor_certifications_expired_notification' => 'instructorCertificationsExpired',
	        'share_course' => 'shareCourse',
	        'revoke_access_for_course' => 'revokeAccess'

	    ];
	}

	public function passwordUpdateStudent($event){

		$data= $event->getdata();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);
	}

	public function shareCourse($event){
		$data= $event->getdata();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);
	}

	public function revokeAccess($event){
		$data= $event->getdata();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);
		// pr($data);die;
	}

	public function passwordUpdateSuperAdmin($event){
		
		$data= $event->getdata();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);
	}

	public function passwordUpdateTenant($event){
		$data= $event->getdata();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);
	}

	public function accountConfirmationInstructor($event){
        // pr($event);
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function forgotPassword($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function corporateRegistration($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function instructorAcceptCourse($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function instructorDeclineCourse($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function cancelCourse($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function registerStudentToCourse($event){
		
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		$this->_sendEmail($data);

	}

	public function InstructorExpirationData($event){
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		pr($sendData);die;
		// $this->_sendEmail($data);

	}
	public function CourseRegistrationConfirmation($event){

		$data = $event->getData();
		// pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($sendData);die;
		$this->_sendEmail($data);

	}
	public function AccountPasswordUpdateInstructor($event){
		$data = $event->getData();

// 		pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($sendData);die;
		$this->_sendEmail($data);
	}
	public function CoursePaymentConfirmation($event){
		$data = $event->getData();
// 		pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($sendData);die;
		$this->_sendEmail($data);
	}
	public function AccountCreationNotificationInstructor($event){
		$data = $event->getData();
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($data);die('here');
		$this->_sendEmail($data);	
	}
	public function TrainingOpportunityNotificationInstructor($event){
		$data = $event->getData();
		// pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($data);die('here');
		$this->_sendEmail($data);
	}

	public function TrainingOpportunityReassignmentNotificationInstructor($event){
		$data = $event->getData();
		// pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($data);die('here');
		$this->_sendEmail($data);	
	}
	public function accountPasswordUpdateNotificationCorporate($event){
		$data = $event->getData();
		// pr($data);die;
		$this->_getEvent($event->getName(), $data['tenant_id']);
		// pr($data);die('here');
		$this->_sendEmail($data);
	}
	public function instructorCertificationsExpiringIn90Days($event){
		$data = $event->getData();
		// pr($data['hashData']->emails[0]);die;
		// $emailData = [];
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$instructors = $this->getInstructor($value1->id,$value1->tenant_id);
				// pr($value1);die;
				foreach ($instructors as $key => $val) {
					foreach ($val->instructor->instructor_qualifications as $key => $qual) {
						// pr($val->instructor);die;
										$date = date_diff(Time::now(),$qual->expiry_date);


										if($date->days == $data['hashData']->emails[0]->schedule){
											$emailData['hashData'] = [ 'first_name' => $val->instructor->first_name,
															'last_name' => $val->instructor->last_name,
															'email' => $val->instructor->email,
															'course_type' => $value1->course_type->name,
															'course_type_agency' => $value1->course_type->agency->name,
															'instructor_expiry_date' => $qual->expiry_date->format('Y-m-d'),
															'training_site_name' => $value1->training_site->name,
															'training_site_phone' => $value1->training_site->contact_phone,
															'training_site_email' => $value1->training_site->contact_email,
														 ];
											// pr($val);die;
											$emailData['event'] = $data['hashData'];
											// pr($emailData['event']);die;
											// $this->_getEvent($event->getName(),$value1->tenant_id);
											$this->_sendEmail($emailData);
										}
									}				
				}
				$corporateClients = $this->getCorporateClients($value->tenant_id);
				// $data = array_merge($courses,$instructors,$corporateClients);
				// pr($data);die;
			}
		}

	}
	public function OneDayCourseReminderStudent($event){
		
		$data = $event->getData();
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$students = $this->getStudents($value1->id, $value1->tenant_id);
				$instructors = $this->getInstructor($value1->id, $value1->tenant_id);
				$date = date_diff(Time::now(),$value1->course_dates[0]->course_date);
					if($date->days == $data['hashData']->emails[0]->schedule){
				
				foreach($students as $key => $val2) {
					foreach ($instructors as $key => $value) {
						$emailData['hashData'] = [
										'first_name' =>$val2->student->first_name,
										'last_name' =>$val2->student->last_name,
										'email'=> $val2->student->email,
										'training_site_name'=>$value1->training_site->name,
										'training_site_phone'=>$value1->training_site->contact_phone,
										'training_site_email'=>$value1->training_site->contact_email,
										'course_id' => $value1->id,
										'course_type' => $value1->course_type->name,
										'course_type_agency'=>$value1->course_type->agency->name,
										'course_date' => $value1->course_dates[0]->course_date->format('Y-m-d'),
										'course_start_time' => $value1->course_dates[0]->time_from->format('H:i'),
										'course_end_time' => $value1->course_dates[0]->time_to->format('H:i'),
										'location_name' => $value1->location->name,
										'location_address' => $value1->location? $value1->location->address: "No location data available!",
										'location_city' => $value1->location->city,
										'location_state'=> $value1->location->state,
										'location_zipcode'=> $value1->location->zipcode,
										'instructor_first_name' => $value->instructor->first_name,
										'instructor_last_name'=> $value->instructor->last_name,
										];
										$emailData['event'] = $data['hashData'];
										$this->_sendEmail($emailData);
										}
						
					}
				}	
			}
		}
	}

	public function SevenDayCourseReminderInstructor($event){
		$data = $event->getData();
		// pr($data);die;
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$instructors = $this->getInstructor($value1->id,$value1->tenant_id);
				// pr($instructors);die;
				$date = date_diff(Time::now(),$value1->course_dates[0]->course_date);
					if($date->days == $data['hashData']->emails[0]->schedule){
				foreach($instructors as $key=>$value2){
					$emailData['hashData'] =[
										'first_name' => $value2->instructor->first_name,
										'last_name' => $value2->instructor->last_name,
										'email' => $value2->instructor->email,
										'training_site_name'=>$value1->training_site->name,
										'training_site_phone'=>$value1->training_site->contact_phone,
										'training_site_email'=>$value1->training_site->contact_email,
										'course_id' => $value1->id,
										'course_type' => $value1->course_type->name,
										'course_type_agency'=>$value1->course_type->agency->name,
										'course_date' => $value1->course_dates[0]->course_date->format('Y-m-d'),
										'course_start_time' => $value1->course_dates[0]->time_from->format('H:i'),
										'course_end_time' => $value1->course_dates[0]->time_to->format('H:i'),
										'location_name' => $value1->location->name,
										'loation_address' => $value1->location? $value1->location->address:  "No location data available!",
										'location_city' =>$value1->location->city,
										'location_state'=>$value1->location->state,
										'location_zipcode'=>$value1->location->zipcode,
										'location_notes' => $value1->location? $value1->location->notes: "No data exits!",
										'course_notes'=>$value1->notes? $value1->notes : "No data exists!",
											];
										$emailData['event'] = $data['hashData'];
										// pr($emailData);die;
										$this->_sendEmail($emailData);
					}					
				}	
			}
		}
	}
	public function instructorCertificationsExpiringIn60Days($event){
		$data = $event->getData();
		// pr($data['hashData']);die('60Days');
		// $emailData = [];
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$instructors = $this->getInstructor($value1->id,$value1->tenant_id);
				// pr($instructors);die;
				foreach ($instructors as $key => $val) {
					foreach ($val->instructor->instructor_qualifications as $key => $qual) {
						// pr($val->instructor->email);die;
										$date = date_diff(Time::now(),$qual->expiry_date);
										// pr($date);die;
										if($date->days == $data['hashData']->emails[0]->schedule){
											$emailData['hashData'] = [ 'first_name' => $val->instructor->first_name,
															'last_name' => $val->instructor->last_name,
															'email' => $val->instructor->email,
															'course_type' => $value1->course_type->name,
															'course_type_agency' => $value1->course_type->agency->name,
															'instructor_expiry_date' => $qual->expiry_date->format('Y-m-d'),
															'training_site_name' => $value1->training_site->name,
															'training_site_phone' => $value1->training_site->contact_phone,
															'training_site_email' => $value1->training_site->contact_email,
														 ];
											$emailData['event'] = $data['hashData'];
											// pr($emailData);die;
											// pr($emailData['event']);die;
											// $this->_getEvent($event->getName(),$value1->tenant_id);
											$this->_sendEmail($emailData);
										}
									}				
				}
				$corporateClients = $this->getCorporateClients($value->tenant_id);
				// $data = array_merge($courses,$instructors,$corporateClients);
				// pr($data);die;
			}
		}
	}
	public function instructorCertificationsExpiringIn30Days($event){
		$data = $event->getData();
		// die('test');
		// pr($data['hashData']);die('60Days');
		// $emailData = [];
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$instructors = $this->getInstructor($value1->id,$value1->tenant_id);
				// pr($instructors);die;
				foreach ($instructors as $key => $val) {
					foreach ($val->instructor->instructor_qualifications as $key => $qual) {
						// pr($val->instructor->email);
										$date = date_diff(Time::now(),$qual->expiry_date);
										// pr($date);
										if($date->days == $data['hashData']->emails[0]->schedule){
											$emailData['hashData'] = [ 'first_name' => $val->instructor->first_name,
															'last_name' => $val->instructor->last_name,
															'email' => $val->instructor->email,
															'course_type' => $value1->course_type->name,
															'course_type_agency' => $value1->course_type->agency->name,
															'instructor_expiry_date' => $qual->expiry_date->format('Y-m-d'),
															'training_site_name' => $value1->training_site->name,
															'training_site_phone' => $value1->training_site->contact_phone,
															'training_site_email' => $value1->training_site->contact_email,
														 ];
											$emailData['event'] = $data['hashData'];
											// pr($emailData['hashData']);die;
											// pr($emailData['event']);die;
											// $this->_getEvent($event->getName(),$value1->tenant_id);
											$this->_sendEmail($emailData);
										}
									}
				}
									// die;				
				$corporateClients = $this->getCorporateClients($value->tenant_id);
				// $data = array_merge($courses,$instructors,$corporateClients);
				// pr($data);die;
			}
		}
	}
	public function instructorCertificationsExpired($event){
		$data = $event->getData();
		// die('Expired');
		// pr($data['hashData']);die('60Days');
		foreach ($data['hashData']->emails[0]->email_course_types as $key => $value) {
			$courses = $this->getCourses($value->course_type_id);
			foreach ($courses as $key => $value1) {
				$instructors = $this->getInstructor($value1->id,$value1->tenant_id);
				// pr($instructors);die;
				foreach ($instructors as $key => $val) {
					// pr('here');die;
					if(isset($val->instructor->instructor_qualifications)){
						foreach ($val->instructor->instructor_qualifications as $key => $qual) {
							// pr($qual);pr('test');
								$date = date_diff(Time::now(),$qual->expiry_date);
								if($date->days == 0){
									$emailData['hashData'] = [ 'first_name' => $val->instructor->first_name,
													'last_name' => $val->instructor->last_name,
													'email' => $val->instructor->email,
													'course_type' => $value1->course_type->name,
													'course_type_agency' => $value1->course_type->agency->name,
													'instructor_expiry_date' => $qual->expiry_date->format('Y-m-d'),
													'training_site_name' => $value1->training_site->name,
													'training_site_phone' => $value1->training_site->contact_phone,
													'training_site_email' => $value1->training_site->contact_email,
												 ];
									$emailData['event'] = $data['hashData'];
									// pr($emailData['hashData']);
									// pr($emailData['event']);die;
									// $this->_getEvent($event->getName(),$value1->tenant_id);
									$this->_sendEmail($emailData);
								}
							}
						}
					}
									die;				
				$corporateClients = $this->getCorporateClients($value->tenant_id);
				// $data = array_merge($courses,$instructors,$corporateClients);
				// pr($data);die;
			}
		}
	}

	private function _getEvent($eventKey, $tenantId = null){
		$this->initialize();
		if($tenantId !== null){			
        $event = $this->Events->findByEventKey($eventKey)->contain([
       	'EventVariables',
       	"Emails" => function($q) use($tenantId){
   			return $q->where(['tenant_id' => $tenantId]);
       	}
       ])->first();
        if(empty($event['emails'][0]['from_email']) && isset($event['emails'][0]['from_email'])){
        	$email = $this->TenantSettings->findByTenantId($tenantId)->first();
        	$event['emails'][0]['from_email'] = $email['from_email'];
        	$this->_bcc = $email['bcc_email'];
        }
		}else {
			$event = $this->Events->findByEventKey($eventKey)->contain([
       	'EventVariables',
       	"Emails" => function($q) use($tenantId){
   			return $q->where(['tenant_id IS Null']);
       	}
       ])->first();
		}

       if(!$event){
       	//handle case here
       }
       $this->_event = $event;
    }

	private function _sendEmail($data){

		if(isset($this->_event) && !empty($this->_event)){
		$event = $this->_event;
		}
		// pr($data);die;	
		if(isset($event->emails) && !empty($event->emails)){
			$status = $event->emails[0]->status;
		}
		
		if(!isset($data['event'])){
			$data['event'] = $this->_event;
			// die('here12');
		}else{
			$status = $data['event']->emails[0]->status;
			// pr($status);die;
		}
		if(isset($this->_bcc) && !empty($this->_bcc)){
			$data['hashData']['bcc'] = $this->_bcc;
		}

		// pr($data);die;
		if($status){
			$this->getMailer('General')->send('sendMail', [$data]);
			
			Log::write('debug', json_encode($data));	
		}else{
			Log::write('debug', 'Email Disabled for eventId '.json_encode($event));
		}
	}

	public function getCourses($courseTypeId){

		return $this->Courses->findByCourseTypeId($courseTypeId)->contain(['CourseTypes.Agencies','TrainingSites','CourseDates','Locations'])->toArray();
	}
	public function getInstructor($courseId, $tenantId){
		return $this->CourseInstructors->find()->where(['course_id' => $courseId])
										->contain(['Instructors' => function($q) use($tenantId){
												return $q->where(['tenant_id' => $tenantId]);
										},'Instructors.InstructorQualifications'])
										->toArray();
		// pr($data);die;
	}
	public function getCorporateClients($tenantId){
		return $this->CorporateClients->findByTenantId($tenantId)->contain(['SubcontractedClients'])->toArray();
		// pr($data);die;
	}

	public function getStudents($courseId, $tenantId){
		return $this->CourseStudents->findByCourseId($courseId)->contain(['Students'=>function($q) use ($tenantId) {
			return $q->where(['Students.tenant_id'=> $tenantId]);
		}])->where(['payment_status NOT IN' => 'Amount Refunded'])->toArray();
		// pr($data);die;
	}
}

?>