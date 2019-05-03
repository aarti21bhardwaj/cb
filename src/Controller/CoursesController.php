<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Routing\Router;
use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\BadRequestException;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Event\Event;
use Robotusers\Excel\Registry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls; 
use Cake\Http\Session;

/**
 * Courses Controller..
 *
 * @property \App\Model\Table\CoursesTable $Courses
 *
 * @method \App\Model\Entity\Course[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{   

    public $helpers = ['Cewi/Excel.Excel'];

    public function ahaECard($id = null){
        $data = $this->request->getData();
        if(empty($data['mychecklist'])){
            $this->Flash->error(__('Please select a student before printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }

        $course = $this->Courses->findById($id)->contain(['CourseDates'])->first();
        if(!empty($course->course_dates)){
            $courseDate = $course->course_dates[0]->course_date->format('m/d/Y');
        }else{
            $courseDate = '';
        }

        $students = $this->Courses->CourseStudents->Students->find()
                                                            
                                                            ->matching('CourseStudents', function($q) use($data){
                                                                return $q->where(['CourseStudents.id IN' => $data['mychecklist']]);
                                                            })
                                                            ->toArray();
        if(empty($students)){
            $this->Flash->error(__('Students not found.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }

        $reqData = [];
        foreach ($students as $key => $value) {
            $reqData[$key] = [
                                'Course Date' => $courseDate,
                                'First Name' => $value->first_name,
                                'Last Name' => $value->last_name,
                                'Email' => $value->email,
                                'Phone(Optional)' => ($value->phone1)?($value->phone1): '-'
                              ];
        }

        $this->set(compact('reqData'));
    }

    
     /**
     * courseTransfer method
     *
     * @return \Cake\Http\Response|void
     */
     public function transferCourse($courseId)
    {
      $this->loadModel('Tenants');
      $this->loadModel('TransferCourses');
      $loggedInUser = $this->Auth->user();
      $tenant = $this->Tenants->find()
                              ->where(['id NOT IN' => $loggedInUser['tenant_id'] ])
                              ->combine('id','center_name')
                              ->toArray();
                              // pr($tenant);die;
      $transferCourse = $this->TransferCourses->findByCourseId($courseId)
                                                 ->where(['assigning_tenant_id' => $loggedInUser['tenant_id']])
                                                 ->contain(['Tenants'])
                                                 ->order(['TransferCourses.created' => 'DESC'])
                                                 ->toArray(); 
      
      
      $this->set(compact('tenant','courseId','transferCourse'));    
    }

    public function ashiECard($id = null){
        $data = $this->request->getData();
        if(empty($data['mychecklist'])){
            $this->Flash->error(__('Please select a student before printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }

        $course = $this->Courses->findById($id)->contain(['CourseDates'])->first();
        if(!empty($course->course_dates)){
            $courseDate = $course->course_dates[0]->course_date->format('m/d/Y');
        }else{
            $courseDate = '';
        }

        $students = $this->Courses->CourseStudents->Students->find()
                                                            
                                                            ->matching('CourseStudents', function($q) use($data){
                                                                return $q->where(['CourseStudents.id IN' => $data['mychecklist']]);
                                                            })
                                                            ->toArray();
        if(empty($students)){
            $this->Flash->error(__('Students not found.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }

        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("excel/test.xls");
        $sheet = $spreadsheet->getActiveSheet();
        $j = 0;
        for($i=9; $i< (count($students) +9); $i++){
            
            $sheet->setCellValue('D'.$i, $students[$j]->last_name);
            $sheet->setCellValue('E'.$i, $students[$j]->first_name);
            $sheet->setCellValue('G'.$i, $students[$j]->email);
            $sheet->setCellValue('H'.$i, "");
            $sheet->setCellValue('I'.$i, "");
            $j++;
            
        }      

        $writer = new Xls($spreadsheet);
        $writer->save('excel/helloworld3.xlsx');
        return $this->redirect('http://'.$_SERVER['SERVER_NAME'].Router::url('/').'excel/helloworld3.xlsx');
    }
    public function aha3Pdf($id = null){
      // pr('here in aha3Pdf');die;
      $data = $this->request->getData();
      // pr($data);die;
      if(empty($data['mychecklist'])){
            $this->Flash->error(__('Please select a student before printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPofileId = $data['printerProfile'];
      $this->loadModel("CardPrintingProfiles");
      if(empty($data['printerProfile'])){
            $this->Flash->error(__('Please select a Printing Profile for printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPrintingProfile = $this->CardPrintingProfiles->findById($cardPofileId)->first();
      // pr( $cardPrintingProfile);die;

      $this->loadModel('CourseStudents');
      $courseStudents = $this->CourseStudents->find()
                                             ->where(['CourseStudents.id IN' => $data['mychecklist']])
                                             ->contain(['Students'])
                                             ->all()
                                             ->toArray();
      // pr($courseStudents);die;
      $this->loadModel('Courses');
      $course = $this->Courses->findById($id)->contain(['CourseDates','TrainingSites'])->first();
      if(!empty($course->course_dates)){
            $courseDate = $course->course_dates[0]->course_date->format('F d,Y');
            $eD = explode("," , $courseDate);
            $eY = $eD[1]+ 2;
            $arr = [$eD[0],$eY];
            $courseExpiryDate = implode(",", $arr);
        }else{
            $courseDate = '';
            $courseExpirydate = '';
        }
        // pr($courseExpiryDate);die;

        $locationData = $data['location'];
        $instructorData = $data['instructor_code'];
                if(isset($data['training_center']) && !empty($data['training_center'])){
            // pr('checked');
            if(isset($course['training_site']->city)&& !empty($course['training_site']->city)){
            // pr('checked and exists');die;
            $siteData = $course['training_site']->city;
            } else {
            $siteData = "";
            // pr('checked but does not exist');die;
            }           
        } else {
          $siteData = "";
          // pr('not checked');die;
        }            
      $reqData = [];
      foreach ($courseStudents as $key => $value) {
            $reqData[$key] = [
                                'First Name' => $value->student->first_name,
                                'Last Name' => $value->student->last_name,
                                'Date' => $courseDate,
                                'Location Data' => $locationData,
                                'Instructor Data' => $instructorData,
                                'Expiry Date' => $courseExpiryDate,
                                'Site Data' => $siteData
                              ];
        }
        // pr($reqData);die();
      $this->viewBuilder()->setLayout('unit')->options([
                 'pdfConfig' => [
                  'margin' => [
                      'bottom' =>10 + $cardPrintingProfile->up_down_adjustment,
                      'left' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'right' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'top' => 10 + $cardPrintingProfile->up_down_adjustment
                  ],  
                    'filename' => 'Aha3CardTemplate_'.$id.'.pdf',
                 ]
            ]);
      $this->RequestHandler->renderAs($this, 'pdf', ['attachment' => 'abc']);
      $this->set(compact('reqData'));

  }
     public function exportCsv($id = null){
        $loggedInUser = $this->Auth->user();
        
        $this->loadModel('CourseStudents');
        $courseStudents = $this->CourseStudents->find()
                                               ->contain([
                                                            'Students'
                                                            ,'Courses' => function($q) use($id, $loggedInUser){
                                                              return $q->where([
                                                                                'Courses.id' => $id,
                                                                                'Courses.tenant_id' => $loggedInUser['tenant_id']
                                                                              ])
                                                                       ->contain(['CourseDates']);
                                                            },'Courses.CourseTypes'
                                                        ])
                                               ->all()
                                               ->toArray();
                                               // pr($courseStudents);die;
        
        $studentIds = (new Collection($courseStudents))->extract('student_id')->toArray();
        
        
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("excel/registration_data.xls");
        $sheet = $spreadsheet->getActiveSheet();
        $j = 0;
        for($i=2; $i< (count($courseStudents) +2); $i++){
            $sheet->setCellValue('A'.$i, $i-1);
            $sheet->setCellValue('B'.$i, ($courseStudents[$j]->student->first_name)?($courseStudents[$j]->student->first_name):'-');
            $sheet->setCellValue('C'.$i, $courseStudents[$j]->student->last_name);
            $sheet->setCellValue('D'.$i, $courseStudents[$j]->student->email);
            $sheet->setCellValue('E'.$i, $courseStudents[$j]->student->phone1);
            $sheet->setCellValue('F'.$i, $courseStudents[$j]->student->phone2);
            $sheet->setCellValue('G'.$i, $courseStudents[$j]->student->address);
            $sheet->setCellValue('H'.$i, $courseStudents[$j]->student->address);
            $sheet->setCellValue('I'.$i, $courseStudents[$j]->student->city);
            $sheet->setCellValue('J'.$i, $courseStudents[$j]->student->state);
            $sheet->setCellValue('K'.$i, $courseStudents[$j]->student->zipcode);
            $sheet->setCellValue('L'.$i, $courseStudents[$j]->student->hear_about_us);
            $sheet->setCellValue('M'.$i, $courseStudents[$j]->course_status);
            $sheet->setCellValue('N'.$i, $courseStudents[$j]->payment_status);
            $sheet->setCellValue('O'.$i, 'demo addon');
            $sheet->setCellValue('P'.$i, '1');
            $sheet->setCellValue('Q'.$i, $courseStudents[$j]->course->id);
            for($k=0; $k< count($courseStudents[$j]->course->course_dates); $k++){
              if(!empty($courseStudents[$j]->course->course_dates[$k])){

            $courseDate = $courseStudents[$j]->course->course_dates[$k]->course_date->format('m/d/Y');
            $courseTime = $courseStudents[$j]->course->course_dates[$k]->time_from->format('H:i:s');

          }else{
            $courseDate = '';
          }
            }
              $sheet->setCellValue('R'.$i, $courseDate);
              $sheet->setCellValue('S'.$i, $courseTime);
            $sheet->setCellValue('T'.$i, $courseStudents[$j]->course->course_type->name);
            
            $j++;
            
        }      

        $writer = new Xls($spreadsheet);
        $writer->save('excel/registered_data.xlsx');
        return $this->redirect('http://'.$_SERVER['SERVER_NAME'].Router::url('/').'excel/registered_data.xlsx');

    }

    public function ashi5Pdf($id = null){
        // pr('here in ashi5Pdf');die;
        $data = $this->request->getData();
      // pr($data);die;
      if(empty($data['mychecklist'])){
            $this->Flash->error(__('Please select a student before printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPofileId = $data['printerProfile'];
      $this->loadModel("CardPrintingProfiles");
      if(empty($data['printerProfile'])){
            $this->Flash->error(__('Please select a Printing Profile for printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPrintingProfile = $this->CardPrintingProfiles->findById($cardPofileId)->first();
      // pr( $cardPrintingProfile);die;

      $this->loadModel('CourseStudents');
      $courseStudents = $this->CourseStudents->find()
                                             ->where(['CourseStudents.id IN' => $data['mychecklist']])
                                             ->contain(['Students'])
                                             ->all()
                                             ->toArray();
      // pr($courseStudents);die;
      $this->loadModel('Courses');
      $course = $this->Courses->findById($id)->contain(['CourseDates','TrainingSites'])->first();
      if(!empty($course->course_dates)){
            $courseDate = $course->course_dates[0]->course_date->format('F d,Y');
            $eD = explode("," , $courseDate);
            $eY = $eD[1]+ 2;
            $arr = [$eD[0],$eY];
            $courseExpiryDate = implode(",", $arr);
        }else{
            $courseDate = '';
            $courseExpirydate = '';
        }
        // pr($courseExpiryDate);die;

        $locationData = $data['location'];
        $instructorData = $data['instructor_code'];

        if(isset($data['training_center']) && !empty($data['training_center'])){
            // pr('checked');
            if(isset($course['training_site']->city)&& !empty($course['training_site']->city)){
            // pr('checked and exists');die;
            $siteData = $course['training_site']->city;
            } else {
            $siteData = "";
            // pr('checked but does not exist');die;
            }           
        } else {
          $siteData = "";
          // pr('not checked');die;
        }            
      $reqData = [];
      foreach ($courseStudents as $key => $value) {
            $reqData[$key] = [
                                'First Name' => $value->student->first_name,
                                'Last Name' => $value->student->last_name,
                                'Date' => $courseDate,
                                // 'Location Data' => $locationData,
                                'Instructor Data' => $instructorData,
                                'Expiry Date' => $courseExpiryDate,
                                // 'Site Data' => $siteData
                              ];
        }
        // pr($reqData);die();
      $this->viewBuilder()->setLayout('unit')->options([
                 'pdfConfig' => [
                  'margin' => [
                      'bottom' =>10 + $cardPrintingProfile->up_down_adjustment,
                      'left' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'right' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'top' => 10 + $cardPrintingProfile->up_down_adjustment
                  ],  
                    'filename' => 'Ashi5CardTemplate_'.$id.'.pdf',
                 ]
            ]);
      $this->RequestHandler->renderAs($this, 'pdf', ['attachment' => 'abc']);
      $this->set(compact('reqData'));

    }

    public function averyPdf($id = null){
          $data = $this->request->getData();
      // pr($data);die;
      if(empty($data['mychecklist'])){
            $this->Flash->error(__('Please select a student before printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPofileId = $data['printerProfile'];
      $this->loadModel("CardPrintingProfiles");
      if(empty($data['printerProfile'])){
            $this->Flash->error(__('Please select a Printing Profile for printing cards.'));
            return $this->redirect(['action' => 'process-cards/'.$id ]);
        }
      $cardPrintingProfile = $this->CardPrintingProfiles->findById($cardPofileId)->first();
      // pr( $cardPrintingProfile);die;

      $this->loadModel('CourseStudents');
      $courseStudents = $this->CourseStudents->find()
                                             ->where(['CourseStudents.id IN' => $data['mychecklist']])
                                             ->contain(['Students'])
                                             ->all()
                                             ->toArray();
      // pr($courseStudents);die;
      $this->loadModel('Courses');
      $course = $this->Courses->findById($id)->contain(['CourseDates','TrainingSites'])->first();
      if(!empty($course->course_dates)){
            $courseDate = $course->course_dates[0]->course_date->format('F d,Y');
            $eD = explode("," , $courseDate);
            $eY = $eD[1]+ 2;
            $arr = [$eD[0],$eY];
            $courseExpiryDate = implode(",", $arr);
        }else{
            $courseDate = '';
            $courseExpirydate = '';
        }
        // pr($courseExpiryDate);die;

        $locationData = $data['location'];
        $instructorData = $data['instructor_code'];

        if(isset($data['training_center']) && !empty($data['training_center'])){
            // pr('checked');
            if(isset($course['training_site']->city)&& !empty($course['training_site']->city)){
            // pr('checked and exists');die;
            $siteData = $course['training_site']->city;
            } else {
            $siteData = "";
            // pr('checked but does not exist');die;
            }           
        } else {
          $siteData = "";
          // pr('not checked');die;
        }            


      $reqData = [];
      foreach ($courseStudents as $key => $value) {
        $stateData = substr($value->student->state,0,3);
        $state = strtoupper($stateData); 
        // pr($state);die;
            $reqData[$key] = [
                                'First Name' => $value->student->first_name,
                                'Last Name' => $value->student->last_name,
                                'Address' => $value->student->address,
                                'City' => $value->student->city,
                                'State' => $state,
                                'Zipcode' => $value->student->zipcode
                              ];
        }


      $this->viewBuilder()->setLayout('unit')->options([
                 'pdfConfig' => [
                  'margin' => [
                      'bottom' =>10 + $cardPrintingProfile->up_down_adjustment,
                      'left' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'right' => 10 + $cardPrintingProfile->left_right_adjustment,
                      'top' => 10 + $cardPrintingProfile->up_down_adjustment
                  ],  
                    'filename' => 'Avery_'.$id.'.pdf',
                 ]
            ]);
      $this->RequestHandler->renderAs($this, 'pdf', ['attachment' => 'abc']);
      $this->set(compact('reqData'));
        // pr('here in averyPdf');die;
    }


    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','privateCourse','roster','removeRoster','notes','printRoster','processCards','aha3Pdf']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','privateCourse','roster','removeRoster','notes','printRoster','addStudentToCourse','register','exportCsv','processCards','aha3Pdf']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
            return true;
        }

        else if (in_array($action, ['index','view','add','edit','delete','privateCourse','roster','removeRoster','notes','register','addStudentToCourse','closeCourse','reopenCourse','printRoster','aha3','processCards','ashi5Pdf','cancel','exportCsv','averyPdf','ahaECard','ashiECard','aha3Pdf','transferCourse', 'revokeCourseAccess']) && $user['role']->name === self::TENANT_LABEL) {

            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','privateCourse','roster','removeRoster','notes','register','addStudentToCourse','closeCourse','exportCsv','reopenCourse','printRoster','processCards','aha3Pdf']) && $user['role']->name === self::CLIENT_LABEL) {

            return true;
        }
        
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }


    

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->Auth->allow(['privateCourse','tenantCourseReply']);
    }

    public function processCards($id = null){
        
        $loggedInUser = $this->Auth->user();
        if($id){  
            $course = $this->Courses->get($id, [
                'contain' => ['TrainingSites','CourseTypes','CourseDates','CourseInstructors.Instructors','CourseStudents.Students']
            ]); 
        }else {
            $this->Flash->error(__('Internal Server Error.'));
            return $this->redirect($this->request->referer());
       }
       $this->loadModel('CardPrintingProfiles');
       $cardProfiles = $this->CardPrintingProfiles->find()
                                                  ->all()
                                                  ->combine('id','name')
                                                  ->toArray();
        
       $this->set(compact('course','cardProfiles'));
    }

    public function printRoster($id = null){
        $this->viewBuilder()->setLayout('popup-view');
        $loggedInUser = $this->Auth->user();
        $course = $this->Courses->get($id, [
            'contain' => ['Tenants', 'Locations', 'TrainingSites', 'CorporateClients', 'CourseTypeCategories', 'CourseTypes', 'CourseAddons', 'CourseDates', 'CourseDisplayTypes','CourseStudents.Students','CourseInstructors.Instructors'=> function($q) use($id){
                            return $q->where(['CourseInstructors.status'=>1]);
                        }
                ]
        ]);
        $this->loadModel('CourseStudents');
        
        // pr($courses);die;
        $this->set('course', $course);
    }





    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($request = null)
    {
        $this->loadModel('IndexSettings');

        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == 'corporate_client'){
          $tenant_id = $loggedInUser['corporate_client']['tenant_id'];
        }else{
          $tenant_id = $loggedInUser['tenant_id'];
        }
        $indexSettings = $this->IndexSettings->findByForId($loggedInUser['id'])->where(['index_name' => 'Courses'])->extract('meta')->last();
        $requestData = $this->request->getQuery('request');
        $agencyName = $this->Courses->Agencies->find();
        $agencyName = $agencyName->select(['name'])
                                 ->distinct(['name'])->extract('name')->toArray();
        $courseTypeIds = $this->Courses->findByTenantId($tenant_id)
                                        ->select(['course_type_id'])
                                        ->distinct(['course_type_id'])
                                        ->extract('course_type_id')
                                        ->toArray();
        if(!empty($courseTypeIds)){
          $courseTypes = $this->Courses->CourseTypes->find()
                                                      ->where(['id IN'=>$courseTypeIds])
                                                      ->extract('name')
                                                      ->toArray();
        }else{
          $courseTypes = []; 
        }                                
        $corporateClientIds = $this->Courses->findByTenantId($tenant_id)
                                            ->select(['corporate_client_id'])
                                            ->distinct(['corporate_client_id'])
                                            ->extract('corporate_client_id')
                                            ->toArray();
        if(!empty($corporateClientIds)){
          $corporateClients = $this->Courses->CorporateClients->find()
                                                      ->where(['id IN'=> $corporateClientIds])
                                                      ->extract('name')
                                                      ->toArray();
        }else{
          $corporateClients = [];
        }                                    
        $trainingSiteIds = $this->Courses->findByTenantId($tenant_id)
                                        ->select(['training_site_id'])
                                        ->distinct(['training_site_id'])
                                        ->extract('training_site_id')
                                        ->toArray();
        if(!empty($trainingSiteIds)){
          $trainingSites = $this->Courses->TrainingSites->find()
                                             ->where(['id IN'=> $trainingSiteIds])
                                             ->extract('name')
                                             ->toArray();
        }else{
          $trainingSiteIds = [];
        }                                                                
        $courseStatus = $this->Courses->findByTenantId($tenant_id)
                                            ->select(['status'])
                                            ->distinct(['status'])
                                            ->extract('status')
                                            ->toArray();                                   
        $courseLocationIds = $this->Courses->findByTenantId($tenant_id)
                                            ->select(['location_id'])
                                            ->distinct(['location_id'])
                                            ->extract('location_id')
                                            ->toArray();
        if(!empty($courseLocationIds)){
          $courseLocations = $this->Courses->Locations->find()
                                                      // ->select(['name','city','state'])
                                                      ->where(['id IN'=> $courseLocationIds])
                                                      ->extract('name')
                                                      ->toArray();
          $courseCity = $this->Courses->Locations->find()
                                                 // ->select(['name','city','state'])
                                                 ->where(['id IN'=> $courseLocationIds])
                                                 ->extract('city')
                                                  ->toArray();
          $courseState = $this->Courses->Locations->find()
                                                  // ->select(['name','city','state'])
                                                  ->where(['id IN'=> $courseLocationIds])
                                                  ->extract('state')
                                                  ->toArray();                                
        }else{
          $courseLocations = [];
          $courseCity = [];
          $courseState = [];
        }
        // pr($indexSettings);die('here');                                    
        // $courseDates = $this->Courses->CourseDates
        //                              ->find()
        //                              ->contain(['Courses'])
        //                              ->groupBy('course_id')
        //                              ->map(function($value, $key){
        //                                 return (new Collection($value))->sortBy('course_date')->first();
        //                              })
        //                              ->groupBy(function($value) use($today){
        //                                 return $value->course_date >= $today ? "future" : 'past';
        //                              })
        //                              ->map(function($value){

        //                                 return (new Collection($value))->extract('course_id')->toArray();
        //                              })
        //                              ->toArray();
        //                              // pr($courseDates);die;

            
            
        // if($loggedInUser['role']->name == self::TENANT_LABEL){
        //     if($requestData == 'draft'){
        //     // pr($loggedInUser);die();
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status' => 'draft'];
        //         // pr($status);die();
        //     }
        //     if($requestData == 'past-courses'){
        //         $where = ['Courses.tenant_id' =>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['past'])){
        //             $where['Courses.id IN'] = $courseDates['past'];
        //         }
        //     }
        //     if($requestData == 'future-courses'){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['future'])){
        //             $where['Courses.id IN'] = $courseDates['future'];
        //         }
        //     }
        //     if($requestData == null){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id']];  
        //     }

        //       $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        //       $locations = $this->Courses->Locations->find()->indexBy('id')->toArray();
        //       $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        //       $corporateClients = $this->Courses->CorporateClients->find()->indexBy('id')->toArray();
        //       $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        //       // $courseDates = $this->Courses->CourseDates->find()->indexBy('course_id')->toArray();

        //       $instructors = $this->Instructors->find('withTrashed')->indexBy('id')->toArray();

        //       $courses = $this->Courses->find()
        //                              ->contain([ 'CourseTypes', 'CourseInstructors','CourseDates'])
        //                              ->where($where)
        //                              ->order(['Courses.created' => 'DESC'])
        //                              ->limit(10)
        //                              ->toArray();

        //       $myCourses = $this->Courses->find()
        //                              ->contain([ 'CourseTypes', 'CourseInstructors'])
        //                              ->where([$where,'added_by' => 'tenant','owner_id' => $loggedInUser['id']])
        //                              ->order(['Courses.created' => 'DESC'])
        //                              ->limit(10)
        //                              ->toArray();                       
              
            
        //     // pr($courses);die();
        // }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        //     if($requestData == 'draft'){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status' => 'draft'];
        //     }
        //     if($requestData == 'past-courses'){
        //         $where = ['Courses.tenant_id' =>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['past'])){
        //             $where['Courses.id IN'] = $courseDates['past'];
        //         }
        //     }
        //     if($requestData == 'future-courses'){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['future'])){
        //             $where['Courses.id IN'] = $courseDates['future'];
        //         }
        //     }
        //     if($requestData == null){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id']];  
        //     }
        //     $courses = $this->Courses
        //                     ->find()
        //                     ->contain(['Tenants', 'Locations', 'TrainingSites', 'CorporateClients', 'CourseTypeCategories', 'CourseTypes.Agencies'])
        //                     ->order(['Courses.created' => 'DESC'])
        //                     ->all();
        // }
        // else if($loggedInUser['role']->name == self::INSTRUCTOR_LABEL){
        //     // pr($course_instructor);die;
        //     if($requestData == 'draft'){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status' => 'draft'];
        //     }
        //     if($requestData == 'past-courses'){
        //         $where = ['Courses.tenant_id' =>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['past'])){
        //             $where['Courses.id IN'] = $courseDates['past'];
        //         }
        //     }
        //     if($requestData == 'future-courses'){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id'], 'Courses.status NOT IN' => 'draft'];
        //          if(!empty($courseDates['future'])){
        //             $where['Courses.id IN'] = $courseDates['future'];
        //         }
        //     }
        //     if($requestData == null){
        //         $where = ['Courses.tenant_id'=>$loggedInUser['tenant_id']];  
        //     }
        //     // pr($loggedInUser['role']->name); die();
        //                            // pr($course_instructor);die;
        //     $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        //     $locations = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        //     $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        //     $corporateClients = $this->Courses->CorporateClients->find()->indexBy('id')->toArray();
        //     $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        //     $courseDates = $this->Courses->CourseDates->find()->indexBy('id')->toArray();
        //     $instructors = $this->Courses->Instructors->find()->indexBy('id')->toArray();

        //     $courses = $this->Courses->find()
        //                              ->contain([ 'CourseTypes', 'CourseInstructors'])
        //                              ->where($where)
        //                              ->order(['Courses.created' => 'DESC'])
        //                              ->all()
        //                              ->toArray();
        //                              // pr($courses); die;
        
        // }
        //  else if($loggedInUser['role']->name == self::CLIENT_LABEL){
        //     // pr($loggedInUser['role']->name); die();
        //     if($requestData == 'draft'){


        //         $whereClient = ['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status' => 'draft'];
        //     }
        //     if($requestData == 'past-courses'){

        //         $whereClient = ['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['past'])){
        //             $whereClient['Courses.id IN'] = $courseDates['past'];
        //         }
        //     }
        //     if($requestData == 'future-courses'){
        //         // pr('here');
        //         $whereClient = ['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['future'])){
        //             $whereClient['Courses.id IN'] = $courseDates['future'];
        //         }
        //     }
        //     if($requestData == null){
        //         $whereClient = ['Courses.corporate_client_id'=>$loggedInUser['corporate_client_id']];  
        //     }
        //     $tenants = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        //     $locations = $this->Courses->Tenants->find()->indexBy('id')->toArray();
        //     $trainingSites = $this->Courses->TrainingSites->find()->indexBy('id')->toArray();
        //     $corporateClients = $this->Courses->CorporateClients->find()->indexBy('id')->toArray();
        //     $agencies = $this->Courses->Agencies->find()->indexBy('id')->toArray();
        //     $courseDates = $this->Courses->CourseDates->find()->indexBy('id')->toArray();
        //     $instructors = $this->Courses->Instructors->find()->indexBy('id')->toArray();
            
        //     $courses = $this->Courses->find()
        //                              ->contain([ 'CourseTypes', 'CourseInstructors'])
        //                              ->where($whereClient)
        //                              ->order(['Courses.created' => 'DESC'])
        //                              ->all()
        //                              ->toArray();
        //                              // pr($courses); die();
        // }
        // if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
        //     if($requestData == 'draft'){
        //     // pr($loggedInUser);die();
        //         $where = ['Courses.training_site_id'=>$loggedInUser['training_site_id'], 'Courses.status' => 'draft'];
        //         // pr($status);die();
        //     }
        //     if($requestData == 'past-courses'){
        //         $where = ['Courses.training_site_id' =>$loggedInUser['training_site_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['past'])){
        //             $where['Courses.id IN'] = $courseDates['past'];
        //         }
        //     }
        //     if($requestData == 'future-courses'){
        //         $where = ['Courses.training_site_id'=>$loggedInUser['training_site_id'], 'Courses.status NOT IN' => 'draft'];
        //         if(!empty($courseDates['future'])){
        //             $where['Courses.id IN'] = $courseDates['future'];
        //         }
        //     }
        //     if($requestData == null){
        //         $where = ['Courses.training_site_id'=>$loggedInUser['training_site_id']];  
        //     }
            
        //       $courses = $this->Courses->find()
        //                              ->contain([ 'CourseTypes', 'CourseInstructors'])
        //                              ->where($where)
        //                              ->order(['Courses.created' => 'DESC'])
        //                              ->all()
        //                              ->toArray();
              
            
        //     // pr($courses);die();
        // }
       

        //     // pr($courses);die();
        $this->set('loggedInUser', $loggedInUser);
        $this->set('requestData', $requestData);
        $this->set(compact('agencyName','courseTypes','corporateClients','trainingSites','courseStatus','courseLocations','courseCity','courseState','indexSettings'));
    }

    /**
     * View method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loggedInUser = $this->Auth->user();

        $this->viewBuilder()->setLayout('default-override');
        $this->loadModel('CourseStudents');
        $this->loadModel('Orders');
        $this->loadModel('CourseAddons');
        $this->loadModel('Addons');
        $studentAddons = $this->Addons->find()->all()->toArray();
        $courseAddons = $this->CourseAddons->findByCourseId($id)
                                           ->contain(['Addons'])
                                           ->all()
                                           ->toArray();
       
        if($loggedInUser['role_id'] == 3){
         $orders = $this->Orders->find()
                               ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                               ->all()
                               ->toArray();
        $CourseStudents = $this->CourseStudents->find()
                                               ->contain(['Students','Courses'])
                                               ->where([
                                                'course_id' => $id,
                                                'Courses.tenant_id' => $loggedInUser['corporate_client']['tenant_id']
                                                       ]
                                                      )
                                               ->all()
                                               ->toArray();
         $waitlistedStudents = $this->CourseStudents->find()
                                                   ->contain(['Students','Courses'])
                                                   ->where([
                                                    'course_id' => $id,
                                                    'Courses.tenant_id' =>$loggedInUser['corporate_client']['tenant_id'],
                                                    'payment_status' => 'Not Paid'
                                                    ])
                                                   ->count();
        $registeredStudents = $this->CourseStudents->find()
                                                   ->contain(['Students','Courses'])
                                                   ->where([
                                                    'course_id' => $id,
                                                    'Courses.tenant_id' =>$loggedInUser['corporate_client']['tenant_id'], 'OR' => ['payment_status' => 'Paid','payment_status' => 'Partial']
                                                    ])
                                                   ->indexBy('student_id')
                                                   ->toArray();  
        
        $registeredStudents = (new Collection($registeredStudents))->map(function($value, $key){
                                                        $courseId = $value->course_id;
                                                        $studentId = $value->student_id;
                                                        $this->loadModel('LineItems');
                                                        $query = $this->LineItems->find()->where([
                                                                                    'course_id' => $courseId,
                                                                                    'student_id'=> $studentId
                                                                                  ])->toArray();

                                                        if(!empty($query)){
                                                          $orderId = $query[0]->order_id;
                                                          $totalAmount = (new Collection($query))->sumof('amount');
                                                          $this->loadModel('Payments');
                                                          $amountPaid = $this->Payments->findByOrderId($orderId)->contain('Transactions')->first()->transaction->amount;
                                                          $balance = $totalAmount - $amountPaid;

                                                          $paymentData = [
                                                                            'totalAmount' => $totalAmount,
                                                                            'paidAmount' => $amountPaid,
                                                                            'balance' => $balance
                                                                        ];
                                                          
                                                          return $paymentData;
                                                        }
                                                  })
                                                  ->toArray();
                                                  
        $this->set('paymentData', $registeredStudents);  
        $this->request->getSession()->write('getPaymentData',$registeredStudents);
        $registeredStudents = count($registeredStudents);

        } else {
            
        $orders = $this->Orders->find()
                               ->where(['tenant_id' => $loggedInUser['tenant_id']])
                               ->all()
                               ->toArray();
        $CourseStudents = $this->CourseStudents->find()
                                               ->contain(['Students','Courses'])
                                               ->where([
                                                'course_id' => $id,
                                                'Courses.tenant_id' => $loggedInUser['tenant_id']
                                                       ]
                                                      )
                                               ->all()
                                               ->toArray();
        $waitlistedStudents = $this->CourseStudents->find()
                                                   ->contain(['Students','Courses'])
                                                   ->where([
                                                    'course_id' => $id,
                                                    'Courses.tenant_id' =>$loggedInUser['tenant_id'],
                                                    'payment_status' => 'Not Paid'
                                                    ])
                                                   ->count();
                                                   

         $registeredStudents = $this->CourseStudents->find()
                                                   ->contain(['Students','Courses'])
                                                   ->where([
                                                    'course_id' => $id,
                                                    'Courses.tenant_id' =>$loggedInUser['tenant_id'],'OR' => ['payment_status' => 'Paid','payment_status' => 'Partial']])
                                                   ->indexBy('student_id')
                                                   ->toArray();  
                                                   
        $registeredStudents = (new Collection($registeredStudents))->map(function($value, $key){
                                                        $courseId = $value->course_id;
                                                        $studentId = $value->student_id;
                                                        $this->loadModel('LineItems');
                                                        $query = $this->LineItems->find()->where([
                                                                                    'course_id' => $courseId,
                                                                                    'student_id'=> $studentId
                                                                                  ])->toArray();

                                                        if(!empty($query)){
                                                          $orderId = $query[0]->order_id;
                                                          $totalAmount = (new Collection($query))->sumof('amount');
                                                          $this->loadModel('Payments');
                                                          $amountPaid = $this->Payments->findByOrderId($orderId)->contain('Transactions')->first()->transaction->amount;
                                                          $balance = $totalAmount - $amountPaid;

                                                          $paymentData = [
                                                                            'totalAmount' => $totalAmount,
                                                                            'paidAmount' => $amountPaid,
                                                                            'balance' => $balance
                                                                        ];

                                                          return $paymentData;
                                                        }
                                                  })
                                                  ->toArray();

        $this->set('paymentData', $registeredStudents);
        $this->set('totalPayment',$registeredStudents);       
        $this->request->getSession()->write('getPaymentData',$registeredStudents); 
        $registeredStudents = count($registeredStudents);
        }

        $course = $this->Courses->get($id, [
            'contain' => [
                    'CourseStudents.Students','Tenants', 'Locations', 'TrainingSites', 'CorporateClients', 'CourseTypeCategories', 'CourseTypes', 'CourseAddons.Addons', 'CourseDates', 'CourseDisplayTypes',
                        'CourseInstructors.Instructors'
                ]
        ]);

        if(!$this->request->getSession()->read('finalAmount')){
            $finalAmount = $course->cost;
            $this->request->getSession()->write('finalAmount',$finalAmount);
        }
        $remSeats = $course->seats - $registeredStudents;
        $domain = $course['tenant']['domain_type'];
        $this->loadmodel('Tenants');
        if($loggedInUser['role_id'] == 3){
        
        $url = $this->Tenants
                            ->find()
                            ->select('domain_type')
                            ->where(['id'=>$loggedInUser['corporate_client']['tenant_id']])
                            ->first();
        } else {


        
        $url = $this->Tenants
                            ->find()
                            ->select('domain_type')
                            ->where(['id'=>$loggedInUser['tenant_id']])
                            ->first();
        }
        $temp = $url['domain_type'];
        $url=explode("/",$temp);
        $urldomain=$url['0'];
        $this->loadModel('TenantConfigSettings');
        if($loggedInUser['role']->name != 'corporate_client'){

        $tenantConfigSettings = $this->TenantConfigSettings->find()
                                                           ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                           ->first();
                                                           // pr($tenantConfigSettings);die;
        }else{
          $tenantConfigSettings = $this->TenantConfigSettings->find()
                                                           ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                                                           ->first();
        }

        if(isset($tenantConfigSettings) && $tenantConfigSettings->payment_mode == "stripe"){
          $this->set('stripePublishedKey', $tenantConfigSettings->stripe_test_published_key);
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set('course', $course);
        $this->set('id',$id);
        $this->set(compact('urldomain','CourseStudent','CourseStudents','order','courseAddons','courseAddon','studentAddons','waitlistedStudents','remSeats','registeredStudents'));
    }


    public function privateCourse($requestData = null){
        $requestData = $this->request->getQuery('course-hash');
        $this->viewBuilder()->layout('login-admin-override');
        
        $course = $this->Courses->findByPrivateCourseUrl($requestData)->first();
        if(isset($course) && !empty($course)){
            $this->set('course', $course);
        }else{
            $this->Flash->error(__('Please try again, Something went wrong'));
        }

    }
    /*Send Email To Coordinator If checkbox is checked true*/
    // Send the email to selected coordinator
    public function _sendEmailToCoordinator($training_site_id){
        $this->loadModel('TrainingSites');
        $training_email = $this->TrainingSites->find()->where(['id =' => $training_site_id])->first();
        $getEmail = $training_email->contact_email;
        $name = $training_email->name;
        if(!empty($getEmail)){
            $emailBody = '<p><span style="font-weight: 400;">Hi '.$name.',<br /><br /></span><span style="font-weight: 400;">A new course has been added to your training site '.$name.'. <br /><br /></span><span style="font-weight: 400;">Thank you,<br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';
            $email = new Email('default');
            $email->setTo($getEmail)
                  ->emailFormat('html')
                  ->setSubject('New Course Added '.$name)
                  ->send($emailBody);
        }
    }

    //Generate random string alphanum        
    public function _generateRandomString($length = 36) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $course = $this->Courses->newEntity();
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser);die;
        // pr($course);die;
        if($loggedInUser['role']->name != 'corporate_client'){
          $where= $loggedInUser['tenant_id'];
        }else{
          $where= $loggedInUser['corporate_client']['tenant_id'];
        }
        $tenant_config_settings = $this->Courses->Tenants->TenantConfigSettings->find()
                                                              ->where(['tenant_id' => $where])
                                                              ->all()
                                                              ->toArray();
        if ($this->request->is('post')) {
        // pr($course);die();
            $data = $this->request->getData();
            if($data['duration'] != count($data['course_dates'])){
               $this->Flash->error(__('Selected date/time slots should be equal to the duration of the course.'));
               return $this->redirect(['action' => 'add']);
            }            
            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
              $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            if($loggedInUser['role']->name == 'corporate_client' && isset($loggedInUser['corporate_client']['training_site_id'])){
                $data['training_site_id'] = $loggedInUser['corporate_client']['training_site_id'];
            }
            if($loggedInUser['role']->name == 'corporate_client' && $data['status'] == "publish"){
              
              $data['status'] = 'Corp Request';
              // pr($data);die;
            }
            $data['added_by'] = $loggedInUser['role']->name;
            if($loggedInUser['role']->name !== self::TENANT_LABEL){
            $data['owner_id'] = $loggedInUser['id'];
            }

            if($data['status'] == 'publish'){
                if(!isset($data['training_site_id']) || !$data['training_site_id']){
                    if(isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id']){
                        $data['training_site_id'] = $loggedInUser['training_site_id'];
                    }else{
                        $this->Flash->error(__('Please choose Training Site in order to publish this course.'));
                        return $this->redirect(['action' => 'add']);
                    }
                }
                if(!isset($data['course_type_category_id']) || !$data['course_type_category_id']){
                 $this->Flash->error(__('Please choose Course Type Category in order to publish this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(!isset($data['course_type_id']) || !$data['course_type_id']){
                 $this->Flash->error(__('Please choose course type for this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(!isset($data['duration']) || !$data['duration']){
                 $this->Flash->error(__('Please fill duration for this Course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(empty($data['course_dates'][0]['course_date'])){
                 $this->Flash->error(__('Please choose Course Dates for this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(empty($data['course_dates'][0]['time_from']) || empty($data['course_dates'][0]['time_to'])){
                 $this->Flash->error(__('Please choose time for this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(count($data['course_dates']) > 0 ){

                  foreach ($data['course_dates'] as $key => $value) {
                    if(empty($value['course_date']) || empty($value['time_from']) || empty($value['time_to'])) {
                      $this->Flash->error(__('Please choose date and time for all the selected course/s.'));
                      return $this->redirect(['action' => 'add']);
                    }
                  }
                }
                if(!isset($data['location_id']) || !$data['location_id']){
                 $this->Flash->error(__('Please choose location for this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(!isset($data['instructorId']) || !$data['instructorId']){
                 $this->Flash->error(__('Please choose Instructors for this course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(!isset($data['seats']) || !$data['seats']){
                 $this->Flash->error(__('Please fill Number of Students for this Course.'));
                 return $this->redirect(['action' => 'add']);
                }
                if(!isset($data['cost']) || !$data['cost']){
                 $this->Flash->error(__('Please fill cost of the course.'));
                 return $this->redirect(['action' => 'add']);
                }
 
            } 
            
            $courseAddons = [];
            // $courseInstructors = [];
            $courseDates = [];
            // if(!empty($data['course_instructors'])){
            //     foreach ($data['course_instructors'] as $key => $value) {
            //         $courseInstructors[] = [
            //                                             // 'instructor_id' => $value,
            //                                             'course_id' => $data['location_id']
            //                                         ];
            //     }
            //     $data['course_instructors'] = $courseInstructors;
            // }
             if($loggedInUser['role']->name == "instructor")  { 
            $courseInstructors[] = [
                                                        'instructor_id' => $loggedInUser['id'],
                                                        'location_id' => $data['location_id']
                                                    ];
                }




            if(!empty($data['instructorId'][0])){
              die('not empty');
                // pr($data['instructorId']);
                $inst = explode(",",$data['instructorId']['0']);
                foreach ($inst as $key => $value) {
                // pr($value);
                    $courseInstructors[] = [
                                                        'instructor_id' => $value,
                                                        'location_id' => $data['location_id']
                                                    ];
                }
                $data['course_instructors'] = $courseInstructors;
            }

            // pr($data['course_instructors']);die;
            if(!empty($data['course_addons'])){
                foreach ($data['course_addons'] as $key => $value) {
                    $courseAddons[] = ['addon_id' => $value];
                }
                $data['course_addons'] = $courseAddons;
            }
            
            if(!empty($data['course_dates'])){
                foreach ($data['course_dates'] as $key => $value) {
                    $data['course_dates'][$key]['course_date'] = new Date($value['course_date']);
                }
            }

             if(!empty($data['course_display_types'])){
                foreach ($data['course_display_types'] as $key => $value) {
                    $data['course_display_types'][$key]['display_type_id'] =$value['display_type_id'];
                }
            }

           
            if($loggedInUser['role']->name == "instructor"){
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            $data['training_site_id'] = $loggedInUser['training_site_id'];    
            }
            
            if($loggedInUser['role']->name == "corporate_client"){
            $data['tenant_id'] = $loggedInUser['corporate_client']['tenant_id'];
            // pr($loggedInUser['corporate_client_id']);die();
            $data['training_site_id'] = $loggedInUser['corporate_client']['training_site_id'];
            $data['corporate_client_id'] = $loggedInUser['corporate_client_id'];
            } else {

            $data['tenant_id'] = $loggedInUser['tenant_id'];
            }

            if(!isset($data['private_course']) || !$data['private_course']){
                $data['private_course'] = 0;
            }

            // Generate a private course link and save in DB
            if(isset($data['private_course']) && $data['private_course']){
                $data['private_course_flag'] = 1;
            }
            
            // $courseHash = $this->_generateRandomString();
            // $data['private_course_url'] = $courseHash;

            // pr($data);die;
            // Send the email to selected coordinator if checked true
            $training_site_id = $data['training_site_id'];
            if(isset($data['send_email_to_site_coordinator']) && $data['send_email_to_site_coordinator']){
                $sendEmailToSiteCoordinator = $data['send_email_to_site_coordinator'];
                $this->_sendEmailToCoordinator($training_site_id);
            }

            $course = $this->Courses->patchEntity($course, $data,['associated'=>['CourseAddons','CourseInstructors','CourseDates','CourseDisplayTypes']]);
            // pr($course); die();
            if($course['status'] == 'draft'){
                $redirect = 'index?request=draft';
            }
            elseif($course['status'] == 'publish' || $course['status'] == 'Corp Request'){
                $redirect = 'index?request=future_courses';
            }
            // $this->trainingOpportunityNotification(34);
            // pr(34); die('here');
            if ($this->Courses->save($course)) {
               // pr($course);die();
              if($course->status == 'publish'){
                $this->trainingOpportunityNotification($course->id);
              }
                $this->Flash->success(__('The course has been saved.'));


                return $this->redirect(['action' => $redirect]);
            }
            // pr($course);die('not saved');
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
        }

        $trainingSiteOwner = "";
        $this->loadModel('Instructors');
        $this->loadModel('Addons');
        $this->loadModel('DisplayTypes');
        $this->loadModel('TenantUsers');

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            
            $tenants = $this->Courses->Tenants->find()
                                                // ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $courseTypeCategories = $this->Courses->CourseTypeCategories->find()
                                                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                    ->all()
                                                                    ->combine('id','name')
                                                                    ->toArray();
            // pr($course);die;
            $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();
            // pr($corporateClients);die();
            $trainingSites = $this->Courses->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
            $locations = $this->Courses->Locations->find()
                                                  ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                  ->all()
                                                  ->combine('id','name')
                                                  ->toArray();
            
            $courseTypes = $this->Courses->CourseTypes->find()
                                                      ->where(['status' => 1])
                                                      ->all()
                                                      ->combine('id','name')
                                                      ->toArray();
            
            $addons = $this->Addons->find()
                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                    ->all()
                                    ->combine('id','name')
                                    ->toArray();

            $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            // ->all()
                                            ->combine('id', function($val){
                                                  return $val->first_name.' '.$val->last_name.' ( '.$val->email.' )('.$val->phone_1.')';
                                                 })
                                            ->toArray();
                                            // ->combine('id', 'first_name');

            // $students = $this->Students->find()
            //                        ->where($studentsConditions)
            //                        ->combine('id', function($val){
            //                             return $val->last_name.' , '.$val->first_name.' ( '.$val->email.' )';
            //                         })
            //                        ->toArray();
            // pr($instructors);die;
            $displayTypes = $this->DisplayTypes->find()->all()
                                                // ->combine('id','name')
                                                ->toArray();
            // pr($displayTypes);
            // $tenantUsers = $this->TenantUsers->findByTenantId($loggedInUser['tenant_id'])->all()->combine('id',function ($q){
            //   return $q->select('first_name','last_name');
            // })->toArray();
            $tenantUsers = $this->TenantUsers
                ->find('list', [
                    'valueField' => function ($row) {
                        return $row['first_name'] . ' ' . $row['last_name'];
                    }
                ])
                ->where(['tenant_id' => $loggedInUser['tenant_id']])->all()->toArray();
            // pr($tenantUsers);die;

        }else if($loggedInUser['role']->name == self::CLIENT_LABEL){
            // pr(); die();
            $tenants = $this->Courses->Tenants->find()
                                                // ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $courseTypeCategories = $this->Courses->CourseTypeCategories->find()
                                                                    ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                                    ->all()
                                                                    ->combine('id','name')
                                                                    ->toArray();
            // pr($course);die;
            $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();
            
           
            // $course->tenant_id == $tenantId;
            // pr($course);die();                                   
            $trainingSites = $this->Courses->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
            $locations = $this->Courses->Locations->find()
                                                  ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                  ->all()
                                                  ->combine('id','name')
                                                  ->toArray();
            
            $courseTypes = $this->Courses->CourseTypes->find()
                                                      ->where(['status' => 1])
                                                      ->all()
                                                      ->combine('id','name')
                                                      ->toArray();
            
            $addons = $this->Addons->find()
                                    ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                    ->all()
                                    ->combine('id','name')
                                    ->toArray();

            $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            ->all()
                                            ->toArray();

            $displayTypes = $this->DisplayTypes->find()->all()
                                                // ->combine('id','name')
                                                ->toArray();
            // pr($displayTypes);

        }else{
            $tenants = $this->Courses->Tenants->find()
                                                // ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $courseTypeCategories = $this->Courses->CourseTypeCategories->find()
                                                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                    ->all()
                                                                    ->combine('id','name')
                                                                    ->toArray();
            // pr($course);die;
            $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();

            $trainingSites = $this->Courses->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
            $locations = $this->Courses->Locations->find()
                                                  ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                  ->all()
                                                  ->combine('id','name')
                                                  ->toArray();
            
            $courseTypes = $this->Courses->CourseTypes->find()
                                                      ->where(['status' => 1])
                                                      ->all()
                                                      ->combine('id','name')
                                                      ->toArray();
            
            $addons = $this->Addons->find()
                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                    ->all()
                                    ->combine('id','name')
                                    ->toArray();

            $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            ->all()
                                            ->toArray();
                                            // ->toArray(); 
                                            // pr($instructors);die;

            $displayTypes = $this->DisplayTypes->find()->all()
                                                // ->combine('id','name')
                                                ->toArray();
        }
        if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();
          $locations = $this->Courses->Locations->find()
                                                ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
          
          $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            ->all()
                                            ->toArray();

        }

       
        $this->set('trainingSiteOwner', $trainingSiteOwner);
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('course', 'tenants', 'locations', 'trainingSites', 'corporateClients', 'courseTypeCategories', 'courseTypes','instructors','addons','displayTypes','tenantId','tenant_config_settings','tenantUsers','loggedInUser'));
    }


    public function trainingOpportunityNotification($courseId){
      $courseData = $this->Courses->findById($courseId)->contain(['Locations','CourseDates','CourseTypes.Agencies','TrainingSites','CourseInstructors.Instructors'])->first();
      $url = Router::url('/', true).'instructors/login';
      if(isset($courseData->instructor_bidding) && $courseData->instructor_bidding == 1){
        $emailData = [  
                      'training_site_name' => $courseData->training_site->name,
                      'content' => 'This training opportunity has been offered to multiple instructors and will be assigned to the first '.$courseData->bidding_number.' instructor(s) to accept the course being offered by',
                      'training_site_phone' => $courseData->training_site->contact_phone,
                      'training_site_email' => $courseData->training_site->contact_email,
                      'server_name' => $url,
                      'course_id' => $courseData->id,
                      'course_type' => $courseData->course_type->name,
                      'course_type_agency' => $courseData->course_type->agency->name,
                      'course_date' => $courseData->course_dates[0]->course_date->format('Y-M-d'),
                      'course_start_time' => $courseData->course_dates[0]->time_from->format('h-i'),
                      'course_end_time' => $courseData->course_dates[0]->time_to->format('h-i'),
                      'location_city' => $courseData->location->city,
                      'location_state' => $courseData->location->state,
                      'location_zipcode' => $courseData->location->zipcode,

                    ];
      }else{

        $emailData = [  
                      'training_site_name' => $courseData->training_site->name,
                      'content' => 'A training opportunity has been offered to you by',
                      'training_site_phone' => $courseData->training_site->contact_phone,
                      'training_site_email' => $courseData->training_site->contact_email,
                      'server_name' => $url,
                      'course_id' => $courseData->id,
                      'course_type' => $courseData->course_type->name,
                      'course_type_agency' => $courseData->course_type->agency->name,
                      'course_date' => $courseData->course_dates[0]->course_date->format('Y-M-d'),
                      'course_start_time' => $courseData->course_dates[0]->time_from->format('h-i'),
                      'course_end_time' => $courseData->course_dates[0]->time_to->format('h-i'),
                      'location_city' => $courseData->location->city,
                      'location_state' => $courseData->location->state,
                      'location_zipcode' => $courseData->location->zipcode,

                    ];
      }

       // pr($courseData);die;             
      $course = (new Collection($courseData->course_instructors))->map(function($val)use($emailData, $courseData){
                                        // pr($emailData);
                                        $emailData['first_name'] = $val->instructor->first_name;
                                        $emailData['last_name'] = $val->instructor->last_name;
                                        $emailData['email'] = $val->instructor->email;
                                        // pr($emailData);die;
                                         $event = new Event('training_opportunity_notification_instructor', $this, [
                                                           'hashData' => $emailData,
                                                           'tenant_id' => $courseData->tenant_id
                                                      ]);
                                        $this->getEventManager()->dispatch($event);
                                        })->toArray();
      // die('herewerty');

    }

    public function edit($id = null)
    {
        $this->loadModel('CourseDates');
        $this->loadModel('Instructors');
        $this->loadModel('Addons');
        $this->loadModel('DisplayTypes');
        $this->loadModel('TenantUsers');
        $loggedInUser = $this->Auth->user();
        $course = $this->Courses->get($id, [
            'contain' => ['CourseDates','CourseAddons.Addons','CourseInstructors.Instructors','CourseDisplayTypes']
        ]);
        $tenant_config_settings = $this->Courses->Tenants->TenantConfigSettings->find()
                                                              ->where(['tenant_id' => $course->tenant_id])
                                                              ->all()
                                                              ->toArray();
          
        // pr($course); die();
        $this->loadModel('CourseInstructors');
        $courseInstructors = $this->CourseInstructors->findByCourseId($id)
                                                     ->contain(['Instructors'])
                                                     ->toArray();
        // pr($courseInstructors);die;                                             
        $course->course_addons = (new Collection($course->course_addons))->extract('addon_id')->toArray();
        $course->course_instructors = (new Collection($course->course_instructors))->extract('instructor_id')->toArray();
        $temp = $course->course_instructors;
        // pr($course->course_instructors);die;
        $getCourseDates = (new Collection($course->course_dates))->toArray();
        $getCourseDateCount = (new Collection($course->course_dates))->count();
        $course->course_display_types = (new Collection($course->course_display_types))->extract('display_type_id')->toArray();

        // pr($course->course_instructors);
        $trainingSiteOwner = "";
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // pr($data);die;
              if($data['duration'] != count($data['course_dates'])){
               $this->Flash->error(__('Selected date/time slots should be equal to the duration of the course.'));
               return $this->redirect(['action' => 'edit',$id]);
              }
                if(empty($data['course_dates'][1]['course_date'])){
                 $this->Flash->error(__('Please choose Course Dates for this course.'));
                 return $this->redirect(['action' => 'edit',$id]);
                }
                if(empty($data['course_dates'][1]['time_from']) || empty($data['course_dates'][1]['time_to'])){
                 $this->Flash->error(__('Please choose time for this course.'));
                 return $this->redirect(['action' => 'edit',$id]);
                }
                if(count($data['course_dates']) > 0 ){

                  foreach ($data['course_dates'] as $key => $value) {
                    if(empty($value['course_date']) || empty($value['time_from']) || empty($value['time_to'])) {
                      $this->Flash->error(__('Please choose date and time for all the selected course/s.'));
                      return $this->redirect(['action' => 'edit',$id]);
                    }
                  }
                }   
            
            if($loggedInUser['role_id'] == 3 && $data['status'] == "publish"){
              $data['status'] = 'Corp Request';
              // pr($data);die;
            }
            // pr($course);die;

            if($loggedInUser['role_id'] == 2 && isset($loggedInUser['training_site_id'])){
                $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            $courseAddons = [];
            $courseInstructors = [];
            $courseDates = [];
            $courseInstructors =  (new Collection($data['course_instructors']))->extract('instructor_id')->toArray();
              
            if($tenant_config_settings[0]->instructor_bidding == 1){

            if($data['bidding_number'] > $course->bidding_number){
              $data['full'] = 0;
            }
            }

            if(!empty($data['course_addons'])){
                foreach ($data['course_addons'] as $key => $value) {
                    $courseAddons[] = ['addon_id' => $value];
                }
                $data['course_addons'] = $courseAddons;
            }
            
            if(!empty($data['course_dates'])){
                foreach ($data['course_dates'] as $key => $value) {
                    $data['course_dates'][$key]['course_date'] = new Date($value['course_date']);
                }
            }
            // pr($data['course_dates']); die();

            if(!empty($data['course_display_types'])){
                foreach ($data['course_display_types'] as $key => $value) {
                    $data['course_display_types'][$key]['display_type_id'] =$value['display_type_id'];
                }
            }

            if(!isset($data['private_course']) || !$data['private_course']){
                $data['private_course'] = 0;
                $data['private_course_flag'] = 0;
            }else if(isset($data['private_course']) && $data['private_course']){
                $data['private_course'] = 1;
                $data['private_course_flag'] = 1;
            }

            $course = $this->Courses->patchEntity($course,$data);
            $checkOutInstructorId = array_diff(array_merge($temp, $courseInstructors),array_intersect($temp,$courseInstructors));
            // pr($courseInstructors);die;
            if ($this->Courses->save($course)) {

              if(!empty($checkOutInstructorId) && $course->status == 'publish'){
                $this->trainingOpportunityReassignmentNotification($course->id,$checkOutInstructorId);
              }
                $this->Flash->success(__('The course has been saved.'));

                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('The course could not be saved. Please, try again.'));
        }

        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){

           $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            // ->all()
                                            ->combine('id', function($val){
                                                  return $val->first_name.' '.$val->last_name.' ( '.$val->email.' )('.$val->phone_1.')';
                                                 })
                                            ->toArray();
            if(isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id']){
                $trainingSiteOwner = $loggedInUser['training_site_id'];
            }
            $tenants = $this->Courses->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

        }else {
            $tenants = $this->Courses->Tenants->find()->all()->combine('id','center_name')->toArray();
            
        }
        if($loggedInUser['role_id']==3){
        $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                            ->select(['id','first_name'])
                                            ->all()
                                            ->combine('id', 'first_name');
                                                  
        $addons = $this->Addons->find()
                                    ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                    ->all()
                                    ->combine('id','name')
                                    ->toArray();    
        }  else {
       $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            // ->select(['id','first_name'])
                                            ->all()
                                            ->toArray();
                                            // ->combine('id', 'first_name');
            // pr($instructors);die;
                                                  
        $addons = $this->Addons->find()
                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                    ->all()
                                    ->combine('id','name')
                                    ->toArray();
        }
        $courseDates = $this->Courses->CourseDates->find('list', ['limit' => 200]);


        $tenants = $this->Courses->Tenants->find('list', ['limit' => 200]);
        $locations = $this->Courses->Locations->find('list', ['limit' => 200]);
        // $trainingSites = $this->Courses->TrainingSites->find('list', ['limit' => 200]);
        if($loggedInUser['role_id']==3){
        $trainingSites = $this->Courses->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
        $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();

        $courseTypeCategories = $this->Courses->CourseTypeCategories->find()
                                                                    ->where(['tenant_id'=>$loggedInUser['corporate_client'] ['tenant_id']])
                                                                    ->all()
                                                                    ->combine('id','name')
                                                                    ->toArray();    
        } else {

        $trainingSites = $this->Courses->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
        $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();

        $courseTypeCategories = $this->Courses->CourseTypeCategories->find()
                                                                    ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                    ->all()
                                                                    ->combine('id','name')
                                                                    ->toArray();
        $tenantUsers = $this->TenantUsers
                ->find('list', [
                    'valueField' => function ($row) {
                        return $row['first_name'] . ' ' . $row['last_name'];
                    }
                ])
                ->where(['tenant_id' => $loggedInUser['tenant_id']])->all()->toArray();                                                            
        }
        if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          $corporateClients = $this->Courses->CorporateClients->find()
                                                                ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                                ->all()
                                                                ->combine('id','name')
                                                                ->toArray();
          $locations = $this->Courses->Locations->find()
                                                ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
          
          $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name'])
                                            ->all()
                                            ->combine('id', 'first_name');

        }
        $courseTypes = $this->Courses->CourseTypes->find()
                                                  ->where(['status' => 1])
                                                  ->all()
                                                  ->combine('id','name')
                                                  ->toArray();
        
        // $displayTypes = $this->DisplayTypes->find()->all()->toArray();

        $displayTypes = $this->DisplayTypes->find()
                                            ->select(['id','name'])
                                            ->all()
                                            ->combine('id', 'name');
        $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name','last_name','email','phone_1'])
                                            // ->all()
                                            ->combine('id', function($val){
                                                  return $val->first_name.' '.$val->last_name.' ( '.$val->email.' )('.$val->phone_1.')';
                                                 })
                                            ->toArray();

        $this->set('trainingSiteOwner', $trainingSiteOwner);
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('course','instructors', 'tenants', 'locations', 'trainingSites', 'corporateClients', 'courseTypeCategories', 'courseTypes','instructors','addons','courseDates','displayTypes','getCourseDates','getCourseDateCount','courseInstructors','tenant_config_settings','tenantUsers','loggedInUser'));

    }

    /**
     * reopenCourse method
     *
     * @return \Cake\Http\Response|void
     */
    public function reopenCourse(){
        $this->loadModel('Agencies');
        $this->loadModel('CourseTypes');
        $loggedInUser = $this->Auth->user();
        $agencies = $this->Agencies->find()->indexBy('id')->toArray();
        // pr($agencies);die;
        // $courseTypes = $this->CourseTypes->find()->indexBy('id')->toArray();
        // $closedCourses = $this->Courses
        //                       // ->find()
        //                       ->findByStatus('closed')
        //                       ->contain([
        //                         // 'TrainingSites', 
        //                         // 'CourseTypes'
        //                       ])
        //                       ->toArray();
        // pr($closedCourses);die;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // pr($data); die();
            $courseId = $data['Course_ID'];
            // pr($courseId); die();
            $course = $this->Courses->find()->where(['id'=>$courseId,'tenant_id'=>$loggedInUser['tenant_id']])->first();
            if (!$course) {
                $this->Flash->error(__('Course not found'));
                return;
            }
            if($course['status'] != 'closed'){
                $this->Flash->error(__('This Course is already open!'));
                return $this->redirect(['action' => 'reopenCourse']);
            }
            else{
                $course['status'] = 'publish';
                $course = $this->Courses->patchEntity($course, $this->request->getData());
            }
            if ($this->Courses->save($course)) {
             $this->Flash->success(__('The course has been Reopened successully'));
                
                    return $this->redirect(['action' => 'view', $courseId]);

        }else{
           $this->Flash->error(__('This Course could not be reopened. Please try again!'));
            return $this->redirect(['action' => 'reopenCourse']); 
        }

        }
        $this->set(compact('agencies','courseTypes'));
    }
    /**
     * Cancel method
     *
     * @return \Cake\Http\Response|void
     */
    public function cancel($id = null)
    {
      // pr('hi');die;
      $course = $this->Courses->get($id, [
            'contain' => ['CourseTypes.Agencies','CourseDates','Locations','CourseStudents.Students','TrainingSites','CourseInstructors.Instructors']
      ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
              // pr($course->course_instructors);die;
                $course['status'] = 'Cancelled';
                $course = $this->Courses->patchEntity($course, $this->request->getData());
      if ($this->Courses->save($course)) {
        if(isset($course->course_students) && !empty($course->course_students)):
        foreach ($course->course_students as $data):
          if($data->payment_status != 'Not Paid'){ 
        $emailData = [
          'name' => $data->student->first_name,
          'email' => $data->student->email,
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
          'training_site_name' => $course->training_site->name,
          'training_site_email' => $course->training_site->contact_email,
          'training_site_phone' => $course->training_site->phone,
        ]; 


        }else{
          $emailData = [];
        }
        if(isset($emailData) && !empty($emailData)):
        $event = new Event('cancel_course', $this, [
             'hashData' => $emailData,
             'tenant_id' => $course->tenant_id
        ]);
        $this->getEventManager()->dispatch($event);
        endif;
        endforeach;
        foreach ($course->course_instructors as $data):
          $emailData = [
          'name' => $data->instructor->first_name,
          'email' => $data->instructor->email,
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
          'training_site_name' => $course->training_site->name,
          'training_site_email' => $course->training_site->contact_email,
          'training_site_phone' => $course->training_site->phone,
        ];
        if(isset($emailData) && !empty($emailData)):
        $event = new Event('cancel_course', $this, [
             'hashData' => $emailData,
             'tenant_id' => $course->tenant_id
        ]);
        $this->getEventManager()->dispatch($event);
         endif;
        endforeach;
        endif;


                $this->Flash->success(__('The course status set to Cancelled - Emails to all students has been sent. '));

                return $this->redirect(['action' => 'view',$id]);
            }
            $this->Flash->error(__('The course could not be Cancelled. Please, try again.'));
      }
        

      
    }



    /**
     * Roster method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */

    public function roster($id = null){
      // die('sss'); 
      $this->viewBuilder()->setLayout('popup-view');
      $this->loadModel('Instructors');
      $course = $this->Courses->get($id, [
            'contain' => []
      ]);
      // pr($course); die('sss');
      $oldImageName = $course->document_name;
        $path = Configure::read('ImageUpload.unlinkPathForCourseRoster');


       $loggedInUser = $this->Auth->user();
       // pr($loggedInUser);die();
        if ($this->request->is(['patch', 'post', 'put'])) {
          $requestData = $this->request->getData();
          // pr($requestData); die('ss');
            $course = $this->Courses->patchEntity($course,  $requestData);
            // pr($course); die('ss');
            if ($this->Courses->save($course)) {
              if(empty($requestData['document_name']['tmp_name'])){

              unset($requestData['document_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('Roster has been saved.'));
                // $popupLayout = $this->request->getQuery('layoutType');
                if($loggedInUser['role']->name == self::TENANT_LABEL){
                    $this->redirect(['action' => 'view', $course->id]);
                } elseif($loggedInUser['role']->name == self::INSTRUCTOR_LABEL){
                    $this->redirect(['controller' => 'Instructors','action' => 'viewCourse',$course->id]);
                } else {
                    $this->redirect(['controller' => 'Courses','action' => 'view',$course->id]);
                }

            }
            else{$this->Flash->error(__('Roster could not be saved. Please, try again.'));
          }
        }
      $this->set(compact('course', 'closeIframe'));
    }

    public function removeRoster($id=null){

    $this->viewBuilder()->setLayout('popup-view');
    $course = $this->Courses->get($id, [
            'contain' => []
      ]);
    $loggedInUser = $this->Auth->user();
    // // pr($course->document_name);die();
    //         // $data = array();
    //         $data = $this->request->getData();
    //         $data['document_name'] = $course->document_name;
    //         $data['document_path'] = $course->document_path;
    //         // pr($data);die();
    //         $data['document_name'] = null;
    //         $data['document_path'] = null;
    //         // unset($data['document_name']);
    //         // unset($data['document_path']);
            
    //         // pr($data);die();
        if ($this->request->is(['patch', 'post', 'put'])) {
    //         $course = $this->Courses->patchEntity($course,  $data);
    //        
            $this->Courses->updateAll(
                [  // fields
                    'document_name' => null,
                    'document_path' => null
                ],
                [  // conditions
                    'id' => $id
                ]
            );
            $this->Flash->success(__('The roster has been deleted.'));

            if($loggedInUser['role']->name == self::TENANT_LABEL){
                 $this->redirect(['action' => 'view',$course->id]);
            }
            elseif($loggedInUser['role']->name == self::INSTRUCTOR_LABEL){
                 $this->redirect(['controller'=>'instructors','action'=>'viewCourse',$course->id]);
            } else {
                 $this->redirect(['controller'=>'courses','action'=>'view',$course->id]);
            };
        } else {
            $this->Flash->error(__('The roster could not be deleted. Please, try again.'));
    }
        // $this->set(compact('course', 'closeIframe'));
}

    public function closeCourse($id = null)
    {
       
    $course = $this->Courses->get($id, [
            'contain' => []
      ]);
    // pr($course);die;
            if ($this->request->is(['patch', 'post', 'put'])) {
                $course['status'] = 'closed';
                $course = $this->Courses->patchEntity($course, $this->request->getData());
                // $requestData = $this->request->getData();
                // pr($requestData);die;
                
            
                if ($this->Courses->save($course)) {
                    $this->Flash->success(__('The course has been closed'));
                    return $this->redirect(['action' => 'view', $course->id]);

                }else{
                    $this->Flash->error(__('The course could not be closed. Please, try again.'));
                }

            }
            $this->set(compact('course'));
     }

    public function notes($id = null){

      $this->viewBuilder()->setLayout('popup-view');
      $this->loadModel('Instructors');
      $course = $this->Courses->get($id, [
            'contain' => []
      ]);
       $loggedInUser = $this->Auth->user();

        if ($this->request->is(['patch', 'post', 'put'])) {
          $requestData = $this->request->getData();
          $course['status'] = 'confirmed';
            $course = $this->Courses->patchEntity($course,  $requestData);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been confirmed.'));
                $popupLayout = $this->request->getQuery('layoutType');
            if($loggedInUser['role']->name == self::TENANT_LABEL){
                     $this->redirect(['action' => 'view', $course->id]);

            } elseif($loggedInUser['role']->name == self::INSTRUCTOR_LABEL) {
                     $this->redirect(['controller'=>'Instructors','action' => 'viewCourse',$course->id]);
            } else {
                     $this->redirect(['controller'=>'Courses','action' => 'view',$course->id]);
            };

            }
            else{$this->Flash->error(__('Notes could not be saved. Please, try again.'));
          }
        }
      $this->set(compact('course', 'closeIframe','loggedInUser'));
    }



    function validEmail($email){
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }


    //This function is for registering new and exising students to a new Course//
    public function register($id){
        $this->loadModel('Students');
        $this->viewBuilder()->setLayout('popup-view');


      
        if($id){
        $course = $this->Courses->get($id, [
            'contain' => ['Locations','CourseTypes.Agencies','CourseDates','CourseTypeCategories','TrainingSites']
        ]);
        } else {
             $this->Flash->error(__('The course does not exist. Please, try again.'));
             return $this->redirect(['action' => 'register',$course->id]);
        }

        // $emailFlag = 1;


        // // $saveStudents = $this->Students->registerStudents($this->request->getData('studentDetails'), $course,$emailFlag,1); 
        //  $loggedInUser = $this->Auth->user();
        // // $student = $this->Students->newEntity();
        // $data = $this->request->getData();
        // $data['training_site_id'] = $course->training_site_id;
        // $data['tenant_id'] = $course->tenant_id;
        // $data['corporate_client_id'] = $course->corporate_client_id;
        // $data['course_students'][] = [
        //                                 'course_id' => $id,
        //                                 'payment_status' => 'Not Paid'
        //                              ];
        // // $data['course_students'][] = ['payment_status' => 'Not Paid'];
        // // $data['/'] = $course->password;
        //                              // pr($data);die;

        // $courseTypeCategory = $course->course_type_category?$course->course_type_category->name:"No information available!";
        // $courseType  = $course->course_type?$course->course_type->name:"No information available!";
        // $trainingSite = $course->training_site?$course->training_site->name:"No information available!";
        // $courseId = $course->id;
        // $locationName = $course->location?$course->location->name:"No information available!";
        // $locationAddress = $course->location?$course->location->address:"No information available!";
        // $locationCity = $course->location?$course->location->city:"No information available!";
        // $locationState = $course->location?$course->location->state:"No information available!";
        // $locationZipcode = $course->location?$course->location->zipcode:"No information available!";
        // $url = Router::url('/', true);

       
        // // pr($message);die();


        // if(isset($course->course_type_category)){
        //   $courseTypeCategory = $course->course_type_category->name;
        // } else {
        //   $courseTypeCategory = "No data exits";
        // }             
        // if(isset($course->course_type)){
        //   $courseType  = $course->course_type->name;
        // } else {
        //   $courseType  = 'No data exits';  
        // }              
        // if(isset($course->training_site)){  
        //   $trainingSite = $course->training_site->name;
        // } else {
        //   $trainingSite = 'No data exists';  
        // }
        //   $courseId = $course->id;
        // if(isset($course->location) && !empty($course->location)){
        //   $locationName = $course->location->name;
        //   $locationAddress = $course->location->address;
        //   $locationCity = $course->location->city;
        //   $locationState = $course->location->state;
        //   $locationZipcode = $course->location->zipcode;
        // }else {
        //   $locationAddress= "No data exits";  
        //   $locationName = "No data exits";
        //   $locationCity = "No data exits";
        //   $locationState = "No data exits";
        //   $locationZipcode = "No data exits";
        // }
        // if ($this->request->is('post')) {

        //     // $studentDetails = $this->request->getData;
        //     // pr($studentDetails);die();
        //     $studentNumbers =(explode("\n",$this->request->getData('studentDetails')));
        //     // pr($studentNumbers);die;
           
        //     $reqData = [];
        //     $reqData['send_email_to_student'] = $data['send_email_to_student'];
        //     $abort = false;
        //     foreach($studentNumbers as $key => $value){
        //           $studentData = explode(",", $value);
                    
        //             // pr($value);
        //             if(count($studentData) > 4){
        //               // die('here');
        //                 $this->Flash->error(__(' Please enter details of student in new lines!'));

        //               break;
        //             }
        //             if(!empty($studentData[2]) && isset($studentData[2])){
        //               $email = trim($studentData[2]);
        //               $emailValidator = $this->validEmail($email);
        //               $student = $this->Students->findByEmail($email)->first(); 
        //               if($student){ 
        //                   $this->Flash->error(__($email.' already exists. Please try again!'));
        //                   // return $this->redirect(['action' => 'register',$course->id]);
        //               // pr('here');
        //               }
                 
        //               if(!$emailValidator) {
        //                 $abort = true;
        //                 break;
        //               }
        //               $password = substr($studentData[0], 0, 3).substr($studentData[0], 0, 3);

        //               $reqData[] = [
        //                           'first_name' => $studentData[0],
        //                           'last_name' => $studentData[1],
        //                           'phone1' => $studentData[3],
        //                           'email' => $email,
        //                           'tenant_id' => $data['tenant_id'],
        //                           'training_site_id' => $data['training_site_id'],
        //                           'corporate_client_id' => $data['corporate_client_id'],
        //                           'password' => $password ,
        //                           'status' => 1,
        //                           'role_id' => 5,
        //                           'course_students' => $data['course_students']
        //                        ];
        //           }
        //       // $this->Flash->error(__('Please enter First Name, Last Name, Email.'));
        //     }
        //         // die();
        //     if(!$abort)
        //      {

        //     // pr($reqData);die();

        //     $students = $this->Students->newEntities($reqData);
        //     $students = $this->Students->patchEntities($students, $reqData);
        //     // pr($students);die;

        //     // $student = $this->Students->patchEntity($student, $data);
        //     if ($this->Students->saveMany($students)) {
        //         // pr($students);die;
        //         $emailFlag = $reqData['send_email_to_student'];
        //         if($emailFlag == true){

        //             foreach($students as $reqData){

        //             $name = $reqData['first_name'].' '.$reqData['last_name'];
        //             $email = $reqData['email'];
                    

        //             $emailData = [
        //               'name' => $name,
        //               'email' => $email,
        //               'course_id' => $course->id,
        //               'course_type' => $courseType,
        //               'email_content'=> "You have been Registered to ".$course->training_site->name.". Your username and password is mentioned below: <br>",
        //               'username' => "Username : ".$email,
        //               'password' => "Password : ".$password,
        //               'to_login' => "You can Login at :".$url.'students/login',
        //               'course_type_agency' => $course->course_type->agency->name,
        //               'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
        //               'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
        //               'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
        //               'location_name' => $locationName,
        //               'location_address' => $locationAddress,
        //               'location_city' => $locationCity,
        //               'location_state' => $locationState,
        //               'location_zipcode' => $locationZipcode,
        //               'training_site_name' => $course->training_site->name,
        //               'training_site_email' => $course->training_site->contact_email,
        //               'training_site_phone' => $course->training_site->phone,
        //               'server_name' => $url.'students/login',
        //             ];
        //             if(isset($emailData) && !empty($emailData)):
        //               $event = new Event('register_student_to_course', $this, [
        //                    'hashData' => $emailData,
        //                    'tenant_id' => $course->tenant_id
        //               ]);
        //               $this->getEventManager()->dispatch($event);
        //             endif;
        //              }
        //         }
        //         // pr('here');pr($students);die();
        //         $this->Flash->success(__('The students have been saved.'));
        //         return $this->redirect(['action' => 'register',$course->id]);
        //      }
        //     }
        //     // pr('there');pr($students);die();
        //     if(empty($reqData['first_name']) && empty($reqData['last_name']) && empty($reqData['email'])){
        //     $this->Flash->error(__('Please enter First Name, Last Name, Email'));   
        //     }
        //     // if(empty($reqData['last_name'])){
        //     // $this->Flash->error(__('Please enter last name'));   
        //     // }
        //     // if(empty($reqData['email'])){
        //     // $this->Flash->error(__('Please enter email'));   
        //     // }
        //     $this->Flash->error(__('The student(s) could not be saved. Please, try again.'));
           
      // }
        $this->set(compact('students','course','addStudent','courseStudent','id'));
    }

 
    public function addStudentToCourse($id)
    {
        $this->viewBuilder()->setLayout('popup-view'); 
        $this->loadModel('Students');
        $this->loadModel('CourseStudents');
        // pr($this->request->getData());die();
        if($id){
        $course = $this->Courses->get($id, [
            'contain' => ['Locations','CourseTypes.Agencies','CourseDates','CourseTypeCategories','TrainingSites']
        ]);
        }
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // pr($data);die();
            $courseTypeCategory = $course->course_type_category?$course->course_type_category->name:"No information available!";
            $courseType  = $course->course_type?$course->course_type->name:"No information available!";
            $trainingSite = $course->training_site?$course->training_site->name: "No data available!";
            $courseId = $course->id;
            $locationName = $course->location?$course->location->name:"No data available!";
            $locationAddress = $course->location?$course->location->address:"No data available!";
            $locationCity = $course->location?$course->location->city:"No data available!";
            $locationState = $course->location?$course->location->state:"No data available";
            $locationZipcode = $course->location?$course->location->zipcode:"No data available";
            $servername = $this->request->host()."/students/login";

            if(!empty($data['student_ids'])){
                $courseStudents = [];
                foreach ($data['student_ids'] as $key => $value) {
                    $courseStudents[] = [
                                            'course_id' => $id,
                                            'student_id' => $value,
                                            'payment_status' => 'Not Paid'
                                        ];
                }
                $courseStudents = $this->CourseStudents->newEntities($courseStudents);
                if ($this->CourseStudents->saveMany($courseStudents)) {
                  // pr($courseStudents);die;
                    $emailFlag = $data['send_email_to_student'];
                    if($emailFlag == true){
                        foreach ( $courseStudents as $getStudents) {
                      $studentId = $getStudents->student_id;
                      $studentInfo = $this->Students->findById($studentId)->first();

                    // pr($course);
                       $emailData = [
                        'name' => $studentInfo->first_name,
                        // 'email' => 'mihir.dayal@twinspark.co',
                        'email' => $studentInfo->email,
                        'email_content' => "",
                        'username' => "",
                        'password' => "",
                        'to_login' => "",
                        'course_id' => $course->id,
                        'course_type' => $courseType,
                        'course_type_agency' => $course->course_type->agency->name,
                        'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
                        'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
                        'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
                        'location_name' => $locationName,
                        'location_address' => $locationAddress,
                        'location_city' => $locationCity,
                        'location_state' => $locationState,
                        'location_zipcode' => $locationZipcode,
                        'training_site_name' => $course->training_site->name,
                        'training_site_email' => $course->training_site->contact_email,
                        'training_site_phone' => $course->training_site->phone,
                        'server_name' => $servername,
                      ];
                      
                        $event = new Event('register_student_to_course', $this, [
                             'hashData' => $emailData,
                             'tenant_id' => $course->tenant_id
                        ]);
                        $this->getEventManager()->dispatch($event);
                      }
                    }
                    $this->Flash->success(__('The student(s) have been added.'));
                    return $this->redirect(['action' => 'addStudentToCourse',$id]);
                }
                $this->Flash->error(__('The student(s) could not be added. Please, try again.'));
            }else{
                $this->Flash->error(__('Please select some students'));
            }

        }
       
        // $existingCourseStudents = $this->CourseStudents->   
        // }
        // pr($loggedInUser);die();
        $existingCourseStudents = $this->CourseStudents->findByCourseId($id)->extract('student_id')->toArray();
        // pr($existingCourseStudents);die();
        if($loggedInUser['role_id'] == 3){
        $studentsConditions = [
                                  'tenant_id'=>$loggedInUser['corporate_client']['tenant_id'],
                              ];
                              // pr('here');die();  
        } else {

        $studentsConditions = [
                                  'tenant_id'=>$this->Auth->user('tenant_id'),
                              ];
                              // pr('there');die();
       
        }
        // pr($studentsConditions);die();
        if(!empty($existingCourseStudents)){
            $studentsConditions['id Not IN'] = $existingCourseStudents;
        }

        $students = $this->Students->find()
                                   ->where($studentsConditions)
                                   ->combine('id', function($val){
                                        return $val->last_name.' , '.$val->first_name.' ( '.$val->email.' )';
                                    })
                                   ->toArray();

        $course = $this->Courses->findById($id)->first();
        $this->set(compact('course','students'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Course id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    public function delete($id = null)
    {
        $this->request->allowMethod(['get','post', 'delete']);
        $course = $this->Courses->get($id);
        if($course->status == 'draft'){
            $redirect = 'index?request=draft';
        }else{
            $redirect = 'index';
        }

        if ($this->Courses->delete($course)) {
            $this->Flash->success(__('The course has been deleted.'));
        } else {
            $this->Flash->error(__('The course could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => $redirect]);
    }

    public function trainingOpportunityReassignmentNotification($courseId,$instructorIds){
      if(!empty($instructorIds)){
        // pr($instructorIds);die;
        $courseData = $this->Courses->findById($courseId)->contain(['Locations','CourseDates','CourseTypes.Agencies','TrainingSites','CourseInstructors.Instructors' => function($q)use($instructorIds){
          return $q->where(['Instructors.id IN' => $instructorIds]);
        }])->first();
      }

      $emailData = [  'training_site_name' => $courseData->training_site->name,
                      'training_site_phone' => $courseData->training_site->contact_phone,
                      'training_site_email' => $courseData->training_site->contact_email,
                      'course_id' => $courseData->id,
                      'course_type' => $courseData->course_type->name,
                      'course_type_agency' => $courseData->course_type->agency->name,
                      'course_date' => $courseData->course_dates[0]->course_date->format('Y-M-d'),
                      'course_start_time' => $courseData->course_dates[0]->time_from->format('h-i'),
                      'location_city' => $courseData->location->city,
                      'location_state' => $courseData->location->state,

                    ];
        // pr($emailData);die;
        $course = (new Collection($courseData->course_instructors))->map(function($val)use($emailData, $courseData){
                                        // pr($emailData);
                                        $emailData['first_name'] = $val->instructor->first_name;
                                        $emailData['last_name'] = $val->instructor->last_name;
                                        $emailData['email'] = $val->instructor->email;
                                        // pr($emailData);
                                         $event = new Event('training_opportunity_reassignment_notification_instructor', $this, [
                                                           'hashData' => $emailData,
                                                           'tenant_id' => $courseData->tenant_id
                                                      ]);
                                        $this->getEventManager()->dispatch($event);
                                        })->toArray();
        // die('here');
    }
    // public function test(){
    //   pr('here');
    // }

   public function revokeCourseAccess($id = null) {
        $this->loadModel('TransferCourses');
        $transferCourse = $this->TransferCourses->findById($id)
                                                ->first();
                                                // pr($transferCourse->access_revoked);die;

        if(!$transferCourse) {
          $this->Flash->error(__('Unable to process your request'));
          throw new Exception("Not Found", 1);
        }else {
          if($transferCourse->access_revoked == 1){
            $data['access_revoked'] = 0;
          }else{
            $data['access_revoked'] = 1;
          }
          // pr(gettype($data['access_revoked'])); 
        }
          // pr($data);

        $transferCourse = $this->TransferCourses->patchEntity($transferCourse,$data);
            if ($this->TransferCourses->save($transferCourse)) {
              if($transferCourse->access_revoked == 1){

                $this->Flash->success(__('The access has been successully revoked'));
                $this->loadModel('Tenants');
                $this->loadModel('Courses');
                $course = $this->Courses->findById($transferCourse['course_id'])
                                        ->contain(['CourseTypes'])
                                        ->first();
                $tenant = $this->Tenants->findById($transferCourse['tenant_id'])
                                        ->first();
                $assignerTenant = $this->Tenants->findById($transferCourse['assigning_tenant_id'])
                                        ->first();
                


                $emailData1 = [
                  "center_name" => $tenant->center_name,
                  'email' => $tenant->email,
                  'assigner_center_name' => $assignerTenant->center_name,
                  'course_name' => $course->course_type->name,
                  'course_id' => $course->id,
                  'assigner_email' => $assignerTenant->email,                  
                ];

                if(isset($emailData1)){

                  $event = new Event('revoke_access_for_course', $this, [
                       'hashData' => $emailData1,
                       'tenant_id' => $assignerTenant->id
                  ]);
                  $this->getEventManager()->dispatch($event);
                }

              }else{
                $this->Flash->success(__('The access has been successully granted'));
                

              }

            } else {
            $this->Flash->error(__('This action could not be performed. Please, try again.'));
            }
        // pr($transferCourse);die;
            return $this->redirect(['action' => 'transferCourse', $transferCourse->course_id]);
   }


}
