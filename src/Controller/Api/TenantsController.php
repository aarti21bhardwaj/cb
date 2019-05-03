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
use Cake\Routing\Router;
use Cake\Utility\Security;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Collection\Collection;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;



/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class TenantsController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','login','socialLogin','socialSignup','updatePassword','getTrainingSites','indexSettings','dashboardDataRefresh']);
    }

      public function updatePassword(){
        if(!$this->request->is(['put'])){
          // die('aa gaye idhar');
          throw new MethodNotAllowedException(__('BAD_REQUEST'));
        }
        $data = $this->request->getData();
        // die('aaa');
        // pr($data['new_password']);
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
        $this->loadModel('TenantUsers');
        $user = $this->TenantUsers->find()
                                  ->where(['TenantUsers.id'=>$id])
                                  ->contain(['Tenants'])
                                  ->first();

        if(!$user){
          throw new NotFoundException(__('ENTITY_DOES_NOT_EXISTS','User'));
        }

        $password = $data['new_password'];
        $reqData = ['password'=>$password];
        $user = $this->TenantUsers->patchEntity($user, $reqData);
        if($this->TenantUsers->save($user)){

                 $url = Router::url('/', true);
                 $emailData = [
                'name' => $user->first_name,
                'email' => $user->email,
                'server_name' => $url,
                'user_name' => $user->email,
                'user_password'=> $data['new_password'],
                'tenant_name' => $user->tenant->center_name
               ];
                $event = new Event('password_update_tenant', $this, [
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

      public function getTrainingSites($tenantId = null){
        if(!$this->request->is(['get'])){
          throw new MethodNotAllowedException(__('BAD_REQUEST'));
        }
        if(!$tenantId){
          throw new NotFoundException(__('Tenant id not found'));
        }
        $trainingSites = $this->Tenants->TrainingSites->find()
                                                      ->where(['tenant_id' => $tenantId])
                                                      ->all()
                                                      ->toArray();

        if(empty($trainingSites)){
          throw new NotFoundException(__('Training Site for this Tenant has not been found'));
        }

        $this->set('response',$trainingSites);
        $this->set('_serialize', ['response']);
      }
      public function dashboardDataRefresh(){
        // pr('test');die;
        $tenant_id = $this->Auth->user('tenant_id');
        $this->loadModel("Instructors");
        $this->loadModel('InstructorQualifications');
        $this->loadComponent('DashboardRefresh');
        $todayDate = FrozenTime::now();
        $fetchData['expiringThreeMonths'] = $this->DashboardRefresh->fetchData($tenant_id,'expiringThreeMonths');
      $fetchData['expiringToday'] = $this->DashboardRefresh->fetchData($tenant_id,'expiringToday');
      $fetchData['pendingQualifications'] = $this->DashboardRefresh->fetchData($tenant_id,'pendingQualifications');
      $fetchData['courseDates'] = $this->DashboardRefresh->fetchData($tenant_id,'courseDates');
      $fetchData['courseInstructors'] = $this->DashboardRefresh->fetchData($tenant_id,'courseInstructors');
      $fetchData['incompleteCheckout'] = $this->DashboardRefresh->fetchData($tenant_id,'incompleteCheckout');
      // pr($fetchData['courseInstructors']);die;
      if(isset($fetchData['expiringThreeMonths']['expiringThreeMonths'])){
        $expiringThreeMonths = $fetchData['expiringThreeMonths']['expiringThreeMonths'];
        $expiringThreeMonths = $this->_unsetKey($expiringThreeMonths);
        
      }
      if(isset($fetchData['expiringToday']['expiringToday'])){
        $expiringToday = $fetchData['expiringToday']['expiringToday'];
        $expiringToday = $this->_unsetKey($expiringToday);
        
      }
      if(isset($fetchData['pendingQualifications']['pendingQualifications'])){
        $pendingQualifications = $fetchData['pendingQualifications']['pendingQualifications'];
        $pendingQualifications = $this->_unsetKey($pendingQualifications);
        
      }
      if(isset($fetchData['courseDates'])){
        $courseDates = $fetchData['courseDates']['courseDates'];
        $location = $fetchData['courseDates']['location'];
        $courseDates = $this->_unsetKey($courseDates);
        
      }
      if(isset($fetchData['courseInstructors'])){
        $courseInstructors = $fetchData['courseInstructors']['courseInstructors'];
        $courses = $fetchData['courseInstructors']['courses'];
        $instructorsData = $fetchData['courseInstructors']['instructorsData'];
        $courseInstructors = $this->_unsetKey($courseInstructors);
      }
      if(isset($fetchData['incompleteCheckout'])){
        $incompleteCheckout = $fetchData['incompleteCheckout']['incompleteCheckout'];
        $incompleteCheckout = $this->_unsetKey($incompleteCheckout);
      }
        $response = [
                      'expiringToday' => $expiringToday,
                     'expiringThreeMonths' => $expiringThreeMonths,
                     'pendingQualifications' => $pendingQualifications,
                     'incompleteCheckout' => $incompleteCheckout,
                     'courseDates' => $courseDates,
                     'location' => $location,
                     'courseInstructors' => $courseInstructors,
                     'courses' => $courses,
                     'instructorsData' => $instructorsData
                   ];
        $this->set(compact('response'));
        $this->set('_serialize',['response']);           

      }
      private function _unsetKey($data){
      foreach ($data as $key => $value) {
        if(empty($value)){
          unset($data[$key]);
        }
      }
      return $data;
      // unset($courseDates['expiringToday']);
    }
    public function indexSettings(){
      $tableName = $this->request->getData('tableName');
      $response = Configure::read($tableName);
      $this->set(compact('response'));
      $this->set('_serialize',['response']);

    }
}
