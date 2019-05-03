<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Robotusers\Excel\Registry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls; 
use Cake\Datasource\ConnectionManager;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 *
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentsController extends AppController
{

    
    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Auth->allow(['logout','login','forgotPassword','resetPassword','signUp','privateCourse','register','makePayment','classes','exportCsv','thankYou','bulkPayment','paymentInfo','updateStatus']);
    }


    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.

        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus','history']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }


        else if (in_array($action, ['index', 'view','add','edit','delete','updateStatus','register','transferStudent','exportCsv','adminPayment','history']) && $user['role']->name === self::TENANT_LABEL) {

        // pr($action); die('in tenant admin');
            return true;
        }

        else if (in_array($action, ['index', 'view','add','edit','delete','updateStatus','history']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','dashboard','delete','updateStatus','login','signUp','courseHistory','calender','payment','course-history','thankYou','history','checkPaymentStatus','paymentInfo']) && $user['role']->name === self::STUDENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);

    }

    public function payment(){
      $this->viewBuilder()->setLayout('student-layout');

    }

    public function history($id = null){
      // pr($id);die;
      $this->loadModel('StudentTransferHistories');
      $this->loadModel('LineItems');
      $studentTransferHistory = $this->StudentTransferHistories->findByStudentId($id)
                                                               ->contain(['PreviousCourses.CourseTypes','CurrentCourses.CourseTypes'])
                                                               // ->all()
                                                               ->toArray();                                  
    // pr($studentTransferHistory);die;                            

    // $courseIds=(new Collection($studentTransferHistory))->extract('previous_course_id')->toArray();
    // // pr($courseIds);die;
    // $orderIds = $this->LineItems->find()->where(['student_id' => $id, 'course_id IN'=>$courseIds])->extract('id')->toArray();
    $this->loadModel("CourseStudents");
    $this->loadModel("Courses");
    $this->loadModel('Payments');
    $this->loadModel('CourseStudents');
    $studentData = $this->CourseStudents->findByStudentId($id)
                                           ->contain(['Courses.CourseTypes','Students','Courses.CourseDates'])
                                           ->where(['Courses.status NOT IN'=>'draft'])
                                           ->toArray();
    // pr($studentData);die;                                       
    // pr($id);die;
    $payments = $this->Payments->findByStudentId($id)
                              ->contain(['Transactions'])
                              ->toArray();
    // pr($payments);die;                          
    $courseStudent = $this->CourseStudents->find()                         
                                          ->contain(['Courses'=>function($q) {
                                            return $q->where(['Courses.status NOT IN'=>'draft']);
                                          },'Courses.CourseTypes','Courses.CourseDates'])
                                          ->where(['student_id' => $id])
                                          // ->contain(['Courses'])
                                          ->first();
    // pr($courseStudent->course['course_dates'][0]->course_date->format('m-d-y'));die;
    // pr($courseStudent);die;

    $this->set(compact('studentTransferHistory','payments','amount','courseStudent','studentData'));          


    }
    
    public function exportCsv(){
        $loggedInUser = $this->Auth->user();
        $student = $this->Students->find()
                                      ->contain(['TrainingSites', 'CorporateClients', 'SubcontractedClients'])
                                      ->where(['Students.tenant_id ='=>$loggedInUser['tenant_id']])
                                      ->all()
                                      ->toArray();
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("excel/student_data.xls");
        $sheet = $spreadsheet->getActiveSheet();
        $j=0;
        for($i=2; $i< (count($student) +2); $i++){
            $sheet->setCellValue('A'.$i, $i-1);
            if(!empty($student[$j]->training_site) && isset($student[$j]->training_site)){

            $sheet->setCellValue('B'.$i, $student[$j]->training_site->name);
            }
            if(!empty($student[$j]->corporate_client) && isset($student[$j]->corporate_client)){
            $sheet->setCellValue('C'.$i, $student[$j]->corporate_client->name);
            }
            $sheet->setCellValue('D'.$i, $student[$j]->first_name);
            $sheet->setCellValue('E'.$i, $student[$j]->last_name);
            $sheet->setCellValue('F'.$i, $student[$j]->email);
            $sheet->setCellValue('G'.$i, $student[$j]->phone1);
            $sheet->setCellValue('H'.$i, $student[$j]->city);
            $sheet->setCellValue('I'.$i, $student[$j]->state);
            $sheet->setCellValue('J'.$i, $student[$j]->address);
            $sheet->setCellValue('K'.$i, $student[$j]->address);
            $sheet->setCellValue('L'.$i, $student[$j]->zipcode);
            $sheet->setCellValue('M'.$i, $student[$j]->phone2);
            if(!empty($student[$j]->status) && $student[$j]->status == 1){
              $status = 'Active';
            }else{
              $status = 'Inactive'; 
            }
            $sheet->setCellValue('N'.$i, $status);
            $j++;
            
        }      

        $writer = new Xls($spreadsheet);
        $writer->save('excel/students.xlsx');
        return $this->redirect('http://'.$_SERVER['SERVER_NAME'].Router::url('/').'excel/students.xlsx');
    }


    public function transferStudent($id = null, $courseId = null){
      $loggedInUser = $this->Auth->user();
      $now = Time::now()->format('Y-m-d');
      $this->loadModel('CourseTypes');
      $this->loadModel('Courses');
      $this->loadModel('CourseDates');
      $this->loadModel('StudentTransferHistories');
      $this->loadModel('Payments');
      $this->loadModel('LineItems');
      $this->loadModel('Orders');
      $this->loadModel('TenantConfigSettings');
      // pr($id);pr($courseId);
      $orderDetails = $this->Students->LineItems->findByStudentId($id)
                                                ->contain(['Orders'])
                                                ->where(['course_id' => $courseId])
                                                ->toArray();
       // pr($orderDetails);die;
       if(empty($orderDetails)){
        $sum = 0;
       } else {                                          
       $sum = $this->Payments->find();  
       $sum = $sum->select([
                          'sumOfAmount'=> $sum->func()->sum('amount') 
                         ])
                         ->where([
                            'AND' => [
                              'order_id' => $orderDetails[0]->order_id
                            ],
                            'OR'=>[
                              ['payment_status' => 'Paid'],
                              ['payment_status'=>'Partial']
                            ]
                          ])
                         ->first()
                         ->sumOfAmount;
      }                                           
      // pr($sum);die;                                          
      // if(!$orderDetails){
      //     $this->Flash->error(__('Record could not be updated in the CourseStudent'));
      //   }

      // $transaction = $this->Students->LineItems->findByStudentId($id)
      //                                           ->contain(['Orders','Orders.Payments','Orders.Payments.Transactions'])
      //                                           ->where(['course_id' => $courseId])
      //                                           ->extract('order.payments')
      //                                           ->first();
      // pr($transaction);die;                                      
      $this->loadModel('CourseStudents');
      $courseStudent = $this->CourseStudents->findByStudentId($id)
                                            ->where(['course_id' => $courseId])
                                            ->first();
      if($this->request->is('post')){
        $data = $this->request->getData();
        // pr($data);die;
        $courseAmount = $this->Courses->findById($data['transferToCourses'])->select(['cost'])->first();
        $courseAmount = ((int)$courseAmount->cost);
          
          $student_transfer_histories = [
                                    'previous_course_id' => $courseStudent['course_id'],
                                    'current_course_id' => $data['transferToCourses'],
                                    'student_id' => $id,
                                    'transfer_date' => $now,
                                    'additional_amount' => null,
                                    'refund_amount' => null
                                ];   

      if($data['transferType'] == 'Transfer Only' ){
          // pr($data);die;
          $student_transfer_histories['refund_amount'] = 0;
          $student_transfer_histories['additional_amount'] = 0;
          $courseStudents['course_id'] = $data['transferToCourses'];
          $courseStudent = $this->CourseStudents->patchEntity($courseStudent,$courseStudents);
          // pr($courseStudent);die('here');
      } elseif($data['transferType'] == 'Transfer & Process Payment'){
        // die('here');
        $paymentAccessToken = $this->request->getSession()->read('token');
        $data['amount'] = $this->request->getSession()->read('amount');
        $student_transfer_histories['additional_amount'] = $data['amount'];
        $student_transfer_histories['refund_amount'] = 0;
        // pr($data);pr($paymentAccessToken);die('here');
        $data['available_amount'] = $data['amount'];
        // pr($data);die('here');
        $paymentAccessToken = $paymentAccessToken['token']['id'];
        if(empty($orderDetails)){
          $courseStudents['course_id'] = $data['transferToCourses'];
          $courseStudent = $this->CourseStudents->patchEntity($courseStudent,$courseStudents);
          $orderData = [
                        'total_amount' => $courseAmount,
                        'tenant_id' => $loggedInUser['tenant_id'],
                        'student_id' => $id,
                                                
                    ];
                    $orderData['line_items'][]= [
                                            'type' => 'online',
                                            'course_id' =>  $data['transferToCourses'],
                                            'amount' => $courseAmount,
                                            'student_id' => $id
                                        ];

          // pr($orderData);die;          
          $order = $this->Orders->newEntity();
          // pr($order);die;
          $order = $this->Orders->patchEntity($order,$orderData, ['associated' => 'LineItems']);
          // pr($order);die;
          if(empty($paymentAccessToken)){
            $this->Flash->error(__('Payment access token not found. Please try again later.'));
           return $this->redirect(['controller' => 'students','action' => 'transferStudent',$id,$courseId]);
              }
          // $lineItems = $this->LineItems->newEntity();
          // $lineItems = $this->LineItems->patEntity();
          // die('die here'  );
           $savePayment = $this->Orders->save($order, ['paymentCredentials' => ['stripeToken' => $paymentAccessToken],'type' => 'transfer','loggedInUser' => $loggedInUser, 'finalAmount' => $data['amount']]);
              $this->request->getSession()->delete('token');
                if($savePayment == true){
                  $this->Flash->success(__('Payment has been successfully done.'));
                }
                
        }else{

            // die('in line item');
            $courseStudents['course_id'] = $data['transferToCourses'];
            $courseStudentSave = $this->CourseStudents->patchEntity($courseStudent,$courseStudents);
            $lineItems = $this->LineItems->findByOrderId($orderDetails[0]['order_id'])->first();
            // pr($lineItems);die;
            $lineItem['course_id'] = $data['transferToCourses'];
            $lineItem['amount'] = $courseAmount;
            $lineItems = $this->LineItems->patchEntity($lineItems,$lineItem);
            if(!$this->LineItems->save($lineItems)){
               $this->Flash->success(__('LimeItems has not updated'));
            }
            // pr($paymentAccessToken);die('die');
            $this->payments($orderDetails[0],['paymentCredentials' => $paymentAccessToken,'amount' => $data['amount'], 'available_amount' => $data['available_amount']],'Paid');
          }
       } // ---------------------------Transfer And Refund Students-------------------------------
        else {
          $data = $this->request->getData();
          $data['student_id'] = $id;
          $data['course_id'] = $courseId;
          $courseCost = $this->Courses->findById($data['transferToCourses'])->first()->cost;
          if(empty($data['refund_amount'])){
            $data['refund_amount'] = $courseCost;
          }
          if($sum < $courseCost){
            $this->Flash->error('Please Enter Valid Amount');
            return $this->redirect(['action' => 'transferStudent',$id,$courseId]);
          }
          $stripe = $this->loadComponent('Stripe');
          $tenantId = $loggedInUser['tenant_id'];
          if(!empty($orderDetails[0]->order_id)){
          $amount = $this->Payments->findByOrderId($orderDetails[0]->order_id)
                                        ->contain(['Transactions' => function($q){
                                            return $q->where(['Transactions.type' => 'charge']);
                                        }])
                                        ->order(['Payments.amount' => 'DESC'])
                                        ->toArray();
           $courseStudents['course_id'] = $data['transferToCourses'];
           $courseStudent = $this->CourseStudents->patchEntity($courseStudent,$courseStudents);
            // pr($amount);die;
          $balance = (new Collection($amount))->map(function($value,$key){
            return $test['chargeIds'][] =['charge_id'=>$value->transaction->charge_id,
                                          'available_amount'=>$value->amount,
                                          'transaction_id' => $value->transaction_id
                                            ];
          })->toArray();
        }
        // pr($balance);die;
        $configSettings = $this->TenantConfigSettings->find()
                                                   ->where(['tenant_id' => $tenantId])
                                                   ->first();
        $response = $stripe->refundTransactions($balance,$data,$configSettings,$orderDetails[0]->order_id);
        if(!empty($response)){
          $student_transfer_histories['additional_amount'] = 0;
          $student_transfer_histories['refund_amount'] = $data['refund_amount'];
        }
        // die('here');
      }//else End
      // die('here4');
        $student_transfer = $this->StudentTransferHistories->newEntity();
        $student_transfer_histories = $this->StudentTransferHistories->patchEntity($student_transfer,$student_transfer_histories);
        if(!$this->CourseStudents->save($courseStudent)){
          $this->Flash->error(__('Record could not be updated in the CourseStudent'));
        } else {
          if(!$this->StudentTransferHistories->save($student_transfer_histories)){
          $this->Flash->error(__('Record could not be updated in StudentTransferHistories'));
        }
          $this->Flash->success(__('Transfered Succesfully'));
          return $this->redirect(['action' => 'history',$id]);
        }

        // pr($student_transfer_histories);pr($courseStudent);die;
      }
      $student= $this->Students->findById($id)
                               ->contain(['CourseStudents.Students'])
                               ->first();
      // pr($student);die();
      $course = $this->Courses->findById($courseId)
                              ->contain(['CourseTypes','CourseTypeCategories'])
                              ->first();
      // pr($course);die;
      // pr($orderId);die;                        
      $courseTypes = $this->CourseTypes->find()->all()->combine('id','name')->toArray();
      $loggedInUser = $this->Auth->user();
      $tenant_id = $this->Auth->user(['tenant_id']);
      $transferToCourses = $this->CourseDates->find()
                                              ->where(['course_date >' => $now])
                                              ->contain(['Courses'=>function($q) use($tenant_id){
                                                return $q->where(['status NOT IN' => 'draft','tenant_id'  => $tenant_id]);
                                              },"Courses.CourseTypes"])
                                              ->combine('course_id',function($q){
                                                return $q->course->course_type->name.'( $'.$q->course->cost.' )'; 
                                              })
                                              ->toArray();


      // pr($transferToCourses);die;                             
      $transferType = [ 'Transfer & Process Payment'=> 'Transfer & Process Payment', 'Transfer & Process Refund'=> 'Transfer & Process Refund' , 'Transfer Only'=>'Transfer Only'
        ];
      $this->set(compact('sum','student_transfer_histories','student','course','courseTypes','transferToCourses','transferType','orderDetails'));
    }
     public function payments($order,$data,$type){
      // pr('order');
      // pr($order);
      // pr('data');
      // pr($data);
      // pr('type');
      // pr($type);
      // die('Yeah!');
      $connection = ConnectionManager::get('default');
      $response = $connection->transactional(function () use($data, $order, $type) {

        $loggedInUser = $this->Auth->user();
        $tenantId = $loggedInUser['tenant_id'];
        $this->loadModel('TenantConfigSettings');
        $configSettings = $this->TenantConfigSettings->find()
                                                   ->where(['tenant_id' => $tenantId])
                                                   ->first();
        if(!$configSettings){
            $this->Flash->error(__("Tenant doesn't support online payment."));
            return $this->referer();
        }
        if(empty($data['paymentCredentials'])){
            $this->Flash->error(__('Payment access token not found. Please try again later.'));
        }                                       
        if($configSettings->payment_mode == "stripe"  && $configSettings->sandbox == 1){
            $stripe = $this->loadComponent('Stripe');
            $coursePayment = $stripe->chargeCards($data['amount'],$data['paymentCredentials'],$configSettings->stripe_test_private_key);
        }
        if($configSettings->payment_mode == "stripe" && $configSettings->sandbox == 0){
            $stripe = $this->loadComponent('Stripe');
            $charge_id = $data['charge_id'];
            $coursePayment = $stripe->chargeCards($data['amount'],$data['paymentCredentials'],$configSettings->stripe_live_private_key);
        }
          $paymentData = [
                          'student_id' => $order->student_id,
                          'tenant_id' => $tenantId,
                          'payment_status' => 'Paid',
                          'amount' => $data['amount'],
                          'order_id' => $order->order_id,
                          'transaction' => [
                                                // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                'charge_id' => $coursePayment['data']['id'],
                                                'payment_method' => $configSettings->payment_mode,
                                                'amount' => $data['amount'],
                                                'available_amount' => $data['available_amount'],
                                                'remark' => 'Registration for New Course',
                                                'status'=> 1,
                                                'type'=> 'charge',
                                                'parent_id' => null
                                              ]
                      ];  
        // pr($paymentData);die;
        $this->loadModel('Payments');
        $payment = $this->Payments->newEntity();
        $payment = $this->Payments->patchEntity($payment, $paymentData);
        // pr($payment);die;
        if ($this->Payments->save($payment)) {
          return true; 
        }           
        return false;
      });
    }

    public function thankYou(){
      $this->viewBuilder()->setLayout('student-layout');
      // pr($this->getRequest()->getSession()->read('selected_course'));die;
      $selected_course = $this->getRequest()->getSession()->read('selected_course');
      $this->loadModel('Courses');
      $course = $this->Courses->findById($selected_course)
                              ->contain(['CourseTypes'])
                              ->first();
                              // pr($course);die;
      $finalAmount = $this->getRequest()->getSession()->consume('finalAmount');
      // pr($finalAmount);die;
      //-------------------------------UNCOMMENT----------------------------------//
      $addons = [];
      $addonsIds = $this->request->getSession()->read('selected_addons');
      if(!empty($addonsIds['addon_ids'])){
        $this->loadModel('Addons');
        $addons = $this->Addons->find()->where(['id IN' => $addonsIds['addon_ids']])
                              ->all();
      }
      //---------------------------------------------------------------------------------
      if($this->Auth->user()){
        $loggedInUser = $this->Auth->user();
      }
      if($this->getRequest()->getSession()->read('student_ids') && $this->Auth->user('role_id') !==5){
        $this->loadModel('Students');
        $id = $this->getRequest()->getSession()->read('student_ids');
        $student = $this->Students->find()->where(['id IN' => $id])->all()->toArray();
        } elseif(isset($loggedInUser) && $loggedInUser['role_id'] == 5) {
          if($loggedInUser){
            $id = $loggedInUser['id'];    
            $student = $this->Students->get($id, [
            'contain' => []
            ]);
          } else {
            $this->Flash->error(__('Student(s) not found!'));
            $this->redirect(['action' => 'classes']);
          }
      }

      if ($this->request->is(['patch', 'post', 'put'])) {
          // pr($this->request->getParam());die;
          foreach($student as $patchStudents){
          $student[] = $this->Students->patchEntity($patchStudents, $this->request->getData());
          }
          if ($this->Students->saveMany($student)) {
              $this->Flash->success(__('Your response has been saved!'));
              return $this->redirect(['controller'=>'Students','action' => 'classes']);
          }
          $this->Flash->error(__('Your response could not be saved. Please, try again.'));
      }
      $this->set(compact('course','loggedInUser','addons','finalAmount','student'));

    }

    public function adminPayment($studentId = null, $courseId = null){
       $paymentData = $this->request->getSession()->read('paymentData');
       // pr($paymentData);die;
      $loggedInUser = $this->Auth->user();
      if(!isset($studentId) && $studentId){
        $this->Flash->error('Student not found!');
        $this->redirect($this->referer());
      }
      if(!isset($courseId) && $courseId){
        $this->Flash->error('Course not found!');
        $this->redirect($this->referer());
      }
      $this->loadModel('TenantConfigSettings');
     if($loggedInUser['role']->name != 'corporate_client'){

        $tenantConfigSettings = $this->TenantConfigSettings->find()
                                                           ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                           ->first();
        }else{
          $tenantConfigSettings = $this->TenantConfigSettings->find()
                                                           ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                                                           ->first();
        }

      if($tenantConfigSettings->payment_mode == "stripe"){
        if($tenantConfigSettings->sandbox == 1){
          $this->set('stripePublishedKey', $tenantConfigSettings->stripe_test_published_key);
        }
        if($tenantConfigSettings->sandbox == 0){
          $this->set('stripePublishedKey', $tenantConfigSettings->stripe_live_published_key);
        }
      }
      $courseStudents = $this->Students->CourseStudents->find()->where(['course_id' => $courseId,'student_id' =>  $studentId])->first();
      
      $course = $this->Students->CourseStudents->Courses->findById($courseId)->contain(['CourseTypes'])->first();

      $student = $this->Students->findById($studentId)->first();

      if($this->request->is('post')){
        $data = $this->request->getData();
        if(!isset($data['amount']) && !$data['amount']){
          $this->Flash->error('Please enter the amount.');
          $this->redirect(['controller' => 'Courses', 'action' => 'view',$course->id]);
        }
        if(!isset($data['stripeToken']) && !$data['stripeToken']){
          $this->Flash->error('Payment Credentials could not be verified. Please try again later!');
          $this->redirect(['controller' => 'Courses', 'action' => 'view',$course->id]);
        }
        $amountToBePaid = isset($paymentData[$student->id]['finalAmount'])?$paymentData[$student->id]['finalAmount']: $course->cost;
        // $paymentData = $this->request->getSession()->read('paymentData');
        // if(!empty($paymentData)){
        //   $this->set('paymentData',$paymentData);  
        //   if(isset($paymentData[$student->id]['addon_ids']) && !empty($paymentData[$student->id]['addon_ids'])){
        //     $this->loadModel('Addons');
        //     $addons = $this->Addons->find()
        //                            ->where(['id IN' => $paymentData[$student->id]['addon_ids']])
        //                            ->toArray();

        //     $this->set('addons',$addons);
        //   }
        // pr($this->request->data);die;
        $this->payNow($this->request->getData('stripeToken'), $course, $student, $this->request->getData('amount'));

      }
      $this->set(compact('student','course','courseStudents','paymentData'));

    }
    public function payNow($paymentAccessToken, $course, $student = null, $amountPaid = null){
          // pr($paymentAccessToken);die;
          $loggedInUser = $this->Auth->user();
          // pr($loggedInUser);die;
          if($loggedInUser['role_id'] == 2){
            $redirect = ['controller' => 'Courses', 'action' => 'view',$course->id];
          }else{
            $redirect = ['action' => 'privateCourse',$course->id];
          }

          if(!$paymentAccessToken){
            $this->Flash->error(__('Payment access token not found. Please try again later.'));
            return $this->redirect($redirect);
          }
          if(!$course){
            $this->Flash->error(__('Course not found for which you are going to pay.'));
            return $this->redirect($redirect);
          }
         if(!is_null($student)){
          $lineItemsData = $this->Students->LineItems->find()->where(['course_id' => $course->id,'LineItems.student_id'=> $student->id])->contain('Orders')->toArray();
         }
         // die('outside');
          if(isset($lineItemsData) && !empty($lineItemsData)){
            // die('in IF of partialPayment');
            $this->partialPayment($paymentAccessToken,$lineItemsData,$student->id,$amountPaid);
            return $this->redirect(['controller' => 'Courses', 'action' => 'view',$course->id]);
          }

          // die('Below Pratial Payment');
          $connection = ConnectionManager::get('default');
          $response = $connection->transactional(function () use($course, $paymentAccessToken, $student, $amountPaid, $loggedInUser) {
              $tenantId = $loggedInUser['tenant_id'];
              $this->loadModel('Orders');
              if($loggedInUser['role_id'] == 2){
                  //Payment when the user is a tenant
                $paymentData = $this->request->getSession()->read('paymentData');
                $reqData = [
                            'total_amount' => isset($paymentData[$student->id]['finalAmount'])?$paymentData[$student->id]['finalAmount']:$course->cost,
                            // 'total_amount' => $amountPaid,
                            'tenant_id' => $tenantId,
                            'student_id' => $student->id,
                            'line_items' => [
                                              [
                                                'course_id' => $course->id,
                                                'type' => 'online',
                                                'amount' => $course->cost,
                                                'student_id' => $student->id
                                              ]
                                            ]
                          ];
                if(!empty($paymentData[$student->id]['addon_ids'])){
                  foreach ($paymentData[$student->id]['addon_ids'] as $key => $value) {
                    $this->loadModel('Addons');
                    $addon = $this->Addons->findById($value)->first();
                    $reqData['line_items'][] = [
                                                  'course_id' => $course->id,
                                                  'addon_id' => $addon->id,
                                                  'type' => 'online',
                                                  'amount' => $addon->price,
                                                  'student_id' => $student->id
                                              ];
                  }
                }
                // if($course->cost == $amountPaid){
                //   $paymentStatus = 'Paid';
                // }elseif($course->cost > $amountPaid){
                //   $paymentStatus = 'Partial';
                // }
                // pr($reqData);
                // pr('amount Paid');
                // pr($amountPaid);die;
                if($reqData['total_amount'] == $amountPaid){
                  $paymentStatus = 'Paid';
                }elseif($reqData['total_amount'] > $amountPaid){
                  $paymentStatus = 'Partial';
                }
              }else{
                // die('In Else');
                //payment when a user is a student who is logged in
                $reqData = [
                            'total_amount' => ($this->request->getSession()->read('finalAmount'))?($this->request->getSession()->read('finalAmount')):$course->cost,
                            'tenant_id' => $tenantId,
                            'student_id' => isset($student)?$student->id:$loggedInUser['id'],
                            'line_items' => [
                                              [
                                                'course_id' => $course->id,
                                                'type' => 'online',
                                                'amount' => $course->cost,
                                                'student_id' => isset($student)?$student->id:$loggedInUser['id']
                                              ]
                                            ]
                          ];

                if($this->request->getSession()->read('selected_addons')){
                  $addons = $this->request->getSession()->read('selected_addons');
                  foreach ($addons['addon_ids'] as $key => $value) {
                    $this->loadModel('Addons');
                    $addon = $this->Addons->findById($value)->first();
                    $reqData['line_items'][] = [
                                                  'course_id' => $course->id,
                                                  'addon_id' => $addon->id,
                                                  'type' => 'online',
                                                  'amount' => $addon->price,
                                                  'student_id' => $loggedInUser['id']
                                              ];
                  }
                }
                $paymentStatus = 'Paid';
                $amountPaid = $reqData['total_amount'];
              }
              $order = $this->Orders->newEntity();
              $order = $this->Orders->patchEntity($order, $reqData, ['associated' => 'LineItems']);
              // pr($order);pr($amountPaid);die;
              // $paymentStatus = 'Paid';
              $savePayment = $this->Orders->save($order, ['paymentCredentials' => $paymentAccessToken,'loggedInUser' => $loggedInUser, 'amountPaid' => $amountPaid, 'student'=> isset($student)?$student:null, 'paymentStatus'=> $paymentStatus]);

              // pr("savePayment");pr($savePayment);die;
              if($savePayment == true){
                $this->Flash->success(__('Payment has been successfully done.'));
                if($loggedInUser['role_id'] == 2){
                  $redirect = ['controller' => 'Courses', 'action' => 'view',$course->id];
                  $studentId = $student->id;
                }else{
                  $redirect = ['action' => 'thankYou'];
                  $studentId = $loggedInUser['id'];
                }
                $date = new FrozenTime();
                $date = $date->format('Y-m-d');
                $this->Students->CourseStudents->updateAll(
                                                    [  // fields
                                                        'payment_status' => $paymentStatus,
                                                        'registration_date' => $date,
                                                        'course_status' => 1
                                                    ],
                                                    [  // conditions
                                                        'student_id' => $studentId,
                                                        'course_id'=> $course->id
                                                    ]
                                                );
                return $this->redirect($redirect);
              }
              $this->Flash->error(__('Error while payment.'));              
          });
          
    }
    public function partialPayment($paymentAccessToken,$lineItemsData,$studentId,$amountPaid){
      $this->loadModel('TenantConfigSettings');
      $configSettings = $this->TenantConfigSettings->find()
                                             ->where(['tenant_id' => $lineItemsData[0]->order->tenant_id])
                                             ->first();
      $this->loadModel('Payments');
      // $this->loadModel('CourseStudents');
      $paymentInfo = $this->Payments->find();  
      $paymentInfo = $paymentInfo->select(['sumOfAmount'=> $paymentInfo->func()->sum('amount') ])
                              ->where([
                                    'AND' => [
                                      'order_id' => $lineItemsData[0]->order_id
                                    ],
                                    'OR'=>[
                                      ['payment_status' => 'Paid'],
                                      ['payment_status'=>'Partial']
                                    ]
                              ])
                         ->first()
                         ->sumOfAmount;
      if($configSettings->payment_mode == 'stripe'){
            $stripe = $this->loadComponent('Stripe');
            if($configSettings->sandbox == 1){
              $coursePayment = $stripe->chargeCards($amountPaid,$paymentAccessToken,$configSettings->stripe_test_private_key);
            } 
            if($configSettings->sandbox == 0){
              $coursePayment = $stripe->chargeCards($amountPaid,$paymentAccessToken,$configSettings->stripe_live_private_key);
            }
        }
      // pr($coursePayment);
      if($lineItemsData[0]->order->total_amount == ($paymentInfo+$amountPaid)){
         $paymentData = [
                          'student_id' => $studentId,
                            'tenant_id' => $lineItemsData[0]->order->tenant_id,
                            'payment_status' => 'Paid',
                            'order_id' => $lineItemsData[0]->order->id,
                            'amount' => $amountPaid,
                            'transaction' => [
                                                  // 'charge_id' => 'ch_1E7R5cF26LXDyeKyMf37VEOZ',
                                                  'charge_id' => $coursePayment['data']['id'],
                                                  'payment_method' => $configSettings->payment_mode,
                                                  'amount' => $amountPaid,
                                                  'remark' => 'Registration for New Course',
                                                  'status'=> 1,
                                                  'type'=> 'charge'
                                                ]
                            ]; 
      }
      if($lineItemsData[0]->order->total_amount > ($paymentInfo+$amountPaid)){
         $paymentData = [
                            'student_id' => $studentId,
                              'tenant_id' => $lineItemsData[0]->order->tenant_id,
                              'payment_status' => 'Partial',
                              'order_id' => $lineItemsData[0]->order->id,
                              'amount' => $amountPaid,
                              'transaction' => [
                                                    // 'charge_id' => 'ch_1E7R5cF26LXDyeKyMf37VEOZ',
                                                    'charge_id' => $coursePayment['data']['id'],
                                                    'payment_method' => $configSettings->payment_mode,
                                                    'amount' => $amountPaid,
                                                    'remark' => 'Registration for New Course',
                                                    'status'=> 1,
                                                    'type'=> 'charge'
                                                  ]
                              ];  
      }
       $payment = $this->Payments->newEntity();
       $payment = $this->Payments->patchEntity($payment, $paymentData, ['associated' => 'Transactions']);
        // pr($payment);die('inside');
        if(!$this->Payments->save($payment)){
            // pr($payment);
            $this->Flash->error(__('Payment And Transactions Not done'));
        }
        if($lineItemsData[0]->order->total_amount == ($paymentInfo+$amountPaid)){
          $this->Students->CourseStudents->getQuery()->update()->set(['payment_status' => 'Paid'])->where(['student_id' => $studentId,'course_id'=> $lineItemsData[0]->course_id])->execute();
        }
        // pr($payment);
        return;
        // die('here');        
    }

    public function bulkPayment($courseId= null , $requestData = null){
      // pr('In bulk payment');
      if($this->request->getSession()->read('selected_course') == null){
        $this->request->getSession()->write('selected_course',$courseId); 
      } 
      // pr($this->request->getSession()->read('studentsInfo'));die;
      $this->viewBuilder()->setLayout('student-layout');
      if($this->request->is('post')){
              $data = $this->request->getData();
              $data['bulkPayment'] = 1;
              // pr($data);pr('in bulk payment post');die;
              // CHECK IF EMAIL NEED TO BE SENT OR NOT
              $billingDetails = [
                                  'first_name' => $data['first_name'],
                                  'last_name' => $data['last_name'],
                                  'email' => $data['email'],
                                  'phone' => $data['phone']
                                ];
              // pr($billingDetails);die;                  
              if(!isset($data['email_flag'])){
                $data['email_flag'] = 0;
              } else {
                $data['email_flag'] = 1;
              }
              if(!$data['stripeToken']){
                $this->Flash->error(__('Payment access token not found. Please try again later.'));
                return $this->redirect(['action' => 'bulkPayment',$courseId,$requestData]);
              }
               $amount = $this->request->getSession()->read('finalAmount');
               $connection = ConnectionManager::get('default');
               $response = $connection->transactional(function () use($data, $requestData, $amount,$billingDetails) {
                    if(empty($this->request->getData('studentDetails'))){
                      return $this->redirect(['action' => 'bulkPayment',$courseId,$requestData]);
                    }
                    $this->loadModel('Courses');
                    $course = $this->Courses->findByPrivateCourseUrl($requestData)
                                            ->contain(['Locations','TrainingSites','CourseDates','CourseTypes.Agencies'])
                                            ->first();
                    
                    $saveStudents = $this->Students->registerStudents($this->request->getData('studentDetails'), $course,$data['email_flag'],1);
                    //-------------CODE TO CHECK IF PROMOCODE IS APPLIED OR NOT-------------------
                    if($this->request->getSession()->read('appliedPromocodeId')){
                      $appliedPromocodeId = $this->request->getSession()->read('appliedPromocodeId');
                    } else {
                      $appliedPromocodeId = null;
                    }
                    //----------------------------------------------------------------------------
                    if($saveStudents['status'] == null){
                      // error throw
                      $this->Flash->error(__('Details not found!'));
                      return $this->redirect(['action' => 'classes']); 
                    }
                    //------------------------LINE ITEMS SAVE DATA--------------------------------
                    $reqData = [
                                      'total_amount' => $amount,
                                      'tenant_id' => $course->tenant_id,
                                      // 'promo_code_id' => $this->request->session()->read('appliedPromocodeId') ?$this->request->session()->read('appliedPromocodeId'):'';
                                ];
                    $reqData['line_items'] = [];
                    foreach ($saveStudents['students'] as $key => $student) {
                      $reqData['line_items'][] = [
                                                    'course_id' => $course->id,
                                                    'type' => 'online',
                                                    'amount' => $course->cost,
                                                    'student_id' => $student->id
                                                  ];
                    }
                    //-------------------CODE TO CHECK SELECTED ADDONS IF ANY--------------------
                  if($this->request->getSession()->read('selected_addons')){
                    $addons = $this->request->getSession()->read('selected_addons');
                    foreach ($addons['addon_ids'] as $key => $value) {
                      $this->loadModel('Addons');
                      $addon = $this->Addons->findById($value)->first();
                      foreach($saveStudents['students'] as $key=>$student){
                      $reqData['line_items'][] = [
                                                    'course_id' => $course->id,
                                                    'addon_id' => $addon->id,
                                                    'type' => 'online',
                                                    'amount' => $addon->price,
                                                    'student_id' => $student->id
                                                ];
                        }
                    }
                  } 
                  //------------------------------------------------------------------------------
                  //--------------------END OF ORDERS AND LINE ITEMS DATA-------------------------
                      $paymentStatus = 'Paid';
                      $amountPaid = $reqData['total_amount'];
                      // pr($reqData);die;
                      $savedDetails = $this->saveBulkStudentPayments($data['stripeToken'], $course,$saveStudents['students'], $amount,$reqData['line_items'],$appliedPromocodeId,$requestData,$billingDetails);
                      // pr($savedDetails);die;
                      if($savedDetails){
                        // pr($savedDetails);die;
                        $this->request->getSession()->write('student_ids', $savedDetails['student_ids']);
                        $this->Flash->success(__("Student(s) sucesfully registered!"));
                        return $this->redirect(['action'=> 'thankYou']);
                      } else {
                         $this->Flash->error(__("Student(s) could not be saved!"));
                        return $this->redirect(['action'=> 'bulkPayment']);
                      }
              });// END OF TRANSACTIONAL FUNCTION
          }else{
            $this->privateCourse($courseId,$requestData);
          } // END OF $this->request->is('post')'s ELSE
          $loggedInUser = $this->Auth->user();
          $this->set(compact('loggedInUser'));
    }// END OF BULK PAYMENT FUNCTION


    public function saveBulkStudentPayments($paymentAccessToken, $course,$students, $amountPaid = null,$lineItemData,$appliedPromocode = null,$hashData,$billingDetails){ 

        $this->loadModel('Orders');
        $this->loadModel('Payments');
            // pr($billingDetails);die('in next function');
            if(empty($paymentAccessToken)){
              $this->Flash->error(__('Payment access token not found. Please try again later.'));
              return $this->redirect(['action' => 'bulkPayment']);
            }
            if(!isset($course) && !$course){
              $this->Flash->error(__('Course not found for which you are going to pay.'));
              return $this->redirect(['action' => 'bulkPayment']);
            }
      //------------------------------ORDER AND LINE ITEM DATA-------------------------------------
          
        //   $connection = ConnectionManager::get('default');
        //   $response = $connection->transactional(function () use($paymentAccessToken, $course,$students, $amountPaid ,$lineItemData,$appliedPromocode,$hashData,$billingDetails) {

        $reqData = [];
        $reqData = [
                    'promo_code_id' => $appliedPromocode,
                    'total_amount' => $amountPaid,
                    'tenant_id' => $course->tenant_id,
                    'student_id' => null,
                    'line_items'=> $lineItemData,
                   ];
                   
        $order = $this->Orders->newEntity();
        $order = $this->Orders->patchEntity($order, $reqData, ['associated' => 'LineItems']);
        $order['bulk'] = 1;
        //--------------------------------AFTERSAVE CALLED BELOW-----------------------------------
        
        $savePayment = $this->Orders->save($order, ['paymentCredentials' => $paymentAccessToken, 'amountPaid' => $amountPaid, 'student'=> null, 'paymentStatus'=> 'Paid','billingDetails' => $billingDetails]);
        $studentIds = (new Collection($savePayment['line_items']))->extract('student_id')->toArray();
        // pr('savePayment in aftersave response');
        // pr($savePayment);die;
        
        // pr($hashData);die;
        
        // if(isset($savePayment['status']) && $savePayment['status'] == false){
        //   $this->Flash->error(__('Error Stripe Key is Missing'));
        //   return $this->redirect(['action'=> 'bulkPayment',$course->id,$hashData]);
        // }
        $ids = array_unique($studentIds);
        if($savePayment){
            // pr($savePayment);die('here');
          return $data = ['student_ids' => $ids];
        } else {
          $this->Flash->error(__('Some error occoured!'));
          return false;
        }
        // pr($response);die;
        // });
        if(!empty($response)){
            return $response;
        } else {
            return false;
        }
        // pr($response);die('response');
          
  }      

     public function paymentInfo($courseId = null){
      // pr($courseId);die;
      $this->viewBuilder()->setLayout('student-layout');
      // pr($selected_course);die;
      $this->loadModel('Courses');
      $course = $this->Courses->findById($courseId)
                              ->contain(['CourseTypes','CourseDates','Locations','CourseAddons'])
                              ->first();
      // pr($course);die;
      $loggedInUser = $this->Auth->user();
      $id = $loggedInUser['id'];                        
      $this->loadModel('LineItems');
      $orderDetails = $this->Students->LineItems->findByStudentId($id)
                                                ->contain(['Orders','Orders.Payments','Orders.Payments.Transactions','Addons'])
                                                ->where(['course_id' => $courseId])
                                                ->toArray();
      $finalAmount = (new Collection($orderDetails[0]['order']['payments']))->sumOf(function($orderDetail)
          {
        return $orderDetail['transaction']['amount'];
          });
      // pr($orderDetails);die;
      $loggedInUser = $this->Auth->user();
      $id = $loggedInUser['id'];
      $student = $this->Students->get($id, [
          'contain' => []
      ]);
      $this->set(compact('course','loggedInUser','addon','finalAmount','orderDetails'));

     }

    public function privateCourse($courseId = null,$requestData = null){
      
      $this->loadModel('Courses');
      $loggedInUser = $this->Auth->user();
      if($loggedInUser['role_id'] != 5 && is_null($courseId)){
          $courseId = $this->Courses->findByPrivateCourseUrl($this->request->getQuery('course-hash'))
                                    ->first()->id;
      }
      // pr($courseId);die;
      // if(isset($requestType)){
      // // pr($requestType);die;
      // $this->redirect(['action' => 'classes']); 
      // }      
        // pr($this->request->session()->read('selected_course'));die('here');
      if(!$this->request->getSession()->read('selected_course')){
          $this->request->getSession()->write('selected_course',$courseId);
      }
        // pr($requestData);die;
        // pr($loggedInUser);die;
        $this->loadModel('CourseStudents');
        $getTenantId = $this->Courses->findById($courseId)->extract('tenant_id')->first();
        // pr($getTenantId);die;
        $courseStudent = $this->CourseStudents->findByStudentId($loggedInUser['id'])
                                              ->where(['course_id'=> $courseId])
                                              ->first();
        if(!empty($courseStudent)){
          if($courseStudent->payment_status == 'Paid'){
            $this->redirect(['action' => 'payment_info',$courseId]);
          }
        }
    
        $this->loadModel('TenantConfigSettings');
        $requestData = $this->request->getQuery('course-hash');
        $paymentMethod = $this->TenantConfigSettings->findByTenantId($loggedInUser['tenant_id'])->extract('payment_mode')->first();        
        $tenantConfigSettings = $this->TenantConfigSettings->findByTenantId($getTenantId)->first();
        // pr($tenantConfigSettings);die;
        $tenant = $this->Tenants->findById($getTenantId)->contain(['TenantConfigSettings'])->first();
          if($tenantConfigSettings->payment_mode == "stripe"){
            if($tenantConfigSettings->sandbox == 1){
              $this->set('stripePublishedKey', $tenantConfigSettings->stripe_test_published_key);
            }
            if($tenantConfigSettings->sandbox == 0){
              $this->set('stripePublishedKey', $tenantConfigSettings->stripe_live_published_key);
            }
          }
        $this->viewBuilder()->setLayout('student-layout');
        // $this->loadModel('Courses');
        $course = $this->Courses->findById($courseId)
                                ->contain(['Locations','CourseDates','TrainingSites','CourseAddons.Addons', 'CourseTypes.Agencies'])
                                ->first();


        $session = $this->request->getSession();
        $session->write('selected_course',$course->id);
        $loggedInUser = $this->Auth->user();        
        if($loggedInUser['role_id'] == 5){
          $student = $this->Students->get($loggedInUser['id']);
        }else{
          $student = $this->Students->newEntity();
        }
        if ($this->request->is('post')) {
            $data = $this->request->getData();     
            // pr($data);die;     
          if(isset($data['loginStudent'])){
            $user = $this->Auth->identify();
            // pr($user);die;
          } else {
            // pr('nahi set hai boss');die;
          }  
          // pr($this->request->getData());die('in privateCourse function');


          if($this->payNow($data, $course)){
            $this->paymentConfirmation($student,$course,$paymentMethod);
            $this->conurseRegistrationConfirmation($student,$course);
          }
        }

        if($this->request->getSession()->read('finalAmount')){
          $this->set('finalAmount', $this->request->getSession()->read('finalAmount'));
        }

        if($this->request->getSession()->read('selected_addons')){

          $selectedAddons = $this->request->getSession()->read('selected_addons');
          if(sizeof($selectedAddons['addon_ids'] != 0)){
            $this->set('addonIds', $selectedAddons['addon_ids']);
          }
        }
        // pr($this->request->host());die;
        // pr($course);pr($student);pr($loggedInUser);die;
        
        // pr('here');die;
        $this->set(compact('course','loggedInUser','student','requestData','tenant'));

    }

    public function classes(){
      if($this->request->getSession()->read('finalAmount')){
        $this->request->getSession()->write('finalAmount',0);
      }
      if($this->request->getSession()->read('selected_addons')){
        $files['addon_ids'] = [];
        $this->request->getSession()->write('selected_addons',$files);
      }
      $loggedInUser = $this->Auth->user();
      $this->viewBuilder()->setLayout('student-layout');
       
      $this->loadModel('Tenants');
      $url = Router::url('/', true);
      if($url == "http://localhost/classbyte/"){
        $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      }else{
        $domainType = "http://$_SERVER[HTTP_HOST]";
      }
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $tenant = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
      if(!isset($tenant) && empty($tenant)){
        throw new NotFoundException(__('Tenant Not Found'));
      }
      $today = new Date();
      // pr($today);die; 
      $this->loadModel('Courses');
      // $courses = $this->Courses->find()
      //                                ->contain(['CourseDates' => function($q)use($today){
      //                                 return $q->where(['CourseDates.course_date >=' => $today]);
      //                                }])
      //                                ->where(['Courses.tenant_id'=>$tenant->id, 'Courses.status NOT IN' => 'draft'])
      //                                ->order(['Courses.created' => 'DESC'])
      //                                ->all()
      //                                ->toArray();
                                     // pr($courses); die();
      $this->set(compact('courses','loggedInUser'));
    }

    public function calender(){
      $this->viewBuilder()->setLayout('student-layout');
      $this->loadModel('Tenants');
      $domainType = "http://$_SERVER[HTTP_HOST]";
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $tenant = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
      if(!isset($tenant) && empty($tenant)){
        throw new NotFoundException(__('Tenant Not Found'));
      }
      
      $this->loadModel('Courses');
      $courses = $this->Courses->find()
                                     ->contain(['Locations','CourseDates','CourseTypes'])
                                     ->where(['Courses.tenant_id'=>$tenant->id, 'Courses.status NOT IN' => 'draft'])
                                     ->order(['Courses.created' => 'DESC'])
                                     ->all()
                                     ->toArray();
                                     // pr($courses); die();
      $this->set(compact('courses')); 
    }

    /**
     * Course History method
     *
     * @return \Cake\Http\Response|void
     */
    public function courseHistory(){
      $this->viewBuilder()->setLayout('student-layout');
      $loggedInUser = $this->Auth->user();
      $this->loadModel('CourseStudents');

      $history = $this->CourseStudents->find()
                                     ->where(['student_id' => $loggedInUser['id']])
                                     ->contain(['Courses','Courses.Locations','Courses.CourseDates','Courses.CourseAddons.Addons','Courses.CourseTypes'])
                                     ->all()
                                     ->toArray();
                                     // pr($history); die();
      $this->set(compact('history'));
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index(){

      $loggedInUser = $this->Auth->User();
      $this->loadModel('IndexSettings');
      $indexSettings = $this->IndexSettings->findByForId($loggedInUser['id'])->where(['index_name'=>'Students'])->extract('meta')->last();
      // pr($indexSettings);die;
      // $loggedInUser = $this->Auth->user();
      // $this->loadModel('SubcontractedClients');

      // // pr($loggedInUser);die('ssss');
      // $students = $this->Students->find()->all();
      // if($loggedInUser['role']->name == self::TENANT_LABEL){
      //     $subcontractedClients = $this->SubcontractedClients->find()->indexBy('id')->toArray();
      //     $trainingSites = $this->Students->TrainingSites->find()->indexBy('id')->toArray();
      //     $corporateClients = $this->Students->CorporateClients->find()->indexBy('id')->toArray();

      //     $students = $this->Students->find()
      //                                 ->where(['Students.tenant_id ='=>$loggedInUser['tenant_id']])
      //                                 ->all()
      //                                 ->toArray();
                                      
      // }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
      //     $subcontractedClients = $this->SubcontractedClients->find()->indexBy('id')->toArray();
      //     $trainingSites = $this->Students->TrainingSites->find()->indexBy('id')->toArray();
      //     $corporateClients = $this->Students->CorporateClients->find()->indexBy('id')->toArray();

      //     $students = $this->Students
      //                               ->find()
      //                               ->all();
      //   }else if($loggedInUser['role']->name == self::CLIENT_LABEL){
      //     $this->loadmodel('TrainingSites');
      //     $subcontractedClients = $this->SubcontractedClients->find()->indexBy('id')->toArray();
      //     $trainingSites = $this->Students->TrainingSites->find()->indexBy('id')->toArray();
      //     $corporateClients = $this->Students->CorporateClients->find()->indexBy('id')->toArray();

      //     $students = $this->Students
      //                               ->find()
      //                               ->where(['Students.corporate_client_id ='=>$loggedInUser['corporate_client_id']])
      //                               ->toArray();
      //   }
      //   if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
      //     $subcontractedClients = $this->SubcontractedClients->find()->indexBy('id')->toArray();
      //     $trainingSites = $this->Students->TrainingSites->find()->indexBy('id')->toArray();
      //     $corporateClients = $this->Students->CorporateClients->find()->indexBy('id')->toArray();

      //       $students = $this->Students->find()
      //                                 ->where(['Students.training_site_id ='=>$loggedInUser['training_site_id']])
      //                                 ->toArray();
      //   }
        $this->set(compact('indexSettings','loggedInUser'));
        // $this->set(compact('students','subcontractedClients','trainingSites','corporateClients'));
    }

    /**
     * dashboard method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function dashboard(){
      $loggedInUser = $this->Auth->user();
      $this->set(compact('loggedInUser'));

    }

    public function makePayment(){
      pr($this->request->getData());die('ss');
    }
    

    /**
     * View method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['TrainingSites', 'Tenants', 'CorporateClients', 'SubcontractedClients']
        ]);

        $this->set('student', $student);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $student = $this->Students->newEntity();

        $loggedInUser = $this->Auth->user();
        $trainingSiteOwner = "";
        // pr($loggedInUser); die;
        if ($this->request->is('post')) {
          if($loggedInUser['role_id'] == 2 && isset($loggedInUser['training_site_id'])){
              $this->_RequestData['training_site_id'] = $loggedInUser['training_site_id'];
          }
          if($loggedInUser['role']->name == 'corporate_client'){
                $this->_RequestData['corporate_client_id'] = $loggedInUser['corporate_client_id'];
                $this->_RequestData['tenant_id'] = $loggedInUser['corporate_client']['tenant_id'];
                $this->_RequestData['training_site_id'] = $loggedInUser['corporate_client']['training_site_id'];
                $this->_RequestData['role_id'] = 5;
                $this->_RequestData['status'] = 1;
            }
            if($loggedInUser['role']->name == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
                $this->_RequestData['role_id'] = 5;
                $this->_RequestData['status'] = 1;

            }
            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
              $this->_RequestData['training_site_id'] = $loggedInUser['training_site_id'];
            }
            
            if(empty($this->_RequestData['subcontracted_client_id'])){
                $this->_RequestData['subcontracted_client_id'] = null;
            }
            $student = $this->Students->patchEntity($student, $this->_RequestData);
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            
            $tenants = $this->Students->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
          $trainingSites = $this->Students->TrainingSites->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        $corporateClients = $this->Students->CorporateClients->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        $subcontractedClients = $this->Students->SubcontractedClients->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
            
        }elseif($loggedInUser['role']->name == self::CLIENT_LABEL){
           // pr($loggedInUser['corporate_client']['tenant_id']); die('ss');
         
        
        $subcontractedClients = $this->Students->SubcontractedClients->find()
                                                ->where(['corporate_client_id' => $loggedInUser['corporate_client_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
            
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL)  {
            $tenants = $this->Students->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->Students->TrainingSites->find()->all()->combine('id','name')->toArray();
            $corporateClients = $this->Students->CorporateClients->find()->all()->combine('id','name')->toArray();
            $subcontractedClients = $this->Students->SubcontractedClients->find()->all()->combine('id','name')->toArray();

        }if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          
          $corporateClients = $this->Students->CorporateClients->find()
                                            ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                            ->all()
                                            ->combine('id','name')
                                            ->toArray();
        }
        
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('student', 'trainingSites', 'tenants', 'corporateClients', 'subcontractedClients'));
    }
    /**
     * sign_up method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function signUp(){
      
      $this->viewBuilder()->setLayout('popup-view');
      $this->loadModel('Tenants');
      $domainType = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      // $domainType = Router::url('/', true);
      // $domainType = 'http://cmc.classbyte.twinspark.co/tenants/login';
      $values = parse_url($domainType);
      $host = explode('.',$values['host']);
      $tenantData = $this->Tenants->find()->contain('TrainingSites')->where(['domain_type LIKE' => '%'.$host[0].'%'])->first();
      if(isset($tenantData) && !empty($tenantData)){
          $student = $this->Students->newEntity();
          if ($this->request->is('post')) {
              $data = $this->request->getData();
              // pr($data);die;
              $data['tenant_id'] = $tenantData->id;
              $data['corporate_client_id'] = 1;
              $data['status'] = 1;
              $data['training_site_id'] = (!isset($tenantData->training_sites[0]->id) || is_null($tenantData->training_sites[0]->id)) ? 'null' : $tenantData->training_sites[0]->id;
              $data['role_id'] = 5;
              $student = $this->Students->patchEntity($student, $data);

              if ($this->Students->save($student)) {
                  $this->Flash->success(__('The student has been saved.'));
                  return $this->redirect(['action' => 'login']);
              }
              $this->Flash->error(__('The student could not be saved. Please, try again.'));
          }
          $this->set(compact('tenantData','student'));
      }else{
         throw new NotFoundException(__('You are accessing some wrong page, Please contact admin'));
      }

    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser);die;
        if($loggedInUser['role']['name'] == 'student'){

        $this->viewBuilder()->setLayout('student-layout');
        }
        $trainingSiteOwner = "";
        $student = $this->Students->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
          if($loggedInUser['role_id'] == 2 && isset($loggedInUser['training_site_id'])){
              $this->_RequestData['training_site_id'] = $loggedInUser['training_site_id'];
          }
          if(isset($this->_RequestData['corporate_client_id']) && !is_numeric($this->_RequestData['corporate_client_id'])){
                $this->_RequestData['corporate_client_id'] = null;
            }
            if(isset($this->_RequestData['subcontracted_client_id']) && !is_numeric($this->_RequestData['subcontracted_client_id'])){
                $this->_RequestData['subcontracted_client_id'] = null;
            }
            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
              $this->_RequestData['training_site_id'] = $loggedInUser['training_site_id'];
            }
            $student = $this->Students->patchEntity($student, $this->_RequestData);
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));
                if($loggedInUser['role']->name == 'student'){
                  return $this->redirect(['action' => 'edit',$student->id]);
                }
            }else{
              
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            if(isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id']){
                $trainingSiteOwner = $loggedInUser['training_site_id'];
            }
            $tenants = $this->Students->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
          $trainingSites = $this->Students->TrainingSites->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        $corporateClients = $this->Students->CorporateClients->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        $subcontractedClients = $this->Students->SubcontractedClients->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
            
        }elseif($loggedInUser['role']->name == self::CLIENT_LABEL){
          $trainingSites = $this->Students->TrainingSites->find()
                                                ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        
        $subcontractedClients = $this->Students->SubcontractedClients->find()
                                                ->where(['corporate_client_id' => $loggedInUser['corporate_client_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();


            
        }elseif($loggedInUser['role']->name == self::STUDENT_LABEL){
           
          $trainingSites = $this->Students->TrainingSites->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        
        $subcontractedClients = $this->Students->SubcontractedClients->find()
                                                ->where(['corporate_client_id' => $loggedInUser['corporate_client_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
      
        $corporateClients = $this->Students->CorporateClients->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
            
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL)  {
            $tenants = $this->Students->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->Students->TrainingSites->find()->all()->combine('id','name')->toArray();
            $corporateClients = $this->Students->CorporateClients->find()->all()->combine('id','name')->toArray();
            $subcontractedClients = $this->Students->SubcontractedClients->find()->all()->combine('id','name')->toArray();

        }
        if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          
          $corporateClients = $this->Students->CorporateClients->find()
                                            ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                            ->all()
                                            ->combine('id','name')
                                            ->toArray();
        }
        
        $this->set('loggedInUser', $loggedInUser);
        $this->set('trainingSiteOwner', $trainingSiteOwner);
        $this->set(compact('student', 'trainingSites', 'tenants', 'corporateClients', 'subcontractedClients'));
    }
     /**
     * Register method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

     public function register(){
      $this->viewBuilder()->setLayout('student-layout');
      $this->loadModel('Tenants');
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      $url = Router::url('/', true);
      if($url == "http://localhost/classbyte/"){
        $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      }else{
        $domainType = "http://$_SERVER[HTTP_HOST]";
      }
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $tenant = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
      if(!isset($tenant) && empty($tenant)){
        throw new NotFoundException(__('Tenant Not Found'));
      }
      $this->loadModel('Roles');
      // pr($tenant->id); die();
      // pr($this->request); die(); 

      $register = $this->Students->newEntity();
        
        if ($this->request->is('post')) {
          // pr($this->_RequestData);die;

            if(isset($this->_RequestData['course_flag'])){
              $course_flag = $this->_RequestData['course_flag'];
            }
            if($this->_RequestData['password'] !== $this->_RequestData['confirm_password']){
              $this->Flash->error(__('Passwords do not match!'));
              return $this->redirect(['action' => 'classes']); 
            }
            $this->_RequestData['tenant_id'] = $tenant->id;
            $this->_RequestData['role_id'] = 5;
            $this->_RequestData['status'] = 1;
            // pr($this->_RequestData);die;
            $register = $this->Students->patchEntity($register, $this->_RequestData);
            // pr($register); die();
            if ($this->Students->save($register)) {

            $this->Flash->success(__('The student has been saved!'));
            $register = $this->Auth->identify();
            if ($register && ($register['tenant_id'] == $tenant->id)) {
                $register['role']= $query = $this->Roles->find('RolesById',['role' =>$register['role_id']])->select(['name','label'])->first();

                
                $tenantDisabled = $this->Tenants->findById($register['tenant_id'])->first();
                if($tenantDisabled->status != 1) {
                  $this->Flash->error('Your Tenant has been disabled. Please contact Super Admin');
                  return null;
                }
                
                if($register['status'] != 1){
                  $this->Flash->error('You have been disabled. Please contact your Tenant for details!');
                  return null;
                }

              $this->Auth->setUser($register);
              if(!$register){
                $this->Flash->error('Please enter correct email or password!');
                $this->redirect(['controller' => 'Students','action' => 'login']);
              }
              if(isset($course_flag) && $course_flag == 1){
                  $this->redirect( Router::url( $this->referer(), true ) );
              }

              if( !empty($query) && $query->name == 'student'){
                  $this->redirect(['controller' => 'Students','action' => 'classes']);
              }
          }

            // pr($register); die();
            
            // pr($course_flag); die(); 

              // $this->Flash->success(__('The student has been registered.'));
              // return $this->redirect(['action' => 'register']);
            } else {
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
            }            
        }
        $this->set(compact('register'));
    }
    // public function notFound(){
    //   $this->viewBuilder()->setLayout('popup-view');
    // }

    /**
     * Login method
     *
     * @param string|null $id Corporate Client User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function login(){
          $this->viewBuilder()->setLayout('student-login');
          $this->loadModel('Tenants');
          $this->loadModel('Roles');
          $this->loadModel('Students');
          $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          // $domainType = "http://$_SERVER[HTTP_HOST]";
          // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          $tenantData = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
          if(isset($tenantData) && !empty($tenantData)){
              $this->set(compact('tenantData'));
          }else{

            $this->viewBuilder()->setTemplate('not-found');
             
          }

          if ($this->request->is('post')) {
              $user = $this->Auth->identify();
            
            
              $this->Cookie->write('loginAction', ['controller' => 'Students', 'action' => 'login']);
               
              if ($user && ($user['tenant_id'] == $tenantData['id'])) {
                  $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();

                  
                  $tenantDisabled = $this->Tenants->findById($user['tenant_id'])->first();
                  if($tenantDisabled->status != 1) {
                    $this->Flash->error('Your Tenant has been disabled. Please contact Super Admin');
                    return null;
                  }
                  
                  if($user['status'] != 1){
                    $this->Flash->error('You have been disabled. Please contact your Tenant for details!');
                    return null;
                  }

                  
              $this->Auth->setUser($user);
              if(!$user){
                $this->Flash->error('Please enter correct email or password!');
                $this->redirect(['controller' => 'Students','action' => 'login']);
              }
              if( !empty($query) && $query->name == 'student'){
                  $this->redirect(['controller' => 'Students','action' => 'classes']);
              }
              }elseif($user){
                $this->Flash->error('You do not belong to this Tenant. Please contact Superadsmin');
                $this->redirect(['controller' => 'Students','action' => 'login']);
              }elseif(!$user){
                $this->Flash->error('Please enter correct email or password!');
                $this->redirect(['controller' => 'Students','action' => 'login']);
              }
          }
      }
      public function forgotPassword(){
      if($this->Auth->user()){
        $this->Flash->error("UNAUTHORIZED REQUEST");
        $this->redirect(['action' => 'logout']);
      }
      $this->viewBuilder()->setLayout('student-layout');
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
            // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          
      if ($this->request->is('post')) {
        $email = $this->request->getData('email');
        $students = $this->Students->find()
                                        ->where(['Students.email' => $email])
                                        ->contain(['Tenants' => function($q) use($domainType){
                                          return $q->where(['domain_type LIKE' => '%'.$domainType.'%']);
                                        }])
                                        ->first();
       
        if(!$students){
          return $this->Flash->error(__("This email doesn't exist for this student."));
        }
        $this->loadModel('StudentResetPasswordHashes');
        $hashResetPassword = $this->StudentResetPasswordHashes->find()->where(['student_id' => $students->id])->first();

        if(empty($hashResetPassword)){
          $resetPwdHash = $this->_createResetPasswordHash($students->id);
        }else{
          $resetPwdHash = $hashResetPassword->hash;
          $time = new Time($hashResetPassword->created);
          if(!$time->wasWithinLast(1)){
            $this->StudentResetPasswordHashes->delete($hashResetPassword);
            $resetPwdHash =$this->_createResetPasswordHash($students->id);
          }
        }
        $url = Router::url('/', true);
        $url = $url.'students/resetPassword/?reset-token='.$resetPwdHash;
        $email = new Email('default');
        $emailBody = '<p><span style="font-weight: 400;">Hi '.$students->first_name.',<br /></span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">We have received a request to reset your password. Please use the following link to reset your password '.$url.'.<br /></span><span style="font-weight: 400;">If you did not request this password change, you can contact us at '.$students->tenant->email.'.<br /><br /></span><span style="font-weight: 400;">Thank you,</span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';

        $email->setTo($students->email)
              ->setSubject('Reset Password Link')
              ->emailFormat('html')
              ->send($emailBody);

        $this->Flash->success(__('Please check your email to verify yourself and change your password'));
        $this->redirect(['action' => 'login']);

       }
    }

    protected function _createResetPasswordHash($studentId){
      
        $this->loadModel('StudentResetPasswordHashes');
        $resetPasswordrequestData = $this->StudentResetPasswordHashes->find()
                                                                    ->where(['student_id' =>$studentId ])
                                                                    ->first();
        if($resetPasswordrequestData){
            return $resetPasswordrequestData->hash;
        }
        $hasher = new DefaultPasswordHasher();
        $reqData = ['student_id'=>$studentId,'hash'=> $hasher->hash($studentId)];
        $createPasswordhash = $this->StudentResetPasswordHashes->newEntity($reqData);
        $createPasswordhash = $this->StudentResetPasswordHashes->patchEntity($createPasswordhash,$reqData);
        if($this->StudentResetPasswordHashes->save($createPasswordhash)){
          return $createPasswordhash->hash;
      }else{
        Log::write('error','error in creating resetpassword hash for user id '.$studentId);
        Log::write('error',$createPasswordhash);
      }
        return false;
    }

    public function resetPassword(){
        $this->viewBuilder()->setLayout('login-admin-override');
        $resetToken = $this->request->query('reset-token');
        if ($this->request->is('post')) {
          $uuid = (isset($this->_RequestData['reset-token']))?$this->_RequestData['reset-token']:'';
          if(!$uuid){
            $this->Flash->error(__('BAD REQUEST'));
            $this->redirect(['action' => 'login']);
            return;
          }
          $password = (isset($this->_RequestData['new_pwd']))?$this->_RequestData['new_pwd']:'';
          if(!$password){
            $this->Flash->error(__('PROVIDE PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }
          $cnfPassword = (isset($this->_RequestData['cnf_new_pwd']))?$this->_RequestData['cnf_new_pwd']:'';
          if(!$cnfPassword){
            $this->Flash->error(__('CONFIRM PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }
          // pr($uuid);
          if($password !== $cnfPassword){
            $this->Flash->error(__('MISMATCH PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }
           // pr($uuid);

          $this->loadModel('StudentResetPasswordHashes');
          $checkExistPasswordHash = $this->StudentResetPasswordHashes->find()->where(['hash'=>$uuid])->first();
          // pr($checkExistPasswordHash);die;
          if(!$checkExistPasswordHash){
            $this->Flash->error(__('INVALID RESET PASSWORD'));
            $this->redirect(['action' => 'login']);
            return;
          }
           $user = $this->Students->findById($checkExistPasswordHash->student_id )->first();
           if(!$user){
            $this->Flash->error(__("User Doesn't exist."));
            $this->redirect(['action' => 'login']);
            return;
           }
           $reqData = ['password'=>$password];
           $hasher = new DefaultPasswordHasher();

           $user = $this->Students->patchEntity($user, $reqData);
            if($this->Students->save($user)){
                $data =array();
                $data['status']=true;
                $data['data']['id']=$user->id;
                $this->Flash->success("Password reset successfully");
                return $this->redirect(['action' => 'login']);
            }else{
                throw new InternalErrorException("Something went wrong, try after some time!");
            }
            $this->set('response',$data);
            $this->set('_serialize', ['response']);
        }

        $this->set('resetToken',$resetToken);
        $this->set('_serialize', ['reset-token']);
    }


    /**
     * Delete method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete','get']);
        $student = $this->Students->get($id);
        if ($this->Students->delete($student)) {
            $this->Flash->success(__('The student has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function logout(){
        $this->Auth->logout();
        return $this->redirect(['controller' => 'Students','action' => 'login']);
    }


     public function updateStatus($id = null)
    {

        $query = $this->request->getAttribute('params')['pass'];
        $student_id = $query[0];
        $this->request->allowMethod(['post','get']);
        $student = $this->Students->get($student_id);
        if($student){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $student['status'] = $status;
          // $tenant = $this->Tenants->patchEntity($tenant, $tenantData);
          $student = $this->Students->save($student);
            if($student){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    public function paymentConfirmation($student,$course,$paymentMethod){
      // die('chchchc');
      $emailData1 = [
          "first_name" => $student->first_name,
          'email' => $student->email,
          'training_site_name' => $course->training_site->name,
          'course_id' => $course->id,
          'course_type' => $course->course_type->name,
          'course_type_agency' => $course->course_type->agency->name,
          'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
          'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
          'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
          'location_name' => $course->location->name,
          'location_address' => $course->location->address,
          'location_city' => $course->location->city,
          'location_state' => $course->location->state,
          'location_zipcode' => $course->location->zipcode,
          'course_payment_date' => Time::now()->format('Y-m-d'),
          'course_payment_method' => $paymentMethod,
          'course_amount' => $course->cost,
          'training_site_phone' => $course->training_site->contact_phone,
          'training_site_email' => $course->training_site->contact_email
        ];
        // pr($emailData1);die;
        $event = new Event('course_payment_confirmation', $this, [
             'hashData' => $emailData1,
             'tenant_id' => $course->tenant_id
        ]);
        $this->getEventManager()->dispatch($event);
    }
    public function conurseRegistrationConfirmation($student,$course){
       $emailData = [
          "first_name" => $student->first_name,
          'email' => $student->email,
          'training_site_name' => $course->training_site->name,
          'course_id' => $course->id,
          'course_type' => $course->course_type->name,
          'course_type_agency' => $course->course_type->agency->name,
          'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
          'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
          'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
          'location_name' => $course->location->name,
          'location_address' => $course->location->address,
          'location_city' => $course->location->city,
          'location_state' => $course->location->state,
          'location_zipcode' => $course->location->zipcode,
          'user_email' => $student->email,
          'server_name' => $this->request->host()
        ];
        // pr($emailData);die;
        $event = new Event('course_registration_confirmation', $this, [
             'hashData' => $emailData,
             'tenant_id' => $course->tenant_id
        ]);
        $this->getEventManager()->dispatch($event);
    }
}
