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
use Cake\I18n\Date;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Collection\Collection;
use Cake\Routing\Router;
use Cake\Database\Expression\QueryExpression;
use Cake\Http\Session;
use Cake\I18n\FrozenTime;
use Cake\Event\Event;
/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class StudentsController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Auth->allow(['updatePassword','classes','promocode','clearSession','addAddonToSession','removeAddonToSession','verifyStudentInfo','promocode1','removePromocode','login','getStatus']);
    }
     public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['login','updatePassword','classes','verifyStudentInfo','removePromocode','promocode1','promocode','addAddonToSession','removeAddonToSession','SaveToken','getStudentActions','roleData','index','getStatus']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['login','updatePassword','classes','verifyStudentInfo','removePromocode','promocode1','promocode','addAddonToSession','removeAddonToSession','SaveToken','getStudentActions','roleData','index','getStatus']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['login','updatePassword','classes','verifyStudentInfo','removePromocode','promocode1','promocode','addAddonToSession','removeAddonToSession','SaveToken','getStudentActions','roleData','index','getStatus']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['login','updatePassword','classes','verifyStudentInfo','removePromocode','promocode1','promocode','addAddonToSession','removeAddonToSession','SaveToken','getStudentActions','roleData','index','getStatus']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['login','updatePassword','classes','verifyStudentInfo','removePromocode','promocode1','promocode','addAddonToSession','removeAddonToSession','SaveToken','getStudentActions','roleData','index','getStatus']) && $user['role']->name === self::STUDENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

      public function login(){
          // $this->viewBuilder()->setLayout('student-login');
          $this->loadModel('Tenants');
          $this->loadModel('Roles');
          $this->loadModel('Students');
          $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          $tenantData = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
          if(isset($tenantData) && !empty($tenantData)){
              $this->set(compact('tenantData'));
          }else{
            $this->viewBuilder()->setTemplate('not-found');  
          }
          if ($this->request->is('post')) {
              $user = $this->Auth->identify();
              $this->Cookie->write('loginAction');
               $message = 'Login Successful!';
              if ($user && ($user['tenant_id'] == $tenantData['id'])) {
                  $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
                     
                  $tenantDisabled = $this->Tenants->findById($user['tenant_id'])->first();
                  if($tenantDisabled->status != 1) {
                    $message = 'Your Tenant has been disabled. Please contact Superadmin';
                    return null;
                  }
                  
                  if($user['status'] != 1){
                    $message = 'You have been disabled. Please contact your Tenant for details';
                    return null;
                  }
              $this->Auth->setUser($user);
              if(!$user){
                $message = 'Please enter correct email or password!';
              }
              if( !empty($query) && $query->name == 'student'){
              }
              }elseif($user){
                $message = 'You do not belong to this Tenant. Please contact Superadmin';
              }elseif(!$user){
                $message = 'Please enter correct email or password!';
              }
          }
          $returnData =[];
          $returnData['message'] = $message;
          if($user){
            $returnData['response'] = 1;
          } else {
            $returnData['response'] = 0;
          }
          $this->set('response',$returnData);
          $this->set('_serialize', ['response']);
      }
      public function updatePassword(){
        // pr("here");die;
        if(!$this->request->is(['put'])){
          throw new MethodNotAllowedException(__('BAD_REQUEST'));
        }

        $data = $this->request->getData();
        if(!isset($data['new_password'])){
          throw new BadRequestException(__('MANDATORY FIELD MISSING New Password'));
        }
        if(isset($data['new_password']) && empty($data['new_password'])){
          throw new BadRequestException(__('EMPTY NOT ALLOWED New Password'));
        }
        if(!isset($data['user_id'])){
          throw new BadRequestException(__('MANDATORY_FIELD_MISSING','user_id'));
        }
        if(isset($data['user_id']) && empty($data['user_id'])){
          throw new BadRequestException(__('EMPTY_NOT_ALLOWED','user_id'));
        }
        $id = $data['user_id'];
        // pr($id);die('here');
        $this->loadModel('Students');
        $user = $this->Students->find()
                               ->where(['Students.id'=>$id])
                               ->contain(['TrainingSites'])
                               ->first();
                               // pr($user->email);die;
        if(!$user){
          throw new NotFoundException(__('ENTITY_DOES_NOT_EXISTS','User'));
        }
        $password = $data['new_password'];
        $reqData = ['password'=>$password];
        $user = $this->Students->patchEntity($user, $reqData);
        if(isset($user->training_site) && !empty($user->training_site)){
          $trainingSiteName = $user->training_site->name;
          $trainingSitePhone = $user->training_site->contact_phone;
          $trainingSiteEmail = $user->training_site->contact_email;
        } else {
          $trainingSiteName = 'No Training Site Information Available!';
          $trainingSitePhone = 'No Training Site Information Available!';
          $trainingSiteEmail = 'No Training Site Information Available!';
        }
        if($this->Students->save($user)){

                 $host = $this->request->host();
                 $emailData = [
                'name' => $user->first_name." ".$user->last_name,
                'email' => $user->email,
                'training_site_name' => $trainingSiteName,
                'training_site_phone' => $trainingSitePhone,
                'training_site_email'=> $trainingSiteEmail,
                'server_name' => $host,
                'user_name' => $user->email,
                'user_password' => $data['new_password']
                ];
                $event = new Event('password_update_student', $this, [
               'hashData' => $emailData,
               'tenant_id' => $user->tenant_id
                ]);

                $this->getEventManager()->dispatch($event);

          $data =array();
          $data['status']=true;
          $data['data']['id']=$user->id;
          $data['data']['message']='password saved';
          $this->set('response',$data);
          $this->set('_serialize', ['response']);
        }else{
          throw new BadRequestException(__('BAD_REQUEST'));
        }
      }

      public function classes(){
      $this->loadModel('Tenants');
      $this->loadModel('Courses');
      $url = Router::url('/', true);
      // pr($url);die;
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
      $queryString = $this->getRequest()->getQuery();
      // pr($queryString['start']);die;
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      // pr($domainType); die();
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $tenant = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
      if(!isset($tenant) && empty($tenant)){
        throw new NotFoundException(__('Tenant Not Found'));
      }
        if($tenant){
          $where = ['Courses.tenant_id'=>$tenant->id, 'Courses.status NOT IN' => 'draft','Courses.private_course' => 0];
        }
     Log::write('debug','before courses');

      // pr('test');die;
      $courses = $this->Courses->find()
                                     ->contain(['CourseDates' => function($exp)use($queryString){
                                      return $exp->where(['course_date >=' => $queryString['start'],'course_date <=' => $queryString['end']]); 
                                     },'CourseTypes'])
                                     ->where($where)
                                     ->order(['Courses.created' => 'DESC'])
                                     // ->all()
                                     ->toArray();
       // pr($courses);die;                              
      $courseData = [];
        foreach ($courses as $key => $value) {
          $domainType = Router::url('/', true);
          if(!empty($value->private_course_url)){
            $url = $domainType.'students/private_course/'.$value->id.'/?course-hash='.$value->private_course_url;
          }
          foreach ($value->course_dates as $key => $valueDate) {
            $toDate = $valueDate->course_date->format('Y-m-d');
            $time = $valueDate->time_from->format('H:i:s');
            $timeTo = $valueDate->time_to->format('H:i:s');
            // pr($toDate.' '.$timeTo);die;
            // pr();die;
            $courseData[] = [
                              'title' => $value->course_type->name,
                              'start'=> (date(DATE_ISO8601, strtotime($toDate.' '.$time))),
                              'end' => (date(DATE_ISO8601, strtotime($toDate.' '.$timeTo))),
                              'url'=> $url,
                        ];
            if(empty($value->private_course_url)){
                unset($courseData[$key]['url']);
            }
          }
        }
        // $courseData[] = [
        //                 'title' => 'test',
        //                 'start'=> '2019-03-13',
        //                 'end'=> '2019-03-13',
        //                 ];
      $this->set('event',$courseData);
      $this->set('_serialize', ['event']);
    }

    public function verifyStudentInfo(){
      // die;
      if(!$this->request->is(['post'])){
        throw new MethodNotAllowedException(__('BAD_REQUEST'));
      }
      $status = 1;
      $studentInfo = array();
      $studentData = array();
      $data = $this->request->getData();
      if(empty($data['requestController'])){
        $data['requestController'] = "Students";
      }
      if(empty($data['studentInfo'])){
        $status = 0;
        $reason = "Students Info is missing.";
      }
      // pr($data);
      $studentInfo = array_chunk($data['studentInfo'],4,true);
      // pr($studentInfo);

      foreach ($studentInfo as $key => $value) {
        # code...
        $studentData[$key] = $value;
      }
      // pr($studentData);
      foreach ($studentData  as $student) {
        # code...
        $student = array_values($student);
        // pr($students.' '.$key);
        // $test = $students[2];
        // pr($students.'test'.$key);
        // pr($students[2]);die;
        foreach ($student as $key => $value) {
          # code...
          // pr($value);die('ss');
        }
          $emailValidator = $this->Students->validEmail($student[2]);
          // pr($emailValidator);die;
          if($emailValidator != 1) {
            // die('outside');

            $status = 0;
            $reason = "Invalid Email!";
            $abort = true;
            // break;
          }
          // pr($value);die;
          if(empty($value)){
            $status = 0;
            $reason = "Please enter student's details in the correct format first"; 
            break;
          }
          
          // pr($emailValidator);die('hi');
          $studentemail = $this->Students->findByEmail($student[2])->first(); 
          // pr($studentemail);die;
          if($studentemail){
            // die('inside');
            $status = 0;
            $reason = "Email Already exist. Please check and verify students info before payment.";
          }
      }
      // die('here');
      // die('ss');

      // $studentNumbers =(explode("\n",$data['studentInfo']));
      // // pr($studentNumbers);die;
      // $abort = false;
      // foreach($studentNumbers as $key => $value){
      //   $studentData = explode(",", $value);
  
      //   if(empty($studentData[0])){
      //     $status = 0;
      //     $reason = "Please enter data in the following format: First Name , Last Name , Email-Id";
      //   }
      //   if(empty($studentData[1])){
      //     $status = 0;
      //     $reason = "Please enter data in the following format: First Name , Last Name , Email-Id"; 
      //   }
      //   if(empty($studentData[2])){
      //     $status = 0;
      //     $reason = "Please enter data in the following format: First Name , Last Name , Email-Id";
      //   }
      //   if(isset($studentData[3])){
      //     $status = 0;
      //     $reason = "Please enter data in the following format: First Name , Last Name , Email-Id";
      //   }
      //   if(!empty($studentData[2]) && isset($studentData[2])){

      //     $email = trim($studentData[2]);
      //     $emailValidator = $this->Students->validEmail($email);
      //     $student = $this->Students->findByEmail($email)->first(); 
      //     if($student){
      //       $status = 0;
      //       $reason = "Email Already exist. Please check and verify students info before payment.";
      //     }
      //     if(!$emailValidator) {
      //         $abort = true;
      //         break;
      //     }
      //   }
      // }

      if($status == 1){
        // pr('here');die;

        if($data['requestController'] == "Courses"){

          // pr('here');
          $this->request->getSession()->write('studentsInfo', $studentData);
      // pr($session->read('studentsInfo'));die('table');

          $this->loadModel('Courses');
          $course = $this->Courses->findById($data['courseId'])
                                  ->contain(['Locations','CourseTypes.Agencies','CourseDates','CourseTypeCategories','TrainingSites'])
                                  ->first();
                                  // pr($course);
          $saveStudents = $this->Students->registerStudents($studentData, $course,$data['emailFlag'],1); 
          // pr($saveStudents);die('ss');
          if($saveStudents['status'] == 1){
            // pr('saved');
            $this->set('saved',$saveStudents['status']);   
            $this->set('_serialize', ['saved']);
          }

        }else{
        $totalAmount = $this->request->getSession()->read('baseAmount');

        $count = count($studentData);
        $totalAmount = $count*$totalAmount; 

          $this->request->getSession()->write('studentsInfo', $studentData);
          $this->request->getSession()->write('finalAmount', $totalAmount);
          // $amount = $this->request->getSession()->read('finalAmount');
          if(!$totalAmount){
            $courseId = $this->request->getSession()->read('selected_course');
            $totalAmount = $this->Students->CourseStudents->Courses->findById($courseId)->first()->cost;



          }


        $this->set('status',$status);
        $this->set('finalAmount',$totalAmount);
        $this->set('_serialize', ['status','finalAmount','saved']);
        }
      }else{
        // pr($status);pr($reason);die;        
        $this->set('status',$status);
        $this->set('reason',$reason);
        $this->set('_serialize', ['status','reason']);
      }
    }

    public function removePromocode(){
      if(!$this->request->is(['get'])){
        throw new MethodNotAllowedException(__('BAD_REQUEST'));
      }

      $promocodeId = $this->request->getSession()->read('appliedPromocodeId');
      if(!$promocodeId){
        throw new NotFoundException(__('Promocode Id not found.'));
      }
      $this->loadModel('PromoCodes');
      $promoCode = $this->PromoCodes->findById($promocodeId)                             
                                    ->first();
      
      $totalAmount = $this->request->getSession()->read('finalAmount');
      if(!$totalAmount){
        throw new NotFoundException(__('Amount not found.')); 
      }
      $loggedInUser = $this->Auth->user();
      if($loggedInUser['role_id'] == 2){
        // $studentId = $this->request->query('studentId');
        $appliedBy = 'tenant';
      }elseif($loggedInUser['role_id'] == 5) {
        // $studentId = $loggedInUser['id'];
        $appliedBy = 'student';
      }else{
        $appliedBy = null;
      }
      // create a beauty expression
      $expression = new QueryExpression('coupon_used - 1');
      
      // execute a update with the beauty expression
      $expertData = $this->PromoCodes->updateAll( 
                                                    ['coupon_used' => $expression], // fields
                                                    ['id' => $promoCode->id] // conditions
                                                );

      $finalAmount = ($totalAmount + $promoCode->discount);
      if(isset($appliedBy) && $appliedBy == 'tenant'){
        $data[$studentId] = [
                              // swal({
                    //         type: 'error',
                    //         title: 'Promo code is not valid.'
                    //     })                      'finalAmount' => $finalAmount
                            ];
        $this->set('response',$data);
        $this->set('_serialize', ['status','response']);
      }else{
        $this->request->getSession()->write('finalAmount', $finalAmount);
        $this->request->getSession()->write('appliedPromocodeId', '');
        $this->set('finalAmount',$finalAmount);
        $this->set('_serialize', ['status','finalAmount']);
      }
    }

    public function promocode1(){
      if(!$this->request->is(['get'])){
        throw new MethodNotAllowedException(__('BAD_REQUEST'));
      }
      $courseId = $this->request->getQuery(['courseId']);
      $studentId = $this->request->getQuery(['studentId']);
      $status = true;
      $this->loadModel('Tenants');
      $url = Router::url('/', true);
      if($url == "http://localhost/classbyte/"){
        $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      }else{
        $domainType = "http://$_SERVER[HTTP_HOST]";
      }
      $tenant = $this->Tenants->find()
                              ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                              ->first();

      $loggedInUser = $this->Auth->user();
      if($loggedInUser['role_id'] == 2){
          if($this->request->getSession()->read('paymentData'));{
            $sessionData = $this->request->getSession()->read('paymentData');

              if(isset($sessionData[$studentId])){
                $totalAmount = $sessionData[$studentId]['finalAmount'];
              } else {
                 $this->loadModel('Courses');
                $totalAmount = $this->Courses->findById($courseId)->first()->cost;
                $totalAmount = (int)$totalAmount;
              }
          }
        $appliedBy = 'tenant';
      }elseif($loggedInUser['role_id'] == 5) {
        // $studentId = $loggedInUser['id'];
        $appliedBy = 'student';
      }else{
        $studentInfo = $this->request->getSession()->read('studentsInfo');
        if(empty($studentInfo)){
          $status = false;
          throw new NotFoundException(__('Students not found.'));
        }
        //---------------------------EARLIER TOTAL AMOUNT------------------------
        // $totalAmount = $this->request->getSession()->read('bulkStudentsCost');
        //-----------------------------------------------------------------------
        $totalAmount = $this->request->getSession()->read('finalAmount');
        // pr($totalAmount);pr('totalamount1');pr($totalAmount1);die;
      }
      if(!$totalAmount){
        throw new NotFoundException(__('Total amount is not found.'));
      }
      $code =  $this->request->getQuery('request');
      if(!isset($code) && !$code){
        throw new BadRequestException(__('MANDATORY FIELD MISSING PROMOCODE'));
      }
      $date = new FrozenTime();
      $this->loadModel('PromoCodes');
      $promoCode = $this->PromoCodes->find()
                                    ->where([
                                              'code' => $code,
                                              'tenant_id'=> $tenant->id,
                                              'start_date <=' => $date,
                                              'end_date >=' => $date,
                                              'status'=> 1
                                            ])                             
                                    ->first();
      // pr($promoCode);die;
      if(!$promoCode){
        $status = false;
        throw new NotFoundException(__('Promocode is not valid.'));
      }
      //condition that the coupon is valid for that specific email.
      if(isset($promoCode->restrict_by_email) && $promoCode->restrict_by_email){
        $this->loadModel('PromoCodeEmails');
        $checkEmail = $this->PromoCodeEmails->findByEmail($tenant->email)
                                            ->where(['promo_code_id' => $promoCode->id])
                                            ->first();
        if(!$checkEmail){
          $status = false;
          throw new NotFoundException(__('Promocode is not valid for this Email.'));
        }
      }
      //condition that No. of uses should be greater than coupon used.
      if($promoCode->no_of_uses <= $promoCode->coupon_used){
        $status = false;
        throw new NotFoundException(__('Promocode exceeds its limit.'));        
      }
      //condition that the coupon is valid for that specific course type.
      if(isset($promoCode->restrict_by_course_types) && $promoCode->restrict_by_course_types){
        $courseId = $this->request->getSession()->read('selected_course');
        if(!$courseId && !isset($courseId)){
          $courseId =  $this->request->getQuery('courseId');
          if(!isset($courseId) && !$courseId){
            throw new NotFoundException(__('Course Id not found.'));
          }
        } 
        $this->loadModel('Courses');
        $course = $this->Courses->findById($courseId)
                                ->first();
        if(!$course){
          throw new NotFoundException(__('Course not found with this Id.'));
        }
        $courseTypeId = $course->course_type_id;
        $this->loadModel('PromoCodeCourseTypes');
        $checkCourseTypes = $this->PromoCodeCourseTypes->find()
                                                        ->where([ 
                                                                    'course_type_id' => $courseTypeId,
                                                                    'promo_code_id' => $promoCode->id
                                                                ])
                                                        ->first();
        if(!$checkCourseTypes){
          $status = false;
          throw new NotFoundException(__('Promocode is not valid for this Course Type.'));
        }
      }

      //condition that the coupon is valid for that specific corporate and or subcontracted client
      if((isset($promoCode->corporate_client_id) && $promoCode->corporate_client_id) && (isset($tenant->training_site_id) && $tenant->training_site_id)){
      
        $this->loadModel('CorporateClients');
        $checkCorporateClient = $this->CorporateClients->find()
                                                       ->where([
                                                                  'id' => $promoCode->corporate_client_id,
                                                                  'tenant_id' => $tenant->id,
                                                                  'training_site_id' => $tenant->training_site_id
                                                               ])
                                                       ->first();
 
        if(!$checkCorporateClient){
          $status = false;
          throw new NotFoundException(__('Promocode is not valid for this Corporate Client.'));
        }

        if(isset($promoCode->subcontracted_client_id) && $promoCode->subcontracted_client_id){
      
          $this->loadModel('SubcontractedClients');
          $checkSubcontractedClient = $this->SubcontractedClients->find()
                                                             ->where([
                                                                       'id' => $promoCode->corporate_client_id,
                                                                       'tenant_id' => $tenant->id,
                                                                       'training_site_id' => $tenant->training_site_id,
                                                                       'corporate_client_id' => $checkCorporateClient->id
                                                                     ])
                                                              ->first();
   
          if(!$checkSubcontractedClient){
            $status = false;
            throw new NotFoundException(__('Promocode is not valid for this Subcontracted Client.'));
          }

          
        }

      }
      if($promoCode->discount_type == 0){
        // pr($totalAmount);die;
        $finalAmount = ($totalAmount - $promoCode->discount);
        if($loggedInUser['role_id'] == 2){
        $sessionData[$studentId]['finalAmount'] = $finalAmount;
        }
        // pr($sessionData);die;
      }else{
        $finalAmount = $totalAmount - ($promoCode->discount/100)*$totalAmount;
        if($loggedInUser['role_id'] == 2){
        $sessionData[$studentId]['finalAmount'] = $finalAmount;
        }
      }
      // create a beauty expression
      $expression = new QueryExpression('coupon_used + 1');
      
      // execute a update with the beauty expression
      $expertData = $this->PromoCodes->updateAll( 
                                                    ['coupon_used' => $expression], // fields
                                                    ['id' => $promoCode->id] // conditions
                                                );

      $this->request->getSession()->write('appliedPromocodeId', $promoCode->id);
      // pr($finalAmount);die;
      if(isset($appliedBy) && $appliedBy == 'tenant'){

        $data[$studentId] = [
                                'finalAmount' => $finalAmount
                            ];
        if($this->request->getSession()->read('paymentData')){
         // pr($sessionData);die;
        $this->request->getSession()->write('paymentData', $sessionData);
        }                    
        $this->set('response',$data);
        $this->set('status',$status);
        $this->set('_serialize', ['status','response']);
      }else{
        $this->request->getSession()->write('finalAmount', $finalAmount);
        $this->set('finalAmount',$finalAmount);
        $this->set('status',$status);
        $this->set('_serialize', ['status','finalAmount']);
      }
    }

    public function promocode(){
      $data= $this->request->getData();
      if(!$this->request->is(['get'])){
        throw new MethodNotAllowedException(__('BAD_REQUEST'));
      }
      $loggedInUser = $this->Auth->user();
      if(!isset($loggedInUser) && !$loggedInUser){
        throw new UnauthorizedException(__('You are not logged in.'));
      }
      $courseId = $this->request->getSession()->read('selected_course');
      if(!$courseId && !isset($courseId)){
        $courseId =  $this->request->getQuery('courseId');
        if(!isset($courseId) && !$courseId){
          throw new NotFoundException(__('Course Id not found.'));
        }
      }  
      $this->loadModel('Courses');
      $course = $this->Courses->findById($courseId)
                              ->first();

      $courseId = $this->request->getQuery('courseId');
      if($loggedInUser['role_id'] == 2){
        $studentId = $this->request->getQuery('studentId');
        $appliedBy = 'tenant';
      } else {
        $studentId = $loggedInUser['id'];
        $appliedBy = 'student';
      }
      $amount = $this->request->getSession()->read('paymentData');
      
      $totalAmount = isset($amount[$studentId]['finalAmount'])?$amount[$studentId]['finalAmount']:$course->cost;

      if(!isset($totalAmount) && !$totalAmount){
        throw new NotFoundException(__('Total Amount not found.'));
      }

      $code =  $this->request->getQuery('request');
      // pr($code);die();
      if(!isset($code) && !$code){
        throw new BadRequestException(__('MANDATORY FIELD MISSING PROMOCODE'));
      }
      $success = false;
      // $date = Time::now();
      $date = new FrozenTime();
      // $date = $date->format('Y-m-d');
      // pr($date);
      $this->loadModel('PromoCodes');
      $promoCode = $this->PromoCodes->find()
                                    ->where([
                                              'code' => $code,
                                              'tenant_id'=> $loggedInUser['tenant_id'],
                                                // 'start_date' <= $date,
                                                // 'end_date' >= $date,
                                             // 'start_date <=' => $date,
      //                                        'end_date >=' => $date,
                                              'status'=> 1
                                            ])                             
                                    ->first();
      
      if(!$promoCode){
        throw new NotFoundException(__('Promocode is not valid.'));
      }
      //condition that the coupon is valid for that specific email.
      if(isset($promoCode->restrict_by_email) && $promoCode->restrict_by_email){
        $this->loadModel('PromoCodeEmails');
        $checkEmail = $this->PromoCodeEmails->findByEmail($loggedInUser['email'])
                                            ->where(['promo_code_id' => $promoCode->id])
                                            ->first();
        if(!$checkEmail){
          throw new NotFoundException(__('Promocode is not valid for this Email.'));
        }
      }
      // pr('here');die;
      //condition that No. of uses should be greater than coupon used.
      if($promoCode->no_of_uses <= $promoCode->coupon_used){
        throw new NotFoundException(__('Promocode is not valid.'));        
      }
      // pr('here now');die;
      //condition that the coupon is valid for that specific course type.
      if(isset($promoCode->restrict_by_course_types) && $promoCode->restrict_by_course_types && isset($courseTypeId) && $courseTypeId){
      
        $this->loadModel('PromoCodeCourseTypes');
        $checkCourseTypes = $this->PromoCodeCourseTypes->find()
                                                        ->where([ 
                                                                    'course_type_id' => $courseTypeId,
                                                                    'promo_code_id' => $promoCode->id
                                                                ])
                                                        ->first();
        // pr('reached');die;
        if(!$checkCourseTypes){
          throw new NotFoundException(__('Promocode is not valid for this Course Type.'));
        }
      }

      //condition that the coupon is valid for that specific corporate and or subcontracted client
      if((isset($promoCode->corporate_client_id) && $promoCode->corporate_client_id) && (isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id'])){
      
        $this->loadModel('CorporateClients');
        $checkCorporateClient = $this->CorporateClients->find()
                                                       ->where([
                                                                  'id' => $promoCode->corporate_client_id,
                                                                  'tenant_id' => $loggedInUser['tenant_id'],
                                                                  'training_site_id' => $loggedInUser['training_site_id']
                                                               ])
                                                       ->first();
 
        if(!$checkCorporateClient){
          throw new NotFoundException(__('Promocode is not valid for this Corporate Client.'));
        }

        if(isset($promoCode->subcontracted_client_id) && $promoCode->subcontracted_client_id){
      
          $this->loadModel('SubcontractedClients');
          $checkSubcontractedClient = $this->SubcontractedClients->find()
                                                             ->where([
                                                                       'id' => $promoCode->corporate_client_id,
                                                                       'tenant_id' => $loggedInUser['tenant_id'],
                                                                       'training_site_id' => $loggedInUser['training_site_id'],
                                                                       'corporate_client_id' => $checkCorporateClient->id
                                                                     ])
                                                              ->first();
   
          if(!$checkSubcontractedClient){
            throw new NotFoundException(__('Promocode is not valid for this Subcontracted Client.'));
          }

          
        }

      }

      $this->loadModel('StudentPromoCodes');
      $studentPromocode = $this->StudentPromoCodes->find()
                                                  ->where([
                                                            'promo_code_id' => $promoCode->id,
                                                            'student_id' => $studentId,
                                                            'course_id' => $courseId
                                                          ])
                                                  ->first();
      if($studentPromocode){
        throw new BadRequestException(__('PromoCode already in use.'));
      }
      if($promoCode->discount_type == 0){
        $finalAmount = ($totalAmount - $promoCode->discount);
      }else{
        $finalAmount = $totalAmount - ($promoCode->discount/100)*$totalAmount;
      }
      $paymentData[$studentId] = [
                                      'finalAmount' => $finalAmount
                                  ];

      $amount = $this->request->getSession()->read('paymentData');
      
      $this->request->getSession()->write('finalAmount',$finalAmount);
      $finalAmount = $this->request->getSession()->read('finalAmount');
      if($finalAmount){
        $success = true;
      }
      $reqData = [
                    'promo_code_id' => $promoCode->id,
                    'student_id' => $studentId,
                    'applied_by' => $appliedBy,
                    'course_id' =>  $courseId      
                  ];

      $studentPromoCode = $this->StudentPromoCodes->newEntity();
      $studentPromoCode = $this->StudentPromoCodes->patchEntity($studentPromoCode, $reqData);
      if (!$this->StudentPromoCodes->save($studentPromoCode)) {
          throw new BadRequestException(__('Processing Error while saving PromoCode Students.'));
      }
      
      // create a beauty expression
      $expression = new QueryExpression('coupon_used + 1');
      
      // execute a update with the beauty expression
      $expertData = $this->PromoCodes->updateAll( 
                                                    ['coupon_used' => $expression], // fields
                                                    ['id' => $promoCode->id] // conditions
                                                );

      if($appliedBy == 'tenant'){
        $data[$studentId] = [
                                'finalAmount' => $finalAmount
                            ];
        $this->set('status',$success);
        $this->set('response',$data);
        $this->set('_serialize', ['status','response']);
      }else{
        $this->set('status',$success);
        $this->set('finalAmount',$finalAmount);
        $this->set('_serialize', ['status','finalAmount']);
      }
    }

    public function addAddonToSession(){
      $data = $this->request->getData();
      // pr($data);die;
      $courseAmount = $data['course_amount'];

      if($data['hasAddon'] == 'false'){
        $session = new Session();
        $addonAmount = 0;
        $session->write('selected_addons',null);
        $totalAmount = $courseAmount + $addonAmount;
        $session->write('finalAmount',$totalAmount);
        $session->write('baseAmount',$totalAmount);
      }else{
        $addonId = $data['addon_id'];
        $addonAmount = $data['addon_amount'];
        
        $existedAddonIds = [];
        if($this->request->getSession()->read('selected_addons')){
          $existedAddonIds = $this->request->getSession()->read('selected_addons');
        }
        if(count($existedAddonIds) > 0 && isset($existedAddonIds['addon_ids'][0])){
          $session = $this->request->getSession();
          if(!in_array($addonId, $existedAddonIds['addon_ids'])){
            array_push($existedAddonIds['addon_ids'],$addonId);
            $totalAmount = $this->request->getSession()->read('finalAmount') + $addonAmount;
            $this->request->getSession()->write('finalAmount',$totalAmount);
          }

          $y = array_unique($existedAddonIds['addon_ids']);
          $files['addon_ids'] = $y;
          $session->write('selected_addons',$files);
          
        }else{
          $session = new Session();
          $files['addon_ids'] = [$addonId];
          $session->write('selected_addons',$files);
          
          $totalAmount = $courseAmount + $addonAmount;
          $session->write('finalAmount',$totalAmount);
          $session->write('baseAmount',$totalAmount);
        }
      }
      $finalAmount = $this->request->getSession()->read('finalAmount');
      
      $this->set('data',$finalAmount);
      $this->set('_serialize', ['status','data']);
    }

    public function removeAddonToSession(){
  
      $data = $this->request->getData();
      $addonId = $data['addon_id'];
      $addonAmount = $data['addon_amount'];
      $existedAddonIds = $this->request->getSession()->read('selected_addons');
      $totalAmount = $this->request->getSession()->read('finalAmount');
      
      $status = false;
      $finalAmount = '';
      if(count($existedAddonIds) > 0){
        $status = true;
        $session = $this->request->getSession();
        if(in_array($addonId, $existedAddonIds['addon_ids'])){
          $existedAddonIds['addon_ids'] = array_diff($existedAddonIds['addon_ids'],[$addonId]);
          $y = array_unique($existedAddonIds['addon_ids']);
          $files['addon_ids'] = $y;
          $this->request->getSession()->write('selected_addons',$files);
          $totalAmount = ($totalAmount - $addonAmount);
          $this->request->getSession()->write('finalAmount',$totalAmount);
          $this->request->getSession()->write('baseAmount',$totalAmount);
          $this->set('finalAmount',$this->request->getSession()->read('finalAmount'));
        }
      }
      
      $this->set('status',$status);
      $this->set('_serialize', ['status','finalAmount']);
    }
    public function SaveToken(){

      $data = $this->request->getData();
      $this->request->getSession()->write('token',$data);
      $this->request->getSession()->write('amount',$data['amount']);
      $this->set('token',$this->request->getSession()->read('token'));
      $this->set('_serialize', ['token']);
    }
    public function index(){
      $loggedInUser = $this->Auth->user();
      $this->loadModel('SubcontractedClients');
      $this->loadmodel('TrainingSites');
      $indexName = Configure::read('Students');
      $queryString = $this->getRequest()->getQuery();
      $students = $this->Students->find()->all();
      $subcontractedClients = $this->SubcontractedClients->find()->indexBy('id')->toArray();
      $trainingSites = $this->Students->TrainingSites->find()->indexBy('id')->toArray();
      $corporateClients = $this->Students->CorporateClients->find()->indexBy('id')->toArray();
      $roleInfo = $this->roleData($loggedInUser['role']->name,$loggedInUser);
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
          $roleInfo = $this->roleData('TRAINING SITE OWNER',$loggedInUser);
        }

      $studentSorting = $this->studentSorting($indexName[$queryString['order'][0]['column']],$queryString['order'][0]['dir']);
      // pr($studentSorting);die;
      $this->paginate = [
                    'limit' => $queryString['length'],
                    'page' => ($queryString['start']/$queryString['length'])+1,
                    'order' => $studentSorting,
                    'sortWhitelist' => [
                                          'Students.first_name',
                                          'Students.last_name',
                                          'Students.status',
                                          'Students.city',
                                          'Students.state',
                                          'Students.phone1',
                                          'Students.email',
                                          'TrainingSites.name',
                                          'CorporateClients.name',
                                          'SubcontractedClients.name'
                                      ]       
                ];
      $students = $this->Students->find()->contain(['TrainingSites','CorporateClients','SubcontractedClients'])->where($roleInfo['where']);
      $students = $this->studentSearchIndex($queryString,$students);
      // pr($students);die;
      $totalStudents = $students->count();

      $students = $this->paginate($students);
      // pr($students);die;
      $response = (new Collection($students->toArray()))->map(function($value,$key)use($subcontractedClients,$trainingSites,$corporateClients, $loggedInUser){
            $data = [
                      (isset($value->training_site_id) && $value->training_site_id)?$trainingSites[$value->training_site_id]->name:"-",
                      (isset($value->corporate_client_id) && $value->corporate_client_id)?$corporateClients[$value->corporate_client_id]->name:'-',
                      (isset($value->subcontracted_client_id) && $value->subcontracted_client_id)?$subcontractedClients[$value->subcontracted_client_id]->name:'-',
                      $value->first_name,
                      $value->last_name,
                      $value->email,
                      $value->phone1,
                      $value->city,
                      $value->state,
                      $this->getStudentActions($value, $loggedInUser)
                    ];
            if($loggedInUser['role']->name === 'tenant'){
              // pr($value);die;
              $data = [
                      (isset($value->training_site_id) && $value->training_site_id)?$trainingSites[$value->training_site_id]->name:"-",
                      (isset($value->corporate_client_id) && $value->corporate_client_id)?$corporateClients[$value->corporate_client_id]->name:'-',
                      (isset($value->subcontracted_client_id) && $value->subcontracted_client_id)?$subcontractedClients[$value->subcontracted_client_id]->name:'-',
                      $value->first_name,
                      $value->last_name,
                      // $value->status?'Yes':'No',
                      $this->getStatus($value , $loggedInUser),
                      $value->email,
                      $value->phone1,
                      $value->city,
                      $value->state,
                      $this->getStudentActions($value, $loggedInUser)
                    ];
            }     
            return $data;
          // pr($data);die;
      })->toArray();

       $response = [
                    'draw' => $queryString['draw'],
                    'recordsTotal' => $totalStudents,
                    'recordsFiltered' => $totalStudents,
                    'data' => $response,
                ];
        $this->set('response', $response);
        $this->set('_serialize', ['response']);
    }

    public function getStudentActions($student, $loggedInUser){

      $id = $student->id;
      // $viewUrl = Router::url(['action' => 'view', $id], true);
      $viewUrl = str_replace('api/', '', Router::url(['action' => 'view', $id], true));
      $editUrl = str_replace('api/', '', Router::url(['action' => 'edit', $id], true));
      $deleteUrl = str_replace('api/', '', Router::url(['action' => 'delete', $id], true));
      $historyUrl = str_replace('api/', '', Router::url(['action' => 'history', $id], true));

      $string = "<a href='#' onclick=openViewPopUp('".$viewUrl."') class='btn btn-xs btn-success' data-toggle='modal' data-target='#myModal'>
                                          <i class='fa fa-eye fa-fw'></i>
                                      </a> ";


      if($loggedInUser['role']->name == 'tenant'){
        $string = $string. "<a href='".$editUrl."' class='btn btn-xs btn-warning'>
                                      <i class='fa fa-pencil fa-fw'></i>
                                  </a> <a href='".$deleteUrl."' class='btn btn-xs btn-danger'>
                                      <i class='fa fa-trash-o fa-fw'></i>
                                  </a>";
      }
      $string = $string. " <a href='".$historyUrl."' class='btn btn-xs btn-primary'>
                                      <i class='fa fa-exchange fa-fw'></i>
                                  </a>";

      return $string;
    }
      public function getStatus($value, $loggedInUser){
      // $loggedInUser = $this->Auth->user();
      // pr($loggedInUser);die;
      if($value->status == 1){
        if(!$loggedInUser['role_id'] == '2'){
        $string = "Active"; 
        } else {  
          $updateStatus = str_replace('api/', '', Router::url(['action' => 'updateStatus', $value->id,$value->status], true));
          $string = "<a href='".$updateStatus."'>Active</a>";
        }
      }elseif($value->status == 0){
        if(!$loggedInUser['role_id'] == '2'){
          $string = "Inactive";
        } else {
          $updateStatus = str_replace('api/', '', Router::url(['action' => 'updateStatus', $value->id,0], true));
          $string = "<a href='".$updateStatus."'>Inactive </a>";
        }
      }
      return $string;
    }

    public function roleData($role,$loggedInUser){
      $roleInfo = [
                      'tenant' => [
                                      'where' => isset($loggedInUser['tenant_id'])?['Students.tenant_id ='=>$loggedInUser['tenant_id']]:null,
                                    ],
                      'corporate_client' => [
                                                'where' =>  isset($loggedInUser['corporate_client_id'])?['Students.corporate_client_id ='=>$loggedInUser['corporate_client_id']]:null, 
                                                ],
                      'TRAINING SITE OWNER' => [
                                                  'where' => isset($loggedInUser['training_site_id'])?['Students.training_site_id ='=>$loggedInUser['training_site_id']]:null,
                                                ]

                  ];
        return $roleInfo[$role];          
    }
 public function studentSorting($columnName,$order){
        $studentSorting = [
                            'first_name' => ['Students.first_name' => $order],
                            'last_name' => ['Students.last_name' => $order], 
                            'corporate_client' => ['CorporateClients.name' => $order],
                            'training_site' => ['TrainingSites.name' => $order ],
                            'status' => ['Students.status' => $order ],
                            'city' => ['Students.city' => $order ],
                            'state' => ['Students.state' => $order ],
                            'phone1' => ['Students.phone1' => $order],
                            'subcontracted_client' => ['SubcontractedClients.name' => $order],
                            'email' => ['Students.email' => $order]
                        ];
         return $studentSorting[$columnName];               
    }
