<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Core\Exception\Exception;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Auth\DefaultPasswordHasher;
use Firebase\JWT\JWT;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\I18n\Date; 
use Cake\Collection\Collection;
use Cake\I18n\FrozenTime;
use Cake\Routing\Router;
use Cake\Http\Session;
use Cake\Mailer\Email;
use Cake\Event\Event;

/**
 * Courses Controller..
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends ApiController
{

    public function initialize(){
            // $this->_RequestData = $this->request->getData();
            parent::initialize();
            $this->Auth->allow(['getCourses','reopenCourses']);
    }
      public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['edit','removeRoster','assignTenantToCourse','mailTenant','sendEmail','updateStatus','refreshLocations','refreshCourseTypeCategories','cancelandrefundStudent','updateTestScore','sendMailToStudent','sendMailToInstructor','updateSkill','addAddonForStudent','getCourses','bulkStatusUpdate','refundTransactions','index']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['edit','mailDataFetch','verifyTenantUuid','assignTenantToCourse','mailTenant','sharedCourses','removeRoster','sendEmail','updateStatus','refreshLocations','refreshCourseTypeCategories','cancelandrefundStudent','updateTestScore','sendMailToStudent','sendMailToInstructor','updateSkill','addAddonForStudent','getCourses','bulkStatusUpdate','refundTransactions','index']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['edit','removeRoster','sendEmail','updateStatus','refreshLocations','refreshCourseTypeCategories','cancelandrefundStudent','updateTestScore','sendMailToStudent','sendMailToInstructor','updateSkill','addAddonForStudent','getCourses','bulkStatusUpdate','refundTransactions','index']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['edit','removeRoster','sendEmail','updateStatus','refreshLocations','refreshCourseTypeCategories','cancelandrefundStudent','updateTestScore','sendMailToStudent','sendMailToInstructor','updateSkill','addAddonForStudent','getCourses','bulkStatusUpdate','refundTransactions','index']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['edit','removeRoster','sendEmail','updateStatus','refreshLocations','refreshCourseTypeCategories','cancelandrefundStudent','updateTestScore','sendMailToStudent','sendMailToInstructor','updateSkill','addAddonForStudent','getCourses','bulkStatusUpdate','refundTransactions','index']) && $user['role']->name === self::STUDENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }
    


    public function edit($id){
        if(!$this->request->is(['put'])){
          throw new MethodNotAllowedException(__('Bad Request'));
        }
        $reqData = $this->request->getData();
        $reqData['status'] = $reqData['status'];
        // pr($reqData['status']);die;
        $reqData['instructor_id'] = $reqData['instructor_id'];

        $instructorId = $reqData['instructor_id'];
        
        $course = $this->Courses->find()->where(['id'=>$id])->first();
        if(!$course){
            throw new NotFoundException(__('This course does not exists'));
        }
        
        $this->loadModel('CourseInstructors');
        $this->loadModel('Courses');
        $this->loadModel('Instructors');
        $course_instructors = $this->CourseInstructors->find()->where(['course_id'=>$id,'instructor_id'=>$instructorId])->first();
                $instructor =$this->Instructors->findById($instructorId)->first();
                if(!$course_instructors){
                    throw new NotFoundException(__('This course instructors does not exists'));
                }
        $course =$this->Courses->findById($id)->contain(['TrainingSites','Locations','CourseDates'])->first();
        $emailData = [
          'name' => $instructor->first_name,
          'email' => $instructor->email,
          'course_id' => $course->id,
          'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
          'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
          'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
          'location_name' => $course->location->name,
          'location_address' => $course->location->address,
          'location_city' => $course->location->city,
          'location_state' => $course->location->state,
          'location_notes' => $course->location->notes,
          'instructor_notes' => $course->instructor_notes,
          'course_notes' => $course->class_details,
          'training_site_name' => $course->training_site->name,
          'training_site_phone' => $course->training_site->contact_phone,
          'training_site_email' => $course->training_site->contact_email,
          
        ];
        // pr($course_instructors);die;
        if(isset($course->instructor_bidding) && $course->instructor_bidding == 1){
            // pr('here');die;
            $limit = $course->bidding_number;
            // pr($limit);
            $biddingInstructors = $this->CourseInstructors->find()->where(['course_id'=>$id, 'status' => 1])->count();
            // die('here1');
            // pr($biddingInstructors);
            if($limit > $biddingInstructors){
                // die('here');
                $course_instructors->status = $reqData['status'];
                $course_instructors = $this->CourseInstructors->patchEntity($course_instructors, $reqData);
                 if($this->CourseInstructors->save($course_instructors)){
                   $this->sendEmail($course_instructors, $emailData, $course);
                    // $course_instructors['success'] = 'yes';
                        $this->set('response',$course_instructors);
                        // pr($course_instructors);die('there');
                        // $data = serialize($course_instructors);
                        // pr($data);die;
                        $this->set('_serialize', ['response']);
                        }else{
                            throw new BadRequestException(__('Bad Request'));
                        }

                $biddingInstructorsUpdated = $this->CourseInstructors->find()->where(['course_id'=>$id, 'status' => 1])->count();
                    if($biddingInstructorsUpdated < $biddingInstructors){
                        $data['full']='';
                              $course = $this->Courses->patchEntity($course, $data);
                              // pr($course);die;
                                 if($this->Courses->save($course)){
                                    $this->set('response',$course_instructors);
                                 }
                    }
                        if($limit == $biddingInstructors+1){
                            // die('here2');
                             $data['full']=1;
                              $course = $this->Courses->patchEntity($course, $data);
                              // pr($course);die;
                                 if($this->Courses->save($course)){
                                    $this->set('response',$course_instructors);
                                 }
                             
                        }

            }else{
                    // die('here1');
                    if($reqData['status'] == 2){
                        $course_instructors->status = $reqData['status'];
                        $course_instructors = $this->CourseInstructors->patchEntity($course_instructors, $reqData);
                         if(!$this->CourseInstructors->save($course_instructors)){
                                    throw new BadRequestException(__('Course Instructor Data nor saved'));
                            }else{
                                $data['full']=0;
                                $course = $this->Courses->patchEntity($course, $data);
                                 if(!$this->Courses->save($course)){
                                    throw new BadRequestException(__('Course Data nor saved'));
                                 }   
                            }
                                $this->sendEmail($course_instructors, $emailData, $course);
                                $this->set('response',$course_instructors);
                                $this->set('_serialize', ['response']);
                        }    
                 }
        }else{
        $course_instructors->status = $reqData['status'];
        $course_instructors = $this->CourseInstructors->patchEntity($course_instructors, $reqData);
        // pr($course_instructors);die;
            if($this->CourseInstructors->save($course_instructors)){
                $this->sendEmail($course_instructors, $emailData, $course);
        
            $this->set('response',$course_instructors);
            $this->set('_serialize', ['response']);
            }else{
                throw new BadRequestException(__('Bad Request'));
            }
        }
    }




        // pr($course_instructors);die;
       
    public function removeRoster($id=null){
        // pr($id); die('ss');
        $this->viewBuilder()->setLayout('popup-view');
        $course = $this->Courses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->Courses->updateAll(
                [
                    'document_name' => null,
                    'document_path' => null
                ],
                ['id' => $id]
            );
            $data =array();
            $data['status']=true;
            $data['data']['id']=$course->id;
            $data['data']['message']='Roster Removed';
            $this->set('response',$data);
            $this->set('_serialize', ['response']);
        }else{
          throw new BadRequestException(__('Something went wrong, Please try again.'));
        }
    }

    public function sendEmail($course_instructors = null, $emailData = null, $course = null){
        // pr('here');die;
        if($course_instructors->status ==1){

        if(isset($emailData) && !empty($emailData)):
         $event = new Event('instructor_accept_course', $this, [
             'hashData' => $emailData,
             'tenant_id' => $course->tenant_id
            ]);
                $this->getEventManager()->dispatch($event);
        endif;
        }elseif($course_instructors->status ==2){
            if(isset($emailData) && !empty($emailData)):
             $event = new Event('instructor_decline_course', $this, [
                 'hashData' => $emailData,
                 'tenant_id' => $course->tenant_id
                ]);
                    $this->getEventManager()->dispatch($event);
            endif;

        }
    }

    public function updateStatus(){
        // pr($this->request->getData()); die('ss');
        $data = $this->request->getData();
        $course_student_id = $data['course_student_id'];
        $this->loadModel('CourseStudents');
        $courseStudents = $this->CourseStudents->get($course_student_id);
            
            $course_status = $data['course_status'];
            $reqData = ['course_status'=>$course_status];
            $courseStudents = $this->CourseStudents->patchEntity($courseStudents, $reqData);
            if($this->CourseStudents->save($courseStudents)){
                $data =array();
                $data['status']=true;
                $data['data']['id']=$courseStudents->id;
                $this->set('response',$data);
                $this->set('_serialize', ['response']);
            }
    }
    public function refreshLocations(){
        
        $this->loadModel('Locations');
        $loggedInUser = $this->Auth->user();
        $locations = $this->Locations->find()->select(['id', 'name'])->where(['Locations.tenant_id' => $loggedInUser['tenant_id']])->all();
            // pr($locations);die;
            
                $this->set('response',$locations);
                $this->set('_serialize', ['response']);
    }

    public function refreshCourseTypeCategories(){
        
        $this->loadModel('CourseTypeCategories');
        $loggedInUser = $this->Auth->user();
        $courseTypeCategories = $this->CourseTypeCategories->find()->select(['id', 'name'])->where(['CourseTypeCategories.tenant_id' => $loggedInUser['tenant_id']])->all();
            // pr($courseTypeCategories);die;
            
                $this->set('response',$courseTypeCategories);
                $this->set('_serialize', ['response']);
    }
    

    public function cancelandrefundStudent(){
        $this->loadModel("LineItems");
        $this->loadModel('Students');
        $this->loadModel('TenantConfigSettings');
        $this->loadModel('LineItems');
        $this->loadModel('Payments');
        $data = $this->request->getData();
        $stripe = $this->loadComponent('Stripe');
        $loggedInUser = $this->Auth->user();
        // pr($data);die;
        $courseId = $data['course_id'];
        $studentId = $data['student_id'];
        $query = $this->LineItems->find()->where([
                                    'course_id' => $courseId,
                                    'student_id'=> $studentId
                                  ])->toArray();
        // pr($query);die;
        if(!empty($query)){
          $orderId = $query[0]->order_id;
          $totalAmount = (new Collection($query))->sumof('amount');
          $amount = $this->Payments->findByOrderId($orderId)
                                        ->contain(['Transactions' => function($q){
                                            return $q->where(['Transactions.type' => 'charge']);
                                        }])
                                        ->order(['Payments.amount' => 'DESC'])
                                        ->toArray();
            // pr($amount);die;
          $balance = (new Collection($amount))->map(function($value,$key){
            return $test['chargeIds'][] =['charge_id'=>$value->transaction->charge_id,
                                          'available_amount'=>$value->amount,
                                          'transaction_id' => $value->transaction_id
                                            ];
          })->toArray();
        }
        // pr($balance);die;
        $tenantId = $loggedInUser['tenant_id'];
        // $this->loadModel('TenantConfigSettings');
        $configSettings = $this->TenantConfigSettings->find()
                                                   ->where(['tenant_id' => $tenantId])
                                                   ->first();
        $id = $data['course_student_id'];
        if(!$id){
            throw new NotFoundException(__('Course Student Id is missing.'));
        }
        $this->refundTransactions($balance,$data,$configSettings,$stripe,$orderId);
        $this->loadModel('CourseStudents');
        $courseStudent = $this->CourseStudents->findById($id)
                                              ->first();
        $time = Time::now();
        $reqData = [
                        'course_status' => 5,
                        'cancellation_date' => $time,  
                    ];
        if($courseStudent->payment_status == 'Not Paid'){
            $reqData['payment_status'] = 'No Refund';
        }else{
            $reqData['payment_status'] = 'Amount Refund';
        }
        // pr($reqData);die();
        $courseStudent = $this->CourseStudents->patchEntity($courseStudent, $reqData);
         // pr($student);die();
        
        if(!$this->CourseStudents->save($courseStudent)){
            throw new BadRequestException(__('The status could not be updated.'));
        }
        
        $this->set('response',$courseStudent); 
        $this->set('_serialize', ['response']);
        
    }
    public function updateTestScore(){
        $data = $this->request->getData();
        // pr($data);die();
        $Id = $data['course_student_id'];
        $this->loadModel('CourseStudents');
        $courseStudent = $this->CourseStudents->findById($Id)
                                              ->first();
        $courseStudent->id = $Id;
        $courseStudent->test_score = $data['test_score'];
            
        // pr($courseStudent);die(); 
        // $courseStudent = $this->CourseStudents->patchEntity($courseStudent);
        $this->CourseStudents->save($courseStudent);
        // pr($courseStudent);die();
        $this->set('response',$courseStudent); 
        $this->set('_serialize', ['response']);


    }
    public function sendMailToStudent(){
        $data = $this->request->getData();
        // pr($data);die();
        $Id = $data['student_id'];
        $courseId = $data['course_id'];
        $this->loadModel('Students');
        $student = $this->Students->findById($Id)
                                  ->first();
        $mailInfo['first_name'] = $student->first_name;
        $mailInfo['last_name'] = $student->last_name;
        $mailInfo['email'] = $student->email;
        // pr($mailInfo['email']);die();
        $name = $mailInfo['first_name'].' '.$mailInfo['last_name'];
        $email = new Email('default');
        $email->setTo($mailInfo['email'])
              ->setSubject('Hey '.$name.' you have been added to the course with id!'.$courseId)
              ->send('You have been added for the following course.'.$courseId);
        // pr($email);die();
        $this->set('response',$email); 
        $this->set('_serialize', ['response']);
        // pr($student);die();
    }
    public function sendMailToInstructor(){
        $data = $this->request->getData();
        $id = $data['instructor_id'];
        $courseId = $data['course_id'];
        $this->loadModel('Instructors');
        $instructor = $this->Instructors->findById($id)
                                         ->first();   
        $mailInfo['first_name'] = $instructor->first_name;
        $mailInfo['last_name'] = $instructor->last_name;
        $mailInfo['email'] = $instructor->email;   
        $name = $mailInfo['first_name'].' '.$mailInfo['last_name'];
        $email = new Email('default');
        $status = $data['course_instructor_status']; 
        if($status == 1){
        $email->setTo($mailInfo['email'])
              ->setSubject('Hey '.$name.' you have been sent a mail from the course: '.$courseId.'.')
              ->send('Hey '.$name.',you have been accepted for the course :'.$courseId.'.');
        } elseif($status == 2) {
           $email->setTo($mailInfo['email'])
              ->setSubject('Hey '.$name.' you have been sent a mail from the course :'.$courseId.'.')
              ->send('Hey '.$name.',you have been declined for the course :'.$courseId.'.');
        } else {
        $email->setTo($mailInfo['email'])
              ->setSubject('Hey '.$name.' you have been sent a mail from the course: '.$courseId.'.')
              ->send('Your status for the course:'.$courseId.'is pending.Please confirm your status.');
        }
        $this->set('response',$email); 
        $this->set('_serialize', ['response']);                              
    }
    public function updateSkill(){
        $data = $this->request->getData();
        $Id = $data['course_student_id'];
        $this->loadModel('CourseStudents');
        $courseStudent = $this->CourseStudents->findById($Id)->first();
        // pr($courseStudent);die();
        if($data['skill'] == 1){
            $courseStudent->skills = "Passed";
        } elseif($data['skill'] == 2) {
            $courseStudent->skills = "Failed";
        } else {
            $courseStudent->skills = NULL;
        }
        $this->CourseStudents->save($courseStudent);
        $this->set('response',$courseStudent); 
        $this->set('_serialize', ['response']);
        // pr($courseStudent);die();

    }

    public function addAddonForStudent(){
        $data = $this->request->getData();
        if(!isset($data['course_student_id']) && !$data['course_student_id']){
            throw new NotFoundException(__('Course Student Id is missing.'));
        }
        if(!isset($data['student_id']) && !$data['student_id']){
            throw new NotFoundException(__('Student Id is missing.'));
        }
        if(!isset($data['course_id']) && !$data['course_id']){
            throw new NotFoundException(__('Course Id is missing.'));
        }
        $paymentData = $this->request->getSession()->read('paymentData');
        if(!isset($data['addon_ids']) && empty($data['addon_ids'])){
            if(!empty($paymentData) && !empty($paymentData[$data['student_id']]['addon_ids'])){
                
                $addons = $this->Courses->CourseAddons->Addons->find()
                                                          ->where(['id IN' => $paymentData[$data['student_id']]['addon_ids']])
                                                          ->toArray();
                $collection = new Collection($addons);
                $amount = $collection->sumOf(function ($addons) {
                    return $addons->price; 
                });

                $finalAmount = $paymentData[$data['student_id']]['finalAmount'] - $amount; 
                $type = 'remove';

            }else{
                $this->set('response',null); 
                $this->set('_serialize', ['response']);
            }
        }else{
            
            $addons = $this->Courses->CourseAddons->Addons->find()
                                                          ->where(['id IN' => $data['addon_ids']])
                                                          ->toArray();

            if(empty($addons)){
                throw new NotFoundException(__('Addons not found with the given ids.'));
            }
            
            $collection = new Collection($addons);
            $amount = $collection->sumOf(function ($addons) {
                return $addons->price; 
            });

            $courseCost = $this->Courses->find()
                                            ->where(['id' => $data['course_id']])
                                            ->extract('cost')
                                            ->first();
            
            $checkCourseStudent = $this->Courses->CourseStudents->find()
                                                                    ->where(['CourseStudents.id' => $data['course_student_id']])
                                                                    ->first();

            if(!isset($checkCourseStudent) && !$checkCourseStudent){
                throw new NotFoundException(__('Course Students not found with the given id.'));
            }
            if($checkCourseStudent->payment_status == 'Not Paid'){
                $finalAmount = $amount + $courseCost;
                $waitlisted = 'true';
            } else {
                $finalAmount = $amount;
                $waitlisted = 'false';
            }
            $type="add";
            
        }

        $paymentData[$data['student_id']] = [
                                                'student_id' => $data['student_id'],
                                                'finalAmount' => $finalAmount,
                                                'courseId' => $data['course_id'],
                                                'waitlistedStatus' => isset($waitlisted)?($waitlisted):$paymentData[$data['student_id']]['waitlistedStatus'],
                                                'addon_ids' => isset($data['addon_ids'])?$data['addon_ids']:[],
                                                'status'=> $type
                                            ];
        $session = new Session();
        $session->write('paymentData', $paymentData);
        $this->set('response',$paymentData); 
        $this->set('_serialize', ['response','status']);
        
    }


     public function getCourses(){
        // pr('here');die;
        $zipcode = $this->request->getQuery();
        $today = new Date();
        $this->loadModel('Tenants');
        $this->loadModel('Courses');
        $domainType = "http://$_SERVER[HTTP_HOST]";
        $values = parse_url($domainType);
        $host = explode('.',$values['host']);
        // pr($host);
        $tenantData = $this->Tenants->find()->contain('TrainingSites')->where(['domain_type LIKE' => '%'.$host[0].'%'])->first();
        // $tenantData['id'] = 1;
        // pr($tenantData);
        if(isset($zipcode['zipcode']) && !empty($zipcode['zipcode'])){
            $where = ['Courses.tenant_id'=>$tenantData['id'], 'Courses.status NOT IN' => 'draft','Locations.zipcode LIKE' => '%'.$zipcode['zipcode'].'%','Courses.private_course' => 0];
        }else{
            $where = ['Courses.tenant_id'=>$tenantData['id'], 'Courses.status NOT IN' => 'draft','Courses.private_course' => 0];
        }
        $courses = $this->Courses->find()
                                 ->contain(['Locations','CourseDates','CourseTypes'])
                                 ->matching('CourseDates',function($q)use($today){
                                    return $q->where(['course_date >=' => $today]);
                                 })
                                 ->where($where);
                                 // ->groupBy('CourseTypes');
                                 // ->order(['Courses.created' => 'DESC']);
                                 // ->all()
                                 // ->toArray();
        // pr($courses);die;                         
        $this->paginate = [
            'limit' => 750
        ];                         
        $courses = $this->paginate($courses)->toArray();
        // pr($courses);
        $courses = (new Collection($courses))->groupBy('course_type.name')->toArray();
        $domainType = Router::url('/', true);

        // pr($courses);die;
        // pr($courses);die('ss');
        $this->set('response',$courses);
        $this->set('domain',$domainType); 
        $this->set('_serialize', ['response','domain']);
    }
    
    public function bulkStatusUpdate($action, $courseId){
        // pr($this->request->getData());die('ssss');
        // pr($courseId);die;
        $data = $this->request->getData();
        $checkData = explode(",", $data['ids']);
        // pr($checkData);die();
        if(!$action && !isset($action)){
            throw new NotFoundException(__('Something went wrong, Please try again'));
        }
        if(!$courseId && !isset($courseId)){
            throw new NotFoundException(__('Something went wrong, please try again'));
        }
        // pr($checkData); die;
        $this->loadModel('CourseStudents');
        switch($action){
            case 'allpassed':
                $courseStatus = 1;
            break;
            case 'allfailed':
                $courseStatus = 2;
            break;
            case 'allabsent':
                $courseStatus = 3;
            break;
            case 'allincomplete':
                $courseStatus = 4;
            break;    
                     }    
        $reqData = [];                                                    
        foreach($checkData as $key => $value)
        {
            // pr($value);
            $reqData[]=[
            'id'=>$value,
            'course_id'=>$courseId,
            'course_status'=>$courseStatus
            ];
        }
        // pr($reqData);die();
        $courseStudents = $this->CourseStudents->newEntities($reqData);
        // pr($courseStudents);
        $courseStudents = $this->CourseStudents->patchEntities($courseStudents, $reqData);
        // pr($courseStudents);die();
        if(!$this->CourseStudents->saveMany($courseStudents)){
            
            pr('The Status could not be updated. Please try again');
            // pr($courseStudents);
        }
        // $this->set('course_id',$course_id);   
        $this->set('response',$reqData); 
        $this->set('_serialize', ['response']);                                       
    }
    public function refundTransactions($balance,$data,$configSettings,$stripe,$orderId){
        // pr($balance);pr($data);die;
        $tenantId = $this->Auth->user('tenant_id');
        $this->loadModel('Transactions');
        $this->loadModel('Payments');
         $stripe = $this->loadComponent('Stripe');
         $refundAmount = $data['refund_amount'];
        foreach ($balance as $key => $value) {
            if($refundAmount > $value['available_amount'] && $value['available_amount'] !=0 ){
                $refundAmount = $value['available_amount'] - $refundAmount;
                if($configSettings->payment_mode == "stripe"){
                        $charge_id = $value['charge_id'];
                        if($configSettings->sandbox == 1){
                            // pr('test');die;
                            $coursePayment = $stripe->refundAmount($value['available_amount'],$charge_id,$configSettings->stripe_test_private_key);
                        }
                        if($configSettings->sandbox == 0){
                            $coursePayment = $stripe->refundAmount($value['available_amount'],$charge_id,$configSettings->stripe_live_private_key);
                        }
                     // pr($coursePayment);pr($refundAmount);die; 
                        if($coursePayment){
                            // $this->Transactions->query()->update()->set(['available_amount' => 0])->where(['charge_id' => $value['charge_id']])->execute();
                            $this->Payments->getQuery()->update()->set(['amount' => 0])->where(['student_id' => $data['student_id'],'transaction_id'=>$value['transaction_id']])->execute();
                            $paymentData = [
                                'student_id' => $data['student_id'],
                                'tenant_id' => $tenantId,
                                'payment_status' => 'refund',
                                'order_id' => $orderId,
                                'amount' => -$value['available_amount'],
                                'transaction' => [
                                                      // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                      'charge_id' => $coursePayment['data']['id'],
                                                      'payment_method' => $configSettings->payment_mode,
                                                      'amount' => -$value['available_amount'],
                                                      'available_amount' => 0,
                                                      'remark' => 'Refund for Course',
                                                      'status'=> 1,
                                                      'type'=> 'refund',
                                                      'parent_id' => $value['charge_id']
                                                    ]
                            ];
                            $payment = $this->Payments->newEntity();
                            $payment = $this->Payments->patchEntity($payment, $paymentData);
                            // pr($payment);die;
                            if (!$this->Payments->save($payment)) {
                                throw new BadRequestException(__('The status could not be updated.'));
                            }
                        }
                            $refundAmount = abs($refundAmount);
                  }
            }else{
               if($configSettings->payment_mode == "stripe"){
                    $charge_id = $value['charge_id'];
                    if($configSettings->sandbox == 1){
                        $coursePayment = $stripe->refundAmount($refundAmount,$charge_id,$configSettings->stripe_test_private_key);
                    }
                    if($configSettings->sandbox == 0){
                     $coursePayment = $stripe->refundAmount($refundAmount,$charge_id,$configSettings->stripe_live_private_key);   
                    }
                    if($coursePayment){
                            // $this->Transactions->query()->update()->set(['available_amount' => $value['available_amount'] - $refundAmount])->where(['charge_id' => $value['charge_id']])->execute();
                             $this->Payments->getQuery()->update()->set(['amount' => $value['available_amount'] - $refundAmount])->where(['student_id' => $data['student_id'],'transaction_id'=>$value['transaction_id']])->execute();
                            $paymentData = [
                                'student_id' => $data['student_id'],
                                'tenant_id' => $tenantId,
                                'payment_status' => 'refund',
                                'order_id' => $orderId,
                                'amount' => -$refundAmount,
                                'transaction' => [
                                                      // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                      'charge_id' => $coursePayment['data']['id'],
                                                      'payment_method' => $configSettings->payment_mode,
                                                      'amount' => -$refundAmount,
                                                      'available_amount' => $refundAmount,
                                                      'remark' => 'Refund for Course',
                                                      'status'=> 1,
                                                      'type'=> 'refund',
                                                      'parent_id' => $value['charge_id']
                                                    ]
                            ];
                            $payment = $this->Payments->newEntity();
                            $payment = $this->Payments->patchEntity($payment, $paymentData);
                            // pr($payment);die;
                            if (!$this->Payments->save($payment)) {
                                throw new BadRequestException(__('The status could not be updated.'));
                            }
                                return $payment;
                        }
              } 
            }    
        }
        // die('here');
    }
    public function index($type = null){
     $loggedInUser = $this->Auth->user();
        $this->loadModel('Instructors');
        $url = Router::url('/', true);
        $url = $url.'courses/';
        $indexName = Configure::read('Courses');
        $queryString = $this->request->getQuery();
        $today = new Date();
        $courseData = (new Collection($queryString['columns']))->combine('name','search')->toArray();
        $generic = false;
        if(isset($queryString['search']) && $queryString['search'] && $queryString['search']['value']){
            $generic = true;
        }
        // $searchFields = [];
        $columnInfo = $this->searchFilter();
        $today = new Date();
        $requestData = $this->request->getQuery('request');
        // pr($requestData);die;
        $courseDates = $this->Courses->CourseDates
                                     ->find()
                               //     ->contain(['Courses'])
                                     ->groupBy('course_id')
                                     ->map(function($value, $key){
                                        return (new Collection($value))->sortBy('course_date')->first();
                                     })
                                     ->groupBy(function($value) use($today){
                                        return $value->course_date >= $today ? "future" : 'past';
                                     })
                                     ->map(function($value){

                                        return (new Collection($value))->extract('course_id')->toArray();
                                     })
                                     ->toArray();
        // pr($courseDates);die('here');
        $roleInfo = $this->roleData($loggedInUser['role']->name,$requestData,$loggedInUser,$courseDates);
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
            $roleInfo = $this->roleData('TRAINING SITE OWNER',$requestData,$loggedInUser,$courseDates);

        }
        $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        $locations = $this->Courses->Locations->find()->indexBy('id')->toArray();
        $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        $corporateClients = $this->Courses->CorporateClients->find()->indexBy('id')->toArray();
        $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        $instructors = $this->Instructors->find('withTrashed')->indexBy('id')->toArray();
        // pr($instructors);
        if($requestData == 'draft'){
                $where = $roleInfo['draft'];
                $contain =  $roleInfo['contain'];
            }
            if($requestData == 'past-courses'){
                $where = $roleInfo['past-courses'];
                 $contain =  $roleInfo['contain'];
                if(!empty($courseDates['past'])){
                    $where['Courses.id IN'] = $courseDates['past'];
                }
            }
            if($requestData == 'future-courses'){
                $where = $roleInfo['future-courses'];
                 $contain =  $roleInfo['contain'];
                if(!empty($courseDates['future'])){
                    $where['Courses.id IN'] = $courseDates['future'];
                }
                // pr($where);die;
            }
            if($requestData == null){
                $where = $roleInfo['other'];
                $contain =  $roleInfo['contain'];
            }
        if($type == 'myCourses'){
            $where1 = ['added_by' => 'tenant','owner_id' => $loggedInUser['id']];
            $where = array_merge($where,$where1);
        }
        // pr($where);die;
        $courses = $this->Courses->find()
                             ->contain($contain);
                             // ->where($where);
                             // ->andWhere(['agency_id' => $agencyId])
                             // ->matching('Agencies', function($q){
                             //    return $q->where(['Agencies.id Like'=> "test" ]);
                             // })
                             // ->order(['Courses.created' => 'DESC']);
        // pr($courses);die;
        
        foreach ($columnInfo as $key => $value) { 
            if(!((isset($courseData[$value['name_key']]) && $courseData[$value['name_key']]['value'])
               || $generic)){
                continue;
            }
                // pr('test');die;
                if($generic){
                    $searchValue = $queryString['search']['value'];
                    if(!((isset($queryString) && $queryString))){
                        continue;
                    }
                    if($value['genericMatching']){
                        $where['OR'][] = [$value['genericMatching']['where'] => '%'.$searchValue.'%'];
                    }
                }
                if($value['matching'] && $courseData[$value['name_key']]['value']){
                    $searchValue = $courseData[$value['name_key']]['value'];
                    $where['AND'][] = [$value['matching']['where'] => $searchValue];
                }

                // if($value['matching']){
                //     pr('test');
                //     $courses->matching($value['matching']['table_name'],function($q)use($searchValue,$value){
                //         pr('test');die('here');
                //         // return $q->where([$value['matching']['where'] => $searchValue]);
                //     });
                // }
                // if($value['where']){
                //   $courses->where([$value['where'] => $searchValue]); 
                // }
        }
        if(((isset($queryString) && $queryString))){
            if($value['genericMatching']['table_name'] == 'Courses'){
                    $courses->where($where,['Courses.id' => 'string']);
                }else{
                    $courses->where($where);
                }
        }
        // pr($courses);die;
        $courseSorting = $this->courseSorting($indexName[$queryString['order'][0]['column']],$queryString['order'][0]['dir']);
        $this->paginate = [
            // 'limit' => 500,
            'limit' => $queryString['length'],
            'page' =>  ($queryString['start']/$queryString['length'])+1,
            'order' => $courseSorting,
            'sortWhitelist' => [
                'Courses.id',
                'Agencies.name',
                'Locations.city',
                'Locations.name',
                'Locations.state',
                'CourseTypes.name',
                'Instructors.name',
                'TrainingSites.name',
                'CorporateClients.name',
                'CourseDates.course_date',
                'Courses.status',
                'Courses.seats'
            ]
        ];
        $reqData = [];
        $courseCount = $courses->count();
        $totalPages =  $courseCount/$queryString['length'];
        // pr($courses);die;
        $courses =  $this->paginate($courses);   
        // pr($courses);die;
        $reqData = (new Collection($courses->toArray()))->map(function($value, $key) use($tenants, $locations, $trainingSites, $corporateClients, $agencies, $instructors,$requestData,$loggedInUser,$url){
        $courseDates = '';
        $instructorData = '';        
        $firstRow = '';
        // pr($url);die;
        if(isset($value->course_dates) && !empty($value->course_dates)){
            foreach ($value->course_dates as $val) { 
               $date = new Date($val->course_date);
                $timeTo = new Time($val->time_to);
                $timeFrom = new Time($val->time_from);
                $courseDates = $date->format('Y-m-d').' AND '.$timeFrom->format('h:i').'-'.$timeTo->format('h:i');
            }
        }
        if($requestData == 'draft'){
            $firstRow =  "<span class='label  label-xl label-success'>".$value->id."</span>";
            if($loggedInUser['role']->name!='instructor'){
                $firstRow = $firstRow.' '."<a href=".$url."edit/".$value->id." class='btn btn-xs btn-warning'><i class='fa fa-pencil fa-fw'></i></a>";
            }
        }else{
            $firstRow =  "<a href=".$url."view/".$value->id." class='btn btn-xs btn-success'>".$value->id."</a>";
            if($loggedInUser['role']->name!='instructor'){
                $firstRow = $firstRow.' '."<a href=".$url."edit/".$value->id." class='btn btn-xs btn-warning'><i class='fa fa-pencil fa-fw'></i></a>";
            }
        }
        $firstRowTwo = "<a href=".$url."delete/".$value->id." class='btn btn-sm btn-danger fa fa-trash-o fa-fh'</a>";
        $firstRow = $firstRow.' '.$firstRowTwo;
        $instructorData = '';
         if(isset($value->course_instructors) && !empty($value->course_instructors) ){
            // pr($value);die;
            foreach ($value->course_instructors as $getInstructor) {
        // --------------condition to check pending instructors---------------
                if(empty($getInstructor->instructor_id) || is_null($getInstructor->instructor_id)){
                    $instructorData = $instructorData."<p><a class='badge badge-danger' data-toggle='tooltip' data-placement='top' title='Click here to complete instructor assignment process' data-original-title='Tooltip on top' href=".$url."edit/".$getInstructor->course_id.">Intructor Pending</a></p>";
                } else {
        // -------------------------------------------------------------------
                if(isset($getInstructor->instructor_id) && !empty($getInstructor->instructor_id)){
                    if($getInstructor->status == 1){
                        $instructorData = $instructorData."<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                            .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                            "</a><span class='badge badge-primary'>".
                            "Accepted On: ".$getInstructor->modified."</span></p>";
                    }elseif($getInstructor->status == 2){
                        // pr($getInstructor);
                         $instructorData = $instructorData."<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                            .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                            "</a><span class='badge badge-danger'>".
                            "Declined On: ".$getInstructor->modified."</span></p>";
                    }elseif($getInstructor->status == null){
                        $instructorData = $instructorData."<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                            .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                            "</a><span class='badge badge-warning'>Intructor Pending</span></p>";
                        }
                    }
                }
            }
         }
            $data = [
                            $firstRow,
                            $value->seats, 
                            $agencies[$value->course_type->agency_id]->name,
                            $value->course_type->name,
                            (isset($value->corporate_client_id) && $value->corporate_client_id)?$corporateClients[$value->corporate_client_id]->name:'-',
                            (isset($value->training_site_id) && $value->training_site_id)?$trainingSites[$value->training_site_id]->name:"-",
                            $courseDates,
                            $value->status,
                            (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->name:'-',
                            (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->city:'-',
                            (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->state:'-',
                            $instructorData


                        ]; 
       return $data ;             
    })->toArray();
    $response = [
                    'draw' => $queryString['draw'],
                    'recordsTotal' => $courseCount,
                    'recordsFiltered' => $courseCount,
                    'data' => $reqData
                ];
    $this->set('response',$response);
    $this->set('_serialize',['response']);
    }
    public function roleData($role,$requestData,$loggedInUser,$courseDates){
        $roleInfo = [
                        'tenant' => [
                                        'draft' =>isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id'],'Courses.status' => 'draft','Courses.training_site_id IS NOT Null','CourseTypes.agency_id' => 1]:null,
                                        'past-courses' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id' =>$loggedInUser['tenant_id'],'Courses.status NOT IN' => 'draft','Courses.training_site_id IS NOT Null','CourseTypes.agency_id' => 1]:null,
                                        'courseDatespast' => isset($courseDates['past'])?['Courses.id IN' => $courseDates['past']]:null,
                                        'future-courses' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft','Courses.training_site_id IS NOT Null','CourseTypes.agency_id' => 1]:null,
                                        'courseDatesfuture' => isset($courseDates['future'])?['Courses.id IN' => $courseDates['future']]:null,
                                        'other' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id']]:null,
                                        'contain' => [ 'CourseTypes.Agencies', 'CourseInstructors.Instructors','CourseDates','TrainingSites','Locations','CorporateClients']
                                    ],
                        'instructor' => [
                                            'draft' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status' => 'draft']:null,
                                            'past-courses' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id' =>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft']:null,
                                            'courseDatespast' => isset($courseDates['past'])?['Courses.id IN' => $courseDates['past']]:null,
                                            'future-courses' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft']:null,
                                            'courseDatesfuture' => isset($courseDates['future'])?['Courses.id IN' => $courseDates['future']]:null,
                                            'other' => isset($loggedInUser['tenant_id'])?['Courses.tenant_id'=>$loggedInUser['tenant_id']]:null,
                                            'contain' => ['CourseTypes.Agencies', 'CourseInstructors.Instructors','TrainingSites','Locations','CorporateClients','CourseDates']
                                        ],
                        'corporate_client' => [
                                                'draft' => isset($loggedInUser['corporate_client_id'])?['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status' => 'draft']:null,
                                                'past-courses' => isset($loggedInUser['corporate_client_id'])?['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status NOT IN' => 'draft']:null,
                                                'courseDatespast' => isset($courseDates['past'])?['Courses.id IN' => $courseDates['past']]:null,
                                                'future-courses' => isset($loggedInUser['corporate_client_id'])?['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status NOT IN' => 'draft']:null,
                                                'courseDatesfuture' => isset($courseDates['future'])?['Courses.id IN' => $courseDates['future']]:null,
                                                'other' => isset($loggedInUser['corporate_client_id'])?['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id']]:null,
                                                'contain' => [ 'CourseTypes', 'CourseInstructors.Instructors','TrainingSites','Locations','CorporateClients','CourseDates'] 
                                               ],
                        'TRAINING SITE OWNER' => [
                                                    'draft' => isset($loggedInUser['training_site_id'])?['Courses.training_site_id'=>$loggedInUser['training_site_id'], 'Courses.status' => 'draft']:null,
                                                    'past-courses' => isset($loggedInUser['training_site_id'])?['Courses.training_site_id' =>$loggedInUser['training_site_id'], 'Courses.status NOT IN' => 'draft']:null,
                                                    'courseDatespast' => isset($courseDates['past'])?['Courses.id IN' => $courseDates['past']]:null,
                                                    'future-courses' => isset($loggedInUser['training_site_id'])?['Courses.training_site_id'=>$loggedInUser['training_site_id'], 'Courses.status NOT IN' => 'draft']:null,
                                                    'courseDatesfuture' => isset($courseDates['future'])?['Courses.id IN' => $courseDates['future']]:null,
                                                    'other' => isset($loggedInUser['training_site_id'])?['Courses.training_site_id'=>$loggedInUser['training_site_id']]:null,
                                                    'contain' => ['CourseTypes', 'CourseInstructors.Instructors','TrainingSites','Locations','CorporateClients','CourseDates']   
                                                 ]                                                    
                    ];
                    // pr($roleInfo[$role]);die;
                    return $roleInfo[$role];
    }
    public function searchFilter(){
        $columnInfo = [
                            [
                                'name_key' => 'agency',
                                'where'  => false ,
                                'matching' => [ 'table_name' => 'CourseTypes.Agencies',
                                                'where' => 'Agencies.name REGEXP'
                                              ],
                                'genericMatching' => [
                                                        'table_name' => 'CourseTypes.Agencies',
                                                        'where' => 'Agencies.name Like'
                                                    ]              
                            ],
                            [
                                'name_key' => 'course_type',
                                'where'  => false ,
                                'matching' => ['table_name' => 'CourseTypes',
                                               'where' => 'CourseTypes.name REGEXP'
                                              ],
                                'genericMatching' => [
                                                        'table_name' => 'CourseTypes',
                                                        'where' => 'CourseTypes.name Like'
                                                    ]              
                            ],
                            [
                                'name_key' => 'corporate_client',
                                'where'  => false ,
                                'matching' => ['table_name' => 'CorporateClients',
                                               'where' => 'CorporateClients.name REGEXP'
                                              ],
                                'genericMatching' => [
                                                        'table_name' => 'CorporateClients',
                                                        'where' => 'CorporateClients.name Like'
                                                    ]           
                            ],
                            [
                                'name_key' => 'training_site',
                                'where'  => false ,
                                'matching' => ['table_name' => 'TrainingSites',
                                               'where' => 'TrainingSites.name REGEXP'
                                              ],
                                'genericMatching' => [
                                                'table_name' => 'TrainingSites',
                                                'where' => 'TrainingSites.name Like'
                                              ]              
                            ],
                            [
                                'name_key' => 'status',
                                'where'  => 'Courses.status REGEXP',
                                'matching' => false,
                                'genericMatching' => false 
                            ],
                            [
                                'name_key' => 'location',
                                'where'  => false ,
                                'matching' => ['table_name' => 'Locations',
                                               'where' => 'Locations.name REGEXP '
                                              ],
                                'genericMatching' => [
                                                'table_name' => 'Locations',
                                                'where' => 'Locations.name Like'
                                              ]              
                            ],
                            [
                                'name_key' => 'city',
                                'where'  => false ,
                                'matching' => ['table_name' => 'Locations',
                                               'where' => 'Locations.city REGEXP '
                                              ],
                                'genericMatching' => [
                                                'table_name' => 'Locations',
                                                'where' => 'Locations.city Like'
                                              ]              
                            ],
                            [
                                'name_key' => 'state',
                                'where'  => false ,
                                'matching' => ['table_name' => 'Locations',
                                               'where' => 'Locations.state REGEXP '
                                              ],
                                'genericMatching' => [
                                                'table_name' => 'Locations',
                                                'where' => 'Locations.state Like'
                                              ],
                            ],
                            [
                                'name_key' => 'course_id',
                                'where'  => false ,
                                'matching' => ['table_name' => 'Courses',
                                               'where' => 'Courses.id REGEXP '
                                              ],
                                'genericMatching' => [
                                                'table_name' => 'Courses',
                                                'where' => 'Courses.id Like'
                                              ]                                
                            ],
                      ];
         return $columnInfo;             
    }

    public function assignTenantToCourse(){

        $loggedInUser = $this->Auth->user();
        $this->loadModel('TransferCourses');
        $data = $this->request->getData();
        // pr($data);die;
        $existingData = $this->TransferCourses->findByAssignee_uuid($data['assignee_uuid'])
                                              ->where(['course_id' => $data['course_id']])
                                              ->first();
                                              // pr($existingData);die;
        if(!isset($existingData) && empty($existingData)){

            // pr($data);die('here');
            $transferCourse = $this->TransferCourses->newEntity();
            // pr($transferCourse);die;

            $data['assigning_tenant_id'] = $loggedInUser['tenant_id'];

            $this->loadModel('Tenants');
            $data['tenant_id'] = $this->Tenants->findByUuid($data['assignee_uuid'])
                                               ->first()
                                               ->id;
                                    // pr($data);die;
            $transferCourse = $this->TransferCourses->patchEntity($transferCourse, $data);

            if($this->TransferCourses->save($transferCourse)){
                $this->set('response',$transferCourse);
                $this->set('_serialize', ['response']);
                $this->mailTenant($transferCourse);

            }
            // pr($transferCourse); die;
        }else{
            // pr('here');die;
            $reason = 'This course has already been shared with the requested tenant. Resending the mail.';
            $status = 0;

            $this->mailTenant($existingData);
            $this->set('status',$status);
            $this->set('reason',$reason);
            $this->set('_serialize', ['status','reason']);
            // return;
        }
        // pr($transferCourse);die;
    }

    public function mailDataFetch(){
        $this->loadModel('TransferCourses');
        $data = $this->request->getData();
        // pr($data);die;
        $mailData = $this->TransferCourses->find()
                                              ->where(['course_id' => $data['course_id'] , 'tenant_id' => $data['tenant_id']])
                                              ->first();
        // pr($mailData);die;
        if(isset($mailData) && !empty($mailData)){
            $this->mailTenant($mailData);
            $this->set('response',$mailData);
            $this->set('_serialize', ['response']);
        }


    }

    public function verifyTenantUuid($uuid=null){
        $uuid = $this->request->getData();
        $loggedInUser = $this->Auth->user();
        if(empty($uuid) && !isset($uuid)){
            // pr('hi');
            $status = 0;
            $reason = 'No Unique ID Entered';
            $this->set('status',$status);
            $this->set('reason',$reason);
            $this->set('_serialize', ['status','reason']);
            return;
        }else{
        // pr($uuid);die;
            $this->loadModel('Tenants');
            $tenant = $this->Tenants->findByUuid($uuid['uuid'])
                                    ->first();
                                    // pr($tenant);die;
            if(isset($tenant) && !empty($tenant) ){
                if($tenant->id == $loggedInUser['tenant_id']){
                    $status = 0;
                    $reason = 'Unique ID belongs to yourself. Cannot share course!';
                    $this->set('status',$status);
                    $this->set('reason',$reason);
                    $this->set('_serialize', ['status','reason']);

                }else{

                $this->set('response',$tenant);
                $this->set('_serialize', ['response']);
                }

            }else{
                // pr('here');die;
                $status = 0;
                $reason = 'Incorrect Unique ID! Please check and try again.';
                $this->set('status',$status);
                $this->set('reason',$reason);
                $this->set('_serialize', ['status','reason']);
            }


        }
    }

    public function mailTenant($transferCourse){
        // pr($transferCourse);die('iii');

        $this->loadModel('Tenants');
        $this->loadModel('Courses');
        $course = $this->Courses->findById($transferCourse['course_id'])
                                ->contain(['CourseTypes'])
                                ->first();
        $tenant = $this->Tenants->findById($transferCourse['tenant_id'])
                                ->first();
        $assignerTenant = $this->Tenants->findById($transferCourse['assigning_tenant_id'])
                                ->first();
        
        $url = explode("/", $tenant->domain_type);
        // $url = explode("/", 'http://vmc.classbyte.twinspark.co/tenants/login');
        $href1 = $url[2].'/tenants/tenantCourseReply/'.$transferCourse['course_id'].'/'.$tenant->uuid.'/accepted';
        $href2 = $url[2].'/tenants/tenantCourseReply/'.$transferCourse->course_id.'/'.$tenant->uuid.'/declined';


        $emailData1 = [
          "center_name" => $tenant->center_name,
          'email' => $tenant->email,
          'assigner_center_name' => $assignerTenant->center_name,
          'course_name' => $course->course_type->name,
          'course_id' => $course->id,
          'accept_link' => $href1,
          'decline_link' => $href2,
          
        ];
        // pr($emailData1);die;
        
        // pr($tenant->domain_type);die;

        // pr($test);die;
        // pr($href1);die;

        // pr($mailInfo['email']);die();
        // $name = $mailInfo['first_name'].' '.$mailInfo['last_name'];
        if(isset($emailData1)){

        $event = new Event('share_course', $this, [
             'hashData' => $emailData1,
             'tenant_id' => $assignerTenant->id
        ]);
        $this->getEventManager()->dispatch($event);

        // $email = new Email('default');
        // $email->to($mailInfo['email'])
        //       ->subject($assignerTenant->center_name.' shared a course with you!')
        //       ->send($assignerTenant->center_name.' is trying to share a course with you with course ID: 
        //         '.$transferCourse->course_id.'. if you want to accept this course, click here : '.$href1.  '   or to decline click here : '.$href2);
        // // pr($email);die();
              // $status = 1;

        $this->set('response',$event); 
        $this->set('_serialize', ['response']);
        }


    }

    public function courseSorting($columnName,$order){
        $courseSorting = [
                            'course_id' => ['Courses.id' => $order],
                            'no_of_students' => ['Courses.seats' => $order], 
                            'agency' => ['Agencies.name' => $order ],
                            'course_type' => ['CourseTypes.name' => $order],
                            'corporate_client' => ['CorporateClients.name' => $order],
                            'training_site' => ['TrainingSites.name' => $order ],
                            'date' => ['Course.created' => $order ],
                            'status' => ['Courses.status' => $order ],
                            'location' =>  ['Locations.name' => $order ],
                            'city' => ['Locations.city' => $order ],
                            'state' => ['Locations.state' => $order ],
                            'instructor_status' => ['Instructors.name' => $order ],
                        ];
         return $courseSorting[$columnName];               
    }
    
    public function sharedCourses(){
        $this->loadModel('TransferCourses');
        $this->loadModel('Instructors');
        $url = Router::url('/', true);
        $url = $url.'courses/';
        $loggedInUser = $this->Auth->user();
        $queryString = $this->request->getQuery();
         $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        $locations = $this->Courses->Locations->find()->indexBy('id')->toArray();
        $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        $corporateClients = $this->Courses->CorporateClients->find()->indexBy('id')->toArray();
        $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        $instructors = $this->Instructors->find('withTrashed')->indexBy('id')->toArray();
        $courseId = $this->TransferCourses->findByTenant_id($loggedInUser['tenant_id'])
                                          ->where(['status' => 1])
                                          ->extract('course_id')
                                          ->toArray();
                                          // ->course_id;
                                          // pr($courseId);die;
        if(!empty($courseId)){
            // pr('here');die;

    

            $sharedCourses = $this->Courses->find()
                                           ->contain(['CourseTypes','TransferCourses'=> function($q) {
                                            return $q->where(['access_revoked'=>0]);
                                           }])
                                           ->where(['Courses.id IN' => $courseId]); 
                                           // ->toArray();

                                           // pr($sharedCourses);die;
                $courseCount = $sharedCourses->count();
                $totalPages =  $courseCount/$queryString['length'];

                $reqData = [];
                $courses =  $this->paginate($sharedCourses);
                $reqData = (new Collection($courses->toArray()))->map(function($value, $key) use($tenants, $locations, $trainingSites, $corporateClients, $agencies, $instructors,$loggedInUser,$url){
                $courseDates = '';
                $instructorData = '';        
                $firstRow = '';
                if(isset($value->course_dates) && !empty($value->course_dates)){ 
                    foreach ($value->course_dates as $val) { 
                       $date = new Date($val->course_date);
                        $timeTo = new Time($val->time_to);
                        $timeFrom = new Time($val->time_from);
                        $courseDates = $date->format('Y-m-d').' AND '.$timeTo->format('h:i').'-'.$timeFrom->format('h:i');
                    }
                }
                // pr($url);die;
                $firstRow =  "<a href=".$url."view/".$value->id." class='btn btn-xs btn-success'>".$value->id."</a>";
                if($loggedInUser['role']->name!='instructor'){
                    $firstRow =  "<a href=".$url."view/".$value->id." class='btn btn-xs btn-success'>".$value->id."</a><a href=".$url."edit/".$value->id." class='btn btn-xs btn-warning'><i class='fa fa-pencil fa-fw'></i></a>";
                }
                
                $firstRowTwo = "<a href=".$url."delete/".$value->id." class='btn btn-sm btn-danger fa fa-trash-o fa-fh'</a>";
                $firstRow = $firstRow.' '.$firstRowTwo;
                // pr($firstRowTwo);die;
                 if(isset($value->course_instructors) && !empty($value->course_instructors) ){
                    // pr($value->course_instructors);pr('TEST');die('here');
                    foreach ($value->course_instructors as $getInstructor) {
                        if(isset($getInstructor->instructor_id) && !empty($getInstructor->instructor_id)){
                            if($getInstructor->status == 1){
                                $instructorData = "<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                                    .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                                    "</a><span class='badge badge-primary'>".
                                    "Accepted On: ".$getInstructor->modified."</span></p>";
                            }elseif($getInstructor->status == 2){
                                // pr($getInstructor);
                                 $instructorData = "<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                                    .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                                    "</a><span class='badge badge-danger'>".
                                    "Declined On: ".$getInstructor->modified."</span></p>";
                            }elseif($getInstructor->status == null){
                                $instructorData = "<p><a class='btn btn-xs btn-white' data-toggle='tooltip' data-placement='top' title='Click to send mail to the instructor' data-original-title='Tooltip on top' onclick=sendMailToInstructor(".$value->id.','. 1 .','.$getInstructor->instructor_id.")>"
                                    .$instructors[$getInstructor->instructor_id]->first_name." ".$instructors[$getInstructor->instructor_id]->last_name.
                                    "</a><span class='badge badge-warning'>Intructor Pending</span></p>";
                            }
                        }
                    }
                 }
                    $data = [
                                    $firstRow,
                                    $value->seats, 
                                    $agencies[$value->course_type->agency_id]->name,
                                    $value->course_type->name,
                                    (isset($value->corporate_client_id) && $value->corporate_client_id)?$corporateClients[$value->corporate_client_id]->name:'-',
                                    (isset($value->training_site_id) && $value->training_site_id)?$trainingSites[$value->training_site_id]->name:"-",
                                    $courseDates,
                                    $value->status,
                                    (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->name:'-',
                                    (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->city:'-',
                                    (isset($value->location_id) && $value->location_id)?$locations[$value->location_id]->state:'-',
                                    $instructorData


                                ];  
               return $data ;             
            })->toArray();
                 $response = [
                            'draw' => $queryString['draw'],
                            'recordsTotal' => $courseCount,
                            'recordsFiltered' => $courseCount,
                            'data' => $reqData
                        ];                           
            }else{
            $response = [
                            'draw' => $queryString['draw'],
                            'recordsTotal' => 0,
                            'recordsFiltered' => 0,
                            'data' => []
                        ];                             
        }
                $this->set('response',$response);
                $this->set('_serialize', ['response']);
    }
    public function reopenCourses(){
       $loggedInUser = $this->Auth->user();
        $this->loadModel('Instructors');
        $url = Router::url('/', true);
        $url = $url.'courses/';
        $indexName = Configure::read('ReopenCourses');
        $queryString = $this->request->getQuery();
        $columnInfo = $this->searchFilter();
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
            $roleInfo = $this->roleData('TRAINING SITE OWNER',$requestData,$loggedInUser,$courseDates);
        }
        $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        $courses = $this->Courses->find()
                             ->contain(['TrainingSites','CourseTypes','CourseTypes.Agencies'])
                             ->where(['Courses.status' => 'closed','Courses.tenant_id' => $loggedInUser['tenant_id']]);
                             // ->andWhere(['agency_id' => $agencyId])
                             // ->matching('Agencies', function($q){
                             //    return $q->where(['Agencies.id Like'=> "test" ]);
                             // })
                             // ->order(['Courses.created' => 'DESC']);

        $courseCount = $courses->count();
        $totalPages =  $courseCount/$queryString['length'];
        foreach ($columnInfo as $key => $value) { 
            if(!((isset($queryString['search']) && $queryString['search']['value']))){
                continue;
            }
            $searchValue = (string)$queryString['search']['value'];
            // pr($searchValue);die;
            if($value['genericMatching']['table_name'] == 'CourseTypes.Agencies' || $value['genericMatching']['table_name'] == 'CourseTypes' || $value['genericMatching']['table_name'] == 'TrainingSites' || $value['genericMatching']['table_name'] === 'Courses'){
                $where['OR'][] = [$value['genericMatching']['where'] => '%'.$searchValue.'%'];
            }
            // if($value['genericMatching']){
            // }
        }
        if(((isset($queryString['search']) && $queryString['search']['value']))){
            if($value['genericMatching']['table_name'] == 'Courses'){
                    $courses->where($where,['Courses.id' => 'string']);
                }else{
                    $courses->InnerJoinWith($value['genericMatching']['table_name'])
                            ->where($where);
                }
            }
        $courseSorting = $this->courseSorting($indexName[$queryString['order'][0]['column']],$queryString['order'][0]['dir']);
        $this->paginate = [
            'limit' => $queryString['length'],
            'page' =>  ($queryString['start']/$queryString['length'])+1,
            'order' => $courseSorting,
            'sortWhitelist' => [
                'Courses.id',
                'Agencies.name',
                'CourseTypes.name',
                'TrainingSites.name',
            ]
        ];
        $reqData = [];
        $courses =  $this->paginate($courses);   
        // pr($courses);die;
        $reqData = (new Collection($courses->toArray()))->map(function($value, $key) use($tenants,$trainingSites, $agencies,$loggedInUser){
            $data = [
                            $value->id, 
                            (isset($value->training_site_id) && $value->training_site_id)?$trainingSites[$value->training_site_id]->name:"-",
                            $agencies[$value->course_type->agency_id]->name,
                            $value->course_type->name,
                        ];  
       return $data ;             
    })->toArray();
    $response = [
                    'draw' => $queryString['draw'],
                    'recordsTotal' => $courseCount,
                    'recordsFiltered' => $courseCount,
                    'data' => $reqData
                ];
    $this->set('response',$response);
    $this->set('_serialize',['response']);
    }
}
