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
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\Routing\Router;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class InstructorsController extends ApiController
{
	 public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['getInstructor','updatePassword','getInstructorByLocation']);
    }
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        if (in_array($action, ['getInstructorByQualification','getInstructor','getInstructorByLocation','updatePassword','passwordChange','index','getStudentActions','roleData','getStatus','getQualificationsData']) && $user['role']->name === self::TENANT_LABEL) {
            return true;
        }
         else if (in_array($action, ['getInstructorByQualification','getInstructor','getInstructorByLocation','updatePassword','passwordChange','index','getStudentActions','roleData','getStatus','getQualificationsData']) && $user['role']->name === self::CLIENT_LABEL) {
            return true;
        }
         else if (in_array($action, ['getInstructorByQualification','getInstructor','getInstructorByLocation','updatePassword','passwordChange','index','getStudentActions','roleData','getStatus','getQualificationsData']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
            return true;
        }
         else if (in_array($action, ['getInstructorByQualification','getInstructor','getInstructorByLocation','updatePassword','passwordChange','index','getStudentActions','roleData','getStatus','getQualificationsData']) && $user['role']->name === self::STUDENT_LABEL) {
            return true;
        }
    }

    public function getInstructor()
    {
      $query =  $this->request->query('request');
      // pr($query);
      $loggedInUser = $this->Auth->user();
      $instructors = $this->Instructors->find()
                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                            ->select(['id','first_name']);
                                            if($query == 'alpha'){
                                              $instructors->order(['first_name' => 'ASC']);
                                            }
                                            $instructors->combine('id', 'first_name')->toArray();
                                            // pr($instructors);die('ssss');
      $this->set(compact('instructors'));
      $this->set('_serialize', ['instructors']);
    }
    public function getInstructorByQualification(){
      $query =  $this->request->query('request');
      $loggedInUser = $this->Auth->user();
      // pr($query);die;
      $this->loadModel('CourseTypeQualifications'); 
        $this->loadModel('InstructorQualifications'); 
        $qualification = $this->CourseTypeQualifications->find()
                                                        ->where(['course_type_id' => $query])
                                                        ->contain(['CourseTypes','Qualifications'])
                                                        ->all();
        $qualificationids = (new Collection($qualification))->extract('qualification_id')->toArray();
                                                      // pr($qualificationids);die;
      $qualification = $this->InstructorQualifications->find()
                                                      ->contain(['Instructors' => function($q) use($loggedInUser){
                                                              return $q->where([
                                                                                'tenant_id' => $loggedInUser['tenant_id']
                                                                              ]);
                                                                       
                                                            }])
                                                      ->where(['qualification_id IN' => $qualificationids])
                                                      ->all();
                                                      // pr($qualification);die('hihis');
        $instructorids = (new Collection($qualification))->extract('instructor_id')->toArray();
        $instructors = $this->Instructors->find()
                                         ->where(['id IN' => $instructorids])
                                         ->select(['id','first_name'])
                                         ->toArray();
        // pr($instructors);die;
        $this->set(compact('instructors'));
        $this->set('_serialize', ['instructors']);
    }
    // public function testLocation($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 3959){
      // convert from degrees to radians
    public function getInstructorByLocation(){

      $data = $this->request->getData();
      $loggedInUser = $this->Auth->user();
      $earthRadius = 3959;
      $this->loadModel('Locations');
      $location = $this->Locations->findById($data['location'])
                                  ->first()
                                  ->toArray();
      $this->loadModel('Instructors');
      $instructor = $this->Instructors->findByTenantId($loggedInUser['tenant_id'])
                                      ->all()
                                      ->toArray();
      $finalValues = []; 
      foreach($instructor as $getLatLng){

          $latFrom = deg2rad($location['lat']);
          $lonFrom = deg2rad($location['lng']);
          $latTo = deg2rad($getLatLng->lat);
          $lonTo = deg2rad($getLatLng->lng);

          $latDelta = $latTo - $latFrom;
          $lonDelta = $lonTo - $lonFrom;

          $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
          $final = $angle * $earthRadius;
          $instructorId = $getLatLng->id;
          $finalValues[$instructorId] = $final;
      }
      // pr($finalValues);
      asort($finalValues);
      // pr($finalValues);die; 
      if($data['type'] == 'filter'){
        $max = $data['distance'];
        $finalValue  = array_filter($finalValues, function($value) use($max){
          return($value <= $max);
        });

      }else{
        $finalValue = $finalValues;
      }
      // if($data['type'] == 'nofilter'){
      //     foreach ($finalValue as $key => $value) {
      //        $instructorData = $this->Instructors->findById($key)->first();
      //        $instructorsName = ['id' => $key,
      //                            'first_name' => $instructorData->first_name,
      //                            'last_name' => $instructorData->last_name,
      //                            'email' => $instructorData->email,
      //                            'phone' => $instructorData->phone_1,
      //                            'distance' => $value,
      //                           ];  
      //     }
          
      // }


      $instructorsName = [];
        foreach ($finalValue as $key => $value) {
           $value =  number_format((float)$value, 2, '.', '');
           $instructorData = $this->Instructors->findById($key)->first();
           $instructorsName[] = ['id' => $key,
                               'first_name' => $instructorData->first_name,
                               'last_name' => $instructorData->last_name,
                               'email' => $instructorData->email,
                               'phone' => $instructorData->phone_1,
                               'distance' => $value,
                              ];  
        }
                              // pr($instructorsName);
        // die;
       if(!empty($instructorsName)){
        $instructors = $instructorsName;
       } else {
        $instructors = null;
       }
       // pr($instructors);die;
      $this->set(compact('instructors'));
      $this->set('_serialize', ['instructors']);
    }

    public function updatePassword(){
        if(!$this->request->is(['put'])){
          throw new MethodNotAllowedException(__('BAD_REQUEST'));
        }
        $this->loadModel('TrainingSites');
        $data = $this->request->getData();
        // pr($data);die('here1');
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
        $this->loadModel('Instructors');
        $user = $this->Instructors->find()->where(['id'=>$id])->first();
        // pr($user);die;
        $trainingSiteData = $this->TrainingSites->findById($user->training_site_id)->first();
        // pr($trainingSiteData);die;
        if(!$user){
          throw new NotFoundException(__('ENTITY_DOES_NOT_EXISTS','User'));
        }
        $password = $data['new_password'];
        $reqData = ['password'=>$password];
        $user = $this->Instructors->patchEntity($user, $reqData);
        // die('here');
        if($this->Instructors->save($user)){
        $this->passwordChange($user,$trainingSiteData,$password);
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
      public function passwordChange($user,$trainingSiteData,$password){
       $emailData = [
          "first_name" => $user->first_name,
          'email' => $user->email,
          'training_site_name' => $trainingSiteData->name,
          'training_site_phone' => $trainingSiteData->contact_phone,
          'training_site_email' => $trainingSiteData->contact_email,
          'user_name' => $user->email,
          'user_password' => $password,
          'server_name' => $this->request->host()
        ];
        // pr($emailData);die;
        $event = new Event('account_password_update_instructor', $this, [
             'hashData' => $emailData,
             'tenant_id' => $user->tenant_id
        ]);
        $this->getEventManager()->dispatch($event);
      }
      public function index(){
      $loggedInUser = $this->Auth->user();
      // pr($loggedInUser);die;
      $queryString = $this->getRequest()->getQuery();
      $indexName = Configure::read('Instructors');
      $instructorQualifications = $this->Instructors->InstructorQualifications->find()->indexBy('id')->toArray();
      $instructorApplications = $this->Instructors->TrainingSites->find()->indexBy('id')->toArray();
      $instructorInsuranceForms = $this->Instructors->InstructorInsuranceForms->find()->indexBy('id')->toArray();
      $trainingSites = $this->Instructors->TrainingSites->find()->indexBy('id')->toArray();
      $roleInfo = $this->roleData($loggedInUser['role']->name,$loggedInUser);
      if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
          $roleInfo = $this->roleData('TRAINING SITE OWNER',$loggedInUser);
        }
      $this->paginate = [
                    'limit' => $queryString['length'],
                    'page' => ($queryString['start']/$queryString['length'])+1,
                    'order' => [
                                  'Instructors.'.$indexName[$queryString['order'][0]['column']] => $queryString['order'][0]['dir']
                               ]
                ];
      $instructors = $this->Instructors->find()->where($roleInfo['where']);
      $instructors = $this->instructorSearchIndex($queryString,$instructors);
      $totalInstructors = $instructors->count();
      $instructors = $this->paginate($instructors);
      // pr($instructors);die;
      $response = (new Collection($instructors->toArray()))->map(function($value,$key)use($instructorQualifications,$instructorApplications,$instructorInsuranceForms,$loggedInUser,$trainingSites){
            $data = [
                      $value->first_name,
                      $value->last_name,
                      $value->email,
                      empty($value->delete_at)?$this->getStatus($value):'<span class="badge badge-danger">Deleted</span>',
                      $this->getQualificationsData($value),

                      $value->phone_1,
                      $value->city,
                      $value->state,
                      $this->getStudentActions($value, $loggedInUser)
                    ];      
            return $data;
          // pr($data);die;
      })->toArray();
      // pr($response);die;
       $response = [
                    'draw' => $queryString['draw'],
                    'recordsTotal' => $totalInstructors,
                    'recordsFiltered' => $totalInstructors,
                    'data' => $response,
                ];
        $this->set('response', $response);
        $this->set('_serialize', ['response']);
    }

    public function getStudentActions($instructor, $loggedInUser){

      $id = $instructor->id;
      // $viewUrl = Router::url(['action' => 'view', $id], true);
      $viewUrl = str_replace('api/', '', Router::url(['action' => 'view', $id], true));
      $courseHistoryUrl = str_replace('api/', '', Router::url(['action' => 'courseHistory', $id], true));
      $deleteUrl = str_replace('api/', '', Router::url(['action' => 'delete', $id], true));
      $editUrl = str_replace('api/', '', Router::url(['action' => 'edit', $id], true));
      $restoreUrl = str_replace('api/', '', Router::url(['action' => 'restore', $id], true));
      // pr(gettype($viewUrl));die;
      if(empty($instructor->delete_at)){
      $string = "<a href='#' onclick=openViewPopUp('".$viewUrl."') class='btn btn-xs btn-success' data-toggle='modal' data-target='#myModal'>
                                          <i class='fa fa-eye fa-fw'></i>
                                      </a> ";

      $string2 = "<a href='#' onclick=openViewPopUp('".$courseHistoryUrl."') class='btn btn-xs btn-success' data-toggle='modal' data-target='#myModal'><i class='fa fa-list  fa-fw'></i></a> ";

      $string3 = "<a href='".$editUrl."' class='btn btn-xs btn-warning'><i class='fa fa-pencil fa-fw'></i></a>";
      $string4 = "<a href='".$deleteUrl."' class='btn btn-xs btn-danger'><i class='fa fa-trash-o fa-fw'></i>
                                  </a>";
      $string = $string.' '.$string2.' '.$string3.' '.$string4;
      }else{
        $string = "<a href='".$restoreUrl."' class='btn btn-xs btn-success'>
                                      <i class='fa fa-trash-o fa-fw'></i>
                                  </a>";
      }
      // pr($string);die;
      return $string;
    }

    public function roleData($role,$loggedInUser){
      $roleInfo = [
                      'tenant' => [
                                      'where' => isset($loggedInUser['tenant_id'])?['Instructors.tenant_id ='=>$loggedInUser['tenant_id']]:null,
                                    ],
                      'instructor' => [
                                                'where' =>  isset($loggedInUser)?['Instructors.id'=>$loggedInUser['id']]:null, 
                                                ],
                      'TRAINING SITE OWNER' => [
                                                  'where' => isset($loggedInUser['training_site_id'])?['Instructors.training_site_id ='=>$loggedInUser['training_site_id']]:null,
                                                ]

                  ];
        return $roleInfo[$role];          
    }
    public function getStatus($value){
      $loggedInUser = $this->Auth->user();
      if($value->status == 1){
        if($loggedInUser['role_id'] == '4'){
        $string = "Active"; 
        } else {  
          $updateStatus = str_replace('api/', '', Router::url(['action' => 'updateStatus', $value->id,$value->status], true));
          $string = "<a href='".$updateStatus."'>Active</a>";
        }
      }elseif($value->status == 0){
        if($loggedInUser['role_id'] == '4'){
          $string = "Inactive";
        } else {
          $updateStatus = str_replace('api/', '', Router::url(['action' => 'updateStatus', $value->id,0], true));
          $string = "<a href='".$updateStatus."'>Inactive </a>";
        }
      }
      return $string;
    }
    public function getQualificationsData($value){
      // pr($value);
      $this->loadModel('InstructorInsuranceForms');
      $this->loadModel('instructorApplications');
      $instructorQualificationUrl = str_replace('api/', '', Router::url(['controller' => 'instructorQualifications','action' => 'index', $value->id], true));
      $instructorReferenceUrl = str_replace('api/', '', Router::url(['controller' => 'instructorReferences','action' => 'index', $value->id], true));
      $instructorApllicationUrl = str_replace('api/', '', Router::url(['controller' => 'instructorApplications','action' => 'add', $value->id], true));
      $instructorInsuranceFormUrl = str_replace('api/', '', Router::url(['controller' => 'instructorInsuranceForms','action' => 'add', $value->id], true));
      $instructorInsuranceForms = $this->InstructorInsuranceForms->find()->where(['instructor_id' => $value->id])->first();
      $instructorApplications = $this->instructorApplications->find()->where(['instructor_id' => $value->id])->first();
      if($instructorInsuranceForms){  
      $instructorInsuranceFormUrlEdit = str_replace('api/', '', Router::url(['controller' => 'instructorInsuranceForms','action' => 'edit', $instructorInsuranceForms->id,$value->id], true));
      }
      if($instructorApplications){
        $instructorApllicationUrlEdit = str_replace('api/', '', Router::url(['controller' => 'instructorApplications','action' => 'edit',$instructorApplications->id, $value->id], true));
      }
      // pr($instructorInsuranceForms);
      $string = "<p style='text-align: left;'>Qualifications: 
        <span style='float:right;'>
          <a href='#' onclick=openViewPopUp('".$instructorQualificationUrl."') data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
          </a>
        </span>
      </p>";                          
       $stringReferences = "<p style='text-align: left'>References:
                            <span style='float:right;'>
                              <a href='#' onclick=openViewPopUp('".$instructorReferenceUrl."')  data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
                              </a>
                            </span>            
                            </p>";   
      if($instructorApplications && isset($instructorApplications->document_name)){
                                        
       $stringApplications = "<p style='text-align: left'>Application:
                                <span style='float:right;'>
                                  <a href='#' onclick=openViewPopUp('".$instructorApllicationUrlEdit."')  data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
                                     </a>          
                                </span>            
                              </p>";
      }else{
        
        $stringApplications = "<p style='text-align: left'>Application:
                                    <span style='float:right'>
                                      <a href='#' onclick=openViewPopUp('".$instructorApllicationUrl."')  data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
                                     </a>
                                    </span>            
                                </p>";
      }
      if($instructorInsuranceForms && isset($instructorInsuranceForms->document_name)){
                                        
        $stringInstructorInsuranceForms = "<p style='text-align: left'>Insurance:
                          <span style='float:right;'>
                            <a href='#' onclick=openViewPopUp('".$instructorInsuranceFormUrlEdit."')  data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
                            </a>
                          </span>            
                      </p>";
      }else{

        $stringInstructorInsuranceForms = "<p style='text-align: left'>Insurance:
                  <span style='float:right;'>
                    <a href='#' onclick=openViewPopUp('".$instructorInsuranceFormUrl."')  data-toggle='modal'  data-target='#myModal'><i class='fa fa-eye fa-fw'></i>
                    </a>
                  </span>            
              </p>";
        }

        return $string.$stringReferences.$stringApplications.$stringInstructorInsuranceForms;
        
    }
    public function searchFilter(){
        $columnInfo = [
                            [
                                'name_key' => 'first_name',
                                'where'  => 'Instructors.first_name Like' ,
                                'matching' => false,
                                'genericMatching' => false,              
                            ],
                            [
                                'name_key' => 'last_name',
                                'where'  => 'Instructors.last_name Like',
                                'matching' => false,
                                'genericMatching' => false              
                            ],
                            [
                                'name_key' => 'email',
                                'where'  => 'Instructors.email Like',
                                'matching' => false,
                                'genericMatching' => false            
                            ],
                            [
                                'name_key' => 'phone',
                                'where'  => 'Instructors.phone_1 Like',
                                'matching' => false,
                                'genericMatching' => false              
                            ],
                            [
                                'name_key' => 'city',
                                'where'  => "Instructors.city Like",
                                'matching' => false,
                                'genericMatching' => false              
                            ],
                            [
                                'name_key' => 'state',
                                'where'  => 'Instructors.state Like',
                                'matching' => false,
                                'genericMatching' => false,
                            ],
                      ];
         return $columnInfo;             
    }
    public function instructorSearchIndex($queryString,$instructors){
      $columnInfo = $this->searchFilter();
      foreach ($columnInfo as $key => $value) { 
            if(!((isset($queryString['search']) && $queryString['search']['value']))){
                continue;
            }
            $searchValue = (string)$queryString['search']['value'];
            if($value['where']){
                $where['OR'][] = [$value['where'] => '%'.$searchValue.'%'];
            }
        }
        if(((isset($queryString['search']) && $queryString['search']['value']))){
              $instructors->where($where);
            }
        return $instructors;  
    }
}