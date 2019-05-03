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
class UsersController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['add','login','socialLogin','socialSignup','updatePassword']);
    }

      public function updatePassword(){
        $this->loadModel('TrainingSites');
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
        $this->loadModel('Users');
        $user = $this->Users->find()->where(['Users.id'=>$id])->first();
        
        if(!$user){
          throw new NotFoundException(__('ENTITY_DOES_NOT_EXISTS','User'));
        }
        $password = $data['new_password'];
        $reqData = ['password'=>$password];
        $user = $this->Users->patchEntity($user, $reqData);
        if($this->Users->save($user)){

           // $host = Router::url('/', true);
           //       $emailData = [
           //      'name' => $user->first_name,
           //      'email' => $user->email,
           //      'servername' => $host.'users/login',
           //      'user_name' => $user->email,
           //      'user_password'=> $data['new_password']
           //     ];
           //      $event = new Event('password_update_super_admin', $this, [
           //     'hashData' => $emailData,
           //     'tenant_id' => null
           //      ]);
           //      $this->getEventManager()->dispatch($event);
                
          // $reqData = ['user_id'=>$id,'password'=>$password];
          // $userOldPasswordCheck = $this->UserOldPasswords->newEntity($reqData);
          // $userOldPasswordCheck = $this->UserOldPasswords->patchEntity($userOldPasswordCheck, $reqData);
          // if($this->UserOldPasswords->save($userOldPasswordCheck)){
          //   $userOldPasswordCheck = $this->UserOldPasswords->find('all')->where(['user_id'=>$id]);
          //   if($userOldPasswordCheck->count() > 6){
          //     $userOldPasswordCheck =$userOldPasswordCheck->order('created ASC')->first();
          //     $userOldPasswordCheck = $this->UserOldPasswords->delete($userOldPasswordCheck);
          //   }
            $data =array();
            $data['status']=true;
            $data['data']['id']=$user->id;
            $data['data']['message']='password saved';
            $this->set('response',$data);
            $this->set('_serialize', ['response']);
          // }else{
          //   // pr($userOldPasswordCheck->errors());die;
          //   //log password not changed
          //   // throw new BadRequestException(__('can not use earlier used 6 passwords'));
          // }
        }else{
          // pr($user->errors());die;
          throw new BadRequestException(__('BAD_REQUEST'));
        }
      }

       public function fetchQualificationTypes($qualificationId=null){
        if(!$this->request->is('get')){
           throw new MethodNotAllowedException('Request method is not get');          
        }
        if(!$qualificationId){
             throw new NotFoundException('School Id is not available.');
         }
        $this->loadModel('QualificationTypes');
        $qualificationType = $this->QualificationTypes->find()
                                                      ->where(['qualification_id'=> $qualificationId ])                                                
                                                      ->toArray();
 
         if(!$qualificationType){
             throw new NotFoundException('Record not found');
         }
         $this->set('response', $qualificationType);
         $this->set('_serialize', ['response']);
      }

       public function fetchSubcontractors($corporateClientId=null){
        if(!$this->request->is('get')){
           throw new MethodNotAllowedException('Request method is not get');           
        }
        if(!$corporateClientId){
             throw new NotFoundException('School Id is not available.');
         }
        $this->loadModel('SubcontractedClients');
        $subcontractedClient = $this->SubcontractedClients->find()
                                    ->where(['corporate_client_id'=> $corporateClientId ])
                                    ->all()
                                    ->toArray();
  

         $this->set('response', $subcontractedClient);
         $this->set('_serialize', ['response']);
      }
    
}
