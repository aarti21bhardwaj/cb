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

/**
 * Users Controller
 *
 *
 * @method \App\Model\Entity\User[] paginate($object = null, array $settings = [])
 */
class CorporatesController extends ApiController
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
        $this->loadModel('CorporateClientUsers');
        $user = $this->CorporateClientUsers->find()->where(['CorporateClientUsers.id'=>$id])->contain(['CorporateClients','CorporateClients.TrainingSites'])->first();
        // pr($user);die;
        // pr($user->corporate_client->training_site_id);die;
        $trainingSiteData = $this->TrainingSites->findById($user->corporate_client->training_site_id)->first();
        // pr($trainingSiteData);die;
        if(!$user){
          throw new NotFoundException(__('ENTITY_DOES_NOT_EXISTS','User'));
        }
        $password = $data['new_password'];
        $reqData = ['password'=>$password];
        $user = $this->CorporateClientUsers->patchEntity($user, $reqData);
        if($this->CorporateClientUsers->save($user)){
          $data =array();
          $data['status']=true;
          $data['data']['id']=$user->id;
          $this->accountPasswordUpdateNotification($user,$trainingSiteData,$password);
          $data['data']['message']='password saved';
          $this->set('response',$data);
          $this->set('_serialize', ['response']);
        }else{
          throw new BadRequestException(__('BAD_REQUEST'));
        }
      }
      public function accountPasswordUpdateNotification($user,$trainingSiteData,$password){
         $emailData = [
          "first_name" => $user->first_name,
          'last_name' => $user->last_name,
          'email' => $user->email,
          'training_site_name' => $trainingSiteData->name,
          'training_site_phone' => $trainingSiteData->contact_phone,
          'training_site_email' => $trainingSiteData->contact_email,
          'user_name' => $user->email,
          'user_password' => $password,
          'server_name' => $this->request->host()
        ];
        // pr($user->corporate_client->tenant_id);die;
        // pr($emailData);die;
         $event = new Event('account_password_update_notification_corporate', $this, [
             'hashData' => $emailData,
             'tenant_id' => $user->corporate_client->tenant_id
        ]);
         // pr($event);die;
        $this->getEventManager()->dispatch($event);
        // die('here');
      }
    
}
