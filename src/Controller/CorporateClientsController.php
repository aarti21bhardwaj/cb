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
use Cake\Event\Event;


/**
 * CorporateClients Controller
 *
 * @property \App\Model\Table\CorporateClientsTable $CorporateClients
 *
 * @method \App\Model\Entity\CorporateClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorporateClientsController extends AppController
{

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->Auth->allow(['logout','login','notFound','forgotPassword','resetPassword','corporate']);
        $this->loadComponent('Cookie');
    }

    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    /**
     * Index method..
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $corporateClients = $this->CorporateClients->find()
                                              ->contain(['Tenants', 'TrainingSites'])
                                              ->where(['CorporateClients.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->all()
                                              ->toArray();
                                              
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $corporateClients = $this->CorporateClients
                                    ->find()
                                    ->contain(['Tenants', 'TrainingSites'])
                                    ->all();
        }
        if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          
          $corporateClients = $this->CorporateClients->find()
                                                    ->contain(['Tenants', 'TrainingSites'])
                                                    ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                    ->all()
                                                    ->toArray();

        }
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
          $corporateClients = $this->CorporateClients->find()
                                              ->contain(['Tenants', 'TrainingSites'])
                                              ->where(['CorporateClients.training_site_id ='=>$loggedInUser['training_site_id']])
                                              ->all()
                                              ->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);

        $this->set(compact('corporateClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Corporate Client id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $corporateClient = $this->CorporateClients->get($id, [
            'contain' => ['TrainingSites', 'Tenants', 'Courses', 'Locations']
        ]);
        // pr($corporateClient);die;
        $this->set('corporateClient', $corporateClient);
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $corporateClient = $this->CorporateClients->newEntity();

        $loggedInUser = $this->Auth->user();
        $this->loadModel('TrainingSites');
        //pr($loggedInUser);die;
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            $data['status'] = 1;
            $data['corporate_client_users'][0]['role_id'] = 3;
            $data['corporate_client_users'][0]['status'] = 1;
            if($loggedInUser['role']->name =='corporate_client' && $loggedInUser['training_site_id'] && isset($loggedInUser['training_site_id'])){
              $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            if($loggedInUser['role']->label =='TRAINING SITE OWNER'){
              $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            // if($loggedInUser['role_id'] == 2){
            //   $data['training_site_id'] = $loggedInUser['training_site_id'];
            // }
    
            $tenant = $this->Tenants->findById($loggedInUser['tenant_id'])->first();
            // $getTenantDomain = explode('/', $tenant->domain_type);
            // $corporateUrl = $host."/corporate-clients/corporate/".$id."/".$urlId;
            $url = Router::url('/', true);
            $corporateUrl = $url."corporate-clients/corporate"."/";
            if($data['web_page'] == 1){
                $data['web_url'] = $corporateUrl;
            }
            // pr($corporateClient->web_url);die();
            // pr($corporateClient);die;
            // pr($data['corporate_client_users'][0][]);die;
              // pr($emailData);die;
            // pr($data);die;
            $corporateClient = $this->CorporateClients->patchEntity($corporateClient, $data);
            // pr($corporateClient);die;
            if ($this->CorporateClients->save($corporateClient)) {
              $trainingsite= $this->TrainingSites->find()
                                                     ->where(['id' => $data['training_site_id']])
                                                     ->first();
                                                     // pr($trainingsite);die;


              $emailData = [
                'name' => $data['corporate_client_users'][0]['first_name'],
                'email' => $data['corporate_client_users'][0]['email'],
                'username' => $data['corporate_client_users'][0]['email'],
                'password' => $data['corporate_client_users'][0]['password'],
                'server_name' => $url."corporate-clients/login",
                'training_site_name' => $trainingsite->name,
                'training_site_phone' => $trainingsite->phone,
                'training_site_email' => $trainingsite->contact_email,
              ]; 
              if(isset($emailData) && !empty($emailData)):
                $event = new Event('corporate_admin_registration', $this, [
                     'hashData' => $emailData,
                     'tenant_id' => $loggedInUser['tenant_id']
                ]);
                $this->getEventManager()->dispatch($event);
              endif;

                $this->Flash->success(__('The corporate client has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
           // pr($url);pr($corporateClient);die;

            else{ 
            $this->Flash->error(__('The corporate client could not be saved. Please, try again.'));
          }
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->CorporateClients->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
                                                
            $trainingSites = $this->CorporateClients->TrainingSites->find()
                                                        ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->CorporateClients->TrainingSites->find()->all()->combine('id','name')->toArray();
        }
        
        $this->set('loggedInUser', $loggedInUser);


        
        $this->set(compact('corporateClient', 'trainingSites', 'tenants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Corporate Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
     public function corporate($id= null ,$uid = null)
    {
     // pr($cid);
     // pr($uid); die();
        # 
    $corporateClientExists = $this->CorporateClients
                                                ->findById($id)
                                                // ['domain_type LIKE' => '%'.$domainType.'%']
                                                ->where(['url_id =' =>$uid])
                                                ->first();
                                   // pr($checkSubcontractedClientExists->web_id); die();             
    if(!isset($corporateClientExists)  ){
        $this->Flash->error(__('Incorrect url, please try again !'));
        return $this->redirect(['controller'=>'Students','action' => 'login']);
    }
    // pr('here'); die();

    $this->viewBuilder()->setLayout('popup-view');
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
    $corporateClient = $this->CorporateClients->findById($id)->first();
    // pr($corporateClient);die();
    if(!isset($tenant) && empty($tenant)){
    throw new NotFoundException(__('Tenant Not Found'));
    }

    $this->loadModel('Courses');
    
    $courses = $this->Courses->find()
                              ->where(['Courses.corporate_client_id' => $id])
                             // ->matching('CorporateClients',function ($q)  use ($id){
                             //     return $q->where([
                             //         'CorporateClients.id'=>$id
                             //     ]);
                             // })
                             ->contain(['CourseTypes','Locations'])
                             ->toArray();
                    // pr($courses);die();
    $this->loadModel('CourseStudents');
    $courseStudent = $this->CourseStudents->find()
                                          ->contain(['Courses'])
                                          ->where(['Courses.corporate_client_id' => $id])
                                          ->all()
                                          ->count();
    // pr($courseStudent);die();
    $this->set(compact('courses','corporateClient','courseStudent'));
    }

    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $corporateClient = $this->CorporateClients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $urlId = $this->_RequestData['url_id'];
            $data = $this->_RequestData;
            // pr($loggedInUser['role']->name);die;
            $tenant = $this->Tenants->findById($loggedInUser['tenant_id'])->first();
            // pr($tenant);die;
            // pr($this->request->host());die;
            // $getTenantDomain = explode('/', $tenant->domain_type);
            
            
            // pr($corporateUrl);die;
            $corporateClient = $this->CorporateClients->patchEntity($corporateClient, $this->_RequestData);
            if($data['web_page'] == 1){
            $url = Router::url('/', true);
            $corporateUrl = $url."corporate-clients/corporate"."/".$id."/".$urlId;
                $corporateClient->web_url = $corporateUrl;
            }

            if ($this->CorporateClients->save($corporateClient)) {
                $this->Flash->success(__('The corporate client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corporate client could not be saved. Please, try again.'));
        }
        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->CorporateClients->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $trainingSites = $this->CorporateClients->TrainingSites->find()
                                                        ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
                                                        
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->CorporateClients->TrainingSites->find()->all()->combine('id','name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('corporateClient', 'trainingSites', 'tenants'));
    }


    public function dashboard(){
       
    }

    /**
     * Delete method
     *
     * @param string|null $id Corporate Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $corporateClient = $this->CorporateClients->get($id);
        if ($this->CorporateClients->delete($corporateClient)) {
            $this->Flash->success(__('The corporate client has been deleted.'));
        } else {
            $this->Flash->error(__('The corporate client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
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
          $this->viewBuilder()->setLayout('login-admin-override');
          $this->loadModel('Tenants');
          // // $domainType = "http://$_SERVER[HTTP_HOST]";
          //   $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          // // $domainType = 'mi.classbyte.twinspark.co';
           $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          $tenantData = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->contain(['TenantSettings'])->first();
          if(isset($tenantData) && !empty($tenantData)){  
              $this->set(compact('tenantData'));
          }else{
            $this->viewBuilder()->setTemplate('not-found');

          }
            if(!empty($tenantData->tenant_settings[0]->enable_corporate_module) && isset($tenantData->tenant_settings[0]->enable_corporate_module) && $tenantData->tenant_settings[0]->enable_corporate_module!=1){
               $this->Flash->error('Corporate Client module has been disabled. Please contact your tenant.');
                    
            }
          if ($this->request->is('post')) {

                  if(!empty($tenantData->tenant_settings) && isset($tenantData->tenant_settings[0]->enable_corporate_module) && $tenantData->tenant_settings[0]->enable_corporate_module!=1){
               $this->Flash->error('Corporate Client module has been disabled. Please contact your tenant.');
                    return null;
            }
              $this->loadModel('Roles');
              $this->loadModel('CorporateClientUsers');
              $user = $this->Auth->identify();
              $this->Cookie->write('loginAction', ['controller' => 'CorporateClients', 'action' => 'login']);
              $corporateId = $user['corporate_client_id'];
              // pr($corporateId);

              $corporateClientData = $this->CorporateClients->findById($corporateId)->first();
              // pr($corporateClientData);die;

              if ($user && ($corporateClientData['tenant_id'] == $tenantData['id'])) {
                // die('in if');
                  $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
              // pr($query); die();

                  $tenantDisabled = $this->Tenants->findById($corporateClientData['tenant_id'])->first();
                  // pr($query->center_name); die();
                  if($tenantDisabled->status != 1) {
                    $this->Flash->error('This Tenant has been disabled, Please contact Super Admin');
                    return null;
                  }
                  $corporateClientDisabled = $this->CorporateClients->findById($corporateClientData['id'])->first();

              // pr($corporateClientDisabled['id']);die();
              // pr($user);die();
                  if($corporateClientDisabled->status != 1){
                    $this->Flash->error('Your Corporate been disabled by your Tenant.Please contact your Tenant for details');
                    return null;
                  }

                  

                  $corporateClientUserDisabled = $this->CorporateClientUsers->findById($user['id'])->first();
                    // pr($corporateClientUserDisabled);die();
                  if($corporateClientUserDisabled->status != 1){
                    $this->Flash->error('you have been disabled by your Tenant or Corporate. Please contact your Tenant or Corporate for details');
                    return null;
                  }   
                  
                  $user['corporate_client'] = $corporateClientData->toArray();
                  $this->Auth->setUser($user);
              
                  // pr($this->Auth->setUser($user));die;
                  if( !empty($query) && $query->name == 'corporate_client'){
                    // pr('inif1');die('here');
                      $this->redirect(['controller' => 'CorporateClientUsers','action' => 'dashboard']);
                  }
                  if( !empty($query) && $query->name == 'tenant'){
                    // pr('inif2');die('here');
                      $this->redirect(['controller' => 'CorporateClients','action' => 'dashboard']);
                  }
              }elseif($user){
                // pr('else');die('else');
                $this->Flash->error('You do not belong to this Tenant. PLease contact Superadsmin');
                $this->redirect(['controller' => 'CorporateClients','action' => 'login']);
              }elseif(!$user){
                $this->Flash->error('Please enter correct email or password!');
                $this->redirect(['controller' => 'CorporateClients','action' => 'login']);
              }
          }
          $this->set(compact('corporateClientData'));
      }

    public function forgotPassword(){
      if($this->Auth->user()){
        $this->Flash->error("UNAUTHORIZED REQUEST");
        $this->redirect(['action' => 'logout']);
      }
      // pr('here');die;
      $this->viewBuilder()->setLayout('login-admin-override');
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
        $email = $this->_RequestData['email'];
        $this->loadModel('CorporateClientUsers');
        $corporateUsers = $this->CorporateClientUsers->findByEmail($email)
                                        ->matching('CorporateClients.Tenants', function($q) use($domainType){
                                          return $q->where(['domain_type LIKE' => '%'.$domainType.'%']);
                                        })
                                        ->first();
        // pr($corporateUsers);die; 

        if(!$corporateUsers){
          return $this->Flash->error(__("This email doesn't exist for this tenant."));
        }
        $this->loadModel('CorporateClientResetPasswordHashes');
        $hashResetPassword = $this->CorporateClientResetPasswordHashes->find()->where(['corporate_client_user_id' => $corporateUsers->id])->first();
         if(empty($hashResetPassword)){
          $resetPwdHash = $this->_createResetPasswordHash($corporateUsers->id);
        }else{
          $resetPwdHash = $hashResetPassword->hash;
          $time = new Time($hashResetPassword->created);
          if(!$time->wasWithinLast(1)){
            $this->CorporateClientResetPasswordHashes->delete($hashResetPassword);
            $resetPwdHash =$this->_createResetPasswordHash($corporateUsers->id);
          }
        }
        $url = Router::url('/', true);
        $url = $url.'corporateClients/resetPassword/?reset-token='.$resetPwdHash;
        $email = new Email('default');
        $email->setTo($corporateUsers->email)
              ->setSubject('Reset Password Link')
              ->send('To update your password please click the link '.$url);

        $this->Flash->success(__('Please check your email to verify yourself and change your password'));
        $this->redirect(['action' => 'login']);

       }
    }

     protected function _createResetPasswordHash($corporateUserId){
      
        $this->loadModel('CorporateClientResetPasswordHashes');
        $resetPasswordrequestData = $this->CorporateClientResetPasswordHashes->find()
                                                                    ->where(['corporate_client_user_id' =>$corporateUserId ])
                                                                    ->first();
        if($resetPasswordrequestData){
            return $resetPasswordrequestData->hash;
        }
        $hasher = new DefaultPasswordHasher();
        $reqData = ['corporate_client_user_id'=>$corporateUserId,'hash'=> $hasher->hash($corporateUserId)];
        $createPasswordhash = $this->CorporateClientResetPasswordHashes->newEntity($reqData);
        $createPasswordhash = $this->CorporateClientResetPasswordHashes->patchEntity($createPasswordhash,$reqData);
        if($this->CorporateClientResetPasswordHashes->save($createPasswordhash)){
          return $createPasswordhash->hash;
        }else{
          Log::write('error','error in creating resetpassword hash for user id '.$corporateUserId);
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
          if($password !== $cnfPassword){
            $this->Flash->error(__('MISMATCH PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }

          $this->loadModel('CorporateClientResetPasswordHashes');
          $checkExistPasswordHash = $this->CorporateClientResetPasswordHashes->find()->where(['hash'=>$uuid])->first();

          if(!$checkExistPasswordHash){
            $this->Flash->error(__('INVALID RESET PASSWORD'));
            $this->redirect(['action' => 'login']);
            return;
          }
           $user = $this->CorporateClients->CorporateClientUsers->findById($checkExistPasswordHash->corporate_client_user_id )->first();
           if(!$user){
            $this->Flash->error(__("User Doesn't exist."));
            $this->redirect(['action' => 'login']);
            return;
           }
           $reqData = ['password'=>$password];
           $hasher = new DefaultPasswordHasher();

           $user = $this->CorporateClients->CorporateClientUsers->patchEntity($user, $reqData);
            if($this->CorporateClients->CorporateClientUsers->save($user)){
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
     * Logout method
     * @param null
     * @return \Cake\Http\Response|null Redirects to login.
     */
    public function logout(){
        $this->Auth->logout();
        return $this->redirect(['controller' => 'CorporateClients','action' => 'login']);
    }

      /**
     * update status method
     * @param null
     * @return \Cake\Http\Response|null 
     */

     public function updateStatus($id = null)
    {

        $query = $this->request->getAttribute('params')['pass'];
        $corporateClient_id = $query[0];
        $this->request->allowMethod(['post']);
        $corporateClient = $this->CorporateClients->get($corporateClient_id);
        if($corporateClient){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $corporateClient['status'] = $status;
          // $tenant = $this->Tenants->patchEntity($tenant, $tenantData);
          $corporateClient = $this->CorporateClients->save($corporateClient);
            if($corporateClient){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