public function searchFilter(){
        $columnInfo = [
                            [
                                'name_key' => 'subcontracted_client',
                                'where'  => false ,
                                'matching' => [ 'table_name' => 'SubcontractedClients',
                                                'where' => 'SubcontractedClients.name REGEXP'
                                              ],
                                'genericMatching' => [
                                                        'table_name' => 'SubcontractedClients',
                                                        'where' => 'SubcontractedClients.name Like'
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
                                                      ],            
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
                                'name_key' => 'first_name',
                                'where'  => 'Students.first_name Like',
                                'matching' => false,
                                'genericMatching' => false        
                            ],
                            [
                                'name_key' => 'city',
                                'where'  => 'Students.city Like',
                                'matching' => false,
                                'genericMatching' => false              
                            ],
                            [
                                'name_key' => 'state',
                                'where'  => 'Students.state Like',
                                'matching' => false,
                                'genericMatching' => false
                            ],
                            [
                                'name_key' => 'email',
                                'where'  => 'Students.email Like',
                                'matching' => false,
                                'genericMatching' => false                                
                            ],
                            [
                                'name_key' => 'phone1',
                                'where'  => 'Students.phone1 Like',
                                'matching' => false,
                                'genericMatching' => false                                
                            ],
                            [
                                'name_key' => 'last_name',
                                'where'  => 'Students.last_name Like',
                                'matching' => false,
                                'genericMatching' => false                                
                            ]
                      ];
         return $columnInfo;             
    }
    public function studentSearchIndex($queryString,$students){
      $columnInfo = $this->searchFilter();
      foreach ($columnInfo as $key => $value) { 
            if(!((isset($queryString['search']) && $queryString['search']['value']))){
                continue;
            }
            $searchValue = (string)$queryString['search']['value'];
            // pr($searchValue);die;
            if($value['genericMatching']){
                $where['OR'][] = [$value['genericMatching']['where'] => '%'.$searchValue.'%'];
            }
            if($value['where']){
                $where['OR'][] = [$value['where'] => '%'.$searchValue.'%'];
            }
        }
        if(((isset($queryString['search']) && $queryString['search']['value']))){
              $students->where($where);
            }
        return $students;   
    }
}